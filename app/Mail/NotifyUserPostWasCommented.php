<?php

namespace App\Mail;

use App\Comment;
use App\Jobs\SendMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserPostWasCommented extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment has been added to the \"{$this->comment->commentable->title}\" blog post you've commented!";

        return $this
            ->subject($subject)
            ->markdown('emails.posts.new-comment-on-commented-post');
    }
}
