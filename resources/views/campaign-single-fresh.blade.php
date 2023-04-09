@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
  
    <title>FRESH DESIGN {{ $camp->headline}} - {{ $user->company_name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @vite(['resources/css/app.css'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon_url }}">
    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    <x-headstuff/>
    @livewireScripts
    @livewireStyles
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  </head>
  <body class="antialiased bg-body text-body font-body">
  @include('header-campaign')
  <main class="mx-auto max-w-7xl px-4 sm:px-6">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
          <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">Investment Acceleration Video Blog</span>
            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
              <span class="block text-gray-900">{{ $camp->headline}}</span>
              <!--<span class="block text-indigo-600">{{ $camp->subheadline }}</span>-->
            </span>
          </h1>
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">FRESH SUBHEADLINE - {{ $camp->subheadline }}</p>
          


          <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">


          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                  <div class="rounded-md shadow"><a class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="#reading">I Like Reading</a></div>
                  <div class="mt-3 sm:mt-0 sm:ml-3"><a id="myBtn" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="#">{{ $camp->cta_text }}</a></div>
                </div>


            <!--<p class="text-base font-medium text-gray-900">Sign up to get notified when it’s ready.</p>
            <form action="#" method="POST" class="mt-3 sm:flex">
              <label for="email" class="sr-only">Email</label>
              <input type="email" name="email" id="email" class="block w-full py-3 text-base rounded-md placeholder-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:flex-1 border-gray-300" placeholder="Enter your email">
              <button type="submit" class="mt-3 w-full px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto">Notify me</button>
            </form>
            <p class="mt-3 text-sm text-gray-500">
              We care about the protection of your data. Read our
              <a href="#" class="font-medium text-gray-900 underline">Privacy Policy</a>.
            </p>-->
            
          </div>
        </div>
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
          <svg class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-8 scale-75 origin-top sm:scale-100 lg:hidden" width="640" height="784" fill="none" viewBox="0 0 640 784" aria-hidden="true">
            <defs>
              <pattern id="4f4f415c-a0e9-44c2-9601-6ded5a34a13e" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
              </pattern>
            </defs>
            <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
            <rect x="118" width="404" height="784" fill="url(#4f4f415c-a0e9-44c2-9601-6ded5a34a13e)" />
          </svg>
          <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md" style="width:100%;">
          <!--<video id="player" playsinline controls class="relative" data-poster="https://img.freepik.com/free-vector/abstract-colorful-fluid-background_23-2148901720.jpg?w=2000">
              <source src="{{ $camp->tiktok_url }}" type="video/mp4" /> 
                  
              </video>-->
              
  <video id="player" playsinline controls data-poster="{{ $thumbnail }}" <?php if(str_contains($camp->tiktok_url, 'vidtok')) { ?> style="height:500px !important;" <?php } ?>> <!-- style="height:500px !important;" -->
  <source src="{{ $camp->tiktok_url }}" type="video/mp4" />
  <!-- Captions are optional -->
</video>
            <!--<button type="button" class="relative block w-full bg-white rounded-lg overflow-hidden focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="sr-only">Watch our video to learn more</span>
              <img class="w-full" src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="">
              <div class="absolute inset-0 w-full h-full flex items-center justify-center" aria-hidden="true">
                <svg class="h-20 w-20 text-indigo-500" fill="currentColor" viewBox="0 0 84 84">
                  <circle opacity="0.9" cx="42" cy="42" r="42" fill="white" />
                  <path d="M55.5039 40.3359L37.1094 28.0729C35.7803 27.1869 34 28.1396 34 29.737V54.263C34 55.8604 35.7803 56.8131 37.1094 55.9271L55.5038 43.6641C56.6913 42.8725 56.6913 41.1275 55.5039 40.3359Z" />
                </svg>
              </div>
            </button>-->
          </div>
        </div>
      </div>
    </main>


  <div class="mt-16 relative px-4 sm:px-6 lg:px-8">
    <div class="text-lg max-w-prose mx-auto">
      <h1>
        <a id="reading"></a><span class="block text-base text-center text-indigo-600 font-semibold tracking-wide uppercase">Introducing</span>
        <span class="mt-2 block text-3xl text-center leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{ $camp->headline }}</span>
      </h1>
    </div>
    <div class="text-lg max-w-prose mx-auto mb-16 prose">
      
    {!! Str::markdown($camp->copy) !!}

    </div>
  </div>


  <center style="padding:40px;">Copyright {{ $user->company_name }} 2022 {{ $user->favicon_url }}</center>



    
              
            
 <!-- This example requires Tailwind CSS v2.0+ -->
<div id="myModal" class="modal fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->
    <div class="w-full inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle p-6" style="width:50%">
      <div>
      <div class="mt-3 mb-3 text-center sm:mt-5" style="margin-bottom:10px;">
      <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Book a Callback</h3>
</div>
      @livewire('contact-form')  
        <!--<div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
          
          <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <div class="mt-3 text-center sm:mt-5">
          
          <div class="mt-2">
            <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur amet labore.</p>
          </div>
        </div>-->
      </div>
      <!--<div class="mt-5 sm:mt-6">
        <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">Go back to dashboard</button>
      </div>-->
    </div>
  </div>
</div>

  </body>
  <script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
            <script>
  const player = new Plyr('#player', {
  //autoplay: true
});


var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
btn.onclick = function() {
  modal.style.display = "block";
}
modal.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  } }

</script>
</html>

