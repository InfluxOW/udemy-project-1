<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\BlogPost;
use App\User;

class Activity
{
    public function compose(View $view)
    {
        $mostCommentedPosts = Cache::remember('mostCommentedPosts', now()->addHour(), function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActiveUsers = Cache::remember('mostActiveUsers', now()->addHour(), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonthUsers = Cache::remember('mostActiveLastMonthUsers', now()->addHour(), function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommentedPosts', $mostCommentedPosts);
        $view->with('mostActiveUsers', $mostActiveUsers);
        $view->with('mostActiveLastMonthUsers', $mostActiveLastMonthUsers);
    }
}
