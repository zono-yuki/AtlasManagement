@extends('layouts.sidebar')

<!--講師用のスクール予約画面の表示 -->
@section('content')
<div class="w-75 m-auto">
  <div class="w-100 calendar_area shadow">
    <!-- タイトル(2023年⚪︎月)を表示する -->
    <p class="text-center">{{ $calendar->getTitle() }}</p>

    <!-- カレンダーを表示する -->
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection
