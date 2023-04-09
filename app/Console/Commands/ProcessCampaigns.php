<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Campaign;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Campaigns';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $campaigns = Campaign::where('tiktok_url', 'NOT LIKE', '%http%')->get();
        
        
        foreach($campaigns as $campaign) {
            
            
            $response = Http::withHeaders([
                'x-api-key' => env('MOVIO_API')
            ])->get('https://craft-api.surreal-ai.com/pacific/api/v1/video_status.get', [
                'video_id' => $campaign->tiktok_url
            ]); 
            
            
            if($response['data']['status'] == 'completed') {
                $path = 'videos/scripts/final/script_'.rand(0,1000).'.mp4';
                $video = $response['data']['video_url'];
                Storage::put($path, fopen($video, 'r'));
                $url = Storage::disk('s3')->url($path);
                $campaign->tiktok_url = $url;
                $campaign->save();
            }
        }
    }
}
