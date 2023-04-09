<?php
if(isset($_GET['logout'])) { Auth::logout(); }
?>
<!DOCTYPE html>
<html lang="en"  class="scroll-smooth">
<head>
@livewireScripts
<x-headstuff/>
<script type="module" src="node_modules/@headlessui/dist/index.cjs"></script>
    <title>Rent Roll Devour System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link rel="stylesheet" href="https://rsms.me/inter/inter.css">-->
    @vite(['resources/css/app.css'])
    @livewireStyles
    <link rel="icon" type="image/png" sizes="32x32" href="shuffle-for-tailwind.png">
    <style>
      @media(min-width: 768px) {
      .width-200 {
        background-color:white;
        width:200%;
      } }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    
@include('header')

    <!-- quick deply for one small step for man - brush yourself off and try again -->    
      <div class="relative bg-white overflow-hidden">
        <div class="max-w-screen-xl mx-auto">
          <div class="">
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