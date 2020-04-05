<?php

namespace App\Jobs;

use App\Comment;
use App\Mail\CommentPostedMarkdown;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Spatie\RateLimitedMiddleware\RateLimited;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 15;
    public $user;
    public $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Mailable $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send($this->mail);
    }

    public function middleware()
    {
        $rateLimitedMiddleware = (new RateLimited())
            ->allow(5)
            ->everySeconds(10)
            ->releaseAfterSeconds(30);

        return [$rateLimitedMiddleware];
    }
}
