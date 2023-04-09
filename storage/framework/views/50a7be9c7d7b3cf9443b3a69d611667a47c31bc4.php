<?php
use Illuminate\Support\Facades\Auth;
if(isset($_GET['logout'])) { Auth::logout(); }
?>
<!DOCTYPE html>
<html lang="en"  class="scroll-smooth">
<head>
<?php echo \Livewire\Livewire::scripts(); ?>

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.headstuff','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('headstuff'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<script type="module" src="node_modules/@headlessui/dist/index.cjs"></script>
    <title>Rent Roll Devour System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://rsms.me/inter/inter.css">-->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
    <?php echo \Livewire\Livewire::styles(); ?>

    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">
    <style>
      @media(min-width: 768px) {
      .width-200 {
        background-color:white;
        width:200%;
      } }
    </style>
</head>
<body class="font-sans antialiased text-gray-900" style="width:100%;">
    
<?php echo $__env->make('header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- quick deply for one small step for man - brush yourself off and try again -->    
      <div class="relative bg-white overflow-hidden">
        <div class="max-w-screen-xl mx-auto">
          <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewbox="0 0 100 100" preserveaspectratio="none"><polygon points="50,0 100,0 50,100 0,100"></polygon></svg><div class="relative pt-1 px-4 sm:px-6 lg:px-8">
              
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
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewbox="0 0 24 24" onclick="toggleMobMenu()"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                  </div>
                  <div class="px-2 pt-2 pb-3">
      <a class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#inv-data" role="menuitem">Investor Data</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#video-ai" role="menuitem">Video AI</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#mms" role="menuitem">MMS Domination</a><a class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out" href="#pricing" role="menuitem">Pricing</a>
      </div>
                  <div>
                  <a class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out" href="#signup" role="menuitem">Sign Up</a>
                    <a class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out" href="/nova/dashboard" role="menuitem">Log in</a></div>
                </div>
              </div>
            </div>
            <main class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28"><div class="sm:text-center lg:text-left">
                <h2 class="text-4xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
                  <span class="mr-1">Grow your rent roll on  </span>
                  <br class="xl:hidden"><span class="text-indigo-600">autopilot.</span>
                </h2>
                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">Simply upload your investor lead list, choose the pre-built video campaigns and leave it do its job. Set and forget rent roll growth automation using the power of video/image MMS combined with video AI generation software. </p>
                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                  <div class="rounded-md shadow"><a class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="#learnmore">Learn More</a></div>
                  <div class="mt-3 sm:mt-0 sm:ml-3"><a class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-300 transition duration-150 ease-in-out md:py-4 md:text-lg md:px-10" href="#signup">Free Trial</a></div>
                </div>
              </div>
            </main>
      </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
          <img class="h-56 w-full object-scale-down object-left sm:h-72 md:h-96 lg:w-full lg:h-full" src="<?php echo e(asset('images/the_header_screen.jpg')); ?>" alt="">
          <!-- https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2850&q=80 -->
      </div>
      </div>
        
      <div class="bg-white">
        <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
          <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-2">
              <img class="h-9" src="<?php echo e(asset('images/coronis.png')); ?>" alt="">
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
              <img class="h-12" src="<?php echo e(asset('images/metrocityrealty-logo.png')); ?>" alt="">
            </div>
            <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-2">
              <img class="h-12" src="<?php echo e(asset('images/obsidian-property-logo.png')); ?>" alt="">
            </div>
            <!--<div class="col-span-1 flex justify-center md:col-span-3 lg:col-span-1">
              <img class="h-12" src="<?php echo e(asset('plain-assets/logos/resecurb-color.svg')); ?>" alt="">
            </div>
            <div class="col-span-2 flex justify-center md:col-span-3 lg:col-span-1">
              <img class="h-12" src="https://tailwindui.com/img/logos/v1/workcation-logo.svg" alt="">
            </div>-->
          </div>
        </div>
      </div>
        
      <section class="bg-white overflow-hidden"><div class="relative max-w-screen-xl mx-auto pt-20 pb-12 px-4 sm:px-6 lg:px-8 lg:py-20">
          <svg class="absolute top-full left-0 transform translate-x-80 -translate-y-24 lg:hidden" width="784" height="404" fill="none" viewbox="0 0 784 404"><defs><pattern id="e56e3f81-d9c1-4b83-a3ba-0d0ac8c32f32" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="784" height="404" fill="url(#e56e3f81-d9c1-4b83-a3ba-0d0ac8c32f32)"></rect></svg><svg class="hidden lg:block absolute right-full top-1/2 transform translate-x-1/2 -translate-y-1/2" width="404" height="784" fill="none" viewbox="0 0 404 784"><defs><pattern id="56409614-3d62-4985-9a10-7ca758a8f4f0" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="784" fill="url(#56409614-3d62-4985-9a10-7ca758a8f4f0)"></rect></svg><div class="relative lg:flex lg:items-center">
            <div class="hidden lg:block lg:flex-shrink-0">
              <img class="h-64 w-64 rounded-full xl:h-80 xl:w-80" src="images/greg-photo.jpeg" alt="">
      </div>
            <div class="relative lg:ml-10">
              <svg class="absolute top-0 left-0 transform -translate-x-8 -translate-y-24 h-36 w-36 text-indigo-200 opacity-50" stroke="currentColor" fill="none" viewbox="0 0 144 144"><path stroke-width="2" d="M41.485 15C17.753 31.753 1 59.208 1 89.455c0 24.664 14.891 39.09 32.109 39.09 16.287 0 28.386-13.03 28.386-28.387 0-15.356-10.703-26.524-24.663-26.524-2.792 0-6.515.465-7.446.93 2.327-15.821 17.218-34.435 32.11-43.742L41.485 15zm80.04 0c-23.268 16.753-40.02 44.208-40.02 74.455 0 24.664 14.891 39.09 32.109 39.09 15.822 0 28.386-13.03 28.386-28.387 0-15.356-11.168-26.524-25.129-26.524-2.792 0-6.049.465-6.98.93 2.327-15.821 16.753-34.435 31.644-43.742L121.525 15z"></path></svg><blockquote class="relative">
                <div class="text-2xl leading-9 font-medium text-gray-900">
                  <p>My closed property managements are up by 63% compared to before we started and based on what I have seen I don’t think we have scratched the surface of what is possible.</p>
                </div>
                <footer class="mt-8"><div class="flex">
                    <div class="flex-shrink-0 lg:hidden">
                      <img class="h-12 w-12 rounded-full" src="images/greg-photo.jpeg" alt="">
      </div>
                    <div class="ml-4 lg:ml-0">
                      <div class="text-base leading-6 font-medium text-gray-900">Greg Jackson</div>
                      <div class="text-base leading-6 font-medium text-indigo-600">Principal / Metrocity</div>
                    </div>
                  </div>
                </footer>
      </blockquote>
            </div>
          </div>
        </div>
      </section>
        
      <div class="py-16 bg-gray-50 overflow-hidden lg:py-24"><a id="learnmore"></a>
        <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-screen-xl">
          <svg class="hidden lg:block absolute left-full transform -translate-x-1/2 -translate-y-1/4" width="404" height="784" fill="none" viewbox="0 0 404 784"><defs><pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)"></rect></svg><div class="relative">
            <h3 class="text-center text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">Stop relying on referrals and start taking prime position</h3>
            <p class="mt-4 max-w-3xl mx-auto text-center text-xl leading-7 text-gray-500">Be the name on investor’s minds when they are ready to onboard/switch to a new property manager</p>
          </div>
          <div class="relative mt-12 lg:mt-24 lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
            <div class="relative">
              <a id="inv-data"></a><h4 class="text-2xl leading-8 font-extrabold text-gray-900 tracking-tight sm:text-3xl sm:leading-9">When growing a rent roll, timing and the right data is everything</h4>
              <!--<p class="mt-3 text-lg leading-7 text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur minima sequi recusandae, porro maiores officia assumenda aliquam laborum ab aliquid veritatis impedit odit adipisci optio iste blanditiis facere. Totam, velit.</p>-->
              <ul class="mt-10">
      <li>
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
</svg>

      </div>
                    </div>
                    <div class="ml-4">
                      <h5 class="text-lg leading-6 font-medium text-gray-900">Identify the Pain</h5>
                      <p class="mb-2 text-base leading-6 text-gray-500">Get the specific pain the investor faces with their current property manager (e.g. exit report/bond refund issues, maintenance/lack of regular inspection reports etc.) to tailor outreach strategy</p>
                    </div>
                  </div>
                </li>
                <li class="mt-10">
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path d="M 23.136719 10.746094 C 22.738281 10.253906 22.1875 9.621094 21.847656 9.40625 C 21.53125 9.210938 21.140625 8.964844 20.617188 8.964844 C 19.441406 8.964844 18.917969 9.628906 18.917969 10.289062 C 18.917969 10.664062 19.09375 10.890625 19.269531 11.066406 L 14.433594 11.066406 C 14.238281 10.71875 13.9375 10.5 13.589844 10.5 C 13.328125 10.5 13.089844 10.625 12.90625 10.839844 C 12.71875 10.625 12.480469 10.5 12.21875 10.5 C 11.953125 10.5 11.714844 10.625 11.53125 10.839844 C 11.347656 10.625 11.109375 10.5 10.847656 10.5 C 10.5 10.5 10.199219 10.71875 10.003906 11.066406 L 6.609375 11.066406 C 6.585938 11.046875 6.5625 11.027344 6.542969 11.011719 L 4.90625 9.90625 C 4.742188 9.796875 4.464844 9.710938 4.269531 9.710938 L 0.429688 9.710938 C 0.261719 9.710938 0.125 9.785156 0.0507812 9.914062 C -0.0234375 10.042969 -0.015625 10.199219 0.0703125 10.347656 L 1.003906 11.90625 C 1.027344 11.949219 1.027344 12.050781 1.003906 12.09375 L 0.0703125 13.65625 C -0.015625 13.800781 -0.0234375 13.957031 0.0507812 14.085938 C 0.121094 14.214844 0.261719 14.289062 0.429688 14.289062 L 4.265625 14.289062 C 4.464844 14.289062 4.742188 14.203125 4.90625 14.09375 L 6.539062 12.988281 C 6.5625 12.972656 6.585938 12.953125 6.609375 12.9375 L 10.003906 12.9375 C 10.199219 13.28125 10.5 13.5 10.84375 13.5 C 11.109375 13.5 11.347656 13.375 11.53125 13.160156 C 11.714844 13.375 11.953125 13.5 12.21875 13.5 C 12.480469 13.5 12.71875 13.375 12.90625 13.160156 C 13.089844 13.375 13.328125 13.5 13.589844 13.5 C 13.9375 13.5 14.238281 13.28125 14.433594 12.9375 L 19.265625 12.9375 C 19.089844 13.109375 18.917969 13.335938 18.917969 13.710938 C 18.917969 14.371094 19.441406 15.035156 20.617188 15.035156 C 21.140625 15.035156 21.53125 14.789062 21.847656 14.59375 C 22.1875 14.378906 22.734375 13.746094 23.136719 13.253906 C 24 12.199219 24 12.070312 24 12 C 24 11.929688 24 11.800781 23.136719 10.746094 Z M 23.136719 10.746094 "/>
</svg>


      </div>
                    </div>
                    <div class="ml-4">
                      <h5 class="text-lg leading-6 font-medium text-gray-900">Get the right time to strike</h5>
                      <p class="mb-2 text-base leading-6 text-gray-500">Know exactly when an investor’s lease/s are up for renewal  - never miss out on an opportunity due to “bad timing” only to have it scooped up by another agent.</p>
                    </div>
                  </div>
                </li>
                <li class="mt-10">
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path d="M 17.722656 14.859375 L 14.417969 7.84375 C 14.414062 7.832031 14.40625 7.824219 14.402344 7.8125 C 14.28125 7.445312 13.941406 7.179688 13.535156 7.179688 L 11.589844 7.179688 C 11.085938 7.179688 10.675781 7.589844 10.675781 8.09375 L 10.675781 17.429688 C 10.675781 17.894531 11.027344 18.273438 11.476562 18.332031 L 11.460938 20.589844 C 11.457031 20.859375 11.238281 21.082031 10.96875 21.082031 L 7.289062 21.082031 C 6.683594 21.082031 6.191406 21.574219 6.191406 22.175781 L 6.191406 22.910156 C 6.191406 23.511719 6.679688 24 7.28125 24 L 13.355469 23.929688 C 13.960938 23.921875 14.449219 23.425781 14.449219 22.824219 L 14.449219 13.375 L 15.679688 15.824219 C 15.835938 16.136719 16.164062 16.339844 16.515625 16.339844 C 16.652344 16.339844 16.78125 16.308594 16.90625 16.25 L 17.28125 16.078125 C 17.5 15.972656 17.667969 15.789062 17.753906 15.558594 C 17.835938 15.328125 17.824219 15.082031 17.722656 14.859375 Z M 7.28125 23.695312 Z M 7.28125 23.695312 "/>
<path d="M 12.5625 6.199219 C 14.273438 6.199219 15.664062 4.808594 15.664062 3.101562 C 15.664062 1.390625 14.273438 0 12.5625 0 C 10.855469 0 9.460938 1.390625 9.460938 3.101562 C 9.460938 4.808594 10.855469 6.199219 12.5625 6.199219 Z M 12.5625 6.199219 "/>
</svg>

      </div>
                    </div>
                    <div class="ml-4">
                      <h5 class="text-lg leading-6 font-medium text-gray-900">Stop competing like a beggar</h5>
                      <p class="mb-2 text-base leading-6 text-gray-500">Stop competing for scraps and getting hammered on management fees. Own your area by the “lead checkout” system - so the lead is yours and only yours!</p>
                    </div>
                  </div>
                </li>
              </ul>
      </div>
            <div class="mt-10 -mx-4 relative lg:mt-0">
              <svg class="absolute left-1/2 transform -translate-x-1/2 translate-y-16 lg:hidden" width="784" height="404" fill="none" viewbox="0 0 784 404"><defs><pattern id="ca9667ae-9f92-4be7-abcb-9e3d727f2941" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="784" height="404" fill="url(#ca9667ae-9f92-4be7-abcb-9e3d727f2941)"></rect></svg><img class="relative mx-auto" width="600" src="<?php echo e(asset('images/magnify_the_insights.jpg')); ?>" alt=""> 
      </div>
          </div>
          <svg class="hidden lg:block absolute right-full transform translate-x-1/2 translate-y-12" width="404" height="784" fill="none" viewbox="0 0 404 784"><defs><pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)"></rect></svg><div class="relative mt-12 sm:mt-16 lg:mt-24">
            <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
              <div class="lg:col-start-2">
                <a id="video-ai"></a><h4 class="text-2xl leading-8 font-extrabold text-gray-900 tracking-tight sm:text-3xl sm:leading-9">Grab investor attention, address their uncertainty and pains.</h4>
                <p class="mt-3 text-lg leading-7 text-gray-500">Forgettable campaigns that fail to break through the “who cares” investor filter eat into a property management company’s income. Use what works and stop poking around the dark.</p>
                <ul class="mt-10">
      <li>
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        
  <path d="M 17.449219 20.761719 L 17.570312 20.65625 C 17.589844 20.640625 17.605469 20.625 17.621094 20.605469 C 17.683594 20.53125 19.113281 18.882812 19.65625 17.613281 L 19.917969 17.613281 C 20.65625 17.613281 21.257812 17.011719 21.257812 16.273438 L 21.257812 14.152344 C 21.257812 13.414062 20.65625 12.808594 19.917969 12.808594 L 19.628906 12.808594 C 19.183594 11.648438 18.421875 10.601562 17.414062 9.75 C 17.269531 9.226562 17.375 8.667969 17.742188 8.085938 C 17.949219 7.757812 17.949219 7.34375 17.738281 7.015625 C 17.527344 6.6875 17.160156 6.511719 16.773438 6.5625 C 15.359375 6.738281 14.511719 7.378906 14.015625 7.976562 C 13.550781 7.851562 13.070312 7.75 12.585938 7.699219 C 12.320312 7.667969 12.078125 7.855469 12.046875 8.125 C 12.019531 8.386719 12.203125 8.632812 12.472656 8.664062 C 13.011719 8.726562 13.546875 8.84375 14.054688 9.003906 C 14.261719 9.070312 14.480469 8.992188 14.605469 8.816406 C 14.9375 8.320312 15.609375 7.691406 16.890625 7.53125 C 16.898438 7.53125 16.910156 7.53125 16.921875 7.546875 C 16.929688 7.5625 16.925781 7.570312 16.921875 7.574219 C 16.410156 8.386719 16.257812 9.234375 16.484375 10.027344 C 16.488281 10.171875 16.550781 10.304688 16.664062 10.390625 C 17.699219 11.222656 18.449219 12.28125 18.828125 13.453125 C 18.894531 13.652344 19.085938 13.785156 19.289062 13.785156 L 19.917969 13.785156 C 20.121094 13.785156 20.289062 13.953125 20.289062 14.15625 L 20.289062 16.277344 C 20.289062 16.484375 20.121094 16.648438 19.917969 16.648438 L 19.324219 16.648438 C 19.113281 16.648438 18.921875 16.785156 18.859375 16.992188 C 18.585938 17.886719 17.378906 19.40625 16.910156 19.949219 L 16.800781 20.042969 C 15.792969 20.953125 15.691406 22.03125 15.6875 22.355469 L 15.6875 23.035156 L 12.890625 23.035156 L 12.890625 22.378906 C 12.890625 22.242188 12.832031 22.109375 12.726562 22.015625 C 12.625 21.921875 12.488281 21.878906 12.351562 21.894531 C 11.636719 21.96875 10.917969 21.957031 10.222656 21.863281 C 10.082031 21.84375 9.941406 21.890625 9.839844 21.984375 C 9.730469 22.074219 9.671875 22.207031 9.671875 22.351562 L 9.671875 23.03125 L 6.875 23.03125 L 6.875 22.839844 C 6.875 22.835938 6.875 22.824219 6.875 22.820312 C 6.851562 22.304688 6.691406 21.003906 5.671875 19.957031 C 5.191406 19.460938 4.761719 18.804688 4.386719 18.011719 C 4.382812 18.007812 4.382812 18 4.378906 17.992188 C 4.160156 17.570312 3.992188 17.125 3.878906 16.65625 L 3.875 16.636719 C 3.875 16.628906 3.871094 16.625 3.871094 16.621094 C 3.691406 16.03125 3.710938 15.292969 3.710938 15.289062 C 3.710938 15.285156 3.710938 15.277344 3.710938 15.273438 C 3.710938 14.949219 3.742188 14.621094 3.792969 14.304688 C 3.835938 14.039062 3.660156 13.789062 3.394531 13.746094 C 3.128906 13.703125 2.878906 13.878906 2.835938 14.140625 C 2.773438 14.507812 2.742188 14.886719 2.742188 15.265625 C 2.738281 15.363281 2.730469 16.183594 2.9375 16.894531 C 3.066406 17.417969 3.261719 17.933594 3.511719 18.421875 C 3.921875 19.3125 4.417969 20.054688 4.972656 20.625 C 5.75 21.429688 5.882812 22.4375 5.902344 22.847656 L 5.902344 23.050781 C 5.902344 23.070312 5.902344 23.085938 5.90625 23.113281 C 5.941406 23.609375 6.355469 24 6.851562 24 L 9.6875 24 C 10.210938 24 10.636719 23.574219 10.636719 23.050781 L 10.636719 22.886719 C 11.0625 22.921875 11.484375 22.925781 11.914062 22.90625 L 11.914062 23.050781 C 11.914062 23.574219 12.339844 24 12.867188 24 L 15.699219 24 C 16.222656 24 16.652344 23.574219 16.652344 23.050781 L 16.652344 22.359375 C 16.660156 22.207031 16.714844 21.425781 17.449219 20.761719 Z M 17.449219 20.761719 "/>
