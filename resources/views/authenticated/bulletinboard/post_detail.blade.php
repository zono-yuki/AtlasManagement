@extends('layouts.sidebar')
@section('content')

<!-----------------------------投稿詳細画面-------------------------------------------->

<div class="vh-100 d-flex">

  <!-- 左半分。投稿内容、名前や、コメント表示 -->
  <div class="w-50 mt-5">
    <div class="m-3 ml-4 p-2 detail_container">
      <!-----------------------左半分------------------------------------------------------------->
      <div class="p-3">

        <div class="detail_inner_head">

          <div>
          </div>
          <!----------------------------------------------------------------------------------->
          <!-- 編集ボタンと削除ボタン （自分の投稿にのみ表示）-->
          @if($post->user_id === Auth::user()->id )
          <div>

            <!-- 編集を押したら、JSに中身のvalueが渡される。（モーダルに既存のタイトルと投稿を表示させるため） -->
            <span class="edit-modal-open btn btn-primary" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">
              編集
            </span>

            <!-- 削除ボタン -->
            <a class="btn btn-danger" href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('削除してもよろしいですか？')">
              削除
            </a>

          </div>
          @endif
        </div>

        <!------------------------------------------------------------------------------------>

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

        <!------------------------------------------------------------------------------------>
        <!-- タイトルの表示 -->
        <!-- バリデーションメッセージを表示 -->
        @if ($errors->has('post_title'))
        @foreach($errors->get('post_title') as $message)
        <p class="error-message"> {{ $message }} </p>
        @endforeach
        @endif

        <div class="detsail_post_title">{{ $post->post_title }}</div>

        <!------------------------------------------------------------------------------------>

        <!-- 投稿内容の表示 -->
        <!-- バリデーションメッセージを表示 -->
        @if ($errors->has('post_body'))
        @foreach($errors->get('post_body') as $message)
        <p class="error-message"> {{ $message }} </p>
        @endforeach
        @endif

        <div class="mt-3 detsail_post">{{ $post->post }}</div>

      </div>

      <!----------------------------------------------------------------------------->

      <!-- コメント一覧の表示 -->

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


  <!------------------------------右半分----------------------------------------------->


  <!--コメントフォーム -->
  <div class="w-50 p-3">
    <div class="comment_container border m-5">

      <div class="comment_area p-3">

        <!-- コメントのバリデーションメッセージを表示 -->
        @if ($errors->has('comment'))
        @foreach($errors->get('comment') as $message)
        <p class="error-message"> {{ $message }} </p>
        @endforeach
        @endif

        <p class="m-0">コメントする</p>

        <!-- コメント入力欄 form="commentRequest"で関連づける。-->
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>

        <!-- コメント登録にidが必要、隠し表示 form="commentRequest"で関連づける。valueには、この投稿のidをつける-->
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">

        <!-- 投稿ボタン -->
        <div class="comment_btn">
          <input type="submit" class="btn btn-primary btn-lg" form="commentRequest" value="投稿">
        </div>

        <!-- コメントを投稿する処理に飛ばす (id="commentRequestで、関連づけたcommentやpost_idを飛ばす。)" -->
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>

      </div>

    </div>
  </div>
</div>



<!--編集モーダル-->

<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">

    <!-- 投稿を編集する処理へ飛ばす -->
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">

        <!-- タイトル  -->
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>

        <!-- 投稿内容 -->
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>

        <div class="w-50 m-auto edit-modal-btn d-flex">

          <!-- 閉じるボタン -->
          <a class="js-modal-close btn btn-danger btn-lg d-block" href="">閉じる</a>

          <!-- 投稿のidを受け取る -->
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">

          <!-- 編集ボタン -->
          <input type="submit" class="btn btn-primary btn-lg d-block"  value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
