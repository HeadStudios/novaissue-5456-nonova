<!DOCTYPE html>
<html lang="en">
<head>
<x-headstuff/>
    <title>Rent Roll Acceleration Audit for {{ $audit->contact_name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="css/tailwind/tailwind.min.css">-->
    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.2/plyr.css" />
</head>
<body class="font-sans antialiased text-gray-900">
    <div class="">
        
      <div class="bg-gray-50">
        <div class="relative overflow-hidden">
          <div class="block absolute inset-y-0 h-full w-full">
            <div class="relative h-full">
              <svg class="absolute right-full transform translate-y-1/3 translate-x-1/4 md:translate-y-1/2 sm:translate-x-1/2 lg:translate-x-full" width="404" height="784" fill="none" viewbox="0 0 404 784"><defs><pattern id="e229dbec-10e9-49ee-8ec3-0286ca089edf" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="784" fill="url(#ad9a0a02-b58e-4a1d-8c36-1b649889af63)"></rect></svg>
              <svg class="absolute left-full transform -translate-y-3/4 -translate-x-1/4 sm:-translate-x-1/2 md:-translate-y-1/2 lg:-translate-x-3/4" width="404" height="784" fill="none" viewbox="0 0 404 784"><defs><pattern id="d2a68204-c383-44b1-b99f-42ccff4e5365" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="784" fill="url(#478e97d6-90df-4a89-8d63-30fdbb3c7e57)"></rect></svg>
            </div>
          </div>
          <div class="relative pt-6 pb-12 lg:pb-20">
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
              <nav class="relative flex items-center justify-between sm:h-10 md:justify-center">
                <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
                  <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="/" aria-label="Home">
                      <img class="h-8 w-auto sm:h-10" src="{{ asset('plain-assets/logos/small_tiger_vial.png') }}" alt="">
                    </a>
                    <div class="-mr-2 flex items-center md:hidden">
                      
                    </div>
                  </div>
                </div>
                <!--<div class="hidden md:flex md:space-x-10"><a class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out" href="#">Product</a><a class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out" href="#">Features</a><a class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out" href="#">Marketplace</a><a class="font-medium text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out" href="#">Company</a></div>-->
                <div class="hidden md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0">
                  <!--<span class="inline-flex rounded-md shadow"><a class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-600 bg-white hover:text-indigo-500 focus:outline-none focus:border-indigo-300 focus:shadow-outline-indigo active:bg-gray-50 active:text-indigo-700 transition duration-150 ease-in-out" href="#">Log in</a></span>-->
                </div>
              </nav>
            </div>
            <div class="hidden absolute top-0 inset-x-0 p-2 transition transform origin-top-right">
              <div class="rounded-lg shadow-md">
                <div class="rounded-lg bg-white shadow-xs overflow-hidden" role="menu" aria-orientation="vertical" aria-labelledby="main-menu">
                  <div class="px-5 pt-4 flex items-center justify-between">
                    <div>
                      <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/v1/workflow-mark-on-white.svg" alt="">
                    </div>
                    <div class="-mr-2">
                      <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" type="button" aria-label="Close menu">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewbox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="px-2 pt-2 pb-3"><a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#" role="menuitem">Product</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#" role="menuitem">Features</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#" role="menuitem">Marketplace</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#" role="menuitem">Company</a></div>
                  <div><a class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out" href="#" role="menuitem">Log in</a></div>
                </div>
              </div>
            </div>
            <div class="mt-10 mx-auto max-w-screen-xl px-4 sm:px-6 md:mt-16 lg:mt-20">
              <div class="text-center">
                <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                  <span class="mr-1">{{ $audit->headline }}</span>
                  <!--<br>
                  <span class="text-indigo-600">online business</span>-->
                </h2>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">{{ $audit->subheadline }}</p>
              </div>
            </div>
          </div>
          <div class="relative">
            <div class="absolute inset-0 flex flex-col">
              <div class="flex-1"></div>
              <div class="flex-1 w-full bg-gray-800"></div>
            </div>
            <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
            <!--<div class="aspect-w-16 aspect-h-9 z-50">-->
            <?php if(!str_contains($audit->audit_url, 'youtube')) { ?>

            <video id="player" playsinline controls class="relative" data-poster="{{ $audit->v_thumbnail }}">
            <source src="{{ $audit->audit_url }}" type="video/mp4" /> 
            
            </video> <?php } else { 
              $parts = parse_url($audit->audit_url);
              $query = '';
              parse_str($parts['query'], $query);
              ?>
              <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $query['v']; ?>"></div>
            <?php } ?>
              <!--</div>-->
              </div>
          </div>
        </div>
        <div class="bg-gray-800">
          <div class="max-w-screen-xl mx-auto pt-16 pb-20 px-4 sm:px-6 md:pb-24 lg:px-8">
            <!--<h3 class="text-center text-gray-400 text-sm font-semibold uppercase tracking-wide">Trusted by over 26,000 forward-thinking companies</h3>-->
            <div class="mt-8 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
              <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-2">
                <img class="h-12" src="{{ asset('images/coronis.png') }}" alt="">
              </div>
              <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                <img class="h-12" src="{{ asset('images/metrocityrealty-logo.png') }}" alt="">
              </div>
              <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-2">
                <img class="h-12" src="{{ asset('images/obsidian-property-logo.png') }}" alt="">
              </div>
              <!--<div class="col-span-1 flex justify-center md:col-span-3 lg:col-span-1">
                <img class="h-12" src="https://tailwindui.com/img/logos/v1/transistor-logo.svg" alt="">
              </div>
              <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1">
                <img class="h-12" src="https://tailwindui.com/img/logos/v1/transistor-logo.svg" alt="">
              </div>-->
            </div>
          </div>
        </div>
      </div>
        
      <!--<div class="bg-white">
        <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/tuple-logo.svg" alt="">
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/mirage-logo.svg" alt="">
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/statickit-logo.svg" alt="">
            </div>
            <div class="col-span-1 flex justify-center md:col-span-3 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/transistor-logo.svg" alt="">
            </div>
            <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/workcation-logo.svg" alt="">
            </div>
          </div>
        </div>
      </div>-->
        
      <div class="bg-white">
        <div class="max-w-screen-xl mx-auto text-center py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
          <h2 class="text-3xl leading-9 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
            <span>Want to see more than just the tip of the iceberg?</span>
            <br>
            <span>Fill out the form below</span>
          </h2>
          <div class="mt-8 flex justify-center">
            <div class="inline-flex rounded-md shadow"><a class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out" href="https://headstudios.com.au/rent-roll-accelerator-onboarding/?fname=@php echo urlencode($audit->contact_name); @endphp&email=@php echo urlencode($audit->contact_name); @endphp&company_name=Pinnacle%20Properties" target="_blank">Onboarding Form</a></div>
            <div class="ml-3 inline-flex"><a class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline focus:border-indigo-300 transition duration-150 ease-in-out" href="https://headstudios.com.au/client-reviews/" target="_blank">Read Reviews</a></div>
          </div>
        </div>
      </div>
        
      <section class="py-12 white overflow-hidden md:py-20 lg:py-24">
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
          <svg class="absolute top-full right-full transform translate-x-1/3 -translate-y-1/4 lg:translate-x-1/2 xl:-translate-y-1/2" width="404" height="404" fill="none" viewbox="0 0 404 404" role="img" aria-labelledby="svg-workcation">
            <title id="svg-workcation">Workcation</title>
            <defs><pattern id="ad119f34-7694-4c31-947f-5c9d249b21f3" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="404" fill="url(#ad119f34-7694-4c31-947f-5c9d249b21f3)"></rect>
          </svg>
          <div class="relative">
            <!--<svg class="mx-auto h-10" fill="none" viewbox="0 0 180 40">
              <path fill="#2D3748" d="M59.267 32.642h3.718L66.087 21.7l3.126 10.94h3.718l4.642-16.576h-3.434l-3.173 12.29-3.481-12.29H64.69l-3.457 12.29-3.174-12.29h-3.433l4.641 16.576zM83.551 32.973c3.481 0 6.276-2.723 6.276-6.252 0-3.528-2.794-6.252-6.276-6.252-3.48 0-6.252 2.724-6.252 6.252 0 3.529 2.771 6.252 6.252 6.252zm0-2.984c-1.8 0-3.197-1.35-3.197-3.268 0-1.918 1.398-3.268 3.197-3.268 1.824 0 3.221 1.35 3.221 3.268 0 1.918-1.397 3.268-3.22 3.268zM95.031 22.837v-2.036h-3.055v11.84h3.055v-5.66c0-2.486 2.013-3.196 3.6-3.007v-3.41c-1.492 0-2.984.663-3.6 2.273zM111.334 32.642l-4.902-5.992 4.76-5.85h-3.647l-4.073 5.21v-9.946h-3.055v16.578h3.055v-5.376l4.31 5.376h3.552z"></path>
              <path fill="#5850EC" fill-rule="evenodd" d="M42.342 17.45l-7.596-4.385v20.371h8.88v1.974H.21v-1.974h3.947v-12.55l-3.678.92L0 19.89l20.81-5.202h3.08a9.421 9.421 0 00-.67 2.525l-.477 3.922 5.096-2.942v15.243h4.933v-20.37l-7.594 4.385a7.402 7.402 0 012.531-4.736h-4.064a7.39 7.39 0 016.557-2.933l-5.517-3.186a7.388 7.388 0 016.607.397 7.366 7.366 0 012.468 2.316 7.363 7.363 0 012.467-2.316 7.39 7.39 0 016.608-.397l-5.518 3.186a7.389 7.389 0 016.558 2.933h-4.066a7.399 7.399 0 012.533 4.735zm-18.45 6.119h-5.92v9.867h5.92v-9.867zm-10.854 1.973a1.974 1.974 0 11-3.947 0 1.974 1.974 0 013.947 0z" clip-rule="evenodd"></path>
              <path fill="#5850EC" d="M118.495 32.973c2.321 0 4.334-1.232 5.352-3.079l-2.652-1.515c-.474.97-1.492 1.563-2.723 1.563-1.824 0-3.174-1.35-3.174-3.221 0-1.895 1.35-3.244 3.174-3.244 1.207 0 2.226.615 2.699 1.586l2.629-1.54c-.971-1.823-2.984-3.054-5.305-3.054-3.599 0-6.252 2.723-6.252 6.252 0 3.528 2.653 6.252 6.252 6.252zM134.277 20.8v1.398c-.853-1.066-2.131-1.729-3.86-1.729-3.15 0-5.755 2.723-5.755 6.252 0 3.528 2.605 6.252 5.755 6.252 1.729 0 3.007-.663 3.86-1.729v1.397h3.055v-11.84h-3.055zm-3.292 9.26c-1.871 0-3.268-1.35-3.268-3.34 0-1.988 1.397-3.338 3.268-3.338 1.895 0 3.292 1.35 3.292 3.339 0 1.99-1.397 3.339-3.292 3.339zM146.875 23.737v-2.936h-2.676v-3.316l-3.055.924V20.8h-2.06v2.936h2.06v4.926c0 3.197 1.445 4.452 5.731 3.978v-2.77c-1.752.094-2.676.07-2.676-1.208v-4.926h2.676zM150.544 19.38c1.042 0 1.895-.853 1.895-1.871s-.853-1.895-1.895-1.895c-1.018 0-1.87.877-1.87 1.895a1.89 1.89 0 001.87 1.87zm-1.515 13.261h3.055v-11.84h-3.055v11.84zM160.516 32.973c3.481 0 6.276-2.724 6.276-6.252 0-3.529-2.795-6.252-6.276-6.252s-6.252 2.723-6.252 6.252c0 3.528 2.771 6.252 6.252 6.252zm0-2.984c-1.8 0-3.197-1.35-3.197-3.268 0-1.918 1.397-3.268 3.197-3.268 1.824 0 3.221 1.35 3.221 3.268 0 1.918-1.397 3.268-3.221 3.268zM175.524 20.469c-1.586 0-2.818.592-3.528 1.658V20.8h-3.055v11.84h3.055v-6.394c0-2.06 1.113-2.936 2.605-2.936 1.373 0 2.344.829 2.344 2.439v6.891H180v-7.27c0-3.15-1.966-4.902-4.476-4.902z"></path>
            </svg>-->
            <img class="mx-auto h-10" src="{{ asset('images/metro_biglogo.png') }}" />
            <blockquote class="mt-8">
              <div class="max-w-3xl mx-auto text-center text-2xl leading-9 font-medium text-gray-900">
                <p>"My closed property managements are up by 63% compared to before we started and based on what I have seen I don’t think we have scratched the surface of what is possible."</p>
              </div>
              <footer class="mt-8">
                <div class="md:flex md:items-center md:justify-center">
                  <div class="md:flex-shrink-0">
                    <img class="mx-auto h-10 w-10 rounded-full" src="{{ asset('images/greg-photo.jpeg') }}" alt="">
                  </div>
                  <div class="mt-3 text-center md:mt-0 md:ml-4 md:flex md:items-center">
                    <div class="text-base leading-6 font-medium text-gray-900">Greg Jackson</div>
                    <svg class="hidden md:block mx-1 h-5 w-5 text-indigo-600" fill="currentColor" viewbox="0 0 20 20">
                      <path d="M11 0h3L9 20H6l5-20z"></path>
                    </svg>
                    <div class="text-base leading-6 font-medium text-gray-500">Principal, Metrocity</div>
                  </div>
                </div>
              </footer>
            </blockquote>
          </div>
        </div>
      </section>
    </div>
    <script src="https://cdn.plyr.io/3.7.2/plyr.js"></script>
    <script>
  const player = new Plyr('#player');
</script>
</body>
</html>

