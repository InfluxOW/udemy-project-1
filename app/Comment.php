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

    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orederBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            Cache::forget("post-{$comment->blogPost->id}");
            Cache::forget("mostCommentedPosts");
        });

        static::updating(function (Comment $comment) {
            Cache::forget("post-{$comment->blogPost->id}");
        });

        static::deleting(function (Comment $comment) {
            Cache::forget("post-{$comment->blogPost->id}");
            Cache::forget("mostCommentedPosts");
        });
    }
}
