@extends('layouts.sidebar')
<!-- 予約詳細画面 -->
@section('content')
<div class="vh-100 d-flex text-muted" style="align-items:center; justify-content:center;">

  <!-- 2023年⚪︎月⚪︎日⚪︎部も含めた範囲 -->
  <div class="w-50 m-auto h-75">
    <p class="mb-2">{{  $date  }}<span class="ml-3">{{ $part }}部</span></p>
    <div class="border-a p-1">
      <table class="w-100">
        <tr class="border-b">
          <th class="id_font">ID</th>
          <th class="name_font">名前</th>
          <th class="place_font">場所</th>
        </tr>
        <!-- 繰り返し -->
        @foreach($hit_id as $hits_id)
        <tr class="tr2 text-center tr-1">
          <!-- id -->
          <td class="tr-2">{{ $hits_id->id }}</td>
          <!-- 名前 -->
          <td class="tr-2">{{ $hits_id->over_name }} {{ $hits_id->under_name }}</td>
          <!-- 場所 -->
          <td class="tr-2">リモート</td>
        </tr>
        @endforeach


      </table>
    </div>
  </div>
</div>
@endsection
