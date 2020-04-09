<?php

namespace App\Providers;

use App\BlogPost;
use App\Comment;
use App\Http\ViewComposers\Activity;
use App\Observers\BlogPostObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\Comment as CommentResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['posts.index', 'posts.show'], Activity::class);

        BlogPost::observe(BlogPostObserver::class);
        Comment::observe(CommentObserver::class);
        CommentResource::withoutWrapping();
    }
}
