@extends('layouts.sidebar')
<!-- 投稿画面--------------------------------------------------------------- -->
@section('content')
<div class="post_create_container d-flex text-muted">
  <div class="post_create_area  border-0 w-50 m-5 p-5">
    <div class="">

      <p class="mb-0">カテゴリー</p>

      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
          <!--メインカテゴリーごとにグループ化する メインカテゴリーは灰色で表示される。-->
          <optgroup label="{{ $main_category->main_category }}">
            @foreach($main_category -> subCategories as $subcategory)
              <option value="{{ $subcategory-> id}}"> {{ $subcategory-> sub_category }}</option>
            @endforeach
          </optgroup>
        @endforeach
      </select>

    </div>

    <div class="mt-3">

      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>

    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif

      <p class="mb-0">投稿内容</p>

      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>

    </div>

    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>

    <!-- 投稿ボタン -->
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>

  </div>

  <!-------------------------------------------------------------------------------------------------- -->

  <!-- 講師アカウントのみに表示する -->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <!-- メインカテゴリーのエラーメッセージを表示する -->
      @if ($errors->has('main_category_name'))
        @foreach($errors->get('main_category_name') as $message)
          <p class="error-message"> {{ $message }} </p>
        @endforeach
      @endif


      <div class="">
        <p class="m-0">メインカテゴリー</p>
          <!-- 入力（メインカテゴリー） -->
        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
          <!-- 追加ボタン -->
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-3" form="mainCategoryRequest">
      </div>
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>



      <div class="mt-5">

        <!-- サブカテゴリーのエラーメッセージを表示する -->
        @if ($errors->has('main_category_id'))
          @foreach($errors->get('main_category_id') as $message)
            <p class="error-message"> {{ $message }} </p>
          @endforeach
        @endif

        @if ($errors->has('sub_category_name'))
          @foreach($errors->get('sub_category_name') as $message)
            <p class="error-message"> {{ $message }} </p>
          @endforeach
        @endif

        <p class="mb-0">サブカテゴリー</p>

        <!--メインカテゴリーの選択-->
        <select name="main_category_id" class="mt-1 w-100 pt-1 pb-1" form="subCategoryRequest">
          <option value="">---</option>
          @foreach($main_categories as $main_category)
          <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
          @endforeach
        </select>

        <!-- サブカテゴリーの入力 -->
        <input type="text" class="w-100 mt-3" name="sub_category_name" form="subCategoryRequest">

        <!-- 追加ボタン 点火-->
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-3" form="subCategoryRequest">

        <!-- サブカテゴリーの作成に進む -->
        <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">
          {{ csrf_field() }}
        </form>
      </div>

    </div>
  </div>
  @endcan
</div>
@endsection
