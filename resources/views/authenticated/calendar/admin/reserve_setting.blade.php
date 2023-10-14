@extends('layouts.sidebar')
@section('content')
<!-- 講師用【スクール枠登録】画面 -->
<div class="w-75 m-auto">
  <div class="w-100 calendar_area2 shadow">
    <!-- タイトル(2023年⚪︎月)を表示する -->
    <p class="text-center text-muted" style="font-size: 20px;">{{ $calendar->getTitle() }}</p>

    <!-- カレンダーを表示する -->
    {!! $calendar->render() !!}

    <!-- 登録ボタン -->
    <div class="text-right mt-4">
      <!-- もともとのコード -->
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">

      <!-- フォームで送る 作成----->
      {{--<a href="/setting/{{ Auth::user() ->id }}/admin">
      <input type="submit" class="btn btn-primary" value="登録" onclick="return confirm('登録してよろしいですか？')">
      </a>--}}
    </div>
  </div>
</div>
@endsection
