<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Sequencer;
use App\Models\Contact;
use App\Models\Touchpoint;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ScheduledEmail;
use App\Mail\MyMailGun;
use Illuminate\Support\Facades\Mail;

use Illuminate\Queue\SerializesModels;

class SequenceSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     protected $model;
     protected $sequence;
     protected $intro_text;
     protected $test;
     protected $scheduledAt;


    public function __construct($model, $fields, Carbon $scheduledAt)
    {
        $this->model = $model;
        $this->sequence = $fields->sequence;
        $this->test = $fields->test;
        
        $this->intro_text = $fields->intro_text;
        $this->intro_text = $fields->intro_text ?? '';
        $this->scheduledAt = $scheduledAt;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sequence = Sequencer::find($this->sequence);
        $sequencers = $sequence->getPropsCollection();

        $permalink = $sequence->permalink;
        $contactId = $this->model->id;


        // Check if there's already a ScheduledEmail with the same category
        if (!$this->test) {
        $alreadyScheduled = ScheduledEmail::where('category', $permalink)
                            ->where('contact_id', $contactId)
                            ->exists();
        if ($alreadyScheduled) {
          // Log the information and exit the loop
          Log::info("Sequence with category '{$permalink}' has already been scheduled or sent for {$this->model->name}. Skipping.");
          return;
      }
    }

        $schedula = $this->getEmailSchedule(count($sequencers), $this->scheduledAt, $this->model->timezone);
        dump("Schedula is!");
        dump($schedula);

    //return $sequencers;

    

        $mdelay = 0;
        $hdelay = 0;
        $ddelay = 0;
        $firstIteration = true;

        $timezone = $this->model->timezone;
        $workingHoursStart = 9;
        $workingHoursEnd = 17;
        $emailsCount = count($sequencers);
        
        $now = Carbon::now($timezone);
        $callback_datetime = $this->scheduledAt->setTimezone($timezone);
        
        $totalAvailableTime = $callback_datetime->diffInMinutes($now->setTime($workingHoursStart, 0)) + ($callback_datetime->diffInDaysFiltered(function (Carbon $date) use ($workingHoursStart, $workingHoursEnd) {
            return $date->isWeekday();
        }, $now) - 1) * ($workingHoursEnd - $workingHoursStart) * 60;
        
        $averageDelay = $totalAvailableTime / $emailsCount; // in minutes

        dump("Average delay is: ");
        dump($averageDelay);
        
        $previousScheduledTime = clone $now;
        

        foreach ($sequencers as $index => $item) {
      if($item->layout == 'email_single') {

        $message = $item->attributes->email_body;
        $contact = $this->model;
        $fields = [];
        $mdelay = $mdelay + $item->attributes->delay_hours;
        $hdelay += $item->attributes->delay_hours;
        $ddelay += $item->attributes->delay_days;
        $fields['template'] = 'emails.sequence';
        $fields['subject'] = $item->attributes->subject;
        $fields['message'] = $message;
        $fields['intro_text'] = $this->intro_text;
        //$fields = json_encode($fields);
        //$fields = json_decode($fields);
       
        $scheduledEmail = ScheduledEmail::createWithEmailBodyAndContact($message, $contact, $this->intro_text);
        if (!$scheduledEmail) {
          
          Log::debug("Houston we have a problem with the following email to ".$contact->email." and the contents are: ");
          Log::debug($message);
          continue;
        }
        $scheduledEmail->fields = $fields;
        $scheduledEmail->template = 'emails.sequence';
        
        if ($firstIteration) {
          $scheduledEmail->scheduled_at = clone $now;
          $firstIteration = false;
      } else {
          $scheduledEmail->scheduled_at = $schedula[$index];
      }

        }

        if ($this->test) {
          $scheduledEmail->scheduled_at = now()->subMinutes(5);
          $scheduledEmail->test = true;
        }

        $scheduledEmail->save();
        

      }

      
      
    } 

    /*$nextWorkingDay = $this->getNextWorkingDay($latestScheduledAt);
      $touchpoint = new Touchpoint(['date' => $nextWorkingDay]);
      dump("Touchpoing ftw");
      dump($touchpoint);
      $this->model->touchpoints()->save($touchpoint); */

   // }

   protected function getEmailSchedule($emailCount, $callbackDatetime, $timezone)
   {
       $now = Carbon::now($timezone);
       $emailSchedule = [];
   
       // Calculate the total available time in seconds
       $totalAvailableTime = $callbackDatetime->setTimezone($timezone)->subDay()->diffInSeconds($now);
   
       // Calculate the time interval between each email
       $timeInterval = $totalAvailableTime / ($emailCount - 1);
   
       // Generate the email schedule
       for ($i = 0; $i < $emailCount; $i++) {
           $scheduledTime = clone $now;
           $randomFactor = random_int(-0.25 * $timeInterval, 0.25 * $timeInterval);
           $scheduledTime->addSeconds($timeInterval * $i + $randomFactor);
   
           // Ensure that emails are not scheduled between 8 PM and 3 AM
           $hour = $scheduledTime->hour;
           if ($hour >= 20) {
               $scheduledTime->setTime(3, 0)->addDay();
           } elseif ($hour < 3) {
               $scheduledTime->setTime(3, 0);
           }
   
           $emailSchedule[] = $scheduledTime;
       }
   
       return $emailSchedule;
   }
   

    private function getNextWorkingDay(Carbon $date)
  {
    $nextDay = $date->copy()->addDay();
    while ($nextDay->isWeekend()) {
        $nextDay->addDay();
    }

    return $nextDay;
  }
}
