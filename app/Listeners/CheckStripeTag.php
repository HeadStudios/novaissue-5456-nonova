<?php



namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;




class CheckStripeTag
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
     * @param  \App\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        
        
        
        $usereo = $event->user;
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    $stripe = new \Stripe\StripeClient(
        env('STRIPE_SECRET')
      );
      $who = $stripe->customers->search([
        'query' => 'email:\''.$usereo->email.'\'',
      ]);
      $result = json_decode($who, true);
      $data = $who->data;
      if(isset($data[0]->id)) { 
        // 
        Cache::set('striper', 'striped'); 
       
      } else { 
        // 
        Cache::set('striper', 'nope');
       
       }

      
        
    }
}
