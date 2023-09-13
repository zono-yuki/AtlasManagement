@extends('layouts.sidebar')
@section('content')

<!-- 投稿詳細画面 -->

<div class="vh-100 d-flex">

  <!-- 左半分。投稿内容、名前や、コメント表示 -->
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">
      <div class="p-3">
        <div class="detail_inner_head">
          <div>
          </div>
          <!-- 編集ボタンと削除ボタン -->
          <div>
            <span class="edit-modal-open" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
            <a href="{{ route('post.delete', ['id' => $post->id]) }}">削除</a>
          </div>
        </div>

        <div class="contributor d-flex">
          <!--  名前の表示-->
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <!-- 投稿時間の表示 -->
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>

        <!-- タイトルの表示 -->
        <div class="detsail_post_title">{{ $post->post_title }}</div>

        <!-- 投稿内容の表示 -->
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
      </div>


      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>

          @foreach($post->postComments as $comment)
          <!-- Post.phpのpostCommentsメソッドを使う。コントローラーで、userテーブルとpostCommentsテーブルで一致した'postsテーブル'のレコード（投稿$post）が送られてくるので、'その投稿に紐づくコメント'をある分だけ表示する。Post.phpのpostCommentsメソッドで、postCommentsテーブルと繋がっている。-->
          <div class="comment_area border-top">
            <p>

              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <!-- PostComment.phpのcommentUserメソッドで、そのコメントをしたユーザーを探して一致したusersテーブルのレコードをとってくる。そのover_nameを表示する -->

              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
              <!-- 同じようにとってきて、under_nameを表示する-->

            </p>
            <p>{{ $comment->comment }}</p>
            <!-- post_commentsテーブルのcommentカラムを表示する -->
          </div>

          @endforeach
        </div>
      </div>
    </div>
  </div>


  <!-- 右半分のコメントフォーム -->
  <div class="w-50 p-3">
    <div class="comment_container border m-5">

      <div class="comment_area p-3">

        <p class="m-0">コメントする</p>

        <!-- コメント入力欄 form="commentRequest"で関連づける。-->
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>

        <!-- 隠し表示 form="commentRequest"で関連づける。valueには、この投稿のidをつける-->
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">

        <!-- 投稿ボタン -->
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">

        <!-- コメントを投稿する処理に飛ばす (id="commentRequestで、関連づけたcommentやpost_idを飛ばす。)" -->
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>

      </div>

    </div>
  </div>
</div>



<!--編集モーダルここから明日やる-->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
