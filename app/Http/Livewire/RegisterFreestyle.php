<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterFreestyle extends Component
{

    public $users, $email, $password, $name;
    public $registerForm = false;

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function register()
    {
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $passcode = $this->password; // to get non hashed version later 
        $this->password = Hash::make($this->password); 

        $insert = User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);
        $id = $insert->id;

        Auth::attempt(['email' => $this->email, 'password' => $passcode]);

        $success = env('APP_URL').'/nova/dashboards/main';
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email' => $this->email,
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              
              'price' => 'price_1LbMErEe533rJJ8weM4W72Vb',
              'quantity' => 1,
            ]],
            'subscription_data' => [
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                
                'trial_period_days' => 30
              ],
            'mode' => 'subscription',
            'success_url' => $success,
            'cancel_url' => env('APP_URL').'/nevermind',
          ]);
        //return $checkout_session;

        $this->resetInputFields();

        return redirect()->to($checkout_session['url']);

        //session()->flash('message', 'Your register successfully Go to the login page.');

        

    }

    public function render()
    {
        return view('livewire.register-freestyle');
    }
}
