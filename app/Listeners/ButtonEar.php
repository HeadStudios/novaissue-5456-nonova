<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Dnwjn\NovaButton\Events\ButtonClick;

class ButtonEar
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ButtonClick  $event
     * @return void
     */
    public function handle(ButtonClick $event)
    {


        dump("Can I hear something?");
        dump($event);
        
        
    }
}
