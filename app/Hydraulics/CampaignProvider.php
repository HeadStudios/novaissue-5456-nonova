<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Touchpoint;
use Carbon\Carbon;
use App\Models\Opps;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;




class CampaignProvider {

    public function takeScreenshot($model, $width, $height) {

        //env('ABSTRACT_API')
        $url = $model->full_url;
        $app_url = env('APP_URL');
        dump("So just to confirm the queue worker that's doing this... we are inside the APP_ENV being: ".$app_url);
        dump("The URL returned is: ");
        dump($url);


        $get_url = 'https://screenshot.abstractapi.com/v1/?api_key='.env('ABSTRACT_API').'&url='.$url.'&capture_full_page=false&width='.$width.'&height='.$height;
        dump("The URL for GET IS: ");
        dump($get_url);

        return "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/800px-Google_2015_logo.svg.png";
        
        
        $image = file_get_contents($get_url);

        


        $fileName = Str::random(20) . '.png';

        // Define the S3 file path and name
        $s3Path = 'images/screenshots/'.$fileName;

        // Upload the image to S3 using Storage::put method
        Storage::put($s3Path, $image);

        $screenshot_url = Storage::disk('s3')->url($s3Path);

        dump("This is the screenshot that we get back so if it's still complaining about hero image that's total retardation: ");
        dump($screenshot_url);

        $model->screenshot = $screenshot_url;
        $model->save();

        return $screenshot_url;

    }

    public function createVideoCampaigns(User $user) {

        $user_id = $this->user_id;
        $user = User::where('id', $user_id)->first();



    $permalink = $user->company_name;
    $permalink = strtolower($permalink);
    $permalink = str_replace(' ', '-', $permalink);

    $logo_path = $user->company_logo;
    
    
    $hero_path = $user->hero_image;
    $profile_photo_path = $user->profile_image;

    $logo_url = Storage::disk('s3')->url($logo_path);

        $templates = Campaign::where('template', 1)->get();

                foreach($templates as $template) {

                    

                    $proppas = $template->getPropsCollection();
                    $newone = $template->replicate();
                    $newone->author_id = $user_id;
                    $newone->save();

                    

                    foreach($proppas as $prop) {
                        $property = $prop->attributes->property;
                        $property = str_replace('{{logo_url}}', $logo_url, $property);
                        $property = str_replace('{{website_url}}', $user->website_url, $property);
                        $property = str_replace('{{mobile}}', $user->mobile, $property);
                        $property = str_replace('{{company_name}}', $user->company_name, $property);
                        $prop->attributes->property = $property;
                
                    }
                    
                    $newhawk = Campaign::where('id', $newone->id)->first();
                    $newhawk->setPropsCollection($proppas);
                    $newhawk->author_id = $user_id;
                    $newhawk->template = 0;

                    $copy = $newhawk->copy;
                    $copy = str_replace('{{company_name}}', $user->company_name, $copy);
                    $newhawk->copy = $copy;
                    $newhawk->video_thumbnail = '';

                    $newhawk->save();

                    


                }

    }

