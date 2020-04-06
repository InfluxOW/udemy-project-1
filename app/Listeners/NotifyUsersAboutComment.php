<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\SendMail;
use App\Mail\NotifyOwnerPostWasCommented;

class NotifyUsersAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        //Sending emails
        //1) to post owner
        SendMail::dispatch($event->comment->commentable->user, new NotifyOwnerPostWasCommented($event->comment))->onQueue('high');
        //2) to every user who commented the post except owner
        NotifyUsersPostWasCommented::dispatch($event->comment)->onQueue('low');
    }
}
