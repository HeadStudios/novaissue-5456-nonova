<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Hydraulics\Course\CourseStatus;
$user = Auth::user();
$checklists = $user->getCheckListsIn($course);


?>
<html>
  
    <head>
    <title>{{ $course->name }}</title>
    @vite(['resources/css/app.css'])

    
  
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
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
<div class="relative bg-white overflow-hidden">
  <div class="hidden lg:block lg:absolute lg:inset-0" aria-hidden="true">
    <svg class="absolute top-0 left-1/2 transform translate-x-64 -translate-y-8" width="640" height="784" fill="none" viewBox="0 0 640 784">
      <defs>
        <pattern id="9ebea6f4-a1f5-4d96-8c4e-4c2abf658047" x="118" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
          <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
        </pattern>
      </defs>
      <rect y="72" width="640" height="640" class="text-gray-50" fill="currentColor" />
      <rect x="118" width="404" height="784" fill="url(#9ebea6f4-a1f5-4d96-8c4e-4c2abf658047)" />
    </svg>
  </div>

  <div class="relative pt-6 pb-16 sm:pb-24 lg:pb-32">


    <main class="mt-16 mx-auto max-w-7xl px-4 sm:mt-24 sm:px-6 lg:mt-32">
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
          <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">COURSE</span>
            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
              <span class="block text-gray-900">{{ $course->name }}</span>
            </span>
          </h1>
          
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">{{ $course->description }}</p>
          <div class="mt-8 sm:max-w-lg sm:mx-auto sm:flex sm:flex-row lg:text-left lg:mx-0">
            
          
          <div class="sm:w-1/2 mt-3">

              <span class="w-full px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto">Notify me</span>
</div>
<div class="sm:w-1/2">
              <div style="width:300px;height:300px;">
          <canvas id="chrt_{{ $user->id }}" height="200" width="300" ></canvas>
        </div>
</div>
            
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
          
        </div>
      </div>
    </main>
  </div>
</div>

<main class="mx-auto max-w-7xl px-4 sm:px-6">
    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-7 lg:flex lg:items-start">
          <div class="relative mx-auto w-full rounded-lg shadow-lg">
         
    
    <p class="vjs-no-js" style="display:none;">
      To view this video please enable JavaScript, and consider upgrading to a
      web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
  


<div class="relative px-4 sm:px-6 lg:px-8 prose pt-4 pb-4">
<h1>Headline Here</h1>
<p>And here are some bullets points</p>
<ul>
<li>Bullet 1</li>
<li>Bullet 2</li>
<li>Bullet 3</li>
</ul>
<p>See how easy that is?</p>
<p><img src="https://is2-ssl.mzstatic.com/image/thumb/Purple1/v4/9d/0d/80/9d0d80d1-9a9c-2731-fcec-66640b333826/source/256x256bb.jpg" alt="Drag Racing"></p>

  </div>




          </div>
        </div>
        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-5 lg:text-left bg-gray-50 p-4 rounded-lg" style="width:100%;">
            <div>

            <h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base mb-5">Course Syllabus</span>
        <!-- This example requires Tailwind CSS v2.0+ -->




 
        




<div class="bg-white shadow overflow-hidden sm:rounded-md mb-5">
  <ul role="list" class="divide-y divide-gray-200">
  @php $course_lessons = collect($lessons); @endphp
@foreach($course_lessons->sortBy('order_column') as $slesson)

<li>
      <a href="/lms/ovlesson/{{$slesson['permalink']}}" class="block">
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
                {{ $slesson['status'] }}
                
              </p>
             
            </div>
          </div>
        </div>
      </a>
    </li>

@endforeach
       
    
    
  </ul>
</div>


          </h1><h1>
            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">ACTION ITEMS</span>
            <!--<span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
              <span class="block text-gray-900">Ready to</span>
              <span class="block text-indigo-600">start?</span>
            </span>-->
          </h1>
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">Please watch the video (to the left) and then mark the tasks below as complete - these should make sense after completion of video. Any questions contact your CSM (customer success manager). </p>
          <div class="max-w-lg mx-auto lg:max-w-none">
            
        <form id="checklister" class="grid grid-cols-1 gap-y-6">
        <fieldset class="border-t border-b border-gray-200">
  <legend class="sr-only">Notifications</legend>
  <div class="divide-y divide-gray-200">

  
  <div class="relative flex items-start py-4">
      
      <div class="min-w-0 flex-1 text-sm">
        <label for="comments" class="font-medium text-gray-700">Aftermath Tasks</label>
        <p id="comments-description" class="text-gray-500">Start a record label</p>
      </div>
     
      <div class="ml-3 flex items-center h-5">
        <input id="comments" aria-describedby="comments-description" class="checkboxer" name="7" type="checkbox" checked="">
      </div>
    </div>
    @foreach($checklists->sortBy('order_column') as $check)

    <div class="relative flex items-start py-4">
      
      <div class="min-w-0 flex-1 text-sm">
        <label for="comments" class="font-medium text-gray-700">{{ $check['name'] }}</label>
        <p id="comments-description" class="text-gray-500">{{ $check['description'] }}</p>
      </div>
     
      <div class="ml-3 flex items-center h-5">
        <input id="comments" aria-describedby="comments-description" class="checkboxer" name="{{ $check['id'] }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
      </div>
    </div>
    @endforeach
    
    <div class="relative flex items-start py-4">
      
      <div class="min-w-0 flex-1 text-sm">
        <label for="comments" class="font-medium text-gray-700">Do the fourth thing</label>
        <p id="comments-description" class="text-gray-500">Get the fourth thing done</p>
      </div>
     
      <div class="ml-3 flex items-center h-5">
        <input id="comments" aria-describedby="comments-description" class="checkboxer" name="4" type="checkbox">
      </div>
    </div>
        
    
  </div>
    
</fieldset>
          </form></div>
         
        
      </div>
      
          
</div>

        </div>
        
        
      </main>



<script>
@php

$cs = new CourseStatus();
@endphp
{!! $cs->generateJSChartCode($user) !!}
    </script>


</body>
</html>

