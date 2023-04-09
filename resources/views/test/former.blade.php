@php
use App\Models\User;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/js/app.js')
  </head>
  <body>
 
  @php
    $boom = array('name' => 'Killer Mike', 'email' => 'killa@gmail.com');
  @endphp

  {{ Aire::open()->route('users.update', 1)
	->bind($boom)
	->post() }}
			
      {{ Aire::input('name', 'Your Name') }} 
      
      {{ Aire::email('email', 'Your Email Address') }} 

      {{ Aire::textArea('bio', 'About You')
  ->rows(3)
  ->cols(40); }}
      
      {{ Aire::submit('Submit') }} 
      
      {{ Aire::close() }}

    
  </body>
</html>