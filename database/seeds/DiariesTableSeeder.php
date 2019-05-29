<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $user = DB::table('users')->first(); //追加

        // array()の省略形[]
        $diaries = [
            [
                'title' => 'セブでプログラミング',
                'body' => '気づけばもうあと1ヶ月' 
            ],
            [
                'title' => 'やり残したことは、、、',
                'body' => '筋トレだ！' 
            ],
            [
                'title' => 'いや、チーム開発でしょ！',
                'body' => '絶対リリース' 
            ]
        ];

        foreach ($diaries as $diary) {
            DB::table('diaries')->insert([
                'title' => $diary['title'],
                'body' => $diary['body'],
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
