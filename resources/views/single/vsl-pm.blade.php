@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp
<html>
    <head>
    <title>{{ $campaign->headline }} - Rent Roll Devour System</title>
    
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
  
@if(isset($campaign->partner))
<div class="flex justify-end items-center">
  <p class="mr-2 text-gray-500 text-sm">In partnership with</p>
  <div class="w-14 h-14" style="margin-right: 20px;">
    <img src="{{ Storage::disk('s3')->url($campaign->partner) }}" class="w-full h-full object-contain" alt="Partner logo">
  </div>
</div>
@endif

<?php

// Prior to 5.4.7 this would show the path as "//www.example.com/path"
?>
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative overflow-hidden">
  <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
    
  </div>

  <div class="relative">

    <main class="mx-auto max-w-7xl px-4">
      <div class="text-center">
        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
          
          <span class="block text-indigo-600 xl:inline">{{ $campaign->headline }}</span>
          <span class="block xl:inline">{{ $campaign->subheadline }}</span>
        </h1>
        <p class="mt-3 mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl w-full">{{ $campaign->excerpt }}</p>
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
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-7 lg:flex lg:items-start">
          <div class="relative mx-auto w-full rounded-lg shadow-lg">
          <!-- style="height:500px !important;" -->
          @if($campaign->youtube_v) 
          <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $campaign->youtube_v }}" playsinline controls style="height:400px !important; width: 100% !important; object-fit: contain !important;">
          </div>
          @else
          <video id="player" playsinline controls style="height:400px !important; width: 100% !important; object-fit: contain !important;" poster="{{ !empty($campaign->video_thumbnail) ? Storage::url($campaign->video_thumbnail) : '' }}">
          <source src="{{ $campaign->tiktok_url }}" type="video/mp4" />
          </video>
          @endif  

<div class="relative px-4 sm:px-6 lg:px-8">
<div class="text-lg max-w-prose mx-auto mt-5 mb-16 prose">

      {!! $campaign->live_copy !!}
  
      </div>
    
  </div>




          </div>
        </div>
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left bg-gray-50 p-4 rounded-lg">
            <div>
              @if($campaign->offer)

              <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base bg-black text-white	inline p-2" style="display:block;">ATTENTION:  INVESTORS NEAR {{ $campaign->author->area }}</span>
            <span class="mt-1 block text-3xl tracking-tight font-extrabold sm:text-3xl xl:text-3xl">
            {!! convertMarkdownToHtml($campaign->offer->headline) !!}</span>
          </h1>
          {!! convertNewLinesToParagraphs($campaign->offer->description, $campaign) !!}

              @else
          <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base bg-black text-white	inline p-2" style="display:block;">ATTENTION:  INVESTORS NEAR {{ $campaign->author->area }}</span>
            <span class="mt-1 block text-3xl tracking-tight font-extrabold sm:text-3xl xl:text-3xl">
            Try our Rental Acceleration System and if We Can't Prove to You How to <span class="block text-indigo-600 contents decoration-4 underline">put an Extra $4,000 in your Pocket</span> Within 12 Months We'll <span class="block text-indigo-600 contents decoration-4 underline">Give You 3 Months Free Property Management</span>
          </h1>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">At {{ $campaign->author->company_name }} we have developed a system to help our clients accelerate their investments and put them in the black using our tailor made rent acceleration system - combining the triad of tax minimisation, minimum property improvement and rent optimisation.</p>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl"> We're so confident we can help you we're offering our rental acceleration system for free to 5 qualified investors who meet our criteria - and guarantee you an additional $4,000 in year end return or we manage your property for free and you don't pay us a cent! </p>
            @endif
          <div class="max-w-lg mx-auto lg:max-w-none">
            
        <form class="grid grid-cols-1 gap-y-6">
          <div>
            <label for="full-name" class="sr-only">Full name</label>
            <input type="text" name="full-name" id="full-name" autocomplete="name" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Full name">
          <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div></div>
          <div>
            <label for="email" class="sr-only">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Email">
          </div>
          <div>
            <label for="phone" class="sr-only">Mobile</label>
            <input type="text" name="mobile" id="mobile" autocomplete="tel" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Phone">
          </div>
          <!--<div>
            <label for="message" class="sr-only">Message</label>
            <textarea id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" placeholder="Message"></textarea>
          </div>-->
          <div>
            <button type="button" id="gogo" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Book Demo</button>
            <!-- Calendly link widget begin -->
<!-- Calendly link widget end -->
          </div>
        </form>
        <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 text-sm">This is limited and available only to qualified agency owners - to see if you qualify book your "good fit" appointment by entering your details above. I reserve the right to rescind this offer at anytime - if you see the booking form below please register your interest to reserve your spot to learn how to take advantage of this once in a millenium offer.</p>
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
  player.poster();
  setTimeout(() => {
	player.poster = '{{ !empty($campaign->video_thumbnail) ? $campaign->video_thumbnail : '' }}';
}, 500); 
</script>
<script>
    const button = document.getElementById('gogo');

    button.addEventListener("click", counter);
    
    function counter() {
        const name = document.getElementById("full-name").value;
        const name_form = document.getElementById("full-name");
        
        const email = document.getElementById("email").value;
        const email_form = document.getElementById("email");

        const mobile = document.getElementById("mobile").value;
        const mobile_form = document.getElementById("mobile");


        
      

        if(name_form.value == '') {
        name_form.style.backgroundColor = '#fbd9d3';
        } else { name_form.style.backgroundColor = 'white'; }
        if(email_form.value == '') {
          email_form.style.backgroundColor = '#fbd9d3';
        } else { email_form.style.backgroundColor = 'white'; }
        if(mobile_form.value == '') {
          mobile_form.style.backgroundColor = '#fbd9d3';
        } else { mobile_form.style.backgroundColor = 'white'; }

        if(name_form.value.length != 0 && email_form.value.length != 0 && mobile_form.value.length != 0) {

          console.log("Everything ready for a Calendly explosion");
          const url = 'https://calendly.com/kosta-kondratenko/rent-roll-boaa-escape?'+serialize({name: name_form.value, email: email_form.value, location: mobile_form.value});
          //console.log("URL is: "+url+serialize({name: name_form.value, email: email_form.value, mobile: mobile_form.value}));
          Calendly.initPopupWidget({url: url});return false;
        }
        
        
        
    }

    function serialize(obj) {

      var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");

    }
    </script>
</body>
</html>

@php
function convertMarkdownToHtml($markdown) {
    $markdown = preg_replace('/\*\*(.*?)\*\*/', '<span class="block text-indigo-600 contents decoration-4 underline">$1</span>', $markdown);

    return $markdown;
}

function convertNewLinesToParagraphs($text, $campaign) {
    $paragraphs = preg_split('/\r\n|\r|\n/', $text);
    $html = '';

    $currentMonth = date('F');
    $companyName = $campaign->author->name;

    foreach ($paragraphs as $paragraph) {
        // Replace merge tags
        $paragraph = str_replace('{{month}}', $currentMonth, $paragraph);
        $paragraph = str_replace('{{company}}', $companyName, $paragraph);

        $html .= '<p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">' . e($paragraph) . '</p>';
    }

    return $html;
}
@endphp
