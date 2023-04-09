<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Storage;

class TasksController extends Controller
{
    public static function home($id)
    {
        return 'Hello, World! The world is numbered '.$id.' from the sun.';
    }

    public function homie()
    {
        // https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg
        
        //\Storage::disk('s3')->put('images/bob.jpg', 'https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg');
        //$contents = \Storage::disk('s3')->get('https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg');
        //\Storage::disk('s3')->put('images/bob2.jpg', $contents);
        //$contents = '';
        //$contents = file_get_contents('https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg', true);
        //copy('https://media.glamour.com/photos/61e9d12ecbe5a7af083cb0be/master/pass/LIQUIDBOB_110122_muah_sabalevskaya_SQ.jpg', $contents);
        //\Storage::disk('s3')->put('images/bob3.jpg', $contents);
        return 'HOMIE IS HERE This is just something to follow suit - and the directory is: - and it will simply work for no reason';
    }

    public function anything()
    {
        return 'PLEASE JUT WORK This is just something to follow suit - and the directory is: - and it will simply work for no reason';
    }

    public function bromie()
    {
        return 'This is just something to follow suit - and it will simply work for no reason';
    }

    public static function inputter(Request $request, $id) {
        //$data=Input::all();
        //echo $request;
        //$input = $request->all();
        $name = $request->input('object.c');
        $job = array('Name' => 'Job 1', 'Email' => 'job2@gmail.com');
                //return "Do you see the Request: ".$input;
        //return "Nothing and no color ".$name."ID is: ".$id;
        return $job;
    }
}
