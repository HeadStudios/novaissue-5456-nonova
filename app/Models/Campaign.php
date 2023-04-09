<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Illuminate\Support\Collection;
use App\Models\GlobalMerge;
use AshAllenDesign\ShortURL\Models\ShortURL as ShortURLModel;
use Michelf\Markdown;
use WideImage\WideImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
//use Oneduo\NovaFileManager\Casts\AssetCollection;


class Campaign extends Model
{
    use HasFactory;
    protected $table = 'campaign';
    public static $group = 'Marketing';

    protected $fillable = ['headline', 'subheadline', 'video_props', 'video_thumbnail', 'nova_file'];

    protected $casts = [
       
        'video_props' => FlexibleCast::class,
        'ffmpeg' => FlexibleCast::class,
        //'nova_file' => AssetCollection::class

    ];

    public function generateThumbnailWithPlayButton()
{
    // Generate the folder and filename for the modified thumbnail
    $folder = 'campaign-thumbnails';
    $filename = Str::beforeLast($this->video_thumbnail, '.') . '-with-play-button.png';
    $filePath = $folder . '/' . $filename;

    dump("Filepath is: ".$filePath);

    // Check if the modified thumbnail already exists in the S3 bucket
    if (!Storage::disk('s3')->exists($filePath)) {

        
        // Read the video thumbnail from the S3 bucket
        $thumbnailContents = Storage::disk('s3')->get($this->video_thumbnail);

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

    // Return the full URL of the stored play button image
    $full_url = Storage::disk('s3')->url($filePath);
    dump("For some mysterious reson the s3 url for filepath ".$filePath." is: ".$full_url);
    return $full_url;
}

    public function getLiveCopyAttribute()
{
    $copy = $this->attributes['copy'];
    /*preg_match_all('/{!(.*?)}/', $copy, $matches);
    if (count($matches[1])) {
        foreach ($matches[1] as $match) {
            $name = trim($match);
            $value = GlobalMerge::where('name', $name)->first();
            if($value)
                $copy = str_replace("{!{$name}}", $value->value, $copy);
            else
                $copy = str_replace("{!{$name}}", '', $copy);
        }
    }*/
    
    $copy = $this->makeToc($copy);
    $copy = Markdown::defaultTransform($copy);
    $copy = preg_replace('/{#(.*?)}/', '<a id="$1"></a>', $copy);
    $copy = $this->remove_p_tags($copy);
    return $copy;
}


    public function campaigncontacts()
    {
        return $this->hasMany(CampaignContact::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    } 

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    } 



    public function getFullUrlAttribute()
    {
        try {
            $compa_perma = $this->author->company_permalink;
            $url = route('landing', ['category' => $this->category, 'permalink' => $this->permalink, 'compa_perma' => $compa_perma]);
            
            return $url;
        } catch (\Exception $e) {
            return 'NO URL FOUND';
        }
        return "Website!";
    }

    public function makeToc($copy)
    {
        preg_match_all('/(^#+\s+)(.*)$/m', $copy, $matches, PREG_SET_ORDER);
        $table_of_contents = "## Table of Contents\n";
        foreach ($matches as $match) {
            $level = strlen($match[1]) - strlen(ltrim($match[1], "#"));
            $link = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $match[2]));
            $table_of_contents .= str_repeat("  ", $level - 1) . "* [" . $match[2] . "](#" . $link . ")\n";
            $copy = preg_replace_callback('/(^'.preg_quote($match[0]).')/m', function($matches) use ($link) {
                return '{#'.$link.'"}'.PHP_EOL.$matches[1];
            }, $copy);
        }
        return $table_of_contents . "\n" . $copy;
    }
    
    protected function remove_p_tags($html) {
        // Regular expression pattern to match <p> tags immediately followed by an <a> tag with an id attribute
        $pattern = '/<p>(?=<a id="(.*?)">)(.*?)(<\/a>)<\/p>/';
        // Replacement string with the <a> tag and its contents
        $replacement = '<a id="$1">$3';
        // Use preg_replace to replace all matches of the pattern with the replacement string
        return preg_replace($pattern, $replacement, $html);
    }
    





    public function getShortUrlAttribute()
    {
        
        $destination_url = $this->full_url;
        $shortURLKey = $this->shortlink_path;
        
        try {
            $shortURL = ShortURLModel::where('url_key', $shortURLKey)->firstOrFail();
            return $shortURL->default_short_url;
        } catch (\Exception $e) {
            $builder = new \AshAllenDesign\ShortURL\Classes\Builder();
            $shortURLObject = $builder->destinationUrl($destination_url)->urlKey($shortURLKey)->make();
            $shortURL = $shortURLObject->default_short_url;
            
            return $shortURL;
        }
    }


    public function getYoutubeVAttribute()
    {
        if(strpos($this->tiktok_url, 'youtube') !== false) {
            parse_str(parse_url($this->tiktok_url, PHP_URL_QUERY), $vars);
            return $vars['v'];
        }
        return false;
    }

    public function getPropsCollection(): Collection
    {
         return new Collection(
              isset($this->attributes['video_props']) 
              ? json_decode($this->attributes['video_props'], false) 
              : []
         );
    }
    
    public function setPropsCollection(Collection $products): void
    {
         $this->attributes['video_props'] = $products->toJson();
    }

    
      

}
