<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;


class ImageMagic {

    public static function createImage($url, $name, $left=46, $top=151, $fontsize=48) {

        
        $file_txt = str_replace(' ', '_', $name);
        $filename = 'images/'.$file_txt.rand(0,100).'.png';
        $imgurl = Storage::disk('s3')->url($url);
        $image = \WideImage\WideImage::load($imgurl);
        $canvas = $image->getCanvas();
        $font = public_path().'/fonts/arialblack.ttf';
        $canvas->useFont($font, $fontsize, $image->allocateColor(76, 75, 75)); 
        $canvas->writeText($left, $top, $name);
        $data = $image->asString('png');
        $result = Storage::disk('s3')->put($filename, $data);
        return $filename;
        /*
        Log::debug('Name argument is: ');
        Log::debug($name);
        Log::debug('URL argument is: ');
        Log::debug($url);
        $imgurl = Storage::disk('s3')->url('iywHgix0fFxCMqxgbhJRsc3fDnMD4h5G870HP3rs.png');
        //$imgurl = 'https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/images/bob3.jpg';
        Log::debug('URL is: ');
        Log::debug($imgurl);
        
        $path = 'images/'.$name.rand(1,100).'.jpg';
        Log::debug('Path to the file is:');
        Log::debug($path);
        //Storage::disk('s3')->put($path, $data);
        Storage::disk('s3')->put($path, file_get_contents($imgurl));
        return $path;
        //$file = 'images/'.$name.rand(1,100).'.jpg';
        //$file = str_replace(' ', '_', $file);
        //$image->saveToFile($file);
        //$complete = $this->url.$file;
        //return $complete;
        //return $imgurl;
        */
    }

    public static function return32() {
        
        $imgurl = Storage::disk('s3')->url('images/bob3.jpg');
        $image = \WideImage\WideImage::load('https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/images/bob3.jpg');
        $canvas = $image->getCanvas();
        $name = 'John Connor';
        $font = public_path().'/fonts/arialblack.ttf';
        $canvas->useFont($font, 100, $image->allocateColor(76, 75, 75)); 
        $canvas->writeText('42', '135', $name);
        $data = $image->asString('jpg');
        Storage::disk('s3')->put('images/newstuffaadfd.jpg', $data);
        //$file = 'images/'.$name.rand(1,100).'.jpg';
        //$file = str_replace(' ', '_', $file);
        //$image->saveToFile($file);
        //$complete = $this->url.$file;
        //return $complete;
        return $imgurl;
    }

}