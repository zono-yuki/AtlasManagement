@extends('layouts.sidebar')
<!-- 投稿一覧画面の表示 -->
@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>


    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">

      <!-- 名前の表示 -->
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>

      <!-- タイトルの表示 -->
      <!-- クリックしたら投稿詳細画面へ遷移する (投稿idを送る)-->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>

      <!-- コメントといいねの表示 -->
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">

          <!-- コメントの表示 -->
          <div class="mr-5">
            <!-- アイコンの表示 -->
            <i class="fa fa-comment"></i>
            <!-- コメント数の表示 -->
            <!-- 作成中 -->
            <span class="">{{ $post->commentCounts($post->id) }}</span>
          </div>

          <!-- いいねボタンの表示 -->
          <div>
            @if(Auth::user()->is_Like($post->id))
            <!-- もしログインユーザーがこの投稿をイイネしていた場合は、-->
            <p class="m-0">
              <!-- ハート 赤 -->
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
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
  <div class="other_area border w-25">
    <div class="border m-4">

      <!-- 投稿をクリックすると、新規投稿画面に遷移する-->
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>

      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>

      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
