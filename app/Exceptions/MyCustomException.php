<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class MyCustomException extends Exception
{

    public function render($request)
    {

        
        //return redirect()->route('terms');
        return route('terms');
    }
}