<?php

namespace App;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    use Taggable;

    protected $fillable = ['created_at', 'content'];

    protected $hidden = [
        'commentable_type', 'commentable_id', 'deleted_at', 'user_id'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orederBy(static::CREATED_AT, 'desc');
    }
}
