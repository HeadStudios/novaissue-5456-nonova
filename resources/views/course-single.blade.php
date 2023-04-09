<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
$assignment = $vlesson->getAssignment($user->id);
?>
<html>
  
    <head>
    <title>{{ $vlesson->title }} - @role('student') {{ $course->name }} @endrole</title>
    @vite(['resources/css/app.css'])
  
    
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <!-- https://unpkg.com/@videojs/themes@1.0.1/dist/fantasy/index.css -->
    <link href="https://unpkg.com/@videojs/themes@1.0.1/dist/fantasy/index.css" rel="stylesheet"
/>
<link
  rel="stylesheet"
  href="https://unpkg.com/@tailwindcss/typography@0.4.x/dist/typography.min.css"
/>
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
<script src="/js/Youtube.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>

</head>
<body>


  
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative overflow-hidden">
  <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full" aria-hidden="true">
    
  </div>

  <div class="relative pt-6">
    

    <main class="mx-auto max-w-7xl px-4">



  <!-- This example requires Tailwind CSS v2.0+ -->
<div class="lg:flex lg:items-center lg:justify-between">
  <div class="flex-1 min-w-0">
    <nav class="flex" aria-label="Breadcrumb">
      <ol role="list" class="flex items-center space-x-4">
        <li>
          <div class="flex">
            <a href="{{ route('courses') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Up & Go Training Wheels</a>
          </div>
        </li>
        <li>
          <div class="flex items-center">
            <!-- Heroicon name: solid/chevron-right -->
            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            @role('student')<a href="" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $course->name }}</a>@endrole
          </div>
        </li>
      </ol>
    </nav>
    <h2 class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">{{ $vlesson->title }}</h2>
    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
      <div class="mt-2 flex items-center text-sm text-gray-500">
        <!-- Heroicon name: solid/briefcase -->
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" id="status"> In Progress </span>
      </div>
      <!--
      <div class="mt-2 flex items-center text-sm text-gray-500">
        
        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
        </svg>
        Remote
        
      </div>
      <div class="mt-2 flex items-center text-sm text-gray-500">
        
        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
        </svg>
        $120k &ndash; $140k
      </div>
      <div class="mt-2 flex items-center text-sm text-gray-500">
       
        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
        </svg>
        Closing on January 9, 2020
      </div>-->
    </div>
  </div>
  <div class="mt-5 flex lg:mt-0 lg:ml-4">
    <span class="hidden sm:block">
      <a href="/lms/printc/{{ $user->id }}/{{ $vlesson->id }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <!-- Heroicon name: solid/pencil -->
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
        </svg>
        Print 
    </a>
    </span>

    <span class="hidden sm:block ml-3">
      <a href="/lms/dashboard" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <!-- Heroicon name: solid/link -->
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
        </svg>
        Back to Dashboard
      </a>
    </span>

    <span class="sm:ml-3">
    <a href="@role('admin') {{ $next }} @endrole" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <!-- Heroicon name: solid/check -->
        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        Next Lesson
        </a>
    </span>

    <!-- Dropdown -->
    
  </div>
</div>







    <!-- this is where the header must goo.... -->











      <!--<div class="text-center">
        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
          <span class="block xl:inline">Data to enrich your</span>
          <span class="block text-indigo-600 xl:inline">online business</span>
        </h1>
        <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.</p>
       
      </div>-->
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
          <!-- video --> 

@if (strpos($vlesson->video_url, 'youtube') !== false)
          <video
  id="vid1"
  class="video-js vjs-theme-fantasy"
  controls
  width="640" height="400"
  data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{{$vlesson->video_url}}"}], "youtube": { "iv_load_policy": 1 } }'
>
</video>
@else
<video controls
class="video-js vjs-theme-fantasy"
    preload="auto"
    style="width:100%;"
    height="400" id="vid1" class="video-js">
  <source src="{{ $vlesson->video_url }}">
</video>

