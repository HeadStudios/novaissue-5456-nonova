<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaign;

class PropItUpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = Campaign::find($this->campaign->id);
            if($campaign->video_props && !is_null($campaign->movio_video_id)) {

          

                $stick_script = array (
                  'template_id' => $campaign->movio_video_id,
                      'title' => 'video_title',
                      'variables' => 
                      array(),
                      'test' => true,
                    );
        
        
                    // Uncomment this once you figure out video props issue
                    


                    //dump($campaign->video_props);
                    $props = $campaign->video_props;
                    
                    foreach($campaign->video_props as $prop) {
                      $title = $prop->title;
                      $name = $prop->name;
                      $property = $prop->property;
        
                      if(str_contains($property, 'http') && $name != 'text') {
        
                        $stick_script['variables'][] = array  (
                          'name' => $title,
                          'properties' => 
                          array (
                            $name => $property,
                            'fit' => 'contain'
                          ),
                        );
                        
                      } else {
                  
                      $stick_script['variables'][] = array  (
                        'name' => $title,
                        'properties' => 
                        array (
                          $name => $property,
                        ),
                      );
        
                    }
        
                    
                  
                    } 
        
        
                    //foreach($opp->products as $product) {
         
        
                // uncomment these once you're ready to resume      
        
                
                $stick_script_json = json_encode($stick_script);
        
                dump("Code to go is: ");
                dump($stick_script_json);
                
        
                //$response = Http::withHeaders(['x-api-key' => env('MOVIO_API')])->post('https://craft-api.surreal-ai.com/pacific/api/v1/template.generate', $stick_script);
                
                
              
                //$campaign->tiktok_url = $response['data']['video_id'];
                
        
                    
                  }
    }
}
