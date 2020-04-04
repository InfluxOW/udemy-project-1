<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPosts()
    {
        return $this->morphedByMany('App\BlogPost', 'taggable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphedByMany('App\Comment', 'taggable')->withTimestamps();
    }
}
