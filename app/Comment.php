<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
