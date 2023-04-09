<?php
use Illuminate\Support\Facades\Storage;
if(isset($_GET['logout'])) { Auth::logout(); }
?>
<!DOCTYPE html>
<html lang="en"  class="scroll-smooth">
<head>
@livewireScripts
    <title>Rent Roll Devour System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://rsms.me/inter/inter.css">-->
    @vite(['resources/css/app.css'])
    <!--<link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">-->
    <style>
      @media(min-width: 768px) {
      .width-200 {
        background-color:white;
        width:200%;
      } }
    </style>
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-900">
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative bg-white">
  <div class="flex justify-between items-center px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
    <div>
      <a href="#" class="flex">
        <span class="sr-only">Workflow</span>
        <img class="h-12 w-auto sm:h-12" src="{{ $logo_url }}" alt="" style="width:250px;height:80px;object-fit:contain;">
      </a>
    </div>
    <div class="-mr-2 -my-2 md:hidden">
      <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false" id="main-menu">
        <span class="sr-only">Open menu</span>
        <!-- Heroicon name: outline/menu -->
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="position:fixed; z-index:8000;">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    <div class="hidden md:flex-1 md:flex md:items-center md:justify-between " style="justify-content:flex-end;">
      <nav class="flex space-x-10">
        <div class="relative">
          <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
          

          <!--
            'Solutions' flyout menu, show/hide based on flyout menu state.

            Entering: "transition ease-out duration-200"
              From: "opacity-0 translate-y-1"
              To: "opacity-100 translate-y-0"
            Leaving: "transition ease-in duration-150"
              From: "opacity-100 translate-y-0"
              To: "opacity-0 translate-y-1"
          -->
          <!--
    Mobile menu, show/hide based on mobile menu state.

    Entering: "duration-200 ease-out"
      From: "opacity-0 scale-95"
      To: "opacity-100 scale-100"
    Leaving: "duration-100 ease-in"
      From: "opacity-100 scale-100"
      To: "opacity-0 scale-95"
  -->
  
        </div>
        <a href="#why" class="text-base font-medium text-gray-500 hover:text-gray-900">Why {{ $fname }}</a>
        <a href="#testimonials" class="text-base font-medium text-gray-500 hover:text-gray-900">Testimonials</a>
        <a href="#difference" class="text-base font-medium text-gray-500 hover:text-gray-900">Difference</a>
        <a href="#videos" class="text-base font-medium text-gray-500 hover:text-gray-900">Thought Leadership</a>

        <div class="relative">
          <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
          

          <!--
            'More' flyout menu, show/hide based on flyout menu state.

            Entering: "transition ease-out duration-200"
              From: "opacity-0 translate-y-1"
              To: "opacity-100 translate-y-0"
            Leaving: "transition ease-in duration-150"
              From: "opacity-100 translate-y-0"
              To: "opacity-0 translate-y-1"
          -->
          <div class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0 hidden">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
              <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                  <p class="text-base font-medium text-gray-900">Help Center</p>
                  <p class="mt-1 text-sm text-gray-500">Get all of your questions answered in our forums or contact support.</p>
                </a>

                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                  <p class="text-base font-medium text-gray-900">Guides</p>
                  <p class="mt-1 text-sm text-gray-500">Learn how to maximize our platform to get the most out of it.</p>
                </a>

                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                  <p class="text-base font-medium text-gray-900">Events</p>
                  <p class="mt-1 text-sm text-gray-500">See what meet-ups and other events we might be planning near you.</p>
                </a>

                <a href="#" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                  <p class="text-base font-medium text-gray-900">Security</p>
                  <p class="mt-1 text-sm text-gray-500">Understand how we take your privacy seriously.</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div class="flex items-center md:ml-12">
        <!--<a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900"> Sign in </a>-->
        <a href="#contact" class="ml-8 inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Book Call</a>
      </div>
    </div>
  </div>

  <!--
    Mobile menu, show/hide based on mobile menu state.

    Entering: "duration-200 ease-out"
      From: "opacity-0 scale-95"
      To: "opacity-100 scale-100"
    Leaving: "duration-100 ease-in"
      From: "opacity-100 scale-100"
      To: "opacity-0 scale-95"
  -->
  <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right hidden" style="z-index:9999; position:fixed;" id="mobmenu">
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
      <div class="pt-5 pb-6 px-5">
        <div class="flex items-center justify-between">
          <div>
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
          </div>
          <div class="-mr-2">
            <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" id="mobmenu">
              <span class="sr-only">Close menu</span>
              <!-- Heroicon name: outline/x -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <div class="py-6 px-5">
        <div class="grid grid-cols-1 gap-4">

          <a href="#why" class="text-base font-medium text-gray-900 hover:text-gray-700"> Why {{ $fname }} </a>

          <a href="#testimonials" class="text-base font-medium text-gray-900 hover:text-gray-700"> Testimonials </a>

          <a href="#difference" class="text-base font-medium text-gray-900 hover:text-gray-700">Difference </a>

          <a href="#videos" class="text-base font-medium text-gray-900 hover:text-gray-700"> Thought Leadership </a>
        </div>
        <div class="mt-6">
          <a href="#contact" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"> Book </a>
          <!--<p class="mt-6 text-center text-base font-medium text-gray-500">
            Existing customer?
            <a href="#contact" class="text-indigo-600 hover:text-indigo-500"> Book </a>
          </p>-->
        </div>
      </div>
    </div>
  </div>
</div>


  <main class="lg:relative">
    <div class="mx-auto max-w-7xl w-full pt-16 pb-20 text-center lg:py-48 lg:text-left">
      <div class="px-4 lg:w-1/2 sm:px-8 xl:pr-16">
        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
          <span class="block xl:inline">{{ $user->area }}'s </span><span class="block text-indigo-600 xl:inline">Growth Oriented</span>
          <span class="block xl:inline">Property Manager</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-lg text-gray-500 sm:text-xl md:mt-5 md:max-w-3xl">Hi, I'm {{ $fname }} and I help property investors maximise their rental income and protect their downside using my unique investment acceleration and risk assessment methodology.</p>
        <div class="mt-10 sm:flex sm:justify-center lg:justify-start">
          <div class="rounded-md shadow">
            <a href="#contact" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"> Book Property Audit </a>
          </div>
          <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
            <a href="#why" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10"> Who is {{ $fname }} </a>
          </div>
        </div>
      </div>
    </div>
    <div class="relative w-full h-64 sm:h-72 md:h-96 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 lg:h-full">
      <img class="absolute inset-0 w-full h-full object-cover object-top" src="{{ $hero_image }}" alt="">
    </div>
  </main>
</div>


<a id="why"></a>
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative bg-white py-16 sm:py-24">
  <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:gap-24 lg:items-start">
    <div class="relative sm:py-16 lg:py-0">
      <div aria-hidden="true" class="hidden sm:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-screen">
        <div class="absolute inset-y-0 right-1/2 w-full bg-gray-50 rounded-r-3xl lg:right-72"></div>
        <svg class="absolute top-8 left-1/2 -ml-3 lg:-right-8 lg:left-auto lg:top-12" width="404" height="392" fill="none" viewBox="0 0 404 392">
          <defs>
            <pattern id="02f20b47-fd69-4224-a62a-4c9de5c763f7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
              <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
            </pattern>
          </defs>
          <rect width="404" height="392" fill="url(#02f20b47-fd69-4224-a62a-4c9de5c763f7)" />
        </svg>
      </div>
      <div class="relative mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-0 lg:max-w-none lg:py-20">
        <!-- Testimonial card-->
        <div class="relative pt-64 pb-10 rounded-2xl shadow-xl overflow-hidden">
          <img class="absolute inset-0 h-full w-full object-cover object-top" src="{{ $profile_image }}" alt="">
          <div class="absolute inset-0 bg-indigo-500 mix-blend-multiply"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-indigo-600 via-indigo-600 opacity-90"></div>
          <div class="relative px-8">
            <div>
              <img class="h-12" src="{{ $logo_url }}" alt="Workcation">
            </div>
            <blockquote class="mt-8">
              <div class="relative text-lg font-medium text-white md:flex-grow">
                <svg class="absolute top-0 left-0 transform -translate-x-3 -translate-y-2 h-8 w-8 text-indigo-400" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                  <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                </svg>
                <p class="relative">From choosing the right insurance, to optimising your depreciation schedules for maximum legal tax write-offs, to creating a renovation plan for maximum rental ROI - at {{ $user->company_name }} our goal is to help you setup a plan to join the 1% of property investors in West End.</p>
              </div>

              <footer class="mt-4">
                <p class="text-base font-semibold text-indigo-200">{{ $user->name }}, Head of Property Management at {{ $user->company_name }}</p>
              </footer>
            </blockquote>
          </div>
        </div>
      </div>
    </div>


    
    <div class="relative mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-0">
      <!-- Content area -->
      <div class="pt-12 sm:pt-16 lg:pt-20">
        <h2 class="text-3xl text-gray-900 font-extrabold tracking-tight sm:text-4xl">Why choose {{ $fname }} as your next property manager and growth acceleration specialist? </h2>
        <div class="mt-6 text-gray-500 space-y-6">
          <p class="text-lg">The difference between a top 1% performing property portfolio vs the rest are the little thing - all the little things that add up to the big things. The reason 350+ investors trust {{ $fname }} with their managements is because she knows the "right" little things to focus on.</p>
          <p class="text-base leading-7">From choosing the right insurance company, picking an optimal depreciation schedule - tenant selection and retainment practices, finding the right time to sell and 500 other decisions. {{ $fname }} has seen what works and what doesn't when it comes to property in the {{ $user->area }} and surrounding areas.</p>
          <!--<p class="text-base leading-7">Rhoncus nisl, libero egestas diam fermentum dui. At quis tincidunt vel ultricies. Vulputate aliquet velit faucibus semper. Pellentesque in venenatis vestibulum consectetur nibh id. In id ut tempus egestas. Enim sit aliquam nec, a. Morbi enim fermentum lacus in. Viverra.</p>-->
        </div>
      </div>

      <!-- Stats section -->
      <div class="mt-10">
        <dl class="grid grid-cols-2 gap-x-4 gap-y-8">
          <div class="border-t-2 border-gray-100 pt-6">
            <dt class="text-base font-medium text-gray-500">Total Lifetime Properties Managed</dt>
            <dd class="text-3xl font-extrabold tracking-tight text-gray-900">823</dd>
          </div>

          <div class="border-t-2 border-gray-100 pt-6">
            <dt class="text-base font-medium text-gray-500">Total Monthly Investor Income</dt>
            <dd class="text-3xl font-extrabold tracking-tight text-gray-900">$250K+</dd>
          </div>

          <div class="border-t-2 border-gray-100 pt-6">
            <dt class="text-base font-medium text-gray-500">Portfolio Vacancy Rate</dt>
            <dd class="text-3xl font-extrabold tracking-tight text-gray-900">Under 1.5%</dd>
          </div>

          <div class="border-t-2 border-gray-100 pt-6">
            <dt class="text-base font-medium text-gray-500">{{ $user->area }} Industry Knowledge</dt>
            <dd class="text-3xl font-extrabold tracking-tight text-gray-900">12+ Years</dd>
          </div>
        </dl>
        <!--<div class="mt-10">
          <a href="#" class="text-base font-medium text-indigo-600"> Learn more about how we're changing the world <span aria-hidden="true">&rarr;</span> </a>
        </div>-->
      </div>
    </div>
  </div>
