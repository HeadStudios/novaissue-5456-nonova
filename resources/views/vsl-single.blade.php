@php
use Illuminate\Support\Str;
@endphp
<html>
    <head>
    <title>{{ $campaign->headline }} - Rent Roll Devour System</title>
    
    <!--<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>-->
    
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    <style>
        .plyr audio,.plyr iframe,.plyr video{
    display:block;
    height:100%;
    width:100%;
}
.plyr__control--overlaid {
  background-color:black !important;
}
        </style>

<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
@vite(['resources/css/app.css'])
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

</head>
<body>
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
        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
          <div class="px-5 pt-4 flex items-center justify-between">
            <div>
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="">
            </div>
            <div class="-mr-2">
              <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Close menu</span>
                <!-- Heroicon name: outline/x -->
                
              </button>
            </div>
          </div>
          <div class="px-2 pt-2 pb-3">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Product</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Features</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Marketplace</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Company</a>
          </div>
          <a href="#" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100"> Log in </a>
        </div>
      </div>
    </div>

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
      <div class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
          <div class="px-5 pt-4 flex items-center justify-between">
            <div>
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="">
            </div>
            <div class="-mr-2">
              <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Close main menu</span>
                <!-- Heroicon name: outline/x -->
                
              </button>
            </div>
          </div>
          <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Product</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Features</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Marketplace</a>

            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Company</a>
          </div>
          <a href="#" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100"> Log in </a>
        </div>
      </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-7 lg:flex lg:items-start">
          <div class="relative mx-auto w-full rounded-lg shadow-lg">
          <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ $youtube_v }}"></div> <!-- style="height:500px !important;" -->
  
  <!-- Captions are optional -->
</video>


<div class="relative px-4 sm:px-6 lg:px-8">
<div class="text-lg max-w-prose mx-auto mt-5 mb-16 prose">
      
      {!! Str::markdown($campaign->copy) !!}
  
      </div>
    
  </div>




          </div>
        </div>
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left bg-gray-50 p-4 rounded-lg">
            <div>
            <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base bg-black text-white	inline p-2">ATTENTION:  PRINCIPALS / RENT ROLL OWNERS</span>
            <span class="mt-1 block text-3xl tracking-tight font-extrabold sm:text-3xl xl:text-3xl">
            Get a <span class="block text-indigo-600 contents decoration-4 underline"><u class="underline decoration-rose-700">FREE</u> auto generated positioning video</span> and <span class="block text-indigo-600 contents decoration-4 underline">5 <u class="underline decoration-rose-700">free</u> investor leads</span> as a thank you for trying my rent roll growth program.
          </h1>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">Use the power of content marketing to increase your leads by up to 119% by positioning your BDM team as the smartest team in your district to assist investors. Use my fully automated system that works in the background with minimal input to grow your rent roll on auto pilot.</p>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">As part of my February deal I'm so confident in my system I am offering qualified companies a FREE video worth $3,000 and the first 5 leads free to show them how effective my system is. This is not for everyone and I'm only doing 5 of these a month - CLAIM your free video and 5 investor leads by entering your details below.</p>
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
