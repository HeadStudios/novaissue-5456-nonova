<?php
use Illuminate\Support\Facades\Auth;
?>
<header class="relative">
    <div class="bg-white pt-6 pb-6">
      <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6" aria-label="Global">
        <div class="flex items-center flex-1">
          <div class="flex items-center justify-between w-full md:w-auto">
            <a href="#">
              <span class="sr-only">Workflow</span>
              <a href="/"><img class="h-8 w-auto sm:h-10" src="<?php if(empty($logo_url)): ?> <?php echo e(asset('plain-assets/logos/small_tiger_vial.png')); ?> <?php else: ?> <?php echo e($logo_url); ?>  <?php endif; ?>" alt=""></a>
            </a>
            <div class="-mr-2 flex items-center md:hidden">
              <button id="main-menu" type="button" class="bg-gray-900 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-800 focus:outline-none focus:ring-2 focus-ring-inset focus:ring-white" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <!-- Heroicon name: outline/menu -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
            </div>
          </div>
          <div class="hidden space-x-8 md:flex md:ml-10">
            <a href="/#inv-data" class="text-base font-medium text-gray-500 hover:text-gray-900">Investor Data</a>

            <a href="/#video-ai" class="text-base font-medium text-gray-500 hover:text-gray-900">Video AI</a>

            <a href="/#mms" class="text-base font-medium text-gray-500 hover:text-gray-900">MMS Domination</a>

            <a href="/#pricing" class="text-base font-medium text-gray-500 hover:text-gray-900">Pricing</a>
            <a href="/#360" class="text-base font-medium text-gray-500 hover:text-gray-900">360</a>
          </div>
        </div>
        <div class="hidden md:flex md:items-center md:space-x-6">
        <?php if(Auth::check()) { ?>
          <a href="?logout=true" class="text-base font-medium text-indigo-600 hover:text-indigo-500"> Logout </a>
          <a target="_blank" href="/nova/dashboards/main" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700"> Dashboard </a>
          <?php } else { ?>
            <a target="_blank" href="/nova/login" class="text-base font-medium text-indigo-600 hover:text-indigo-500"> Log in </a>
          <a href="/#signup" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700"> Start free trial </a>
            <?php } ?>
          <!--<a href="/nova/login" class="text-base font-medium text-white hover:text-gray-300"> Log in </a>
          <a href="#signup" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700"> Start free trial </a>-->
        </div>
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
    <div id="mobmenu" class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top hidden" style="z-index:100">
      <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
        <div class="px-5 pt-4 flex items-center justify-between">
          <div>
            <img class="h-8 w-auto" src="<?php echo e(asset('plain-assets/logos/small_tiger_vial.png')); ?>" alt="">
          </div>
          <div class="-mr-2">
            <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600">
              <span class="sr-only">Close menu</span>
              <!-- Heroicon name: outline/x -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        <div class="pt-5 pb-6">
          <div class="px-2 space-y-1">
            <a href="/#inv-data" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Investor Data</a>

            <a href="/#video-ai" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Video AI</a>

            <a href="/#mms" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">MMS Domination</a>

            <a href="/#pricing" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">Pricing</a>
            <a href="/#360" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:bg-gray-50">360</a>
          </div>
          <?php if(Auth::check()) { ?>
            <div class="mt-6 px-5">
            <a target="_blank" href="/nova/dashboards/main" class="block text-center w-full py-3 px-4 rounded-md shadow bg-indigo-600 text-white font-medium hover:bg-indigo-700">Dashboard</a>
          </div>
          <div class="mt-6 px-5">
            <p class="text-center text-base font-medium text-gray-500"><a href="/?logout=true" class="text-gray-900 hover:underline">Logout</a></p>
          </div>
          <?php } else { ?>
            <div class="mt-6 px-5">
            <a href="/#signup" class="block text-center w-full py-3 px-4 rounded-md shadow bg-indigo-600 text-white font-medium hover:bg-indigo-700">Start free trial</a>
          </div>
          <div class="mt-6 px-5">
            <p class="text-center text-base font-medium text-gray-500">Existing customer? <a href="/nova/login" target="_blank" class="text-gray-900 hover:underline">Login</a></p>
          </div>
          <?php } ?>
          
        </div>
      </div>
    </div>
  </header><?php /**PATH /var/www/resources/views/header.blade.php ENDPATH**/ ?>