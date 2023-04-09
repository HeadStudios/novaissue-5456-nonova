@php
use App\Hydraulics\Course\CourseStatus;
@endphp
@extends('lms.lms-tech')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<style>
  canvas { width:30px; }
  </style>
@endsection

@section('title', 'My Team')

@section('main')

@if ($user->teams->count())
    @if ($user->teams->first()->members->count())
    <div class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
        @foreach ($user->teams->first()->members as $member)
        <div class="sm:rounded-bl-lg relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
    <div>
      <span class="rounded-lg inline-flex p-3 bg-rose-50 text-rose-700 ring-4 ring-white">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
        </svg>
      </span>
    </div>
    <div class="mt-8">
      <h3 class="text-lg font-medium">
        <!--<a href="/lms/status/{{ $member->id }}" class="focus:outline-none">-->
          
          {{ $member->name}}
        <!--</a>-->
      </h3>
      <p class="mt-2 text-sm text-gray-500">Status: @if ($member->doneAndDusted()) ON POINT @else OFF THE PATH @endif</p>
      <p class="mt-2 text-sm text-gray-500"></p>
      <div>
      <canvas id="chrt_{{ $member->id }}"></canvas>
      </div>
    </div>
    <span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400" aria-hidden="true">
      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"></path>
      </svg>
    </span>
  </div>
        @endforeach
</div>
    @else
        <p>The team has no members.</p>
    @endif
@else
    <p>The user is not attached to any teams.</p>
@endif

          <!-- /End replace -->
@endsection

@section('scripts')

<script>

@foreach ($user->teams->first()->members as $member)
@php
$cs = new CourseStatus();
@endphp
{!! $cs->generateJSChartCode($member) !!}
@endforeach

</script>

@endsection