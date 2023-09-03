<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = DateTime::createFromFormat('Y年m月d日', '1989年01月10日');

        //初期ユーザー
        DB::table('users')->insert([
            [
                'over_name' => '前薗',
                'under_name' => '良彦',
                'over_name_kana' => 'マエゾノ',
                'under_name_kana' => 'ヨシヒコ',
                'mail_address' => 'zono@gmail.com',
                'sex' => '1',
                'birthday'=> $date->format('Y-m-d'),
                'role' => '1',
                'password' => bcrypt('zono4649'),
                'created_at' => now(),
            ],
        ]);
    }
}