    public function ffmpeg($ffmpeg) {
        $voutpads = [];
$overlay_index = 0;
$output = "ffmpeg ";

foreach ($ffmpeg as $index => $video) {
    if (strtolower(substr($video->file, -4)) === '.mp3') {
        $output .= " -stream_loop -1 -i " . $video->file;
    } else {
        $output .= " -i " . $video->file;
    }
}

$output .= " -filter_complex \"";

foreach ($ffmpeg as $index => $video) {
    if (Str::endsWith(strtolower($video->file), '.mp4')) {
        $voutpads[$index] = $video->name."_r";
        $output .= "[".$index.":v]scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30[".$voutpads[$index]."];";
    }
}

foreach ($ffmpeg as $index => $video) {
    if ((Str::endsWith($video->file, '.png') || Str::endsWith($video->file, '.jpg')) && !Str::contains($video->file, 'overlay')) {
        $voutpads[$index] = $video->name;
        $output .= "[".$index.":v]scale=800:600:force_original_aspect_ratio=decrease[".$video->name."];";
        
        
        //$output .= "[".$index.":v]scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30".$voutpads[$index].";\n";
    }
}

$overlay_id = 0;
foreach ($ffmpeg as $index => $video) {
    if (Str::contains($video->file, 'overlay')) {
        $overlay_id = $index;
    }
}

foreach ($ffmpeg as $index => $video) {
    if (Str::endsWith(strtolower($video->file), '.mp4') && !Str::contains($video->name, 'outro')) {

        $output .= "[".$voutpads[$index]."][".$overlay_id.":v]overlay=x=main_w-overlay_w-10:y=main_h-overlay_h-10:enable='between(t,0,15)'[".$video->name."_lt];";
                $voutpads[$index] = $video->name."_lt";
            
                
            
      

        //$output .= "[".$index.":v]scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30[".$video->name."_r];\n";
        //$voutpads[$index] = "[".$video->name."_lt]";
    }
}

/*// Headlina!
foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith($video->file, '.mp4')) {
    foreach($video->overlays as $overlay) {
        if(isset($overlay->attributes->headline)) {
            $headline = $overlay->attributes->headline;
            $sheadline = $overlay->attributes->subheadline;
            $number = $overlay->attributes->number ?? ' ';
            $output .= "[".$voutpads[$index]."]drawtext=text='".$headline."':fontcolor=black:fontsize=35:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-60:enable='between(t,0,15)'[overlayer3_txt3];[overlayer3_txt3]drawtext=text='".$sheadline."':fontcolor=black:fontsize=25:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-18:enable='between(t,0,15)'[overlayer3_txt2];[overlayer3_txt2]drawtext=text='".$number."':fontcolor=black:fontsize=60:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-677:y=(h-text_h)-34:enable='between(t,0,15)'[".$video->name."_hl];";
            $voutpads[$index] = $video->name."_hl";
            
            
        }
    }
    }
}*/

// Check tha Image Phone!
foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith(strtolower($video->file), '.mp4')) {
    foreach($video->overlays as $overlay) {
        if(isset($overlay->attributes->headline)) {
            $headline = $overlay->attributes->headline;
            $sheadline = $overlay->attributes->subheadline;
            
            
            $output .= "[".$voutpads[$index]."]drawtext=text='".$headline."':fontcolor=black:fontsize=35:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-60:enable='between(t,0,15)'[overlayer3_txt3];[overlayer3_txt3]drawtext=text='".$sheadline."':fontcolor=black:fontsize=25:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-18:enable='between(t,0,15)'[overlayer3_txt2];[overlayer3_txt2]drawtext=text='#2':fontcolor=black:fontsize=60:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-677:y=(h-text_h)-34:enable='between(t,0,15)'[".$video->name."_hl];";
            $voutpads[$index] = $video->name."_hl";
            
            
        }
    }
    }
}

// Attach it! (images to videos)
// Headlina!
foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith(strtolower($video->file), '.mp4')) {
    foreach($video->overlays as $mindex => $overlay) {
        if(isset($overlay->attributes->image_name)) {
            $img_name = $overlay->attributes->image_name;
            $start = $overlay->attributes->start;
            $end = $overlay->attributes->end;
            
            $output .= "[".$voutpads[$index]."][".$img_name."]overlay=(main_w-overlay_w)/2:(main_h-overlay_h)/2:enable='between(t,".$start.",".$end.")'[vid_".$index."_img_".$mindex."];";
            $voutpads[$index] = "vid_".$index."_img_".$mindex;
            
            //$output .= $voutpads[$index]."drawtext=text='".$headline."':fontcolor=black:fontsize=35:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-60:enable='between(t,0,15)'[overlayer3_txt3];[overlayer3_txt3]drawtext=text='".$sheadline."':fontcolor=black:fontsize=25:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-30:y=(h-text_h)-18:enable='between(t,0,15)'[overlayer3_txt2];[overlayer3_txt2]drawtext=text='#2':fontcolor=black:fontsize=60:fontfile=/Fonts/Montserrat-Bold.ttf:x=(w-text_w)-677:y=(h-text_h)-34:enable='between(t,0,15)'[".$video->name."_hl];";
            //$voutpads[$index] = "[".$video->name."_hl]";
            //
            //
        }
    }
    }
}

// Video combiner
$count = 0;
foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith(strtolower($video->file), '.mp4')) {
        $output .= "[".$voutpads[$index]."]";
        $count++;
    }
}

$output .= "concat=n=".$count.":v=1:a=0[videos];";

// Audio combiner

foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith(strtolower($video->file), '.mp4')) {
        $output .= "[".$index.":a]";
    }
}

$output .= "concat=n=".$count.":v=0:a=1[vaudio];";

foreach ($ffmpeg as $index => $video ) {
    if(Str::endsWith(strtolower($video->file), '.mp3')) {
        $output .= "[".$index.":a]volume=0.05[music];[vaudio][music]amerge=inputs=2[a]";
    }
}




$output .= "\"";

$output .= " -map \"[videos]\" -map \"[a]\" big_daddy.mp4";





//$response = Http::post('http://198.199.67.139/mpeger/public/api/ffmpeg', $output);

