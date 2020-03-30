<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\User;
use App\Http\Requests\PostControllerValidation;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogPost::latest()->withCount('comments')->with(['user', 'comments', 'tags'])->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new BlogPost();
        return view('posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostControllerValidation $request)
    {
        $validatedData = $request->validated();
        $post = Blogpost::make($validatedData);

        $user = $request->user();
        $post->user()->associate($user)->save();

        flash('Post was created successfully!')->success()->important();

        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blogpost $post)
    {
        $blogPost = Cache::remember("post-{$post->id}", now()->addHour(), function () use ($post) {
            return $post;
        });

        $counter = watchersCount($post->id);

        return view('posts.show', ['post' => $blogPost, 'counter' => $counter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blogpost $post)
    {
        $this->authorize($post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostControllerValidation $request, Blogpost $post)
    {
        $this->authorize($post);

        $validatedData = $request->validated();
        $post->update($validatedData);

        flash('Post was updated successfully!')->success()->important();

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blogpost $post)
    {
        $this->authorize($post);
        $post->delete();

        flash('Post was deleted successfully!')->success()->important();

        return redirect()->route('posts.index');
    }
}
