@extends('layouts.sidebar')
<!-- 投稿一覧画面の表示 -->
@section('content')
<div class="board_area w-100  d-flex">
  <div class="post_view  mt-5">



    @foreach($posts as $post)
    <div class="post_area  m-posts  border-bottom">

      <!-- 名前の表示 -->
      <p class="name-color"><span class="name-color">{{ $post->user->over_name }}</span><span class="ml-3 name-color">{{ $post->user->under_name }}</span>さん</p>

      <!-- タイトルの表示 -->
      <!-- クリックしたら投稿詳細画面へ遷移する (投稿idを送る)-->
      <p class="post-title">
        <a class="post-title" href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a>
      </p>

      <!-- コメントといいねの表示 -->
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">

          <!-- コメントの表示 -->
          <div class="mr-5">
            <!-- アイコンの表示 -->
            <i class="fa-solid fa-comment" style="color: #adb3bd;"></i>
            <!-- コメント数の表示 -->
            <span class="">{{ $post->commentCounts($post->id) }}</span>
          </div>

          <!-- いいねボタンの表示 -->
          <div class="mr-2">
            @if(Auth::user()->is_Like($post->id))
            <!-- もしログインユーザーがこの投稿をイイネしていた場合は、-->
            <p class="m-0">
              <!-- ハート 赤 -->
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
              <!-- <i class="fa-solid fa-heart un_like_btn" style="color: #ff0033;" post_id="{{ $post->id }}"></i> -->
              <!-- カウント -->
              <span class="like_counts{{ $post->id }}">
                {{ $like->likeCounts($post->id)  }}
              </span>
            </p>

            @else
            <!-- いいねしていなかった場合-->
            <p class="m-0">
              <!-- ハート 黒 -->
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
              <!-- <i class="fa-regular fa-heart like_btn" style="color: #caced3;" post_id="{{ $post->id }}"></i> -->
              <!-- カウント -->
              <span class="like_counts{{ $post->id }}">
                {{ $like->likeCounts($post->id)  }}
              </span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area">
    <div class="search-area">
      <!-- 投稿をクリックすると、新規投稿画面に遷移する-->

      <!-- 投稿ボタン -->
      <a class="post-color" href="{{ route('post.input') }}">
        <button type="submit" class="post_btn">投稿</button>
      </a>
      <!--------------------------------------------------------------------------------------------------- -->
      <!-- 検索-->
      <div class="search-box">
        <input type="text" class="searcher-text pt-2 pb-2 pl-1" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="searcher_btn" value="検索" form="postSearchRequest">
      </div>

      <!------------------------------------------------------------------------------------------------------>

      <!-- いいねした投稿、自分の投稿-->
      <div class="like_post_btn">
        <!-- いいねした投稿 ここからボタンつくっていくbootstrap使わない。-->
        <input type="submit" name="like_posts" class="search_like_btn_good mr-1" value="いいねした投稿" form="postSearchRequest">
        <!-- 自分の投稿 -->
        <input type="submit" name="my_posts" class="search_like_btn_myself" value="自分の投稿" form="postSearchRequest">
      </div>

      <!-- カテゴリー検索--------------------------------------------------------------------------------------->
      <p class="mt-4 text-muted">カテゴリー検索</p>
      <ul class="text-muted">
        <!-- メインカテゴリの表示 -->
        @foreach($categories as $category)
        <li class="main_categories main_conditions mb-3" category_id="{{ $category->id }}">
          <span>{{ $category->main_category }}<span>
        </li>
        <!-- メインカテゴリを押すと、サブカテゴリーが表示される。-->
        <div class="main_conditions_inner">

        </div>
        @endforeach
      </ul>

    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
