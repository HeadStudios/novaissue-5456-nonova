<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Page title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="{{ asset('css/tailwind/tailwind.min.css') }}"> 
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-tailwind.png') }}">
    <script src="{{ asset('js/main.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
    
  </head>
  <body class="antialiased bg-body text-body font-body">
  @include('header')
    
  <main class="mt-20 mx-auto max-w-7xl px-4 sm:px-6">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
          <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">Investment Acceleration Video Blog</span>
            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
              <span class="block text-gray-900">{{ $camp->headline}}</span>
              <!--<span class="block text-indigo-600">{{ $camp->subheadline }}</span>-->
            </span>
          </h1>
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">{{ $camp->subheadline}}</p>
          


          <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">


          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                  <div class="rounded-md shadow"><a class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="#reading">I Like Reading</a></div>
                  <div class="mt-3 sm:mt-0 sm:ml-3"><a class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="{{$camp->cta_link}}">{{ $camp->cta_text }}</a></div>
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
          <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md" style="width:100%;height:100%;">
          <!--<video id="player" playsinline controls class="relative" data-poster="https://img.freepik.com/free-vector/abstract-colorful-fluid-background_23-2148901720.jpg?w=2000">
              <source src="{{ $camp->tiktok_url }}" type="video/mp4" /> 
                  
              </video>-->
              <div class="plyr__video-embed" id="player" style="width:100%;height:100%;">
    <iframe allowtransparency="true" src="https://rent-roll-devour-bucket-a1.s3.ap-southeast-2.amazonaws.com/videos/scripts/final/script_758.mp4" allowfullscreen allowtransparency allow="autoplay" width="100%" height="100%"></iframe>
  </div>
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

  <livewire:register-freestyle /> 

    
              
            
 
  </body>
  <script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
            <script>
  const player = new Plyr('#player', {
  autoplay: true
});
</script>
</html>

