<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMailGun;
use App\Models\ScheduledSms;
use App\Hydraulics\MMSHolder;
use Propaganistas\LaravelPhone\PhoneNumber;



class ScheduleEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump("Fucking work cunt");
        $dueEmails = ScheduledEmail::where('scheduled_at', '<=', now())
        ->whereNull('sent_at')
        ->get();

        dump($dueEmails);

        dump("Nothing???");


        

        foreach ($dueEmails as $dueEmail) {
            $model = $dueEmail->contact;
        
            // Use $dueEmail->fields directly since it's already an array
            $email_fields = $dueEmail->fields;
        
            $fields = [
                'message' => $dueEmail->message,
                'subject' => $email_fields['subject'],
                'template' => $dueEmail->template,
                'intro_text' => $email_fields['intro_text'] ?? 'BOOYAKASHA!!',
            ];
        
            // Combine the fields from $dueEmail->fields and the fields array
            $combined_fields = array_merge($fields, $email_fields);
        
            dump("Fields passing to MyMailGun from ScheduleEmails are: ");
            dump($combined_fields);
        
            dump("Are you alive????");
        
            $stakeholderEmails = $model->stakeholders->pluck('email')->toArray();
        
            if ($dueEmail->test) {
                Mail::to('kosta@headstudios.com.au')
                    ->cc('enquiries@headstudios.com.au')
                    ->send(new MyMailGun($model, (object) $combined_fields));
            } else {
                Mail::to($model->email)
                    ->cc($stakeholderEmails)
                    ->bcc('enquiries@headstudios.com.au')
                    ->send(new MyMailGun($model, (object) $combined_fields));
            }
        
        
            
        
            // Update the sent_at column for the sent email
            $dueEmail->sent_at = now();
            $dueEmail->save();
        }


        // SMS Time
        $dueSmsMessages = ScheduledSms::where('scheduled_at', '<=', now())
        ->whereNull('sent_at')
        ->get();

        // Send the due SMS messages
        foreach ($dueSmsMessages as $dueSms) {
        $mobile = PhoneNumber::make($dueSms->contact->mobile, 'AU')->formatE164(); 
        dump("Mobile we would send to is: ");
        dump($mobile);
        $mobile = '+61415932797';
        dump("But we playing right now");
        $message = $dueSms->message;

        // Send the SMS using your MMSHolder class
        MMSHolder::sendSingleMessage($mobile, $message);

        // Update the sent_at column for the sent SMS
        $dueSms->sent_at = now();
        $dueSms->save();
    }
    }
}
