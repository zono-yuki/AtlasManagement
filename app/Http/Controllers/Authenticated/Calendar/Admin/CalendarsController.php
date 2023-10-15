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

//講師用のカレンダーコントローラー

class CalendarsController extends Controller
{
    //予約確認画面を表示する（講師用）
    public function show(){
        //ここで集計する。
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    //予約詳細画面を表示する(作成中)
    public function reserveDetail($date, $part){
        // dd($date);
        //ok
        // dd($part);
        // ok
        //reserve_settingsテーブルから日付$date、部$partからそのレコードを取得する。
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->first();//getからfirstに変えた。
        $reserve_setting_id = $reservePersons -> id;
        // dd($reserve_setting_id);
        //ok
        // $reserve_users = ;

        //このあとやること
        //$reservePersonsのidを取得する。それを利用して、reserve_setting_usersテーブル（中間テーブル）からそのidと同じreserve_setting_idを持つレコードを全部取得する。
        //そして、そのレコードから、user_idを取得する。（これで、その部を予約しているユーザーがわかる。そのuserを全部送る。）
        //むこうで、foreachで回して名前を表示する。って感じかな。
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons', 'date', 'part'));
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
