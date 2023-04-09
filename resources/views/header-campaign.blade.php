<header class="relative">
    <div class="bg-white pt-6 pb-6">
      <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6" aria-label="Global">
        <div class="flex items-center flex-1">
          <div class="flex items-center justify-between w-full md:w-auto">
            <a href="{{ $site_url }}">
              
              <img class="w-auto m:h-10" src="@if(empty($logo_url)) {{ asset('plain-assets/logos/small_tiger_vial.png') }} @else {{ $logo_url }}  @endif" alt="" style="width:250px;height:80px;object-fit:contain;object-position:left;">
            </a>
            
          </div>
          
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
            <img class="h-8 w-auto" src="{{ asset('plain-assets/logos/small_tiger_vial.png') }}" alt="">
          </div>
          
        </div>
        
      </div>
    </div>
  </header>