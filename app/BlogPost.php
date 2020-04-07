<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class BlogPost extends Model implements Viewable
{
    use SoftDeletes;
    use Taggable;
    use InteractsWithViews;

    protected $fillable = ['title', 'content', 'created_at'];
    protected $removeViewsOnDelete = true;

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    //Scopes

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()->withCount('comments')->with(['user', 'tags']);
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_cound', 'desc');
    }

    //Boot

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();
    }
}
