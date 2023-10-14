<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

///////////////////////////////////////////////////////
  function dayPartCounts($ymd){//予約画面で部名を表示するところ
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';
    if($one_part){
      $html[] = '<p class="day_part m-0 pt-1">1部</p>';
    }
    if($two_part){
      $html[] = '<p class="day_part m-0 pt-1">2部</p>';
    }
    if($three_part){
      $html[] = '<p class="day_part m-0 pt-1">3部</p>';
    }
    $html[] = '</div>';

    return implode("", $html);
  }

  function dayPartCounts2($ymd,$day){ //コピー予約画面で部名を表示するところ
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

  $html[] = '<div class="text-left">';
    if ($one_part) {
      $html[] = '<div class="day_part m-0 pt-1 count_box">';
        $html[] = '<span>1部</span>';
        $html[] = '<span class="text-right">'.$day->onePartFrame2($day->everyDay()).'</span>';
      $html[] = '</div>';
    }
    if ($two_part) {
      $html[] = '<div class="day_part m-0 pt-1 count_box">';
      $html[] = '<span>2部</span>';
      $html[] = '<span class="text-right">' . $day->twoPartFrame2($day->everyDay()) . '</span>';
      $html[] = '</div>';
    }
    if ($three_part) {
      $html[] = '<div class="day_part m-0 pt-1 count_box">';
      $html[] = '<span>3部</span>';
      $html[] = '<span class="text-right">' . $day->threePartFrame2($day->everyDay()) . '</span>';
      $html[] = '</div>';
    }
  $html[] = '</div>';

    return implode("", $html);
  }

///残り人数を表示する機能もともとあったやつ///////////////////////

//1部
  function onePartFrame($day){//$dayはその日
    //その日の1部の残り人数を表示
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){//存在した場合
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;//その日の残り人数をとってくる
    }else{//存在しなければ20とする。絶対存在するからここは入らない。
      $one_part_frame = "20";
    }
    //$one_part_frameを返す。
    return $one_part_frame;
  }

//2部
  function twoPartFrame($day){
    //2部の時の残り人数を表示
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }

//3部
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }
  //////////////////////////////////////////////////////////

  ////////////残り人数を表示する機能改良版///////////////////////////

  //1部
  function onePartFrame2($day)
  { //$dayはその日
    //その日の1部の残り人数を表示
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if ($one_part_frame) { //存在した場合
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users; //その日の残り人数をとってくる
      $one_part_frame =  20 - $one_part_frame;//ここで予約人数を計算
      return $one_part_frame;
    } else { //存在しなければ20とする。絶対存在するからここは入らない。
      $one_part_frame = "20";
      return $one_part_frame;
    }
  }

  //2部
  function twoPartFrame2($day)
  {
    //2部の時の残り人数を表示
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if ($two_part_frame) {
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
      $two_part_frame =  20 - $two_part_frame; //ここで予約人数を計算
      ///////////////////
      if ($two_part_frame === -1) { //カラム'limit_users'を21で登録しているところの補正 -1の時は1と表示する
        $two_part_frame = 0;
      }
      ///////////////////
    } else {
      $two_part_frame = "20";
      return $two_part_frame;
    }
    return $two_part_frame;
  }

  //3部
  function threePartFrame2($day)
  {
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if ($three_part_frame) {
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
      $three_part_frame =  20 - $three_part_frame;//ここで予約人数を計算
      return $three_part_frame;
    } else {
      $three_part_frame = "20";
      return $three_part_frame;
    }
  }
//////////////////////////////////////////////////////////
  //もともとあったやつ
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }

  //追加（dayNumberAdjustment()の改良）
  //これ何に使うの？
  function dayNumberAdjustment2()
  {
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
