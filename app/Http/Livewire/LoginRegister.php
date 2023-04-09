<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginRegister extends Component
{
    public $users, $email, $password, $name;
    public $registerForm = false;

    protected $messages = [
        'required' => 'Please double check :attribute',
        'email.email' => 'The Email Address format is not valid.',
    ];

    public function render()
    {
        return view('livewire.login-register');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function login()
    {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(Auth::attempt(array('email' => $this->email, 'password' => $this->password))){
                session()->flash('message', "You are Login successful.");
                return redirect()->to('/lms/dashboard');
        }else{
            session()->flash('error', 'email and password are wrong.');
            $message = "That's how wiggas get tossed up";
            $error = "How wiggas tossed up";
        }
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

        $this->password = Hash::make($this->password); 

        User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password]);

        session()->flash('message', 'Your register successfully Go to the login page.');

        $this->resetInputFields();

    }
}