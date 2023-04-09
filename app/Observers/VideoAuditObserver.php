<?php

namespace App\Observers;

use App\Models\VideoAudit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Jobs\VideoAuditProcessor;
use Illuminate\Support\Facades\Http;
//SmileAndWave::dispatch($contact, $model);


class VideoAuditObserver
{
    /**
     * Handle the VideoAudit "created" event.
     *
     * @param  \App\Models\VideoAudit  $videoAudit
     * @return void
     */
    public function created(VideoAudit $audit)
    {

        

        //VideoAuditProcessor::dispatch($audit);

        /*
                Log::debug("We here! KSI about to dissapear!!");

                $imgurl = \Storage::disk('s3')->url($audit->logo_url);  // \Storage::disk('s3')->url('images/Alice32.png');
                $image = \WideImage\WideImage::load($imgurl);

                $resized = $image->resize(50, 154, 'outside');
                $data = $resized->asString('png');
                $result = \Storage::disk('s3')->put('images/client_logo.png', $data);
                $client_logo = \Storage::disk('s3')->url('images/client_logo.png');

                https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/images/small_tiger_vial.png

                $mylogo = \Storage::disk('s3')->url('images/small_tiger_vial.png');  // \Storage::disk('s3')->url('images/Alice32.png');
                $image = \WideImage\WideImage::load($mylogo);

                $resized = $image->resize(150, 120, 'outside');
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

                $audit->save(); */
            
    }

    /**
     * Handle the VideoAudit "updated" event.
     *
     * @param  \App\Models\VideoAudit  $videoAudit
     * @return void
     */
    public function updated(VideoAudit $videoAudit)
    {
        //
    }

    /**
     * Handle the VideoAudit "deleted" event.
     *
     * @param  \App\Models\VideoAudit  $videoAudit
     * @return void
     */
    public function deleted(VideoAudit $videoAudit)
    {
        //
    }

    /**
     * Handle the VideoAudit "restored" event.
     *
     * @param  \App\Models\VideoAudit  $videoAudit
     * @return void
     */
    public function restored(VideoAudit $videoAudit)
    {
        //
    }

    /**
     * Handle the VideoAudit "force deleted" event.
     *
     * @param  \App\Models\VideoAudit  $videoAudit
     * @return void
     */
    public function forceDeleted(VideoAudit $videoAudit)
    {
        //
    }
}
