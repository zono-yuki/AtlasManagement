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
        <!-- 繰り返し -->
        @foreach($hit_id as $hits_id)
        <tr class="text-center">
          <!-- id -->
          <td class="">{{ $hits_id->id }}</td>
          <!-- 名前 -->
          <td class="">{{ $hits_id->over_name }} {{ $hits_id->under_name }}</td>
          <!-- 場所 -->
          <td class="">リモート</td>
        </tr>
        @endforeach


      </table>
    </div>
  </div>
</div>
@endsection
