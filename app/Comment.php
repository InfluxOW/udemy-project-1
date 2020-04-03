<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['created_at', 'content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable')->withTimestamps();
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orederBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            Cache::forget("post-{$comment->commentable->id}");
            Cache::forget("mostCommentedPosts");
        });

        static::updating(function (Comment $comment) {
            Cache::forget("post-{$comment->commentable->id}");
        });

        static::deleting(function (Comment $comment) {
            if ($comment->commentable_type == 'App\BlogPost') {
                Cache::forget("post-{$comment->commentabl->id}");
                Cache::forget("mostCommentedPosts");
            }
        });
    }
}
