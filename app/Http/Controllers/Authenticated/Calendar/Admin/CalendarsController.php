<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;
use DateTime;

//講師用のカレンダーコントローラー

class CalendarsController extends Controller
{
    //予約確認画面を表示する（講師用）
    public function show(){
        //ここで集計する。
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    //予約詳細画面を表示する
    public function reserveDetail($date, $part){
        //reserve_settingsテーブルから日付$date、部$partからそのレコードを取得する。
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->first();//getからfirstに変えた。
        $reserve_setting_id = $reservePersons -> id;
        $users = User::get();
        $user_id= array();
        $i = 1;

        $hit_id = array();
        $hit_many = 1;
        //////////////////////
        $ii=User::find(18)->id;

        $iii =User::find(18)->reserveGetUsers2($ii, $reserve_setting_id);
        /////////////////////

        foreach ($users as $user) {//ここで検索する
            $user_id = $user->id;
            // dd($user_id[$i]);
            if ($user->reserveGetUsers2($user_id, $reserve_setting_id)) {
                $hit_id[$hit_many] = $user;
                $hit_many++;
            }
        }
        // dd($hit_id);
        //hit_id[]にidが入っている。あとはこれを表示する。

        $date= new DateTime($date);//文字列になっているので、時間表示に一度変換する。
        $date= $date->format('Y年m月d日');//それを、年月日に変換して送る。
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons', 'date', 'part' ,'hit_id'));
    }

    //スクール枠登録画面を表示する
    public function reserveSettings(){
        $calendar = new CalendarSettingView(time());
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request){
        $reserveDays = $request->input('reserve_day');
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}
