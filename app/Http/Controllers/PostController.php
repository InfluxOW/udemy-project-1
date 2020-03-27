<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\User;
use App\Http\Requests\PostControllerValidation;
use Illuminate\Support\Facades\Gate;

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
        $posts = BlogPost::latest()->withCount('comments')->paginate(10);
        $mostCommentedPosts = BlogPost::mostCommented()->take(5)->get();
        $mostActiveUsers = User::withMostBlogPosts()->take(5)->get();
        $mostActiveLastMonthUsers = User::withMostBlogPostsLastMonth()->take(5)->get();

        return view('posts.index', compact('posts', 'mostCommentedPosts', 'mostActiveUsers', 'mostActiveLastMonthUsers'));
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

        return redirect()->route('posts.index')->with('success', 'Post was created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blogpost $post)
    {
        return view('posts.show', compact('post'));
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

        return redirect()->route('posts.index')->with('success', 'Post was updated successfully!');
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
        return redirect()->route('posts.index')->with('success', 'Post was deleted successfully!');
    }
}
