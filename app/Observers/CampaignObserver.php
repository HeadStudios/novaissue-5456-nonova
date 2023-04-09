<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Hydraulics\Campaigner;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



class CampaignObserver
{
    /**
     * Handle the Campaign "created" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function created(Campaign $campaign)
    {
      
      if(empty($campaign->author_id)) {
        $campaign->author_id = Auth::id();
        $campaign->save();  
      } 
      return;
      $campaign->save();
      $user_id = $campaign->author_id;
      

      if(empty($campaign->movio_video_id)) {return 'nothing';}

      


      switch ($campaign->movio_video_id) {
        case "3971ed61afd84378bb8d465b76340314":
          $campaign->mms_image = '/images/campaign/og_6_mistakes_investors.jpg';
          break;
        case "96d5666ab046461b9681486da103d999":
          $campaign->mms_image = '/images/campaign/og_6_mistakes_investors.jpg';
          break;
        case "green":
          $campaign->mms_image = '/images/campaign/og_6_mistakes_investoria.jpg';
          break;
        default:
          $campaign->mms_image = '/images/campaign/og_6_mistakes_investorsaaaa.jpg';
      }

      
      


        //$logo_url = \Outl1ne\NovaSettings\NovaSettings::getSetting('logo_url');
         
        if($campaign->video_props && !is_null($campaign->movio_video_id)) {

          

        $stick_script = array (
          'template_id' => $campaign->movio_video_id,
              'title' => 'video_title',
              'variables' => 
              array(),
              'test' => true,
            );


            // Uncomment this once you figure out video props issue

            foreach($campaign->video_props as $prop) {
              $title = $prop->title;
              $name = $prop->name;
              $property = $prop->property;

              $property = Campaigner::Merger($property, $user_id);

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
        

        $response = Http::withHeaders(['x-api-key' => env('MOVIO_API')])->post('https://craft-api.surreal-ai.com/pacific/api/v1/template.generate', $stick_script);
        
        
      
        $campaign->tiktok_url = $response['data']['video_id'];
        

            
          }
          $campaign->save();

    }

    public function merger($merge) {

      $property = str_replace('{{logo_url}}', $logo_url, $property);
      $property = str_replace('{{website_url}}', $fields->website_url, $property);
      $property = str_replace('{{mobile}}', $fields->mobile, $property);
      $property = str_replace('{{company_name}}', $fields->company_name, $property); 

    }

    /**
     * Handle the Campaign "updated" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function updated(Campaign $campaign)
    {

      
      /*
      $stick_script = array (
        'template_id' => '3971ed61afd84378bb8d465b76340314',
            'title' => 'video_title',
            'variables' => 
            array(),
            'test' => true,
          );

          foreach($campaign->video_props as $prop) {
            $title = $prop['attributes']['title'];
            $name = $prop['attributes']['name'];
            $property = $prop['attributes']['property'];
        
            $stick_script['variables'][] = array (
              'name' => $title,
              'properties' => 
              array (
                $name => $property,
              ),
            );
        
          }
          //foreach($opp->products as $product) {

        
          $response = Http::withHeaders(['x-api-key' => 'YTU1NDBmNTY5Y2NhNGYwY2FlZmI2NWU0MDg3MWVmMjItMTY1NzI1ODI3MA=='])->post('https://craft-api.surreal-ai.com/pacific/api/v1/template.generate', $stick_script)['data']['video_id'];

      $campaign->tiktok_url = $response;
      $campaign->save();
        */
    }

    /**
     * Handle the Campaign "deleted" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function deleted(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the Campaign "restored" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function restored(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the Campaign "force deleted" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function forceDeleted(Campaign $campaign)
    {
        //
    }
}
