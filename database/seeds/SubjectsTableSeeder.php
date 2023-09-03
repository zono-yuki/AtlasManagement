<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Subjects;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //国語を追加
        $subjects = [
            'subject' => '国語',
        ];

        DB::table('subjects')->insert($subjects);



        //数学を追加
        $subjects = [
            'subject' => '数学',
        ];

        DB::table('subjects')->insert($subjects);



        //英語を追加
        $subjects = [
            'subject' => '英語',
        ];

        DB::table('subjects')->insert($subjects);

    }
}
