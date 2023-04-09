<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Hydraulics\SMSPrep;
use App\Models\Campaign;
use AshAllenDesign\ShortURL\Models\ShortURL as ShortUrl;
use Illuminate\Support\Str;
use App\Jobs\SendAPacket;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CampaignContact extends Model
{
    use HasFactory;

    protected $fillable = ['shortlink', 'action_fields', 'clicks', 'mms_image','contacts_id','campaign_id','mms_msg'];
    protected $casts = [
        'action_fields' => 'array'
    ];

    protected $table = 'campaign_contacts';

    protected static function boot()
    {
        
        parent::boot();

        static::creating(function ($model) {
            
            if (!$model->clicks) {
                $model->clicks = 0;
            }

            
            
            $action = $model->action_fields;

            $model->drawMMS($action['left'], $action['top'], $action['size']);

            $prepper = new SMSPrep;
            $message = $prepper->formatSMS($model->contacts_id, $model->campaign_id);
            $model->mms_msg = $message['sms'];//$model->formatSMS($model->contacts_id, $model->campaign_id);
            $model->shortlink = $message['shortlink'];

            

            
            

            /*if ($model->campaign_id && $model->contacts_id) {
                $contact = Contact::find($model->contacts_id);
                $campaign = Campaign::find($model->campaign_id);
                $sms = $campaign->mms_msg;
                
                $model->mms_msg = $model->formatSMS($sms, $contact, $campaign);
                $model->save();
            }*/
        });
    }


    public function contacts()
    {
        return $this->belongsTo(Contact::class);
    }
 
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    
    public function click() {
        $this->update(['clicks' => $this->clicks + 1], ['timestamps' => false]);

    }

    public function send(Carbon $carbon = null) {

        if (!$carbon) {
            $carbon = Carbon::now();
        }

        
        
        if($this->sent != 1) {
            $contact = Contact::find($this->contacts_id);
            $campaign = Campaign::find($this->campaign_id);
            try {
            $phone = PhoneNumber::make($contact->mobile, 'AU')->formatE164(); 
            } catch(\Exception $e) {
            $phone = null;
            }
            if($phone) {
                SendAPacket::dispatch($phone, $this->mms_msg)->delay($carbon);
                SendAPacket::dispatch($phone, $contact->mms_msg, '',0)->delay($carbon);
                $this->update(['sent' => 1], ['timestamps' => false]);
                
            }
            

        }
    }

    public function drawMMS($left=180, $top=20, $fontsize=3) {

        
        
        $campaign = Campaign::find($this->campaign_id);
        $url = $campaign->mms_image;
        $contact = Contact::find($this->contacts_id);
        $name = $contact->name;
        $file_txt = str_replace(' ', '_', $name);
        $filename = 'images/'.$file_txt.rand(0,100).'.png';
        $imgurl = Storage::disk('s3')->url($url);
        $image = \WideImage\WideImage::load($imgurl);
        $canvas = $image->getCanvas();
        $font = public_path().'/fonts/arialblack.ttf';
        $canvas->useFont($font, $fontsize, $image->allocateColor(0, 0, 0)); 
        $canvas->writeText($left, $top, $name);
        $data = $image->asString('png');
        $result = Storage::disk('s3')->put($filename, $data);
        $this->mms_image = $filename;
        

    }

    public function shortenURL($sms, $campaign, $contact) {
        $destination_url = $campaign->full_url;
        
        
        $short_key = $campaign->shortlink_path;
        //$short_key = 'shortlinker-base-{{name}}';
        $slug = Str::slug($contact->name);
        
        $short_key = str_replace("{{name}}", $slug, $short_key);
        $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
        

        // check if the urlKey already exists
        $existingShortUrl = ShortUrl::where('url_key', $short_key)->first();
        if ($existingShortUrl) {
            $existingShortURL->delete();
            $shortURLObject = $builder->destinationUrl($destination_url)->urlKey($short_key)->trackVisits()->make();
            $shortURL = $shortURLObject->default_short_url;
        } else {
            $shortURLObject = $builder->destinationUrl($destination_url)->urlKey($short_key)->trackVisits()->make();
            $shortURL = $shortURLObject->default_short_url;
        }
        $this->shortlink = $short_key;
        $sms = str_replace("{{link}}", $shortURL, $sms);
        return $sms;
    }

    public function getUrlKeyAttribute()
    {
        $value = $this->attributes['shortlink'];
        $parts = explode('/', $value);
        return end($parts);
    }

}