return $output;
    }

    public function createJson($campaign) {

        /*$proppas = $model->getPropsCollection();
        $newone = $template->replicate();
        $newone->author_id = $user_id;
        $newone->save();
                    
        $newhawk = Campaign::where('id', $newone->id)->first();
        $newhawk->setPropsCollection($proppas);
        $newhawk->author_id = $user_id;
        $newhawk->template = 0;

        $copy = $newhawk->copy;
        $copy = str_replace('{{company_name}}', $user->company_name, $copy);
        $newhawk->copy = $copy;
        $newhawk->video_thumbnail = '';

        $newhawk->save(); */

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
  
                //$property = Campaigner::Merger($property, $user_id);
  
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
          

    }

    public function updateVoicemails() {
        $touchpoints = Touchpoint::whereDate('date', today())
        ->where(function ($query) {
            $query->whereNull('call_result')
                ->orWhere('call_result', '');
        })
        ->get();

    foreach ($touchpoints as $touchpoint) {
        $touchpoint->call_result = 'Voicemail';
        $touchpoint->save();
        dump("Touchpoing id updated: ".$touchpoint->id);
    }
    }

    public function createOppFromModel($model, $email = null, $fields = null) {

        dump("Model coming through for the record is: ");
        dump($model);
        // Get the Opp model to duplicate
        $original = Opps::findOrFail(44);
    
        // Create a new Opp model with the same attributes as the original
        $newOpp = $original->replicate();
    
        // Set the email and contact columns with the values from the provided $model
        $newOpp->email = $model->email;
        $newOpp->address = $model->city;
        $newOpp->setup_fee = $fields->setup_fee_amount ?? null;
        $newOpp->contact_air_id = $model->air_id;
        $newOpp->price = $fields->price;
        $newOpp->date = Carbon::today();
        if(isset($fields->period)) {
            $newOpp->monthly = 1;
            $newOpp->period = $fields->period;
        }
        dump("Email we getting through is: ");
        dump($email);
        if(isset($email)) {
        $newOpp->email_body = $email.$newOpp->email_body;
        }
        if(isset($model->account)) { $newOpp->company = $model->account; } else { $newOpp->company = ''; }
        
        $newOpp->name = $model->name;

        
    
        // Update the website column with the $model->website value
        $newOpp->website = $model->website;

        // Stakeholder Update
        $proppas = $newOpp->getStakeholdersCollection();
        foreach($proppas as $proppa) {
        $proppa->attributes->name = $model->name;
        $mobile = $model->mobile;
        $email = $model->email;
        $proppa->attributes->contact_details = 'Mobile: '.$mobile."\n".'Email: '.$email;
        }

        $newOpp->setStakeholdersCollection($proppas);

        // Date Update

        $daters = $newOpp->getScheduleCollection();
        $previousCompletionDate = null;
        foreach ($daters as $key => $proppa) {
            $timestamp = strtotime('+7 days', $previousCompletionDate ?? time());
            $dateString = date('Y-m-d', $timestamp);
            $daters[$key]->attributes->completion = $dateString;
            $previousCompletionDate = $timestamp;
        }
        
        $newOpp->setScheduleCollection($daters);

        $newOpp->company = $model->account;

        
    
        // Save the new Opp model to the database
        $newOpp->save();
    
        // Return the new Opp model
        return $newOpp;
    }


    public function createThumbnail($video_url) {

        $path = parse_url($video_url, PHP_URL_PATH);
        $path = ltrim($path, '/');

        $rand = random_int(0, 9999);

        FFMpeg::fromDisk('s3')
        ->open($path)
        ->getFrameFromSeconds(3)
        ->export()
        ->toDisk('s3')
        ->save('images/screenshots/screenshot-'.$rand.'.png');

    $imgurl = Storage::url('images/screenshots/screenshot-'.$rand.'.png');

    $image = \WideImage\WideImage::load($imgurl);
                
    $resized = $image->resize(850, 450, 'outside');
    $data = $resized->asString('png');
    $result = Storage::disk('s3')->put('images/screenshots/screenshot-'.$rand.'.png', $data);
    return Storage::url('images/screenshots/screenshot-'.$rand.'.png');
        
    }

    public function getTimezoneByCityName($cityName)
    {
      $apiKey = env('GOOGLE_API_KEY'); // Replace with your actual Google Maps API key
  
      // Get the coordinates (latitude and longitude) of the city using the Google Maps Geocoding API
      $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($cityName) . "&key=" . $apiKey;
      $geocodeResponse = Http::get($geocodeUrl);
      $geocodeData = $geocodeResponse->json();
  
      if (isset($geocodeData['results'][0]['geometry']['location'])) {
          $latitude = $geocodeData['results'][0]['geometry']['location']['lat'];
          $longitude = $geocodeData['results'][0]['geometry']['location']['lng'];
  
          // Get the timezone string using the Google Maps Timezone API
          $timestamp = time();
          $timezoneUrl = "https://maps.googleapis.com/maps/api/timezone/json?location=$latitude,$longitude&timestamp=$timestamp&key=" . $apiKey;
          $timezoneResponse = Http::get($timezoneUrl);
          $timezoneData = $timezoneResponse->json();
  
          if (isset($timezoneData['timeZoneId'])) {
              return $timezoneData['timeZoneId'];
          } else {
              return false;
          }
      } else {
          return false;
      }
    }



}