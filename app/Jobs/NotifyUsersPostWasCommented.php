<?php

namespace App\Jobs;

use App\Comment;
use App\Mail\NotifyUserPostWasCommented;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUsersPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::UsersCommentedPost($this->comment->commentable)
            ->get()
            ->filter(function (User $user) {
                return !in_array($user->id, [$this->comment->user->id]);
            })->map(function (User $user) {
                SendMail::dispatch($user, new NotifyUserPostWasCommented($this->comment, $user));
            });
    }
}