@endif
    <!--<source src="https://p147.p4.n0.cdn.getcloudapp.com/items/OAu2KnAW/238eee72-2541-46cc-be24-3af84376e042.mp4" type="video/mp4" />-->
    
    <p class="vjs-no-js" style="display:none;">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank"
        >supports HTML5 video</a
      >
    </p>
  </video>


<div class="relative px-4 sm:px-6 lg:px-8 prose pt-4 pb-4">
{!! Str::markdown($vlesson->formatted_lesson_outline) !!}
  </div>




          </div>
        </div>
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left bg-gray-50 p-4 rounded-lg" style="width:100%;">
        @isset($vlesson->instructions)
        @role('bdm')
        <div>
            <h1>
            <span class="block font-semibold uppercase tracking-wide text-gray-500 lg:text-sm xl:text-base bg-black text-white	inline p-2">LESSON NOTES</span>
            
          </h1>
          <p class="mt-3 mb-3 text-base text-gray-500 sm:mt-5 sm:text-4xl lg:text-lg xl:text-xl">{{ $vlesson->instructions }}</p>
          <div class="max-w-lg mx-auto sm:max-w-full lg:max-w-none">
          <div class="bg-green-500 text-white px-4 py-3 rounded-md my-2" style="display: none;" id="success"></div>
          <div id="assignment_txt"></div>
          
          
        <form action="{{ route('assignment.submit') }}" class="grid grid-cols-1 gap-y-6" id="assignment-form">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <input type="hidden" name="vlesson_id" value="{{ $vlesson->id }}">
          <div>
            <label for="message" class="sr-only">Mobile</label>
            <textarea name="assignment" rows="8" id="assignment" class="sm:text-xl block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ $vlesson->placeholder  }}">@isset($assignment){!! $assignment !!}@endisset</textarea>
            
          </div>
          <!--<div>
            <label for="message" class="sr-only">Message</label>
            <textarea id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" placeholder="Message"></textarea>
          </div>-->
          <div>
            <button type="submit" id="gogo" class="sm:py-8 sm:px-8 sm:text-6xl md:text-xl inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
            <!-- Calendly link widget begin -->
<!-- Calendly link widget end -->
          </div>

          <fieldset class="border-t border-b border-gray-200">
  <legend class="sr-only">Notifications</legend>
  <div class="divide-y divide-gray-200">
  @foreach($checklist->sortBy('order_column') as $check)

  @php dump($check); @endphp
    <div class="relative flex items-start py-4">
      
      <div class="min-w-0 flex-1 text-sm">
        <label for="comments" class="font-medium text-gray-700">{{ $check->name }}</label>
        <p id="comments-description" class="text-gray-500">{{ $check->description }}</p>
      </div>
      
      <div class="ml-3 flex items-center h-5">
        <input aria-describedby="comments-description" class="checkboxer" name="{{ $check->id }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" @if ($check->pivot->status == 1) checked @endif>
      </div>
    </div>
    @endforeach
    
    
  </div>
</fieldset>


        </form>
        
      </div>
          
</div>
@endrole
@endisset
            <div>

            <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base mb-5">@role('admin') {{ $course->name }} @endrole</span>
        <!-- This example requires Tailwind CSS v2.0+ -->




 
        




