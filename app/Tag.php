<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPosts()
    {
        return $this->morphByMany('App\BlogPost', 'taggable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphByMany('App\Comment', 'taggable')->withTimestamps();
    }
}
