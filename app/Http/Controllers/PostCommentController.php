<?php

namespace App\Http\Controllers;

use App\Comment;
use App\BlogPost;
use App\Http\Requests\CommentValidation;

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

        flash('Comment was created successfully!')->success()->important();

        return redirect()->back();
    }
}