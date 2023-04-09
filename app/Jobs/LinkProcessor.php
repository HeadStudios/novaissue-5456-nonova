<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Hydraulics\Shorter;
use App\Models\CampaignContact;

class LinkProcessor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign_id;
    protected $shortlink;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_id, $shortlink)
    {
        $this->campaign_id = $campaign_id;
        $this->shortlink = $shortlink;
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