<path d="M 2.78125 9.371094 C 2.78125 11.570312 4.570312 13.363281 6.773438 13.363281 C 8.972656 13.363281 10.765625 11.578125 10.765625 9.371094 C 10.765625 7.175781 8.976562 5.382812 6.773438 5.382812 C 4.574219 5.382812 2.78125 7.167969 2.78125 9.371094 Z M 9.792969 9.371094 C 9.792969 11.039062 8.4375 12.394531 6.773438 12.394531 C 5.109375 12.394531 3.753906 11.039062 3.753906 9.371094 C 3.753906 7.707031 5.109375 6.351562 6.773438 6.351562 C 8.4375 6.351562 9.792969 7.707031 9.792969 9.371094 Z M 9.792969 9.371094 "/>
<path d="M 14.113281 2.78125 C 14.113281 1.25 12.867188 0 11.332031 0 C 9.800781 0 8.550781 1.25 8.550781 2.78125 C 8.550781 4.3125 9.800781 5.5625 11.332031 5.5625 C 12.867188 5.5625 14.113281 4.3125 14.113281 2.78125 Z M 9.515625 2.78125 C 9.515625 1.78125 10.328125 0.96875 11.328125 0.96875 C 12.328125 0.96875 13.140625 1.78125 13.140625 2.78125 C 13.140625 3.78125 12.328125 4.59375 11.328125 4.59375 C 10.328125 4.59375 9.515625 3.78125 9.515625 2.78125 Z M 9.515625 2.78125 "/>

