<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyOwnerPostWasCommented extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment has been added to your \"{$this->comment->commentable->title}\" blog post!";

        return $this
            ->subject($subject)
            ->markdown('emails.posts.commented-markdown');
    }
}
