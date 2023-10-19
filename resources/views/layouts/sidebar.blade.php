<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <!-- <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
  <!-- FontAwesome追加 -->
  <script src="https://kit.fontawesome.com/6931b833d3.js" crossorigin="anonymous"></script>

</head>

<body class="all_content">
  <div class="d-flex height-1">
    <!-- サイドバー （左側の青い部分）-->
    <div class="sidebar">
      @section('sidebar')
      <p class="mt-3"><i class="fa-solid fa-house ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('top.show') }}">マイページ</a></p>
      <p class="mt-3"><i class="fa-solid fa-arrow-right-from-bracket ml-1 mr-2" style="color: #ffffff;"></i><a href="/logout">ログアウト</a></p>
      <p class="mt-3"><i class="fa-regular fa-calendar ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('calendar.general.show',['user_id' => Auth::id()]) }}">スクール予約</a></p>


      <!-- 管理者のみに表示する 教師の時のみ表示する(スクール予約確認、スクール枠登録) -->
      <!-- スクール予約確認 -->
      @if(Auth::user()->role != 4 )
      <p class="mt-3"><i class="fa-regular fa-calendar-check ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('calendar.admin.show',['user_id' => Auth::id()]) }}">スクール予約確認</a></p>
      <!--スクール枠登録-->
      <p class="mt-3"><i class="fa-regular fa-calendar ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('calendar.admin.setting',['user_id' => Auth::id()]) }}">スクール枠登録</a></p>
      @endif



      <!-- 掲示板へ -->
      <p class="mt-3"><i class="fa-solid fa-message ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('post.show') }}">掲示板</a></p>

      <!-- ユーザー検索へ -->
      <p class="mt-3"><i class="fa-solid fa-user-group ml-1 mr-2" style="color: #ffffff;"></i><a href="{{ route('user.show') }}">ユーザー検索</a></p>

      @show


    </div>

    <div class="main-container">

      <!-- マイページを表示する-->
      @yield('content')

    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
  </script>
  <script src = "{{ asset('js/register.js') }}" rel = "stylesheet" ></script>
  <script src="{{ asset('js/bulletin.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/user_search.js') }}" rel="stylesheet"></script>
  <script src="{{ asset('js/calendar.js') }}" rel="stylesheet"></script>
</body>

</html>
