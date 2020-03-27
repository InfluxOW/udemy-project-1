<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        $postsCount = max((int) $this->command->ask('How many posts do you want to create?', 50), 1);

        factory(App\BlogPost::class, $postsCount)->make()->each(function ($post) use ($users) {
            $post->user()->associate($users->random()->id)->save();
        });
    }
}
