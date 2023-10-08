<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

//スクール生、講師用のカレンダーコントローラー

class CalendarsController extends Controller
{
    public function show(){
        //スクール予約画面を表示する
        $calendar = new CalendarView(time());//ここで全ての集計をしている。
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    //予約するボタンを押した時
    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            // dd($request);
            $getPart = $request->getPart;
            $getDate = $request->getData;
            // dd($getPart);
            // まだ灰色ではない日の予約している部名がはいっている
            // dd($getDate);
            //全ての日付が入っている。
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // dd($reserveDays);
            //$reserveDaysには灰色じゃない日の'予約している日付とリモ⚪︎部'が入っている。
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                // dd($reserve_settings);
                //nullです。
                $reserve_settings->decrement('limit_users');//reserve_settingsテーブルの人数を減らす
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
