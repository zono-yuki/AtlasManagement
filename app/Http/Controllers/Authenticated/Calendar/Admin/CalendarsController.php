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
        //reserve_settingsテーブルから日付$date、部$partからそのレコード自体を取得する。
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->first();//getからfirstに変えた。
        $reserve_setting_id = $reservePersons -> id;//そのレコードのidを取得する。
        $users = User::get();//usersテーブルから全てのユーザーの情報を取得する。
        $user_id= array(); //下のforeachで使う全てのユーザーを回して行く際にユーザーidを入れていくので使用するため、配列を用意する。
        $hit_id = array();//ヒットしたidを入れるために配列を用意する。
        $hit_many = 1;//trueでヒットした際に必要、配列の要素の数。初期値の1を入れる。(1〜)
        foreach ($users as $user) {//ここで検索する
            $user_id = $user->id;
            if ($user->reserveGetUsers2($user_id, $reserve_setting_id)) {
                $hit_id[$hit_many] = $user;
                $hit_many++;
            }
        }
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
