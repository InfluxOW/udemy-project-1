<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentValidation;
use App\User;

class UserCommentController extends Controller
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
    public function store(CommentValidation $request, User $user)
    {
        $validatedData = $request->validated();
        $comment = Comment::make($validatedData);
        $authorizedUser = $request->user();
        $comment->user()->associate($authorizedUser);
        $comment->commentable()->associate($user);
        $comment->save();

        flash(__('Comment was created successfully!'))->success()->important();

        return redirect()->back();
    }
}
