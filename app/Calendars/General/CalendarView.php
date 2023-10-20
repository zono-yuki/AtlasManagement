<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{

  //一般ユーザー用

  private $carbon;
  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  function render()
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';

    ///////////////////////////月〜日/////////////////////////////////////////
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border-right border-left">月</th>';
    $html[] = '<th class="border-right">火</th>';
    $html[] = '<th class="border-right">水</th>';
    $html[] = '<th class="border-right">木</th>';
    $html[] = '<th class="border-right">金</th>';
    $html[] = '<th class="border-right font-blue">土</th>';
    $html[] = '<th class="border-right font-red">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    ////////////////////////////////////////////////////////////////////
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();
    foreach ($weeks as $week) { //1週間を繰り返す
      $html[] = '<tr class="' . $week->getClassName() . '">';
      $days = $week->getDays();

      foreach ($days as $day) { //1日を繰り返す
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        //ここでグレーの背景日を決めている。
        // if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
        if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
          $html[] = '<td class="calendar-td border-left border-right calendar-tx ' . $day->getClassName() . '">'; //灰色に塗る
        } else { //今月の過ぎた日以外の日の場合
          $html[] = '<td class="calendar-td  border-bottom border-left border-bottom ' . $day->getClassName() . '">';
        }
        $html[] = $day->render(); //日付を表示する


        //予約がされているかどうか
        //in_array()は変数が配列にあるかどうかをチェックする関数
        //予約されている
        if (in_array($day->everyDay(), $day->authReserveDay())) { //予約がされていた場合
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;

          //ここで$reservePartに部名を入れて、のちにvalueで送っている。
          if ($reservePart == 1) {
            $reservePart = "リモ1部";
            //追加
            $part = "1";
          } else if ($reservePart == 2) {
            $reservePart = "リモ2部";
            $part = "2";
          } else if ($reservePart == 3) {
            $reservePart = "リモ3部";
            $part = "3";
          }

          // if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) { //予約されているけど、過ぎていた日の場合 未参加か参加の調べ方はあとでわかったら追加する

            // $html[] = '<p class="m-auto p-0 w-100" style="font-size:15px">'. $reservePart. '未参加</p>';
            $html[] = '<p class="m-auto p-0 w-100" style="color:black; font-size:15px">受付終了</p>';
            // $html[] = $reservePart . "未参加";
            // $html[] = "未参加";
            // $html[] = "受付終了";//◯部未参加と表示するのかどうか,わかったら上に変更する。


            // $html[] = '参加or未参加';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else { //過ぎていなければ、キャンセルボタンを表示する //すでに予約している場所に赤色の「リモ⚪︎部ボタン表示する」
            //キャンセルボタンにはと予約日を表示させる//予約日（setting_reserve）はvalueで飛んでいる。時間(リモ○部$reservePartも飛ばしてあげる。)

            //ここで予約している日を取得している。このあと、キャンセルボタンで送る。
            $setting_reserve = $day->authReserveDate($day->everyDay())->first()->setting_reserve;
            //dd($setting_reserve);

            //submit->button
            //キャンセルボタン
            $html[] = '<button type="button" class="btn btn-danger p-0 w-75 cancelModal" name="delete_date" style="font-size:12px" part= "'.$part.'" setting_reserve="' . $setting_reserve . '" setting_part="' . $reservePart . '">' . $reservePart . '</button>';

            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

          }
        } else { //予約がされていない場合///
          //もし過ぎた日だった場合、
          if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
            // $html[] = '受付終了';
            $html[] = '<p class="m-auto p-0 w-100" style="color:black; font-size:15px">受付終了</p>';
            //追加 数を合わせる
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

          } else { //まだ過ぎていない日の場合、セレクトボックスを表示する。
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    //予約するボタンを押した時に必要
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';

    //削除するボタンを押した時に必要 隠しモーダルの下に移動
    // $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    //-----------------------ここから【隠し削除モーダル】追加---------------------------------------

    $html[] =  '<div id="myModal" class="calendar_modal">';
    $html[] =  '<div class="calendar_content">';

    $html[] = '<div class="modal__flex">';

    $html[] = '<div class="text-left">';
    $html[] =   '<div class="mb-2 cancel-font">予約日：';
      $html[] =   '<span id="setting_reserve_id" value =""></span>';//2023-10-⚪︎⚪︎表示用
      $html[] =   '<input type="hidden" id="settings_reserve_id" value="" name="getDate" form="deleteParts">';//コントローラーに送る用
      $html[] = '</div>';
    $html[] = '</div>';

    $html[] = '<div class="text-left">';
    $html[] =   '<div class="mb-2 cancel-font">時間：';
       $html[] =  '<span id="setting_part_id" value =""></span>';//リモ⚪︎部表示用
       $html[] =  '<input type="hidden" id="settings_part_id" value="" name="getPart" form="deleteParts">';//コントローラーに送る用
     $html[] =  '</div> ';
    $html[] = '</div>';

    // setting_partのwhere文で使うため、コントローラーに送る用
    $html[] = '<input type="hidden" id="part" value="" name="parts" form="deleteParts">';

    $html[] = '<div class="text-left">';
    $html[] = '<p class="mb-2 cancel-font">上記の予約をキャンセルしてもよろしいですか？</p>';
    $html[] = '</div>';

    $html[] = '</div>';//追加

    //予約キャンセルボタンと閉じるボタン
    $html[] = '<div class="cancel__box">';
    //閉じるボタン
    $html[] = '<button id="closeModal" class="close__btn">閉じる</button>';
    //予約をキャンセルするボタン//キャンセルモーダルを表示する。onclick="return confirm('削除してもよろしいですか？')"
    $html[] =  '<input type="submit" class="cancel__btn" value="キャンセル" alt="キャンセル" form="deleteParts" >';
    // $html[] =  '<input type="submit" class="cancel__btn" value="キャンセル" alt="キャンセル" form="deleteParts" onclick="return confirm('削除してもよろしいですか？')">';


    $html[] = '</div>';

    //削除するボタンを押した時に必要
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';
    $html[] = '</div>';
    $html[] = '</div>';
    //--------------------------------------------------------------------------------

    return implode('', $html); //$htmlの配列の要素を区切り、文字列とする。
  }




//週と日の情報を取得する
  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
