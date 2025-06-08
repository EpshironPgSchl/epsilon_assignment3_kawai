<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // userを10人作成
        $users = User::factory(10)->create();

        //postを30件作成
        //user_idは上記で作成した10人からランダムに選ばれる
        $posts = Post::factory(30)
            ->recycle($users) // 既存のuserを使い回す
            ->create();

        //commentを100件作成
        //post_idは上記で作成した30件の投稿からランダムに選ばれる
        Comment::factory(100)
            ->recycle($users) //既存のuserを使い回す
            ->recycle($posts) //既存のpostを使い回す
            ->create();
    }
}
