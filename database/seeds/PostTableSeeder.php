<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $contents = [
            'title' => 'テスト投稿１',
            'body' => 'これはテスト投稿１です。コメントを返しましょう。',
            ];
        DB::table('posts')->insert($contents);
            
        $contents = [
            
            'title' => 'テスト投稿２',
            'body' => 'これはテスト投稿２です。コメントを返しましょう。',
        ];
        DB::table('posts')->insert($contents);
    }
}
