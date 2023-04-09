@component('mail::message')
@php
    $nameParts = explode(' ', $user->name);
    $firstName = array_shift($nameParts);
@endphp
Hi {{ $firstName }},

{{ $fields->message }}

Best,  
Kosta

@endcomponent

