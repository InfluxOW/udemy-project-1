<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['science', 'sport', 'games', 'porn', 'memes']);
        $tags->each(function ($tagName) {
            Tag::create(['name' => $tagName]);
        });
    }
}
