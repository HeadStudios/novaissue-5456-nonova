@php
use Illuminate\Support\Str;
@endphp
<html>
    <head>
    <title>{{ $vlesson->title }} - Rent Roll Devour System</title>
    
    <!--<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>-->
    
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <style>
      .prose h1, .prose h2, .prose h3 { margin-bottom: 0 !important; margin-top: 0 !important; }
      .prose :where(h3):not(:where([class~="not-prose"] *)) { margin-top: 0 !important; }
        .plyr audio,.plyr iframe,.plyr video{
    display:block;
    height:100%;
    width:100%
}
.plyr__control--overlaid {
  background-color:black !important;
}
em { font-weight: 800; }
.prose img {
  margin-top:0em;
  margin-bottom:0em;
}
        </style>

<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
@vite(['resources/css/app.css'])


</head>
<body>
@role('guest')
GUEST CONTENT
@endrole

@role('admin')
ADMIN CONTENT
@endrole
<?php

// Prior to 5.4.7 this would show the path as "//www.example.com/path"
?>
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative overflow-hidden">
  <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
    
  </div>

  <div class="relative">
    <div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <nav class="relative flex items-center justify-between sm:h-10 md:justify-center" aria-label="Global">
          <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
            <div class="flex items-center justify-between w-full md:w-auto">
              <!--<a href="/">
                <span class="sr-only">Workflow</span>
                <img class="h-8 w-auto sm:h-10 mb-3" src=" {{ asset('plain-assets/logos/small_tiger_vial.png') }}" alt="">
              </a>-->
              <div class="-mr-2 flex items-center md:hidden">
                <button type="button" class="bg-gray-50 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                  <span class="sr-only">Open main menu</span>
                  <!-- Heroicon name: outline/menu -->
                  
                </button>
              </div>
            </div>
          </div>
          <!-- <div class="hidden md:flex md:space-x-10">
            <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Product</a>

            <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Features</a>

            <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Marketplace</a>

            <a href="#" class="font-medium text-gray-500 hover:text-gray-900">Company</a>
          </div> -->
          <!--<div class="hidden md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0">
            <span class="inline-flex rounded-md shadow">
              <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50"> Log in </a>
            </span>
          </div>-->
        </nav>
      </div>

      <!--
        Mobile menu, show/hide based on menu open state.

        Entering: "duration-150 ease-out"
          From: "opacity-0 scale-95"
          To: "opacity-100 scale-100"
        Leaving: "duration-100 ease-in"
          From: "opacity-100 scale-100"
          To: "opacity-0 scale-95"
      -->
      <div class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        
      </div>
    </div>

    <main class="mx-auto max-w-7xl px-4">
      <div class="text-center">
        <h1 class="sm:text-7xl text-4xl tracking-tight font-extrabold text-gray-900">
          
          <span class="block text-indigo-600 xl:inline">{{ $vlesson->title }}</span>
          <span class="block xl:inline">{{ $vlesson->subheadline }}</span>
        </h1>
        <!--<p class="mt-3 mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl w-full">{{ $vlesson->lesson_outline }}</p>-->
        <!--<div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
          <div class="rounded-md shadow">
            <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"> Get started </a>
          </div>
          <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
            <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10"> Live demo </a>
          </div>
        </div>-->
      </div>
    </main>
  </div>
</div>





<!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<div class="relative bg-white overflow-hidden">
  <div class="hidden lg:block lg:absolute lg:inset-0" aria-hidden="true">
    
  </div>

  <div class="relative pt-6 pb-16 sm:pb-24 lg:pb-32">
    <div>

      <!--
        Mobile menu, show/hide based on menu open state.

        Entering: "duration-150 ease-out"
          From: "opacity-0 scale-95"
          To: "opacity-100 scale-100"
        Leaving: "duration-100 ease-in"
          From: "opacity-100 scale-100"
          To: "opacity-0 scale-95"
      -->
      
    </div>
    <main class="mx-auto max-w-7xl px-4 sm:px-6">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="mt-12 relative lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-7 lg:flex lg:items-start max-w-full mx-0">
          <div class="relative mx-auto w-full rounded-lg shadow-lg">
          <!-- style="height:500px !important;" -->
          @if(Str::contains($vlesson->video_url, 'youtube')) 
          <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $vlesson->video_url }}" playsinline controls style="height:400px !important; width: 100% !important; object-fit: contain !important;">
          </div>
          @else
          <video id="player" playsinline controls style="height:400px !important; width: 100% !important; object-fit: contain !important;">
          <source src="{{ $vlesson->video_url }}" type="video/mp4" />
          </video>
          @endif  

