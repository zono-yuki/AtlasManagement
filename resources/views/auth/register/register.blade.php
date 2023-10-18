<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AtlasBulletinBoard</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&family=Oswald:wght@200&display=swap" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>

  <form action="{{ route('registerPost') }}" method="POST">
    <div class="w-120 vh-100 d-flex all_content" style="align-items:center; justify-content:center;">
      <div class="w-30 vh-60 shadow pt-5 pr-5 pb-4 pl-5 background-white radius_box">
        <!-- ----------------------------------------------------------------------------- -->

        <!--名前（漢字）のエラーメッセージを表示する-->
        @if ($errors->has('over_name'))
        @foreach($errors->get('over_name') as $message)
        <p class="error-message"> {{ $message }} </p>
        @endforeach
        @endif

        @if ($errors->has('under_name'))
        @foreach($errors->get('under_name') as $message)
        <p class="error-message"> {{ $message }} </p>
        @endforeach
        @endif

        <div class="register_form">

          <!-- 姓 名 -->
          <div class="d-flex mt-3" style="justify-content:space-between;">

            <!-- 姓 -->
            <div class="" style="width:180px">
              <label class="d-block m-0" style="font-size:15px">姓</label>
              <div class="border-bottom border-primary" style="width:150px;">
                <input type="text" style="width:140px;" class="border-0 over_name" name="over_name">
              </div>
            </div>

            <!-- 名 -->
            <div class="" style="width:180px">
              <label class=" d-block m-0" style="font-size:15px">名</label>
              <div class="border-bottom border-primary" style="width:150px;">
                <input type="text" style="width:140px;" class="border-0 under_name" name="under_name">
              </div>
            </div>
          </div>

          <!-------------------------------------------------------------------------------- -->

          <!--名前（フリガナ）のエラーメッセージを表示する-->
          @if ($errors->has('over_name_kana'))
          @foreach($errors->get('over_name_kana') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif

          @if ($errors->has('under_name_kana'))
          @foreach($errors->get('under_name_kana') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif


          <div class="register_form">

            <!--  セイ,メイ-->
            <div class="d-flex mt-3" style="justify-content:space-between">

              <!-- セイ -->
              <div class="" style="width:180px">
                <label class="d-block m-0" style="font-size:15px">セイ</label>
                <div class="border-bottom border-primary" style="width:150px;">
                  <input type="text" style="width:140px;" class="border-0 over_name_kana" name="over_name_kana">
                </div>
              </div>

              <!-- メイ -->
              <div class="" style="width:180px">
                <label class="d-block m-0" style="font-size:15px">メイ</label>
                <div class="border-bottom border-primary" style="width:150px;">
                  <input type="text" style="width:140px;" class="border-0 under_name_kana" name="under_name_kana">
                </div>
              </div>
            </div>


            <!--mail_addressのエラーメッセージを表示する-->
            @if ($errors->has('mail_address'))
            @foreach($errors->get('mail_address') as $message)
            <p class="error-message"> {{ $message }} </p>
            @endforeach
            @endif

            <!-- メールアドレス -->
            <div class="mt-3">
              <label class="m-0 d-block" style="font-size:15px">メールアドレス</label>
              <div class="border-bottom  border-primary border-2">
                <input type="mail" class="w-100  border-0 mail_address" name="mail_address">
              </div>
            </div>

          </div>

          <!-- ------------------------------------------------------------------------------- -->

          <!--性別のエラーメッセージを表示する-->
          @if ($errors->has('sex'))
          @foreach($errors->get('sex') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif
          <!-- 性別 -->
          <div class="mt-4 sex-flex">

            <div class="sex-box">
              <input type="radio" name="sex" class="sex" value="1">
              <label class="ml-1" style="font-size:13px">男性</label>
            </div>

            <div class="sex-box">
              <input type="radio" name="sex" class="sex" value="2">
              <label class="ml-1" style="font-size:13px">女性</label>
            </div>

            <div class="sex-box">
              <input type="radio" name="sex" class="sex" value="3">
              <label class="ml-1" style="font-size:13px">その他</label>
            </div>
          </div>

          <!-- ------------------------------------------------------------------------------- -->


          <!--生年月日のエラーメッセージを表示する-->
          @if ($errors->has('datetime_validation'))
          @foreach($errors->get('datetime_validation') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif



          <!-- 生年月日 -->
          <div class="mt-3">

            <label class="d-block m-0 aa" style="font-size:13px">生年月日</label>


            <!-- 年 -->
            <select class="old_year" name="old_year" style="border: none; width:25%; border-bottom: 1px solid #6fa9ff;">
              <option value="none">-----</option>
              <option value="1985">1985</option>
              <option value="1986">1986</option>
              <option value="1987">1987</option>
              <option value="1988">1988</option>
              <option value="1989">1989</option>
              <option value="1990">1990</option>
              <option value="1991">1991</option>
              <option value="1992">1992</option>
              <option value="1993">1993</option>
              <option value="1994">1994</option>
              <option value="1995">1995</option>
              <option value="1996">1996</option>
              <option value="1997">1997</option>
              <option value="1998">1998</option>
              <option value="1999">1999</option>
              <option value="2000">2000</option>
              <option value="2001">2001</option>
              <option value="2002">2002</option>
              <option value="2003">2003</option>
              <option value="2004">2004</option>
              <option value="2005">2005</option>
              <option value="2006">2006</option>
              <option value="2007">2007</option>
              <option value="2008">2008</option>
              <option value="2009">2009</option>
              <option value="2010">2010</option>
              <option value="2011">2011</option>
              <option value="2012">2012</option>
              <option value="2013">2013</option>
              <option value="2014">2014</option>
              <option value="2015">2015</option>
              <option value="2016">2016</option>
              <option value="2017">2017</option>
              <option value="2018">2018</option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
            </select>

            <label style="font-size:13px">年</label>


            <!-- 月 -->
            <select class="old_month" name="old_month" style="border: none; width:25%; border-bottom: 1px solid #6fa9ff;">
              <option value="none">-----</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>

            <label style="font-size:13px">月</label>


            <!-- 日 -->
            <select class="old_day" name="old_day" style="border: none; width: 25%; border-bottom: 1px solid #6fa9ff;">
              <option value="none">-----</option>
              <option value="01">1</option>
              <option value="02">2</option>
              <option value="03">3</option>
              <option value="04">4</option>
              <option value="05">5</option>
              <option value="06">6</option>
              <option value="07">7</option>
              <option value="08">8</option>
              <option value="09">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>

            <label style="font-size:13px">日</label>

          </div>

          <!-- -------------------------------------------------------------------------------- -->

          <!--役職のエラーメッセージを表示する-->
          @if ($errors->has('role'))
          @foreach($errors->get('role') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif

          <!-- 役職 -->
          <div class="mt-3">
            <label class="d-block m-0" style="font-size:13px;">役職</label>

            <div class="role-flex">
              <div class="role-box">
                <input type="radio" name="role" class="admin_role role" value="1">
                <label class="ml-1" style="font-size:13px;">教師(国語)</label>
              </div>

              <div class="role-box">
                <input type="radio" name="role" class="admin_role role" value="2">
                <label class="ml-1" style="font-size:13px;">教師(数学)</label>
              </div>

              <div class="role-box">
                <input type="radio" name="role" class="admin_role role" value="3">
                <label class="ml-1" style="font-size:13px;">教師(英語)</label>
              </div>

              <div class="role-box">
                <input type="radio" name="role" class="other_role role" value="4">
                <label class="ml-1" style="font-size:13px;" class="other_role">生徒</label>
              </div>
            </div>

          </div>

          <!-- 選択科目 -->
          <div class="select_teacher d-none">

            <label class="d-block m-0" style="font-size:13px">選択科目</label>

            <!-- 全ての科目名を表示する処理 -->
            @foreach($subjects as $subject)
            <div class="mt-1">
              <input type="checkbox" name="subject[]" value="{{ $subject->id }}">
              <label>{{ $subject->subject }}</label>
              <!-- 科目名を表示する処理 -->
            </div>
            @endforeach
          </div>

          <!------------------------------------------------------------------------------------->

          <!--パスワードのエラーメッセージを表示する-->
          @if ($errors->has('password'))
          @foreach($errors->get('password') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif

          @if ($errors->has('password_confirmation'))
          @foreach($errors->get('password_confirmation') as $message)
          <p class="error-message"> {{ $message }} </p>
          @endforeach
          @endif

          <!-- パスワード -->

          <div class="mt-3">
            <label class="d-block m-0" style="font-size:13px">パスワード</label>
            <div class="border-bottom border-primary">
              <input type="password" class="border-0 w-100 password" name="password">
            </div>
          </div>


          <div class="mt-3">
            <label class="d-block m-0" style="font-size:13px">確認用パスワード</label>
            <div class="border-bottom border-primary">
              <input type="password" class="border-0 w-100 password_confirmation" name="password_confirmation">
            </div>
          </div>

          <!------------------登録ボタン---------------------------------------------------->
          <div class="mt-3 text-right">
            <input type="submit" class="btn btn-primary register_btn" disabled value="新規登録" onclick="return confirm('登録してよろしいですか？')">
          </div>

          <!------------------ログイン画面へ戻る---------------------------------------------->

          <div class="text-center mt-1 mr-4">
            <a href="{{ route('loginView') }}">ログインはこちら</a>
            <!-- ログイン画面へ戻る処理 -->
          </div>

        </div>
        {{ csrf_field() }}
      </div>
  </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</body>

</html>
