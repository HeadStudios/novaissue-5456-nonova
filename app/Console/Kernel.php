<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Http;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\User;
use App\Jobs\DrippySequence;
use App\Hydraulics\MMSHolder;
use App\Hydraulics\Campaigner;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Filters as WaterMarker;
use App\Models\VideoAudit;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\DB;
use Binarcode\LaravelMailator\Console\Commands\MailatorSchedulerCommand;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    
  
     



    protected function schedule(Schedule $schedule)
    {

         $schedule->call(function () {
            dump('I am here');
        })->everyMinute();



        $schedule->call(function () {

            

            $campaigns = Campaign::where('tiktok_url', 'LIKE', '%tiktok%')->get();
            foreach($campaigns as $campaign) {
                
                
                $tiktok_url = $campaign->tiktok_url;
                $output = 'images/vidtok-'.rand(0,10000).'.mp4';
                //Storage::put($url, fopen($tiktok_url, 'r'));
                /*Log::debug("Campaign still there?");
                Log::debug($campaign);
                Log::debug($campaign->tiktok_url);
                $url = 'images/vidtok-'.rand(0,1000).'.mp4';
                Storage::put($url, fopen($campaign->tiktok_url, 'r'));
                $url = Storage::disk('s3')->url($url);
                $campaign->tiktok_url = $url;
                $campaign->push();*/
            }

        })->daily();	

        

     /*   $schedule->call(function () {

            $records = DB::connection('remote_mysql')
    ->table('Message')->where('status', 'Received')
    ->where(function($query) {
        $query->where('message', 'LIKE', '%STOP%')
        ->orWhere('message', 'LIKE', '%No%')
        ->orWhere('message', 'LIKE', '%remove%')
        ->orWhere('message', 'LIKE', '%wrong%')
        ->orWhere('message', 'LIKE', '%Unsubscribe%'); 
    })->get();

    $val = '';

    $contacts = Contact::get();
    foreach($records as $record) {

        if($record->number == '+61417667100') {
            
        }

       
        foreach($contacts as $contact) {
            if(!ctype_alpha($record->number)) {

                try {
                $remote_mob = PhoneNumber::make($record->number, 'AU')->formatE164();  
                $local_mob = PhoneNumber::make($contact->mobile, 'AU')->formatE164();  
                } catch(\Exception $e) {
                        // Put here to find bad numbers
                }
                //$remote_mob = $record->number;
                //$local_mob = $contact->mobile;
            if($remote_mob == $local_mob) {
                
                $contact->unsubscribed = 1;
                $contact->save();
                MMSHolder::unsubscribeThem($remote_mob, $contact->name);
            }
        }
        }
        
        
    }


        })->everySixHours(); */

       /* $schedule->call(function () {

            // Code to check Campaign videos - download and upload to Amazon - loaded and to change the URL so they can be viewed
            

            $campaigns = Campaign::where('tiktok_url', 'NOT LIKE', '%http%')->get();
            foreach($campaigns as $campaign) {
                $video_id = $campaign->tiktok_url;
                $response = Http::withHeaders([
                    'x-api-key' => 'YTU1NDBmNTY5Y2NhNGYwY2FlZmI2NWU0MDg3MWVmMjItMTY1NzI1ODI3MA=='
                ])->get('https://craft-api.surreal-ai.com/pacific/api/v1/video_status.get', [
                    'video_id' => $video_id
                ]); 

                if($response['data']['status'] == 'completed') {

                    $video = $response['data']['video_url'];
                    $path = 'videos/scripts/final/script_'.rand(0,1000).'.mp4';

                    Storage::put($path, fopen($video, 'r'));
                    $url = Storage::disk('s3')->url($path);                    

                    $campaign->tiktok_url = $url;

                $campaign->push();

                $permalink = env('APP_URL').'/video-ai/'.$campaign->author->company_permalink.'/'.$campaign->permalink;

                $details = [
                    'name' => $campaign->author->name,
                    'subject' => 'Your video is ready!',
                    'body' => 'Your video is ready - and the perma is: '.$permalink
                ];

                \Mail::to('enquiries@headstudios.com.au')->send(new \App\Mail\OppsEmail($details));
                



                } 
                
            }
            
        })->everySixHours();  */

        

        /*$schedule->call(function () {

            $campaigns = Campaign::whereNull('video_thumbnail')->orWhere('video_thumbnail','')->get();

            

   
            foreach($campaigns as $campaign) {

                //return $campaign->id;

                /*if(str_contains($campaign->tiktok_url, 'mp4') && str_contains($campaign->tiktok_url, 'http') && empty($campaign->video_thumbnail)) {

                    $imgname = 'vthumb-'.$campaign->id.'-'.rand(0,1000).'.jpg';
                
                    shell_exec('ffmpeg -ss 1 -i '.$campaign->tiktok_url.' -qscale:v 5 -frames:v 1 '.public_path().'/images/'.$imgname);
                    
                    //
                    Storage::put('images/thumbnails/'.$imgname, file_get_contents(public_path().'/images/'.$imgname));
                    $campaign->video_thumbnail = 'images/thumbnails/'.$imgname;
                    $campaign->save();

                    $user = User::find($campaign->author_id);

                    //if($user->ready()) {
                    //    DrippySequence::dispatch($user->id);
                    //}


                } */

              

            //}

        //})->everySixHours();

       /* $schedule->call(function () {
            
            
            $audit = VideoAudit::where('audit_url', 'LIKE', '%getcloudapp.%')->first();
                $imgurl = $audit->logo_url;  // \Storage::disk('s3')->url('images/Alice32.png');
                $image = \WideImage\WideImage::load($imgurl);
                
                $resized = $image->resize(466, 154, 'outside');
                $data = $resized->asString('png');
                $result = \Storage::disk('s3')->put('images/client_logo.png', $data);
                $client_logo = \Storage::disk('s3')->url('images/client_logo.png');

                //https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/images/small_tiger_vial.png

                $mylogo = \Storage::disk('s3')->url('images/small_tiger_vial.png');  // \Storage::disk('s3')->url('images/Alice32.png');
                $image = \WideImage\WideImage::load($mylogo);
                
                $resized = $image->resize(350, 120, 'outside');
                $data = $resized->asString('png');
                $result = \Storage::disk('s3')->put('images/my_logo.png', $data);
                $tiger_logo = \Storage::disk('s3')->url('images/my_logo.png');

                //$image_ur = $audit->logo_url;
                $audit_url = $audit->audit_url;
                $name = $audit->contact_name;
                $permalink = $audit->permalink;
                $audit_name = $permalink.'-'.rand(0,1000).'.mp4';
                $path = 'videos/audits/final/'.$audit_name;
                //return 'Video AUDIT URL is: '.$audit->audit_url; 

                \FFMpeg::openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/audits/conversion_rate_audit.mp4')->openUrl($audit_url)->openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/audits/outro_generic.mp4')->openUrl($tiger_logo)->openUrl($client_logo)
            ->addFilter('[0:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[a]')
            ->addFilter('[1:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[b]')
            ->addFilter('[2:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[c]')
            ->addFilter('[a][0:a][b][1:a][c][2:a]', 'concat=n=3:v=1:a=1', '[concat1]')
            ->addFilter('[concat1]', 'drawtext=text=\'Video Audit for\':fontcolor=white:fontsize=20:box=1:boxcolor=black:fontfile=/Users/kostakondratenko/Dropbox/larapi/storage/fonts/mont_bold_normal_3ef16c3fc239e05137df2565b4634870.ttf:boxborderw=5:x=(w-text_w)-30:y=(h-text_h)-300:enable=\'between(t,0,85)\'', '[concatz]')
            ->addFilter('[concatz]', 'drawtext=text=\''.$name.'\':fontcolor=white:fontsize=55:box=1:boxcolor=black:fontfile=/Users/kostakondratenko/Dropbox/larapi/storage/fonts/mont_bold_normal_3ef16c3fc239e05137df2565b4634870.ttf:boxborderw=5:x=(w-text_w)-30:y=(h-text_h)-240:enable=\'between(t,0,85)\'', '[concat2]')
            ->addFilter('[concat2][3]', 'overlay=25:y=500:enable=\'between(t,0,85)\'', '[concat4]')
            ->addFilter('[concat4][4]', 'overlay=main_w-overlay_w-25:y=500:enable=\'between(t,0,85)\'', '')
            ->export()
            ->addFormatOutputMapping(new \FFMpeg\Format\Video\X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('s3', $path), ['-vn?', '-an?'])
            ->save($path);

                $audit->audit_url = \Storage::disk('s3')->url($path);

                $audit->save(); 

                

            })->everySixHours(); */
                
                /*
                $url = 'images/vidtok-'.rand(0,1000).'.mp4';
                Storage::put($url, fopen($campaign->tiktok_url, 'r'));
                $url = Storage::disk('s3')->url($url);
                $campaign->tiktok_url = $url;
                $campaign->push();
                Http::post('https://webhook.site/60b9fdd8-2ab9-40ae-9e13-681a9f0c0171', [
                    'verse 1' => 'Off and on',
                    'verse 2' => 'Every day is on',
                    'vid_url' => $url
                ]);
                
            }
        })->everyMinute(); */
    
        // Open this up after Joshua hears reason
       /*$schedule->call(function () {
            $campaigns = Campaign::where('tiktok_url', 'REGEXP', '[0-9a-f]{32}')
            ->where(function ($query) {
                $query->orWhereNull('video_thumbnail')
                    ->orWhere('video_thumbnail', '=', '');
            })
            ->get();
            foreach ($campaigns as $campaign) {
                //$campaign->is_running = true;
                //$campaign->save();

                $url_request = 'https://craft-api.surreal-ai.com/pacific/api/v1/video_status.get?video_id='.$campaign->tiktok_url;
                dump("URL sent is: ");
                dump($url_request);

        
                $response = Http::withHeaders([
                    'x-api-key' => env('MOVIO_API')
                ])->get($url_request, [
                    'video_id' => $campaign->tiktok_url
                ]);

                dump("The response is: ");
                dump($response->json());

                $responseData = $response->json();
                if (isset($responseData['code']) && $responseData['code'] === 40012) {
                    continue;
                }
        
                if ($response['data']['status'] == 'completed') {
                    $path = 'videos/scripts/final/script_' . rand(0, 1000) . '.mp4';
                    $video = $response['data']['video_url'];
                    Storage::put($path, fopen($video, 'r'));
                    $url = Storage::disk('s3')->url($path);
                    $campaign->tiktok_url = $url;

                    $thumb = app()->make('CampMan')->createThumb($url);
                    $base_url = 'https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/';
                    $relative_thumb_url = str_replace($base_url, '', $thumb);
                    $campaign->video_thumbnail = $relative_thumb_url;

                    //$campaign->is_running = false;
                    $campaign->save();

                    $screenshot = app()->make('CampMan')->screenshotModel($campaign);
                }
            }
        })->name('check-campaigns')->everyMinute()->withoutOverlapping(); */

        /*
        // $schedule->command('inspire')->hourly();
        */ 

        $schedule->call(function () {
            
            $campaigns = Campaign::where('tiktok_url', 'LIKE', '%tiktok%')->get();
            foreach($campaigns as $campaign) {
                Log::debug("Campaign still there?");
                Log::debug($campaign);
                Log::debug($campaign->tiktok_url);
                $url = 'images/vidtok-'.rand(0,1000).'.mp4';
                Storage::put($url, fopen($campaign->tiktok_url, 'r'));
                $url = Storage::disk('s3')->url($url);
                $campaign->tiktok_url = $url;
                $campaign->push();
            }
        })->everySixHours();

        
        
        // Is this required if done on push?
        
        

        /*$schedule->call(function () {

            $audits = VideoAudit::where('audit_url', 'LIKE', '%getcloudapp.%')->get();
            foreach($audits as $audit) {
                $audit_url = $audit->audit_url;
                $name = $audit->headline;
                $permalink = $audit->permalink;
                $audit_name = $permalink.'-'.rand(0,1000).'.mp4';
                $path = 'videos/audits/final/'.$audit_name;
                //return 'Video AUDIT URL is: '.$audit->audit_url; 

                \FFMpeg::openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/audits/conversion_rate_audit.mp4')->openUrl($audit_url)->openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/audits/outro_generic.mp4')->openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/0H7BV5ox4FZeXYGS22GiL4Fks32uvyReTBhVNrdW.png')->openUrl('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/0H7BV5ox4FZeXYGS22GiL4Fks32uvyReTBhVNrdW.png')
                ->addFilter('[0:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[a]')
                ->addFilter('[1:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[b]')
                ->addFilter('[2:v]', 'scale=1152:720:force_original_aspect_ratio=decrease,pad=1152:720:(ow-iw)/2:(oh-ih)/2:black,fps=30', '[c]')
                ->addFilter('[a][0:a][b][1:a][c][2:a]', 'concat=n=3:v=1:a=1', '[concat1]')
                ->addFilter('[concat1]', 'drawtext=text=\'Video Audit for\':fontcolor=white:fontsize=20:box=1:boxcolor=black:fontfile=/Users/kostakondratenko/Dropbox/larapi/storage/fonts/mont_bold_normal_3ef16c3fc239e05137df2565b4634870.ttf:boxborderw=5:x=(w-text_w)-30:y=(h-text_h)-300:enable=\'between(t,0,63)\'', '[concatz]')
                ->addFilter('[concatz]', 'drawtext=text=\'John McAfee\':fontcolor=white:fontsize=55:box=1:boxcolor=black:fontfile=/Users/kostakondratenko/Dropbox/larapi/storage/fonts/mont_bold_normal_3ef16c3fc239e05137df2565b4634870.ttf:boxborderw=5:x=(w-text_w)-30:y=(h-text_h)-240:enable=\'between(t,0,63)\'', '[concat2]')
                ->addFilter('[concat2][3]', 'overlay=25:main_h-overlay_h-25:enable=\'between(t,0,20)\'', '[concat4]')
                ->addFilter('[concat4][4]', 'overlay=main_w-overlay_w-25:main_h-overlay_h-25:enable=\'between(t,0,20)\'', '')
                ->export()
                ->addFormatOutputMapping(new \FFMpeg\Format\Video\X264, \ProtoneMedia\LaravelFFMpeg\Filesystem\Media::make('s3', $path), ['-vn?', '-an?'])
                ->save($path);

                //$audit->audit_url = env('AWS_BASE').$path;
                //$audit->push();

                return env('AWS_BASE').$path;

                return 'Off without a hitch';
            }
            //}

        })->everyMinute();  */
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
