@extends('layouts.sidebar')

@section('content')
<div class="vh-100 text-muted">
  <div class="ml-3 mt-3">
    <span class="text-muted">{{ $user->over_name }}</span><span class="text-muted">{{ $user->under_name }}さんのプロフィール</span>
  </div>
  <div class="top_area w-75 m-auto pt-5 text-muted">
    <div class="user_status p-3 shadow">
      <p class="text-muted">名前 :
        <span class="text-muted">{{ $user->over_name }}</span>
        <span class="ml-1 text-muted">{{ $user->under_name }}</span>
      </p>
      <p class="text-muted">カナ :
        <span class="text-muted">{{ $user->over_name_kana }}</span>
        <span class="ml-1 text-muted">{{ $user->under_name_kana }}</span>
      </p>
      <p>性別 :
        @if($user->sex == 1)
        <span class="text-muted">男</span>
        @else
        <span class="text-muted">女</span>
        @endif
      </p>

      <p>生年月日 :
        <span class="text-muted">{{ $user->birth_day }}</span>
      </p>

      <div>選択科目 :
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
      </div>

      <div class="">
        <!-- 講師だけが全員の選択科目を登録できる。 -->
        @can('admin')
        <div class="subject_edit_btn">
          <span>選択科目の登録</span>
          <span class="arrow-subjects"></span>
        </div>

        <div class="subject_inner mt-3">
          <form action="{{ route('user.edit') }}" method="post">
            @foreach($subject_lists as $subject_list)
            <div class="profile-subjects_box mr-2">
              <label>{{ $subject_list->subject }}</label>
              <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
            </div>
            @endforeach

            <input type="submit" value="登録" class="btn btn-primary">
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            {{ csrf_field() }}
          </form>
        </div>
        @endcan
      </div>
    </div>
  </div>
</div>

@endsection
