@extends('lms.lms-tech')

@section('title', 'Tasks')

@section('main')
<div class="py-4">
            <!--<div class="border-4 border-dashed border-gray-200 rounded-lg h-96"></div>-->



<!-- This example requires Tailwind CSS v2.0+ -->















@foreach($checkgroup as $group)
<div class="pb-5 border-b border-gray-200 pt-10">
  <div class="sm:flex sm:justify-between sm:items-baseline">
    <div class="sm:w-0 sm:flex-1">
      <h1 id="message-heading" class="text-lg font-medium text-gray-900">{{$group->name }}</h1>
      <p class="mt-1 text-sm text-gray-500 truncate">{{$group->description }}</p>
    </div>

    <div class="mt-4 flex items-center justify-between sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
    <span class="hidden sm:block ml-3 mr-3">
      <a href="/printer/{{ $user->id }}" target="_blank" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <!-- Heroicon name: solid/link -->
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
        </svg>
        Print
      </a>
    </span>
      <span id="status" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800"> Open </span>
      <div class="ml-3 relative inline-block text-left">
        
        <div>
          <button type="button" class="-my-2 p-2 rounded-full bg-white flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
          <span class="sr-only">Open options</span>
            <!-- Heroicon name: solid/dots-vertical -->
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
          </button>
        </div>

        <!--
          Dropdown menu, show/hide based on menu state.

          Entering: "transition ease-out duration-100"
            From: "transform opacity-0 scale-95"
            To: "transform opacity-100 scale-100"
          Leaving: "transition ease-in duration-75"
            From: "transform opacity-100 scale-100"
            To: "transform opacity-0 scale-95"
        -->
        
      </div>
    </div>
  </div>
</div>

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Training</th>
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody id="tbody-{{$group->id}}" class="bg-white divide-y divide-gray-200">
          @foreach ($user->getChecklistForUserFromCourse($group->id) as $task)
            <tr id="row-{{ $task->id }}" >
    
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
      
                  <div class="flex-shrink-0 h-10 w-10">
                    <img class="h-10 w-10 rounded-full" src="{{ asset('images/lms/avatar_default.png') }}" alt="">
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ $task->name }}</div>
                <div class="text-sm text-gray-500">{{ $task->description }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span aria-num="{{ $task->id }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> @if ($task->users()->first()->pivot->approved == 1) Completed @elseif ($task->users()->first()->pivot->status == 1) Submitted @else Open @endif </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><a href="{{ $task->getVlessonURL($task->id) }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Watch Video</a></td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <input class="checkboxer"  aria-group="{{$group->id}}" name="{{ $task->id }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" @if ($task->users()->first()->pivot->status == 1) checked @endif @if ($task->approved == 1) disabled @endif>
              </td>
            </tr>
            @endforeach

            <!-- More people... -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endforeach





          </div>
@endsection

@section('scripts')

@endsection