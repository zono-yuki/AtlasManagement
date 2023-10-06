<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

//一般ユーザー用

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
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
    foreach($weeks as $week){//1週間を繰り返す
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();//日を数える。
      foreach($days as $day){//1日を繰り返す
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        //ここでグレーの背景日を決めている。
        // if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<td class=" border-left border-right calendar-tx">';//灰色に塗る
        }else{//今月の過ぎた日以外の日の場合
          $html[] = '<td class="calendar-td  border-bottom border-left border-bottom '.$day->getClassName().'">';
        }
        $html[] = $day->render();//前月も来月も含めて全ての日


      //予約がされているかどうか
        //in_array()は変数が配列にあるかどうかをチェックする関数
        //予約されている
        if(in_array($day->everyDay(), $day->authReserveDay())){//予約がされていた場合
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }

            // if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {//予約されているけど、過ぎていた日の場合 未参加か参加の調べ方はあとでわかったら追加する
              // $html[] = '<p class="m-auto p-0 w-100" style="font-size:15px">'. $reservePart. '未参加</p>';
              $html[] = $reservePart."未参加";
              $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            }
            else{//過ぎていなければ、キャンセルボタンを表示する //すでに予約している場所に赤色の「リモ⚪︎部ボタン表示する」
              //キャンセルボタンにはと予約日を表示させる//予約日（setting_reserve）はvalueで飛んでいる。時間(リモ○部$reservePartも飛ばしてあげる。)

              $setting_reserve = $day->authReserveDate($day->everyDay())->first()->setting_reserve;
              //dd($setting_reserve);

              //submit->button
              $html[] = '<button type="button" class="btn btn-danger p-0 w-75 cancelModal" name="delete_date" style="font-size:12px" setting_reserve="'.$setting_reserve.'">'. $reservePart .'</button>';

              $html[] = '<input type="hidden" name="getPart[]" value="'.$reservePart.'" form="reserveParts">';
            }

        }else{//予約がされていない場合///
          //もし過ぎた日だった場合、
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '受付終了';
          }else{ //まだ過ぎていない日の場合、セレクトボックスを表示する。
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
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    //-----------------------ここから削除モーダル---------------------------------------
    $html[] =  '<div id="myModal" class="calendar_modal">';
      $html[] =  '<div class=" text-center calendar_content">';
        $html[] =  '<form class=" text-left" method="get" action="">'; //追加
            // $html[] =  '<input type="hidden" name="id" value="" id="setting_reserve_id">';

            $html[] = '<div>';
            $html[] =   '<p class="mb-2 cancel-font">予約日：<span id="setting_reserve_id"></span></p> ';
            // $html[] =  '<span name="id" value="" id="setting_reserve_id">></span>';
            $html[] = '</div>';

            $html[] = '<div>';
            $html[]=   '<p class="mb-2 cancel-font">時間：<span id="setting_reserve_id"></span></p> ';
            // $html[] =  '<span name="id" value="" id="setting_reserve_id">></span>';
            $html[] = '</div>';

            $html[] = '<div>';
             $html[] = '<p class="mb-2 cancel-font">上記の予約をキャンセルしてもよろしいですか？</p>';
            $html[] = '</div>';

            //予約キャンセルボタン
            $html[] = '<div class="d-flex text-left">';
              $html[] ='<button id="closeModal" class="close__btn">閉じる</button>'; //キャンセルボタン
            $html[] =  '<button type="submit" class="cancel__btn" value="" alt="キャンセル">キャンセル</button>';
            $html[] = '</div>';

        $html[] = '</form>';
        $html[] = '</div>';
      $html[] = '</div>';
    //--------------------------------------------------------------------------------

    return implode('', $html);//$htmlの配列の要素を区切り、文字列とする。
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
