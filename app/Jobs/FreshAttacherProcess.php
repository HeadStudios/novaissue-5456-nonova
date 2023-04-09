<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Hydraulics\SMSPrep;
use App\Jobs\Middleware\RateLimited;


use App\Models\CampaignContact;
use App\Models\Campaign;
use App\Models\Contact;

use Laravel\Nova\Fields\ActionFields;

class FreshAttacherProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $fields;
    public $campaign;
    public $contact;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign, $contact, $fields)
    {
        //$this->campcontact = $campcontact;
        $this->campaign = $campaign;
        $this->contact = $contact;
        $this->fields = $fields;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        
    }
}
