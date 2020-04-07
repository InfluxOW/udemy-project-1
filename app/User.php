<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'ru' => 'Русский'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'locale'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany('App\BlogPost');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function commentsOfUser()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    //Scopes

    public function scopeWithMostBlogPosts(Builder $query)
    {
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');
    }

    public function scopeWithMostBlogPostsLastMonth(Builder $query)
    {
        return $query->has('blogPosts', '>=', 2)
        ->withCount(['blogPosts' => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])
        ->orderBy('blog_posts_count', 'desc');
    }

    public function scopeUsersCommentedPost(Builder $query, BlogPost $post)
    {
        return $query->whereHas('commentsOfUser', function ($query) use ($post) {
            $query->where('commentable_id', '=', $post->id)
                ->where('commentable_type', '=', BlogPost::class);
        });
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('is_admin', true);
    }
}
