<?php

namespace App\Http\Controllers\Api\V1_0_0;

use App\BlogPost;
use App\Comment;
use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentValidation;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store', 'destroy', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogPost $post, Request $request)
    {
        $per = $request['per'] ?? 5;
        return CommentResource::collection(
            $post->comments()->with('user')->paginate($per)->appends(['per_page' => $per])
        );
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

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  BlogPost $post
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post, Comment $comment)
    {
        return $comment->commentable->id === $post->id
        ? new CommentResource($comment)
        : response()->json([
                'message' => 'comment does not belong to the specified blogpost'
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPost $post, Comment $comment, CommentValidation $request)
    {
        $this->authorize($comment);

        if ($comment->commentable->id === $post->id) {
            $comment->update(['content' => $request['content']]);
            return new CommentResource($comment);
        }

        return response()->json([
            'message' => 'comment does not belong to the specified blogpost'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        $this->authorize($comment);

        if ($comment->commentable->id === $post->id) {
            $comment->delete();
            return response()->noContent();
        }
        return response()->json([
            'message' => 'comment does not belong to the specified blogpost'
        ]);
    }
}
