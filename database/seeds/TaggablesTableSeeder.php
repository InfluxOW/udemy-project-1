<?php

use App\BlogPost;
use App\Tag;
use Illuminate\Database\Seeder;

class TaggablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagsCount = Tag::all()->count();
        BlogPost::all()->each(function ($post) use ($tagsCount) {
            $tagsAmount = random_int(1, $tagsCount - 2);
            $tags = Tag::inRandomOrder()->take($tagsAmount)->get()->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