</div>



<a id="testimonials"></a>
<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-sm">
          <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Testimonials</h2>
          <p class="mb-8 font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">At {{ $user->company_name }} we believe Happy Tenants = Happy Landlords. Our tenants are our customers - and keeping customers happy = more consistent income and higher rentals. This is how {{ $user->company_name }} helps investors reach their retirement and passive income goals.</p>
      </div> 
      <div class="grid mb-8 lg:mb-12 lg:grid-cols-2">
          <figure class="flex flex-col justify-center items-center p-8 text-center bg-gray-50 border-b border-gray-200 md:p-12 lg:border-r dark:bg-gray-800 dark:border-gray-700">
              <blockquote class="mx-auto mb-8 max-w-2xl text-gray-500 dark:text-gray-400">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Integrity and Trust</h3>
                  <p class="my-4">{{ $fname }} is one of the most honest and trustworthy Real Estate Agents in the industry. Her passion and integrity for her clients and customer service is what makes her one of the best in Property Management .</p>
                  <p class="my-4">She’s definitely someone you would want , to look after your Investment Property.</p>
              </blockquote>
              <figcaption class="flex justify-center items-center space-x-3">
                  <!--<img class="w-9 h-9 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/karen-nelson.png" alt="profile picture">-->
                  <div class="space-y-0.5 font-medium dark:text-white text-left">
                      <div>Radhika M</div>
                      <!--<div class="text-sm font-light text-gray-500 dark:text-gray-400">Developer at Open AI</div>-->
                  </div>
              </figcaption>    
          </figure>
          <figure class="flex flex-col justify-center items-center p-8 text-center bg-gray-50 border-b border-gray-200 md:p-12 dark:bg-gray-800 dark:border-gray-700">
              <blockquote class="mx-auto mb-8 max-w-2xl text-gray-500 dark:text-gray-400">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Finding new tenants in weeks</h3>
                  <p class="my-4">{{ $fname }} at {{ $user->company_name }} has been great to deal with. Very professional and efficient finding new tenants within weeks, making sure the property was in good order, organising tradespeople and formalising existing arrangements. I would highly recommend her and {{ $user->company_name }}.</p>
              </blockquote>
              <figcaption class="flex justify-center items-center space-x-3">
                  <!--<img class="w-9 h-9 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/roberta-casas.png" alt="profile picture">-->
                  <div class="space-y-0.5 font-medium dark:text-white text-left">
                      <div>Sharon Christensen</div>
                      <!--<div class="text-sm font-light text-gray-500 dark:text-gray-400">Lead designer at Dropbox</div>-->
                  </div>
              </figcaption>    
          </figure>
          <figure class="flex flex-col justify-center items-center p-8 text-center bg-gray-50 border-b border-gray-200 lg:border-b-0 md:p-12 lg:border-r dark:bg-gray-800 dark:border-gray-700">
              <blockquote class="mx-auto mb-8 max-w-2xl text-gray-500 dark:text-gray-400">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">There is no comparison. We will never return to any of the commercialised agencies</h3>
                  <p class="my-4">"We have been fortunate to find {{ $user->company_name }}. {{ $fname }} does a magnificent job managing our property. We have had many rental properties over the years and have to say that without question, metrocity is the most professional and well run operation that we have dealt with. For prospective tenants, {{ $user->company_name }} ensure you have a prompt response to your needs and they treat people respectfully. The agents there take all the stress out of property management. Communication is always open and prompt. These people know and understand the {{ $user->area }} market. Unlike some of the bigger agencies, you are treated as an individual and promptly acknowledged and dealt with. There is no comparison. We will never return to any of the commercialised agencies after having had the experience of placing our property with {{ $user->company_name }}."</p>
                  <!--<p class="my-4">Everything is so well structured and simple to use (I've learnt so much about Figma by just using the toolkit).</p>
                  <p class="my-4">Aesthetically, the well designed components are beautiful and will undoubtedly level up your next application."</p>-->
              </blockquote>
              <figcaption class="flex justify-center items-center space-x-3">
                  <!--<img class="w-9 h-9 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png" alt="profile picture">-->
                  <div class="space-y-0.5 font-medium dark:text-white text-left">
                      <div>G & K Parker</div>
                      <!--<div class="text-sm font-light text-gray-500 dark:text-gray-400">Software Engineer at Facebook</div>-->
                  </div>
              </figcaption>    
          </figure>
          <figure class="flex flex-col justify-center items-center p-8 text-center bg-gray-50 border-gray-200 md:p-12 dark:bg-gray-800 dark:border-gray-700">
              <blockquote class="mx-auto mb-8 max-w-2xl text-gray-500 dark:text-gray-400">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Superior in all areas</h3>
                  <p class="my-4">"{{ $user->company_name }} has been managing two {{ $user->area }} investment properties for me over the last few years after I became displeased with the lack of service offered by the incumbent manager. I've found {{ $user->company_name }} to be superior in all areas, in particular their knowledge of the local market, their ability to quickly fill a vacancy, and their responsiveness to all day-to-day matters. I highly recommend {{$user->company_name}} as your new investment property manager!
"</p>
                  <!--<p class="my-4">You have many examples that can be used to create a fast prototype for your team."</p>-->
              </blockquote>
              <figcaption class="flex justify-center items-center space-x-3">
                  <!--<img class="w-9 h-9 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/joseph-mcfall.png" alt="profile picture">-->
                  <div class="space-y-0.5 font-medium dark:text-white text-left">
                      <div>Luke McCandlish</div>
                      <!--<div class="text-sm font-light text-gray-500 dark:text-gray-400">CTO at Google</div>-->
                  </div>
              </figcaption>    
          </figure>
      </div>
      <!--<div class="text-center">
          <a href="#" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Show more...</a> 
      </div>-->
</section>


<!-- CTA -->

<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-indigo-50">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-24 lg:px-8 lg:flex lg:items-center lg:justify-between">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 md:text-4xl">
      <span class="block">See what {{ $fname }} cand do for your portfolio.</span>
      <span class="block text-indigo-600">Book a sit down your place or mine.</span>
    </h2>
    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
      <div class="inline-flex rounded-md shadow">
        <a href="#contact" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Book My Investment Strategy Session</a>
      </div>
    </div>
  </div>
</div>



<!-- Feature List -->

<!-- This example requires Tailwind CSS v2.0+ -->
<a id="difference"></a>
<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-x-8">
    <div>
      <h2 class="text-base font-semibold text-indigo-600 uppercase tracking-wide">Your Investment Acceleration Toolkit</h2>
      <p class="mt-2 text-3xl font-extrabold text-gray-900">Everything you need to scale your property investment portfolio</p>
      <p class="mt-4 text-lg text-gray-500">Discover and implement the investment acceleration framework that {{ $fname }} has used for 823+ investors to help them manage and grow their property portfolios. Leverage the knowledge of the top 1% of investors and learn to efficiently, safely and ethically scale and grow your property.</p>
      <p class="mt-4 text-lg text-gray-500">Combine the optimal legal, accounting and insurance structure, optimal tenant sourcing and insider data to maximise property return ROI and allow your investments to grow in perpetuity.
  </p>
    </div>
    <div class="mt-12 lg:mt-0 lg:col-span-2">
      <dl class="space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:grid-rows-4 sm:grid-flow-col sm:gap-x-6 sm:gap-y-10 lg:gap-x-8">
        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Rental Acceleration Checklist</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Use {{ $fname }}'s unique rental acceleration checklist to ensure your property is optimised for rental renturns. Yours free for all enquiries.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">50,000+ Tenant Database</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Find quality tenants fast using our extensive database and tenant newsletter to minimise vacancy rates and maximised rental returns.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Investment Scaling Newsletter</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Get investment opportunities before the general public! Have the insider's track when it's time to scale your investment.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">AI Issue Automation</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Streamlined  issue management using our advanced AI software means tenant issues are resolved within 5 minutes day or night - leading to higher satisfaction rates and more consistent rental income.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Investment Exit Timing Optimisation</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Combine my unique, state of the art insider local and national industry trend property forecasting to put your property on the market at the perfect time for maximum upside.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">1.5% Vacancy Rate</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Properties managed by [[name]] are seldom empty - this means your investments will be generating income year round and not picking up dust.</dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Investor Insider's Circle</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Leverage knowledge of the top 1% of {{ $user->area }} investors and get access to insider strategies to scale your investment portfolio. Check out our Investor Acceleration Series below for a taste. </dd>
        </div>

        <div class="relative">
          <dt>
            <!-- Heroicon name: outline/check -->
            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">360 Transparency</p>
          </dt>
          <dd class="mt-2 ml-9 text-base text-gray-500">Get a detailed look into the status of your property from anywhere in the world, anytime using our online app - and get entry and exit report photos, maintenance request monitoring and more!</dd>
        </div>
      </dl>
    </div>
  </div>
</div>



<!-- 3 Blog Sections -->
<a id="videos"></a>
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative bg-gray-50 pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
  <div class="absolute inset-0">
    <div class="bg-white h-1/3 sm:h-2/3"></div>
  </div>
  <div class="relative max-w-7xl mx-auto">
    <div class="text-center">
      <h2 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">Investment Acceleration Series</h2>
      
      <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">Just a taste of the strategies that {{ $fname }} and the team at {{ $user->company_name }} implement to maximise the rental ROI of your investment property. Learn how the 1% play the game.</p>
    </div>
    <div class="mt-12 max-w-lg mx-auto grid gap-5 lg:grid-cols-3 lg:max-w-none">
      
    
    <?php

foreach($campaigns as $campaign) {
  ?>  
        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <div class="flex-shrink-0">
        <a href="<?php echo "./".$campaign->permalink; ?>"> <img class="h-48 w-full object-cover" src="<?php if(!empty($campaign->video_thumbnail)) { echo Storage::disk('s3')->url($campaign->video_thumbnail); } ?>" alt="">
        </div>
        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
          <div class="flex-1">
            <p class="text-sm font-medium text-indigo-600">
              <a href="#" class="hover:underline">Investment Acceleration Video </a>
            </p>
            <a href="<?php echo "./".$campaign->permalink; ?>" class="block mt-2">
              <p class="text-xl font-semibold text-gray-900">{{ $campaign->headline }}</p>
              <p class="mt-3 text-base text-gray-500">{{ $campaign->subheadline }}</p>
            </a>
          </div>
          <div class="mt-6 flex items-center">
           <!-- <div class="flex-shrink-0">
              <a href="#">
                <span class="sr-only">Roel Aufderehar</span>
                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
              </a>
            </div> -->
            <div class="ml-3">
            <!--<p class="text-sm font-medium text-gray-900">
                <a href="#" class="hover:underline"> Roel Aufderehar </a>
              </p>-->
              <div class="flex space-x-1 text-sm text-gray-500">
                <time datetime="2020-03-16"> Mar 16, 2020 </time>
                <span aria-hidden="true"> &middot; </span>
                <span> 6 min read </span>
              </div>
            </div>
          </div>
        </div>
      </div>
</a>
<?php } ?>



    

    </div>
  </div>
</div>



<!-- CONTACT -->
<a id="contact"></a>
<div class="relative bg-white">
  <div class="absolute inset-0">
    <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50"></div>
  </div>
  <div class="relative max-w-7xl mx-auto lg:grid lg:grid-cols-5">
    <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
      <div class="max-w-lg mx-auto">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Book Your Investment Optimisation Audit </h2>
        <p class="mt-3 text-lg leading-6 text-gray-500">Claim your free rental ROI discovery session with {{ $fname }} now to receive a personalised strategy for maximising your rental income and learn the gaps you're missing in your investment strategy.</p>
        <dl class="mt-8 text-base text-gray-500">
          <div>
            <dt class="sr-only">Postal address</dt>
            <dd>
              <!--<p>742 Evergreen Terrace</p>
              <p>Springfield, OR 12345</p>-->
              <?php echo nl2br($user->address); ?>
              
            </dd>
          </div>
          <div class="mt-6">
            <dt class="sr-only">Phone number</dt>
            <dd class="flex">
              <!-- Heroicon name: outline/phone -->
              <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <span class="ml-3"> {{ $user->mobile }} </span>
            </dd>
          </div>
          <div class="mt-3">
            <dt class="sr-only">Email</dt>
            <dd class="flex">
              <!-- Heroicon name: outline/mail -->
              <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <!--<span class="ml-3"> support@example.com </span>-->
            </dd>
          </div>
        </dl>
        <!--<p class="mt-6 text-base text-gray-500">
          Looking for careers? 
          <a href="#" class="font-medium text-gray-700 underline">View all job openings</a>.
        </p>-->
      </div>
    </div>
    <div class="bg-white py-16 px-4 sm:px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
   
      <div class="max-w-lg mx-auto lg:max-w-none">
      @livewire('contact-form')  
        <!--<form action="#" method="POST" class="grid grid-cols-1 gap-y-6">
          <div>
            <label for="full-name" class="sr-only">Full name</label>
            <input type="text" name="full-name" id="full-name" autocomplete="name" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Full name">
          </div>
          <div>
            <label for="email" class="sr-only">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Email">
          </div>
          <div>
            <label for="phone" class="sr-only">Phone</label>
            <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Phone">
          </div>
          <div>
            <label for="message" class="sr-only">Message</label>
            <textarea id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" placeholder="Message"></textarea>
          </div>
          <div>
            <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
          </div>
        </form>-->
      </div>
    </div>
  </div>
</div>


  
<script>
  var button = document.getElementById("main-menu");
  button.addEventListener("click", function(event) { 
    console.log("I hear your calls");
    event.stopPropagation();
    toggleMobMenu();
  });
  window.addEventListener("click", function(event) {
  var hid_menu = document.getElementById("mobmenu");
  var target = String(event.target);
  console.log("Target variable is: ");
  console.log(target);
  if(!hid_menu.classList.contains("hidden")) {
    console.log('The menu is not hidden and the event target is: ');
    console.log(event.target);
    hid_menu.classList.toggle("hidden"); // crashes when I add this line
    
} });
  function toggleMobMenu() {
   var element = document.getElementById("mobmenu");
   element.classList.toggle("hidden");
}
  </script>
    </body>
</html>

