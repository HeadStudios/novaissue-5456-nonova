

<nav class="mt-5 px-2 space-y-1">
    

<!-- Current: "bg-indigo-800 text-white", Default: "text-white hover:bg-indigo-600 hover:bg-opacity-75" -->
@foreach($menu as $item)
<a href="{{ route($item['permalink']) }}" class="@if(isset($item['status']) && $item['status']==true) bg-indigo-800 text-white group flex items-center px-2 py-2 text-base font-medium rounded-md @else text-white hover:bg-indigo-600 hover:bg-opacity-75 group flex items-center px-2 py-2 text-base font-medium rounded-md @endif">
  <!-- Heroicon name: outline/users -->
  <svg class=" mr-4 flex-shrink-0 h-6 w-6 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['svg'] }}" />
  </svg>
  {{ $item['name'] }}
</a>
@endforeach


</nav>