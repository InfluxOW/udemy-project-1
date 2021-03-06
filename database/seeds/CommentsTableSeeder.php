<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\BlogPost::all();
        $users = App\User::all();
        $commentsCount = (int) $this->command->ask('How many comments do you want to create?', 150);

        factory(App\Comment::class, $commentsCount)->make()->each(function ($comment) use ($posts, $users) {
            $comment->commentable()->associate($posts->random());
            $comment->user()->associate($users->random());
            $comment->save();
        });

        factory(App\Comment::class, $commentsCount)->make()->each(function ($comment) use ($users) {
            $comment->commentable()->associate($users->random());
            $comment->user()->associate($users->random());
            $comment->save();
        });
    }
}