</svg>

      </div>
                      </div>
                      <div class="ml-4">
                        <h5 class="text-lg leading-6 font-medium text-gray-900">Piggy back off successful campaigns</h5>
                        <p class="mb-2 text-base leading-6 text-gray-500">Stop wasting days and months of your staff’s time trying to figure out what works and what doesn’t. Create engaging content that’s been tested in the field.</p>
                      </div>
                    </div>
                  </li>
                  <li class="mt-10">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                          <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                          <path d="M 13.625 17.03125 L 13.625 19.5625 C 13.625 20.085938 13.199219 20.515625 12.675781 20.515625 C 12.398438 20.515625 12.152344 20.398438 11.980469 20.210938 C 11.804688 20.398438 11.558594 20.515625 11.28125 20.515625 C 10.753906 20.515625 10.328125 20.085938 10.328125 19.5625 L 10.332031 17.035156 C 7.929688 17.398438 6.179688 18.539062 6.179688 19.890625 C 6.179688 21.535156 8.777344 22.867188 11.984375 22.867188 C 15.1875 22.867188 17.785156 21.535156 17.785156 19.890625 C 17.785156 18.539062 16.03125 17.398438 13.625 17.03125 Z M 13.625 17.03125 "/>
<path d="M 13.292969 10.71875 L 10.671875 10.71875 L 12 12.105469 Z M 13.292969 10.71875 "/>
<path d="M 7.335938 17.53125 L 7.207031 17.683594 C 8 17.089844 9.195312 16.652344 10.59375 16.46875 L 10.59375 19.582031 C 10.59375 19.910156 10.859375 20.183594 11.191406 20.183594 C 11.523438 20.183594 11.976562 19.914062 11.976562 19.585938 L 11.972656 16.382812 C 11.988281 16.382812 12.003906 16.382812 12.015625 16.382812 L 12.015625 19.589844 L 12.019531 19.59375 C 12.023438 19.917969 12.332031 20.179688 12.65625 20.179688 C 12.988281 20.179688 13.253906 19.914062 13.253906 19.585938 L 13.253906 16.449219 L 12.042969 16.378906 C 12.082031 16.378906 12.121094 16.378906 12.160156 16.378906 C 12.121094 16.378906 12.046875 16.378906 12.027344 16.378906 L 12.015625 16.378906 L 12.015625 14.726562 L 11.976562 14.726562 L 11.976562 16.382812 L 10.597656 16.46875 L 10.597656 12.308594 L 8.03125 9.675781 C 8.03125 9.675781 8.03125 9.671875 8.03125 9.671875 C 7.855469 9.5 7.855469 9.21875 8.03125 9.042969 C 8.203125 8.871094 8.484375 8.871094 8.65625 9.042969 C 8.65625 9.046875 8.660156 9.046875 8.660156 9.046875 L 10.320312 10.71875 L 10.671875 10.71875 L 1.542969 1.171875 L 0 1.132812 L 6.101562 19.625 L 6.121094 19.621094 C 6.101562 19.539062 6.097656 19.457031 6.097656 19.375 C 6.097656 18.679688 6.566406 18.042969 7.335938 17.53125 Z M 7.335938 17.53125 "/>
<path d="M 22.199219 1.171875 L 13.292969 10.71875 L 13.539062 10.71875 L 13.539062 10.722656 L 13.539062 10.71875 L 15.199219 9.046875 C 15.199219 9.046875 15.203125 9.046875 15.203125 9.042969 C 15.378906 8.871094 15.660156 8.871094 15.832031 9.042969 C 16.003906 9.21875 16.003906 9.5 15.832031 9.675781 L 15.828125 9.675781 L 13.253906 12.320312 L 13.253906 16.449219 C 14.71875 16.617188 15.972656 17.066406 16.792969 17.683594 L 16.664062 17.53125 C 17.4375 18.039062 17.902344 18.679688 17.902344 19.375 C 17.902344 19.460938 17.894531 19.542969 17.882812 19.621094 L 17.902344 19.625 L 24 1.132812 Z M 22.199219 1.171875 "/>
<path d="M 11.992188 10.378906 C 12.574219 10.378906 13.042969 9.910156 13.042969 9.328125 C 13.042969 8.746094 12.574219 8.277344 11.992188 8.277344 C 11.414062 8.277344 10.941406 8.742188 10.941406 9.328125 C 10.941406 9.910156 11.414062 10.378906 11.992188 10.378906 Z M 11.992188 10.378906 "/>
                          </svg>
      </div>
                      </div>
                      <div class="ml-4">
                        <h5 class="text-lg leading-6 font-medium text-gray-900">Take Advantage of Video AI</h5>
                        <p class="mb-2 text-base leading-6 text-gray-500">Save time on production, creative approvals, getting your team media trained - and let video AI setup your content strategy in 30 minutes.</p>
                      </div>
                    </div>
                    
                  </li>
                  <li class="mt-10">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                          <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path d="M 11.828125 0.933594 C 8.449219 0.953125 5.125 2.507812 2.960938 5.433594 C -0.3125 9.859375 0.1875 15.902344 3.890625 19.730469 L 2.144531 22.089844 L 9.234375 21.03125 L 8.171875 13.941406 L 6.152344 16.675781 C 4.085938 14.125 3.914062 10.410156 5.957031 7.648438 C 7.394531 5.707031 9.605469 4.671875 11.851562 4.660156 C 12.617188 4.65625 13.386719 4.773438 14.128906 5.011719 L 13.804688 2.828125 C 12.6875 2.601562 11.558594 2.59375 10.476562 2.78125 C 7.699219 3.125 5.132812 4.652344 3.53125 7.058594 C 5.203125 3.96875 8.394531 2.09375 11.78125 2.007812 C 11.859375 2.007812 11.941406 2.003906 12.019531 2.003906 C 12.710938 2.003906 13.414062 2.078125 14.109375 2.234375 L 16.386719 1.894531 C 14.925781 1.242188 13.371094 0.925781 11.828125 0.933594 Z M 21.808594 1.96875 L 14.71875 3.027344 L 15.78125 10.117188 L 17.707031 7.511719 C 19.6875 10.058594 19.820312 13.703125 17.808594 16.421875 C 15.925781 18.96875 12.710938 19.949219 9.832031 19.117188 L 10.136719 21.164062 C 11.484375 21.421875 12.867188 21.367188 14.179688 21.019531 C 15.933594 20.738281 17.617188 19.984375 19.015625 18.78125 C 16.707031 21.34375 13.265625 22.414062 10.027344 21.796875 L 7.410156 22.1875 C 12.054688 24.238281 17.648438 22.878906 20.792969 18.628906 C 24.035156 14.25 23.574219 8.28125 19.976562 4.449219 Z M 21.808594 1.96875 "/></svg>
      </div>
                      </div>
                      <div class="ml-4">
                        <h5 class="text-lg leading-6 font-medium text-gray-900">Outreach Follow Up Integration</h5>
                        <p class="mb-2 text-base leading-6 text-gray-500">Stop burning your lists and have a reason to follow up on investors again and again by integrating content into your outreach.</p>
                      </div>
                    </div>
                    
                  </li>
                </ul>
      </div>
              <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
                <svg class="absolute left-1/2 transform -translate-x-1/2 translate-y-16 lg:hidden" width="784" height="404" fill="none" viewbox="0 0 784 404"><defs><pattern id="e80155a9-dfde-425a-b5ea-1f6fadd20131" x="0" y="0" width="20" height="20" patternunits="userSpaceOnUse"><rect class="text-gray-200" x="0" y="0" width="4" height="4" fill="currentColor"></rect></pattern></defs><rect width="784" height="404" fill="url(#e80155a9-dfde-425a-b5ea-1f6fadd20131)"></rect></svg><img class="relative mx-auto" width="490" src="<?php echo e(asset('images/6-investor-mistakes.jpg')); ?>" alt="">
      </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="py-12 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="lg:text-center">
            <a id="mms"></a><p class="text-base leading-6 text-indigo-600 font-semibold tracking-wide uppercase">WHY USE THE INVESTOR STALK AND CONVERT SYSTEM</p>
            <h3 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl sm:leading-10">How MMS will grow your rent roll on auto pilot.</h3>
            <p class="mt-4 max-w-2xl text-xl leading-7 text-gray-500 lg:mx-auto">Stop competing on price and increase your up-sells, conversion rates and management fee by using the Investor Stalk and Convert system to work your database in the background and bring you leads on auto pilot. </p>
          </div>
          <div class="mt-10">
            <ul class="md:grid md:grid-cols-2 md:col-gap-8 md:row-gap-10">
      <li>
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">Higher Recall</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">The average person gets 200 marketing emails per day but less than 1 marketing SMS per day.</p>
                  </div>
                </div>
              </li>
              <li class="mt-10 md:mt-0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                      <path d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
  <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z" clip-rule="evenodd" />
</svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">Increase Lead Response</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">Every MMS image your investors receive will be automatically personalised just for them to increase click through.</p>
                  </div>
                </div>
              </li>
              <li class="mt-10 md:mt-0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">CTR Engaging Links</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">Every campaign will create a personalised link for each of your recipients - leading to higher engagement and click through.</p>
                  </div>
                  
                </div>
              </li>
              <li class="mt-10 md:mt-0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path d="M 24 0.65625 L 0 0.65625 L 9.144531 10.289062 L 9.144531 23.34375 L 14.855469 20.390625 L 14.855469 10.289062 Z M 24 0.65625 "/></svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">Lead Qualification</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">Track clicks from your MMS campaigns to qualify and prioritise your outbound marketing list for your BDM team.</p>
                  </div>
                  
                </div>
              </li>
              <li class="mt-10 md:mt-0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">Decrease Marketing Expenses</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">While other services charge a minimum of 36c per MMS our service charges $0. This leads to a saving of $2,000 on average per campaign.</p>
                  </div>
                </div>
              </li>
              <li class="mt-10 md:mt-0">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                      <svg class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
  <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
</svg>
      </div>
                  </div>
                  <div class="ml-4">
                    <h4 class="text-lg leading-6 font-medium text-gray-900">Save Time</h4>
                    <p class="mb-2 text-base leading-6 text-gray-500">Save your marketing team months of work by using pre-built ready to go conversion optimised video powered campaigns personalised to your brand.</p>
                  </div>
                  
                </div>
              </li>
            </ul>
      </div>
        </div>
      </div>

      <!-- This example requires Tailwind CSS v2.0+ -->
      <a id="360"></a>
