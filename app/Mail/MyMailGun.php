<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Headers;
use App\Models\Campaign;

use Carbon\Carbon;

class MyMailGun extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $model;
    public $markdown;
    protected $sendAt;
    protected $fields;
    protected $contact;
    protected $intro_text;
    public $subject;


    public function __construct($model, $fields)
    {
        
        $template = $fields->template;
        $message = $fields->message;

        $this->subject = $fields->subject ?? null;
        $this->intro_text = $fields->intro_text ?? '';

        
        if ($model instanceof Contact) {
            $this->model = $model;
        } else {
            $this->model = Contact::find($model);
        }
        $this->markdown = $template;
        
        $this->fields = $fields;
        if($model instanceof \App\Models\Touchpoint) {
        $this->contact = $model->contact; 
        //$this->message = $this->replaceMergeTags($message, $model->contact);
        $this->fields->message = $this->replaceMergeTags($message, $model->contact);
        dump("Replacing subject which is : ".$this->subject." in the Touchpoint if instance and passing it to replaceMergeTage");
        $this->subject = $this->replaceMergeTags($this->subject, $model->contact);
     }
        
        elseif($model instanceof \App\Models\Contact) {
        //$this->message = $this->replaceMergeTags($message, $model);
        $this->fields->message = $this->replaceMergeTags($message, $model);
        dump("Replacing subject which is : ".$this->subject." in the Contact if instance and passing it to replaceMergeTage");
        $subject = $this->subject;
        $this->subject = $this->replaceMergeTags($subject, $model);
        dump("After all that the subject is: ");
        dump($this->subject);

        $this->contact = $model;
        }
    }

    public function content()
    {
        return new Content(
            markdown: $this->markdown,
            with: [
                'user' => $this->contact,
                'signature' => $this->getSignature(),
                'fields' => $this->fields
            ],
        );
    }

    public function envelope()
    {

    if(isset($this->fields->subject)) { $subject = $this->subject; } else {
    $subject = 'Rent Roll Devour System';

    switch ($this->fields->template ?? null) {
        case 'emails.simple':
            $subject = 'Rent Roll Devour System [Our Call - Your Request]';
            break;
        case 'emails.sequence':
            $subject = $this->subject;
            break;
        default:
            $subject = ' - Default Value';
    }
    }

    return new Envelope(
        from: new Address('kosta@headstudios.com.au', 'Kosta Mr. Rent Roll Growth Kondratenko'),
        subject: $subject,
    );
    }

    /*protected function getSignature()
    {
        return '<table style="color: rgb(34, 34, 34);font-family: Arial, Helvetica, sans-serif;font-size: small;background-color: rgb(255, 255, 255);direction: ltr;border-radius:0px;"><tbody><tr><td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;"><table cellpadding="0" cellspacing="0" style="font-family: Arial;line-height: 1.15;color: rgb(0, 0, 0);"><tbody><tr>
        <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;vertical-align: top;padding:0.01px 14px 0.01px 0.01px;"><table cellpadding="0" cellspacing="0" style="width: 65px;"><tbody><tr><td style="padding:0.01px;"><img src="https://d36urhup7zbd7q.cloudfront.net/36569729-7d15-47dc-a80c-77697c3aaaf2/my_photo.format_png.resize_200x.jpeg" height="65" width="65"></td></tr></tbody></table></td>
        <td height="1" width="0" style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;width: 0px;padding:0.01px;border-right:2px solid rgb(189, 189, 189);height: 1px;font-size: 1pt;">&nbsp;</td>
        <td valign="top" style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;padding:0.01px 0.01px 0.01px 14px;vertical-align: top;"><table cellpadding="0" cellspacing="0"><tbody>
        <tr><td style="line-height: 1.2;padding:0.01px 0.01px 12px;">
        <span style="font-family: Arial;font-weight: bold;"><span style="color: rgb(100, 100, 100);font-size: 16px;">Kosta Kondratenko</span></span><br><span style="font-size: 13px;letter-spacing: 0px;font-family: Arial;font-weight: bold;color: rgb(100, 100, 100);">Internet Aficionado,&nbsp;</span><span style="font-size: 13px;letter-spacing: 0px;font-family: Arial;font-weight: bold;color: rgb(100, 100, 100);">Head Studios</span>
        </td></tr>
        <tr><td style="padding:0.01px;line-height: 0;"><table cellpadding="0" cellspacing="0"><tbody>
        <tr><td style="padding:0.01px;"><table cellpadding="0" cellspacing="0"><tbody><tr>
        <td><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr><td style="padding:0.01px;font-size: 12px;"><a href="tel:+6412+826+569" target="_blank" style="color: rgb(17, 85, 204);text-decoration: unset;font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">+6412 826 569</span></a></td></tr></tbody></table></td>
        <td><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr>
        <td style="font-family: Roboto, RobotoDraft, Helvetica, Arial, sans-serif;padding-right:6px;padding-left:6px;"><span style="font-family: Arial;font-weight: bold;font-size: 12px;color: rgb(33, 33, 33);vertical-align: 2px;">|</span></td>
        <td style="padding:0.01px;font-size: 12px;"><a href="mailto:kosta@headstudios.com.au" target="_blank" style="color: rgb(17, 85, 204);text-decoration: unset;font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">kosta@headstudios.com.au</span></a></td>
        </tr></tbody></table></td>
        </tr></tbody></table></td></tr>
        <tr><td style="padding:0.01px;"><table cellpadding="0" cellspacing="0"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="line-height: 14px;font-size: 12px;font-family: Arial;"><tbody><tr><td style="padding:0.01px;font-size: 12px;"><a href="https://headstudios.com.au/" target="_blank" style="color: rgb(17, 85, 204);text-decoration: unset;font-size: 12px;"><span style="line-height: 1.2;color: rgb(33, 33, 33);white-space: nowrap;font-size: 12px;">https://headstudios.com.au/</span></a></td></tr></tbody></table></td></tr></tbody></table></td></tr>
        </tbody></table></td></tr>
        </tbody></table></td>
        </tr></tbody></table></td></tr></tbody></table>';
    }
    */

    protected function getSignature() {
        $signature = "Best, 
<br />Kosta";
        return $signature;
    }


    function replaceMergeTags($emailBody, Contact $contact)
    {
        $vauditLink = optional($contact->audit)->first()?->full_url ?? '';
    $auditUrl = route('audit.show', [
        'slug' => $contact->audit?->permalink ?? 'ankley-dorinka', // Provide a default value
        'contact_id' => $contact->id,
    ]);
    $replacements = [
        '{{name}}' => $contact->name,
        '{{intro_text}}' => $this->intro_text,
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
        dump("By the way this is where we at: ".$replacements['{{vauditscreenshot}}']);
    }

    foreach ($replacements as $key => $value) {
        $emailBody = str_replace($key, $value, $emailBody);
    }

    preg_match_all('/\{\{([\w-]+):(full_url|screenshot|thumbnail)\}\}/', $emailBody, $matches);

    preg_match_all('/\{\{([\w-]+):(full_url|screenshot|thumbnail)\}\}/', $emailBody, $matches);

    $campaigns = $contact->user->campaigns;

    dump("The campaigns returned belonging to the contact's user's campaigns are: ");
    dump($campaigns);

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
                dump("The id is a go, and it is: ".$id);
                $campaign = Campaign::find($id);
                
                $thumbnail_url = $campaign->generateThumbnailWithPlayButton();
                dump("The thumbnail url is a go and it is: ");
                dump($thumbnail_url);
                $emailBody = str_replace('{{'.$campaignName.':thumbnail}}', $thumbnail_url, $emailBody);
            }
        }
    }

    dump("And we're giving this back: ");
    dump($emailBody);
    return $emailBody;

}

public function headers(): Headers
{
    return new Headers(
        text: [
            'X-Mailgun-Variables' => json_encode([
                'hakoona' => 'matata',
                'problem_free' => 'philosophy',
            ]),
        ],
    );
}
 

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
