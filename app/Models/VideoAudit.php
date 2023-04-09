<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WideImage\WideImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VideoAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'permalink',
        'headline',
        'subheadline',
        'audit_url',
        'v_thumbnail'
    ];

    protected $table = 'video_audit';

    public function getFullUrlAttribute() {
        return env('APP_URL').'/audit/'.$this->permalink;
    }

    public function contact()
{
    return $this->belongsTo(Contact::class, 'contact_id', 'air_id');
}

public function generateThumbnailWithPlayButton()
{
    // Generate the folder and filename for the modified thumbnail
    $folder = 'videoaudit-thumbnails';
    $filename = Str::beforeLast(Str::afterLast($this->v_thumbnail, '/'), '.') . '-with-play-button.png';
    $filePath = $folder . '/' . $filename;

    dump("Filepath is: " . $filePath);

    // Check if the modified thumbnail already exists in the S3 bucket
    if (!Storage::disk('s3')->exists($filePath)) {

        // Read the video thumbnail from the S3 bucket
        $thumbnailContents = file_get_contents($this->v_thumbnail);

        // Load the thumbnail image using WideImage
        $thumbnail = WideImage::loadFromString($thumbnailContents);

        // Load the play button image
        $playButton = WideImage::load('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/images/play-button-smooth.png');

        // Resize the play button to 50% of the thumbnail size
        $playButtonWidth = $thumbnail->getWidth() / 2;
        $playButtonHeight = $thumbnail->getHeight() / 2;
        $playButton = $playButton->resize($playButtonWidth, $playButtonHeight);

        // Set play button opacity
        $playButton = $playButton->asTrueColor()->applyFilter(IMG_FILTER_COLORIZE, 0, 0, 0, 127 * 0.5);

        // Calculate the position of the play button
        $positionX = ($thumbnail->getWidth() - $playButton->getWidth()) / 2;
        $positionY = ($thumbnail->getHeight() - $playButton->getHeight()) / 2;

        // Merge the thumbnail and play button images
        $result = $thumbnail->merge($playButton, $positionX, $positionY);

        // Store the resulting image in the S3 bucket
        $resultAsString = $result->asString('png');
        Storage::disk('s3')->put($filePath, $resultAsString);
    }
    $full_url = Storage::disk('s3')->url($filePath);
    dump("For some mysterious reason the s3 url for filepath " . $filePath . " is: " . $full_url);
    return $full_url;
}
}