<div class="relative bg-white pt-16 pb-32 overflow-hidden">
  <div class="relative">
    <div class="lg:mx-auto lg:max-w-7xl lg:px-8 lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-24">
      <div class="px-4 max-w-xl mx-auto sm:px-6 lg:py-16 lg:max-w-none lg:mx-0 lg:px-0">
        <div>
          <div>
            <span class="h-12 w-12 rounded-md flex items-center justify-center bg-indigo-600">
              <!-- Heroicon name: outline/inbox -->
              <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path  d="M 12 4.976562 C 5.371094 4.976562 0 12 0 12 C 0 12 5.371094 19.023438 12 19.023438 C 18.628906 19.023438 24 12 24 12 C 24 12 18.628906 4.976562 12 4.976562 Z M 12 16.863281 C 9.3125 16.863281 7.136719 14.6875 7.136719 12 C 7.136719 9.3125 9.3125 7.136719 12 7.136719 C 14.6875 7.136719 16.863281 9.3125 16.863281 12 C 16.863281 14.6875 14.6875 16.863281 12 16.863281 Z M 13.910156 10.089844 C 14.398438 10.578125 14.703125 11.253906 14.703125 12 C 14.703125 13.492188 13.492188 14.703125 12 14.703125 C 10.507812 14.703125 9.296875 13.492188 9.296875 12 C 9.296875 11.253906 9.601562 10.578125 10.089844 10.089844 L 12 12 Z M 13.910156 10.089844 "/>
              </svg>
            </span>
          </div>
          <div class="mt-6">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Don't try to improve what you can't see</h2>
            <p class="mt-4 text-lg text-gray-500">Men lie, women lie. Numbers don't. Corporate level business analytics previously reserved only for public companies have become available to SMBs - no more paying to get reports once a month in messy printouts - have beautiful reports rendered daily/instantenously - and available to your key accountability holders through desktop and mobile. Tie performance to results and build a world class personal net worth growth machine. $5,000 of value available to you for free as a gift for hearing out how I can help you do just that. </p>
            <div class="mt-6">
              <a href="#" class="inline-flex px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700"> Get started </a>
            </div>
          </div> 
        </div>
        <div class="mt-8 border-t border-gray-200 pt-6">
          <blockquote>
            <div>
              <p class="text-base text-gray-500">"If you can't measure it, you can't improve it. Measurement is doing things right- leadership is doing the right things. Peter Drucker said those two things - and yes I just quoted myself quoting someone else."</p>
            </div>
            <footer class="mt-3">
              <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                  <img class="h-6 w-6 rounded-full" src="<?php echo e(asset('images/profile_photo.jpeg')); ?>" alt="">
                </div>
                <div class="text-base font-medium text-gray-700">Kosta Kondratenko, Rent Roll Acceleration Specialist</div>
              </div>
            </footer>
          </blockquote>
        </div>
      </div>
      <div class="mt-12 sm:mt-16 lg:mt-0">
        <div class="pl-4 -mr-48 sm:pl-6 md:-mr-16 lg:px-0 lg:m-0 lg:relative lg:h-full">
          <img class="w-full rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 lg:absolute lg:left-0 lg:h-full lg:w-auto lg:max-w-none" src="<?php echo e(asset('images/360.jpg')); ?>" alt="Inbox user interface">
        </div>
      </div>
    </div>
  </div>
  
</div>

        
      
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-gray-100"><a id="pricing"></a>
  <div class="pt-12 sm:pt-16 lg:pt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl lg:text-5xl">No complicated, messy contracts.</h2>
        <p class="mt-4 text-xl text-gray-600">Straightforward pricing - backed by guarantee</p>
      </div>
    </div>
  </div>
  <div class="mt-8 bg-white pb-16 sm:mt-12 sm:pb-20 lg:pb-28">
    <div class="relative">
      <div class="absolute inset-0 h-1/2 bg-gray-100"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto rounded-lg shadow-lg overflow-hidden lg:max-w-none lg:flex">
          <div class="flex-1 bg-white px-6 py-8 lg:p-12">
            <h3 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">Rent Roll Devour System</h3>
            <p class="mt-6 text-base text-gray-500">Everything you need to position yourself as the No. 1 choice for property managers in your area and fill your team’s pipelines with qualified investors for follow up.
</p>
            <div class="mt-8">
              <div class="flex items-center">
                <h4 class="flex-shrink-0 pr-4 bg-white text-sm tracking-wider font-semibold uppercase text-indigo-600">What's included</h4>
                <div class="flex-1 border-t-2 border-gray-200"></div>
              </div>
              <ul role="list" class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">
                <li class="flex items-start lg:col-span-1">
                  <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <p class="ml-3 text-sm text-gray-700">Winning campaign swipe file</p>
                </li>

                <li class="flex items-start lg:col-span-1">
                  <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <p class="ml-3 text-sm text-gray-700">MMS Domination System</p>
                </li>

                <li class="flex items-start lg:col-span-1">
                  <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <p class="ml-3 text-sm text-gray-700">Video AI Landing Page System.</p>
                </li>

                <li class="flex items-start lg:col-span-1">
                  <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <p class="ml-3 text-sm text-gray-700">2hrs Onboard Training from Creator.</p>
                </li>
              </ul>
            </div>
          </div>
          <div class="py-8 px-6 text-center bg-gray-50 lg:flex-shrink-0 lg:flex lg:flex-col lg:justify-center lg:p-12">
            <p class="text-lg leading-6 font-medium text-gray-900">The only rent roll growth system</p>
            <span class="text-sm leading-6 font-medium text-gray-900">Starting from</span>
            <div class="flex items-center justify-center text-5xl font-extrabold text-gray-900">
              <span> $1399  </span>
              <span class="ml-3 text-xl font-medium text-gray-500"> p/m </span>
            </div>
            <p class="mt-4 text-sm">
              <a href="/pricing" class="font-medium text-gray-500 underline"> View Entire Pricing Model </a>
            </p>
            <div class="mt-6">
              <div class="rounded-md shadow">
                <a href="#signup" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900"> Get Instant Access </a>
              </div>
            </div>
            <div class="mt-4 text-sm">
              <a href="#" class="font-medium text-gray-900">
                Free campaign included.
                <span class="font-normal text-gray-500"> w/ video AI System </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('register-freestyle', [])->html();
} elseif ($_instance->childHasBeenRendered('OK3Dmbz')) {
    $componentId = $_instance->getRenderedChildComponentId('OK3Dmbz');
    $componentTag = $_instance->getRenderedChildComponentTagName('OK3Dmbz');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('OK3Dmbz');
} else {
    $response = \Livewire\Livewire::mount('register-freestyle', []);
    $html = $response->html();
    $_instance->logRenderedChild('OK3Dmbz', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?> 

    
    
      <!-- This example requires Tailwind CSS v2.0+ -->

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

<?php /**PATH /var/www/resources/views/home.blade.php ENDPATH**/ ?>