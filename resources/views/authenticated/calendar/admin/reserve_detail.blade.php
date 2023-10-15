@extends('layouts.sidebar')
<!-- 予約詳細画面 -->
@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <table class="w-100">
        <tr class="border-b">
          <th class="id_font">ID</th>
          <th class="name_font">名前</th>
          <th class="place_font">場所</th>
        </tr>
        <tr class="text-center">
          <td class=""></td>
          <td class=""></td>
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection
