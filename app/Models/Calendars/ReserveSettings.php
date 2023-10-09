<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

//スクール予約（開講日、部名、残り人数が登録されている）テーブル
class ReserveSettings extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'setting_reserve',//開講日
        'setting_part',//部名(1,2,3)
        'limit_users',//人数
        'created_at',//登録日時
    ];

    public function users(){//リレーション、usersテーブルとの中間テーブル
        return $this->belongsToMany('App\Models\Users\User', 'reserve_setting_users', 'reserve_setting_id', 'user_id')->withPivot('reserve_setting_id', 'id');
    }
}
