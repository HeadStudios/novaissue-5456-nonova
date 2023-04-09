<?php

namespace App\Hydraulics;

use App\Models\Contact;
use App\Models\Campaign;
use Illuminate\Support\Str;
use AshAllenDesign\ShortURL\Models\ShortURL;



class SMSPrep {

    public static function formatSMS($contact, $campaign) {
        $contact = Contact::find($contact);
        $campaign = Campaign::find($campaign);
        $name = $contact->name;
        $name_parts = explode(" ", $name);
        if(count($name_parts) > 1) {
            $first_name = ucfirst($name_parts[0]);
        } else {
            $first_name = ucfirst($name);
        }
        $sms = $campaign->mms_msg;
        $sms = str_replace("{{name}}", $first_name, $sms);
        //$sms = str_replace("{{link}}", $campaign->short_url, $sms);

    
        $message = self::shortenURL($sms, $campaign, $contact);//str_replace("{{link}}", $campaign->short_url, $sms);
        $sms = $message['sms'];
        $shortlink = $message['shortlink'];
        
        $sms .= '
P.S. Please reply UNSUBSCRIBE or STOP if you never want to hear from me anymore.';
        
        
        return [
            'sms' => $sms,
            'shortlink' => $shortlink,
        ];
    }

    public static function shortenURL($sms, $campaign, $contact) {
        $destination_url = $campaign->full_url;
        
        $slug = Str::slug($contact->name);
        $short_key = $campaign->shortlink_path;
        
        $short_key = str_replace("{{name}}", $slug, $short_key);
        
        
        
        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        

        // check if the urlKey already exists
        $existingShortURL = ShortUrl::where('url_key', $short_key)->first();
        if ($existingShortURL) {
            $existingShortURL->delete();
            $shortURLObject = $builder->destinationUrl($destination_url)->urlKey($short_key)->trackVisits()->make();
            $shortURL = $shortURLObject->default_short_url;
        } else {
            $shortURLObject = $builder->destinationUrl($destination_url)->urlKey($short_key)->trackVisits()->make();
            $shortURL = $shortURLObject->default_short_url;
        }
        //$this->shortlink = $short_key;
        
        
        $sms = str_replace("{{link}}", $shortURL, $sms);
        return [
            'sms' => $sms,
            'shortlink' => $shortURL,
        ];
    }

    

    public static function Parser($url) {
        return parse_url($url);
    }

}