<?php

namespace App\Http\Controllers;

use App\Comment;
use App\BlogPost;
use App\Events\CommentPosted;
use App\Http\Requests\CommentValidation;
use App\Http\Resources\Comment as CommentResource;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post)
    {
        return CommentResource::collection($post->comments()->with('user')->get());
        // return $post->comments()->with('user')->get();
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

        event(new CommentPosted($comment));

        flash(__('Comment was created successfully!'))->success()->important();

        return redirect()->back();
    }
}