<div class="relative px-4 sm:px-6 lg:px-8">
<div class="sm:text-4xl lg:text-lg max-w-prose mx-auto mt-5 mb-16 prose">



      {!! $vlesson->lesson_outline !!}
  
      </div>
    
  </div>




          </div>
        </div>
        <div class="sm:text-center lg:max-w-2xl lg:mx-auto lg:col-span-5 lg:text-left bg-gray-50 p-4 rounded-lg sm:text-2xl">
            <div>
            <h1>
            <span class="block font-semibold uppercase tracking-wide text-gray-500 lg:text-sm xl:text-base bg-black text-white	inline p-2">LESSON NOTES</span>
            
          </h1>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-4xl lg:text-lg xl:text-xl">Enter your homework here {{ $vlesson->users()->where('user_id', 91)->first()->pivot->instructions  }}</p>
          <div class="max-w-lg mx-auto sm:max-w-full lg:max-w-none">
          <div id="assignment_txt"></div>
        <form action="{{ route('assignment.submit') }}" class="grid grid-cols-1 gap-y-6" id="assignment-form">
          @csrf
          <input type="hidden" name="user_id" value="91">
          <input type="hidden" name="vlesson_id" value="10">
          <div>
            <label for="message" class="sr-only">Mobile</label>
            <textarea name="assignment" rows="8" id="assignment" class="sm:text-5xl block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ $vlesson->users()->where('user_id', 91)->first()->pivot->placeholder  }}"></textarea>
            
          </div>
          <!--<div>
            <label for="message" class="sr-only">Message</label>
            <textarea id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" placeholder="Message"></textarea>
          </div>-->
          <div>
            <button type="submit" id="gogo" class="sm:py-16 sm:px-16 sm:text-6xl inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
            <!-- Calendly link widget begin -->
<!-- Calendly link widget end -->
          </div>
        </form>
        <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 text-sm sm:text-3xl">This is limited and available only to qualified agency owners - to see if you qualify book your "good fit" appointment by entering your details above. I reserve the right to rescind this offer at anytime - if you see the booking form below please register your interest to reserve your spot to learn how to take advantage of this once in a millenium offer.</p>
      </div>
          
</div>
        </div>
        
      </div>
    </main>
  </div>
</div>



<script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
            <script>
  const player = new Plyr('#player', {
  //autoplay: true
});
</script>
<script>
   const form = document.getElementById('assignment-form');
        const textarea = document.getElementById('assignment');
        const assignment_txt = document.getElementById('assignment_txt');
        const myButton = document.getElementById('gogo');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (myButton.textContent === 'Submit') {
            // execute code for submitting the form
            const formData = new FormData(form);

        fetch('{{ route('assignment.submit') }}', {
            method: 'POST',
            body: formData
        });
       
        assignment_txt.textContent = textarea.value;
        assignment_txt.style.display = 'block';
        textarea.style.display = 'none';

        const myButton = document.getElementById('gogo');

        // Change the text of the button to 'Edit'
        myButton.textContent = 'Edit';
        } else if (myButton.textContent === 'Edit') {
            // execute code for editing the form
            textarea.style.display = 'block';
            assignment_txt.style.display = 'none';
            myButton.textContent = 'Submit';

            
        }
        

        

        //alert("IT HAS BEEN SPOKEN");
    });
</script>
</body>
</html>
