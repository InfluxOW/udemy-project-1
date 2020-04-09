<?php

namespace App\Observers;

use App\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        //
    }

    public function creating(Comment $comment)
    {
        Cache::forget("post-{$comment->commentable->id}");
        Cache::forget("mostCommentedPosts");
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    public function updating(Comment $comment)
    {
        Cache::forget("post-{$comment->commentable->id}");
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    public function deleting(Comment $comment)
    {
        if ($comment->commentable_type == 'App\BlogPost') {
            Cache::forget("post-{$comment->commentable->id}");
            Cache::forget("mostCommentedPosts");
        }
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
