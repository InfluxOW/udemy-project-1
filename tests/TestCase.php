<?php

namespace Tests;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function user()
    {
        return factory(User::class)->create();
    }

    protected function createTestBlogPost(): BlogPost
    {
        //Making user
        $user = factory(User::class)->create();
        //Making post and associating it with the user
        $post = factory(BlogPost::class)->make();
        $post->user()->associate($user)->save();
        //Making comment and associating it with the user and the post
        $comment = factory(Comment::class)->make();
        $comment->user()->associate($user);
        $comment->commentable()->associate($post)->save();

        return $post;
    }
}
