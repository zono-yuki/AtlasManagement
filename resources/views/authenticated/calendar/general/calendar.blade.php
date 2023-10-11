@extends('layouts.sidebar')

<!-- スクール生、講師用のスクール予約画面の表示 -->
@section('content')
<div class="calendar-body vh-100" style="background:#ECF1F6;">
  <div class="calendar-margin shadow" style="border-radius:5px; background:#FFF;">
    <div class="calendar-box m-auto pb-2" style="border-radius:5px;">

      <p class="text-center calendar-margin2 pb-2">{{ $calendar->getTitle() }}</p>
      <div class="calendar-center">
        <!-- CalendarView.phpで処理した結果が入る。 -->
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right  m-auto">
      <!-- 予約するボタン -->
      <input type="submit" class="btn btn-primary calendar-btn" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
@endsection
