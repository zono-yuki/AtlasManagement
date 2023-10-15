@extends('layouts.sidebar')

@section('content')
<!-- ーーーーーーーーーーーーーーーーーーーーーー表示ーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
<div class="search_content">
  <div class="reserve_users_area p-3">
    @foreach($users as $user)
    <div class="shadow one_person ">
      <div class="mb-2">
        <span class="text-muted">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div class="mb-1"><span class="text-muted">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div class="mb-1">
        <span class="text-muted">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div class="mb-1">
        @if($user->sex == 1)
        <span class="text-muted">性別 : </span><span>男</span>
        @endif

        @if($user->sex == 2)
        <span class="text-muted">性別 : </span><span>女</span>
        @endif

        @if($user->sex == 3)
        <span class="text-muted">性別 : </span><span>その他</span>
        @endif
      </div>

      <div class="mb-1">
        <span class="text-muted">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div class="mb-1">
        @if($user->role == 1)
        <span class="text-muted">権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span class="text-muted">権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span class="text-muted">権限 : </span><span>講師(英語)</span>
        @else
        <span class="text-muted">権限 : </span><span>生徒</span>
        @endif
      </div>
      <!-- ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
      <div>
        @if($user->role == 4)
        <!-- if文 1の時国語、2の時数学、3の時英語 -->
        <span class="text-muted">選択科目:</span>
        @foreach($user->subjects as $subject )
        @if($subject->id == 1)
        <span>国語</span>
        @endif

        @if($subject->id == 2)
        <span>数学</span>
        @endif

        @if($subject->id == 3)
        <span>英語</span>
        @endif
        @endforeach


        @endif
      </div>
      <!-- ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
    </div>
    @endforeach
  </div>

  <!-- ---------------------------------------検索---------------------------------------- -->
  <div class="search_area">
    <div class="search_box">
      <p class="search-font mb-1">検索</p>
      <div class="mb-2">
        <!-- keyword -->
        <input type="text" class="free_word mb-2 w-100 pt-3 pr-2 pb-3 pl-3" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <p class="mb-1 text-muted">カテゴリ</p>

        <!-- category -->
        <select class="name_id_word text-muted mt-1 mb-3 pt-2 pr-3 pl-3 pb-2" form="userSearchRequest" name="category">
          <option class="" value="name">名前</option>
          <option class="" value="id">社員ID</option>
        </select>

      </div>
      <div>
        <!-- updown -->
        <p class="mb-0 text-muted">並び替え</p>
        <select class="name_id_word text-muted mt-1 mb-3 pt-2 pr-4 pl-3 pb-2" name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_user_box pl-3 mb-5">
        <p class="mb-3 search_conditions arrow-0">
          <span class="text-muted">検索条件の追加</span>
          <span class="arrow"></span>
        </p>
        <div class="search_conditions_inner">
          <div class="mb-3">
            <!-- sex -->
            <label class="mt-1 mb-1 text-muted">性別</label>
            <div>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
              <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
            </div>
          </div>

          <div class="mb-4">
            <!-- role -->
            <label class="text-muted">権限</label>
            <div class="mt-0 mb-3">
              <select name="role" form="userSearchRequest" class="engineer pt-2 pb-2 pr-2 pl-2">
                <option selected disabled>----</option>
                <option value="1">教師(国語)</option>
                <option value="2">教師(数学)</option>
                <option value="3">教師(英語)</option>
                <option value="4" class="">生徒</option>
              </select>
            </div>
          </div>

          <div class="selected_engineer">
            <!-- 選択科目 name="subjects[]"を追加する! -->
            <label class="mb-1 text-muted">選択科目</label>
            <div class="mb-0">
              <span>国語</span><input type="checkbox" name="subjects[]" value="1" form="userSearchRequest" class="mr-2">
              <span>数学</span><input type="checkbox" name="subjects[]" value="2" form="userSearchRequest" class="mr-2">
              <span>英語</span><input type="checkbox" name="subjects[]" value="3" form="userSearchRequest" class="mr-2">
            </div>
          </div>
        </div>
      </div>

      <div class="mt-3 mb-4">
        <!-- 検索ボタン submitで全部送る-->
        <input class="search__button" type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>

      <div class="text-center">
        <!-- リセットボタン -->
        <input class="btn-reset" type="reset" value="リセット" form="userSearchRequest">
      </div>



    </div>
    <!-- ここで送る。Usersコントローラーで$requestで受け取る form="userSearchRequest"がついているものを全て送信する。 -->
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
