<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function blogPosts()
    {
        return $this->morphedByMany('App\BlogPost', 'taggable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphedByMany('App\Comment', 'taggable')->withTimestamps();
    }
}