<div class="bg-white shadow overflow-hidden sm:rounded-md mb-5">
  <ul role="list" class="divide-y divide-gray-200">
    @role('admin')
  @php $course_lessons = collect($course_lessons); @endphp
  @endrole
  @role('admin')
  @foreach($course_lessons->sortBy('order_column') as $slesson)
    <li>
      <a href="/lms/ovlesson/{{$slesson['permalink']}}" class="block @if($slesson['id'] == $vlesson->id) bg-slate-300  @else hover:bg-gray-50  @endif">
        <div class="px-4 py-4 sm:px-6">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-indigo-600 truncate">{{ $slesson['title'] }}</p>
            <div class="ml-2 flex-shrink-0 flex">
              <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"><?php /* {{ App\Hydraulics\Campaigner::courseStatus($slesson->id) }} */ ?></p>
            </div>
          </div>
          <div class="mt-2 sm:flex sm:justify-between">
            <div class="sm:flex">
              <p class="flex items-center text-sm text-gray-500">
                <!-- Heroicon name: solid/users -->
                <!--<svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>-->
                {{ $slesson['status'] }}
                
              </p>
              <!--<p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
              
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                Remote
              </p> -->
            </div>
            <!--<div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
            
              <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
              </svg>
              <p>
                Closing on
                <time datetime="2020-01-07">January 7, 2020</time>
              </p>
            </div>-->
          </div>
        </div>
      </a>
    </li>
    @endforeach
    @endrole

    
  </ul>
</div>



  
</fieldset>
          </div>
         
        </form>
      </div>
      
          
</div>

        </div>
        
        
      </div>
      
    </main>
    
  </div>
</div>



<script>
    

    




    function grayer(formId, yesNo) {
   var f = document.getElementById(formId), s, opacity;
   s = f.style;
   opacity = yesNo? '40' : '100';
   s.opacity = s.MozOpacity = s.KhtmlOpacity = opacity/100;
   s.filter = 'alpha(opacity='+opacity+')';
   for(var i=0; i<f.length; i++) f[i].disabled = yesNo;
}
window.onload=function(){

  //var video = document.getElementById('vid1');
  const player = videojs('vid1', {});
  player.on("ended", function(){ 
    httpGet('{{ env('APP_URL') }}/api/watched/' + {{ Auth::user()->id }} + '/'+{{$vlesson->id}}+'/1');
          });
    /*video.onended = function(e) {
      //httpGet('{{ env('APP_URL') }}/api/watched/' + {{ Auth::user()->id }} + '/'+{{$vlesson->id}}+'/1');
        //grayer('checklister',false);
        alert("That's how wiggas get tossed up");

    };*/

  //const player = videojs('vid1', {});

  
    //grayer('checklister',true);
}; // disabled by default

    
    </script>
    <script>
      const successDiv = document.querySelector('#success');


// Function to display success message and fade it out after 4 seconds
function showSuccessMessage() {
  successDiv.textContent = 'Lesson Submitted';
  successDiv.style.display = 'block';
  successDiv.style.opacity = '1';
  setTimeout(() => {
    successDiv.style.opacity = '0';
    setTimeout(() => {
      successDiv.style.display = 'none';
    }, 1000);
  }, 4000);
}
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
        }).then(response => {
  if (response.ok) {
    showSuccessMessage();
  }
}).catch(error => {
  console.log(error);
});


       
        const formattedText = textarea.value.replace(/\n/g, "<br>");
        assignment_txt.innerHTML = formattedText;
        //assignment_txt.textContent = textarea.value;
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
<style>
  #success {
  transition: opacity 1s ease-in-out;
}
  </style>
<script>

function grayer(formId, yesNo) {
   var f = document.getElementById(formId), s, opacity;
   s = f.style;
   opacity = yesNo? '40' : '100';
   s.opacity = s.MozOpacity = s.KhtmlOpacity = opacity/100;
   s.filter = 'alpha(opacity='+opacity+')';
   for(var i=0; i<f.length; i++) f[i].disabled = yesNo;
}


var elements = document.getElementsByClassName("checkboxer");

var myFunction = function() {
    var attribute = this.getAttribute("name");
    var trueorfalse;
    if(this.checked) { trueorfalse = 1; } else { trueorfalse = 0; }
    httpGet('{{ env('APP_URL') }}/api/check/' + {{ Auth::user()->id }} + '/'+attribute+'/' + trueorfalse);
    if ($('input[type="checkbox"]').not(':checked').length == 0) {
    $('#status').text("GOGOGOGOGO!"); 
  }
};

for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', myFunction, false);
}


function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, true ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}
  </script>



</body>
</html>
