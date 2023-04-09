<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'message',
        'template',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'fields' => 'json',
            'scheduled_at' => 'datetime',
        
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public static function createWithEmailBodyAndContact($emailBody, Contact $contact, $introText)
    {
        // Call the replaceMergeTags method
        $processedEmailBody = self::replaceMergeTags($emailBody, $contact, $introText);

        // Check for unreplaced tags
        if (preg_match('/\{\{[\w\s-]*\}\}/', $processedEmailBody)) {
            // Unreplaced tags found, return false
            return false;
        }

        // Insert a new scheduled email
        $scheduledEmail = new ScheduledEmail();
        $scheduledEmail->contact_id = $contact->id;
        $scheduledEmail->message = $processedEmailBody;

        return $scheduledEmail;
    }

    public static function replaceMergeTags($emailBody, Contact $contact, $introText)
    {
        $vauditLink = optional($contact->audit)->first()?->full_url ?? '';
    $auditUrl = route('audit.show', [
        'slug' => $contact->audit?->permalink ?? 'ankley-dorinka', // Provide a default value
        'contact_id' => $contact->id,
    ]);
    $replacements = [
        '{{name}}' => $contact->name,
        '{{intro_text}}' => $introText,
        '{{company}}' => $contact->account,
        '{{email}}' => $contact->email,
        '{{city}}' => $contact->city,
        '{{bdm}}' => $contact->user->name,
        '{{screenshot}}' => $contact->user->screenshot,
        '{{landing}}' => $contact->user->full_url,
        '{{vauditlink}}' => $contact->audit?->full_url, // Use the null-safe operator
        '{{vaudit:link}}' => $vauditLink,
        '{{audit_url}}' => $auditUrl
    ];

    if (strpos($emailBody, '{{vauditscreenshot}}') !== false && $contact->audit) {
        $replacements['{{vauditscreenshot}}'] = $contact->audit->generateThumbnailWithPlayButton();
        //dump("By the way this is where we at: ".$replacements['{{vauditscreenshot}}']);
    }

    foreach ($replacements as $key => $value) {
        $emailBody = str_replace($key, $value, $emailBody);
    }

    preg_match_all('/\{\{([\w-]+):(full_url|screenshot|thumbnail)\}\}/', $emailBody, $matches);

    preg_match_all('/\{\{([\w-]+):(full_url|screenshot|thumbnail)\}\}/', $emailBody, $matches);

    $campaigns = $contact->user->campaigns;

   

    foreach ($matches[1] as $key => $campaignName) {
        $campaign = $campaigns->where('permalink', $campaignName)->first();
        if (!$campaign) {
            $campaign = Campaign::where('permalink', $campaignName)->first();
        }
        if ($campaign) {
            if ($matches[2][$key] === 'full_url') {
                $emailBody = str_replace('{{'.$campaignName.':full_url}}', $campaign->full_url, $emailBody);
            } elseif ($matches[2][$key] === 'screenshot') {
                $emailBody = str_replace('{{'.$campaignName.':screenshot}}', $campaign->screenshot, $emailBody);
            } elseif ($matches[2][$key] === 'thumbnail') {
                $id = $campaign->id;
                
                $campaign = Campaign::find($id);
                
                $thumbnail_url = $campaign->generateThumbnailWithPlayButton();
                
                $emailBody = str_replace('{{'.$campaignName.':thumbnail}}', $thumbnail_url, $emailBody);
            }
        }
    }

    
    return $emailBody;

}
}
