@extends('layouts.sidebar')
@section('content')
<!-- 講師用【スクール枠登録】画面 -->
<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-100 vh-100 border p-5">
    {!! $calendar->render() !!}
    <div class="adjust-table-btn m-auto text-right">

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
