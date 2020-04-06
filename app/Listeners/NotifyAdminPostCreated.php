<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Jobs\SendMail;
use App\Mail\PostAdded;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminPostCreated
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        User::admins()->get()->map(function (User $user) {
            SendMail::dispatch($user, new PostAdded())->onQueue('high');
        });
    }
}
