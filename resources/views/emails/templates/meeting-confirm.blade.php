@component('mail::message')
@php
    $nameParts = explode(' ', $user->name);
    $firstName = array_shift($nameParts);
@endphp

@php
dump("But the fields receiving in the email are...");
dump($fields);

@endphp

Hi {{ $firstName }},

{{ $fields->intro_text }}

Thank you for booking your appointment on {{ $fields->start_time }} ({{ $fields->timezone }}) time.

Looking forward to seeing you!

Make it a great day,  
Kosta Kondratenko  
Mr. Rent Roll Growth  

@endcomponent