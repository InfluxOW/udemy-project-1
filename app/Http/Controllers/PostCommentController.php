<?php

namespace App\Http\Controllers;

use App\Comment;
use App\BlogPost;
use App\Http\Requests\CommentValidation;
use App\Jobs\SendMail;
use App\Mail\NotifyOwnerPostWasCommented;
use App\Mail\NotifyUserPostWasCommented;
use App\User;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CommentValidation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentValidation $request, BlogPost $post)
    {
        $validatedData = $request->validated();
        $comment = Comment::make($validatedData);
        $user = $request->user();
        $comment->user()->associate($user);
        $comment->commentable()->associate($post);
        $comment->save();

        //Sending emails
        //1) to post owner
        SendMail::dispatch($post->user, new NotifyOwnerPostWasCommented($comment))->onQueue('high');
        //2) to every user who commented the post except owner
        $usersExceptCommentAuthor = getUsersExcept($post->comments, [$user->id]);
        $usersExceptCommentAuthor->map(function (User $user) use ($comment) {
            SendMail::dispatch($user, new NotifyUserPostWasCommented($comment, $user))->onQueue('low');
        });

        flash('Comment was created successfully!')->success()->important();

        return redirect()->back();
    }
}
