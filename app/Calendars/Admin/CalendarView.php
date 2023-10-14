<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Users\User;

class CalendarView{

// 講師（管理者）用

  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

//タイトルを表示する
  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

//予約確認画面を表示する（人数を表示する）//////////////////////////////////////////////////////
  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center" style="background: #fff;">';
    $html[] = '<table class="table m-auto">';

////////////////月〜日/////////////////////////////////////
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
//////////////////////////////////////////////////////////
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();

    foreach($weeks as $week){//1週間を繰り返す
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();

      foreach($days as $day){//1日を繰り返す
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");

        //=を抜いた。
        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){
          //過ぎている日だった場合
          //ここでグレーの背景日を決めている。past-day
          $html[] = '<td class="past-day border-right border-left border-bottom">';


        }else{
          //すぎていない日の場合
          $html[] = '<td class="'.$day->getClassName().' border-right border-left border-bottom">';
        }

        //ここで部数と人数を表示している。(人数もここかも？)
        $html[] = $day->render(); //⚪︎日と表示させる

        //ここが1部,2部,3部を表示するところ&予約人数を表示（計算）
        $html[] = $day->dayPartCounts2($day->everyDay(),$day);

        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    return implode("", $html);
  }

//週と日の情報を取得する////////////////////////////////////////
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
  ////////////////////////////////////////////////////////////////////////////////////////
}
