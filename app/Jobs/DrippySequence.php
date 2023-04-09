<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Sequencer;
use App\Models\User;
use App\Models\Contact;
use App\Models\Campaign;
use App\Hydraulics\Campaigner;
use Propaganistas\LaravelPhone\PhoneNumber;

class DrippySequence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $uid;
     public $real;

    public function __construct($user_id, $real=false)
    {
        $this->uid = $user_id;
        $this->real = $real;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sequence = Sequencer::find(1);
        $user = User::find($this->uid);
        $contact = Contact::where('id', $user->contacts_id)->first();
        $name = $contact->name;
        $name = Campaigner::split_name($name)[0];
        $buffer = 0;
        foreach($sequence->sequence as $seq) {

        $arra = $seq->attributesToArray();

        if($seq->title()=="email_single") {
            
            $parsedown = new \Parsedown();
            //$markdown = nl2br($arra['email_body']);
            $body = $parsedown->text($arra['email_body']);
            $body = self::merge($body);

            
            

            

            $details = [
       
                'name' => $name,
                'body' => $body,
                'subject' => self::merge($arra['subject']),
            ];
            if($this->real) { $email = $contact->email; } else { $email = 'kostakondratenko77@yahoo.com'; $arra['delay_hours'] = 0; $arra['delay_days'] = 0; }
            $delay = now()->addDays($arra['delay_days']+$buffer)->addHours($arra['delay_hours']);
            if($delay->isSunday()) { $buffer += 1; $delay->addDays(1); }
            \Mail::to($email)->cc(['enquiries@headstudios.com.au', 'boom@sandbox8513749f7f204ca0a98e55d785133d1e.mailgun.org'])->later($delay, new \App\Mail\OppsEmail($details));
            //return $parsedown->text($arra['email_body']);
        }

        if($seq->title()=="sms_single") {

            $mobile = PhoneNumber::make($contact->mobile, 'AU')->formatE164();  
            

            //return "Yes";
            //return $seq->title();
            //return $arra['message'];
            //return $arra['delay'];
            $msg = self::merge($arra['message']);


            if($this->real) {   } else { $mobile = '61415932797'; $arra['delay_hours'] = 0; $arra['delay_days'] = 0; }
            $days = $arra['delay_days'] + $buffer;
            $delay = now()->addDays($arra['delay_days']+$buffer)->addHours($arra['delay_hours']);
            if($delay->isSunday()) { $buffer += 1; $delay->addDays(1); }
            SendAPacket::dispatch($mobile, $msg, '')->delay($delay);

        }


        

        //return $seq->title();

    }
    }

    public static function button($text, $link) {

        return '<a rel="noopener" target="_blank" href="'.$link.'" style="background-color: #1c1493; font-size: 14px; font-family: Helvetica, Arial, sans-serif; font-weight: bold; text-decoration: none; padding: 14px 20px; color: #d3daff; border-radius: 5px; display: inline-block; mso-padding-alt: 0;">
        <!--[if mso]>
        <i style="letter-spacing: 25px; mso-font-width: -100%; mso-text-raise: 30pt;">&nbsp;</i>
        <![endif]-->
        <span style="mso-text-raise: 14pt;">'.$text.' &rarr;</span>
        <!--[if mso]>
        <i style="letter-spacing: 25px; mso-font-width: -100%;">&nbsp;</i>
        <![endif]-->
    </a>';

    }

    public function merge($message) {
        $user = User::find($this->uid);
       
        $contact = $user->contacts;
        $name = $contact->name;
        $name = Campaigner::split_name($name)[0];

        $perma = $user->company_permalink;

        $campaigns = Campaign::where('author_id', 77)->get();
        $urls = array();
        foreach($campaigns as $campaign) {
        $urls[] = $campaign->permalink;
        }

        $urls = array_map(function ($str) use ($perma) { return 'https://rrdevours.monster/vblog/'.$perma.'/'.$str; }, $urls);

        $url_6mistakes = preg_grep('/mistake/', $urls);
        $url_6omissions = preg_grep('/omission/', $urls);
        $url_5questions = preg_grep('/questions/', $urls);
        $landing = 'https://rrdevours.monster/vblog/'.$perma.'/';
        
        $url_6omissions = reset($url_6omissions);
        $url_5questions = reset($url_5questions);
        $url_6mistakes = reset($url_6mistakes);

        $msg = str_replace('{{name}}',$name, $message);
        $msg = str_replace('{{email}}', $contact->email, $msg);
        $msg = str_replace('{{bdm}}', $user->name, $msg);
        $msg = str_replace('{{area}}', $user->area, $msg);
        $msg = str_replace('{{myemail}}', 'kosta@headstudios.com.au', $msg);
        
        $msg = str_replace('{{funnel-omissions}}', self::button('Free Gift: Your 6 Exit Report Omissions Video Landing Page', $url_6omissions), $msg);
        $msg = str_replace('{{5-questions}}', self::button('Free Gift: Your 5 Questions Property Management Video Landing Page', $url_5questions), $msg);
        $msg = str_replace('{{funnel-mistakes}}', self::button('Free Gift: Your 6 Mistakes Investors Make Video Landing Page', $url_6mistakes), $msg);
        $msg = str_replace('{{funnel-landing}}', self::button($user->name.'\'s Landing Page is Ready', $landing), $msg);
        $msg = str_replace('{{name}}', $user->name, $msg);

        return $msg;
    }
}
