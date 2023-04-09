<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\Contacts;
use Illuminate\Support\Facades\DB;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLinkmeister implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $campaign;
    public $contact;

    public function __construct(Campaign $campaign, Contacts $contact)
    {
        $this->campaign = $campaign;
        $this->contact = $contact;
    }        

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('campaign_contacts')->insert([
            'shortlink' => 'none',
            'clicks' => '2',
            'contacts_id' => $contact->id,
            'campaign_id' => $model->id
        ]);
        Http::post('https://webhook.site/7058c084-b629-4f76-bd4e-d42e856339fb', [
            'Contact is' => $this->contact->name,
            'Campaign is' => $this->campaign->headline
        ]);
    }
}
