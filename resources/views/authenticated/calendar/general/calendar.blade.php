@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class=" w-75 calendar-margin pt-5 pb-3" style="border-radius:5px; background:#FFF;">
    <div class="calendar-box m-auto pb-2" style="border-radius:5px;">

      <p class="text-center calendar-margin2 pb-2">{{ $calendar->getTitle() }}</p>
      <div class="calendar-center">
        <!-- CalendarView.phpで処理した結果が入る。 -->
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary calendar-btn" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection
