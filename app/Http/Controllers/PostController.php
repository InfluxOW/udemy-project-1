<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\PostCreated;
use App\Http\Requests\PostValidation;
use App\Image;
use App\User;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
        // $this->authorizeResource(BlogPost::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogPost::latestWithRelations()->paginate(10);

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
     * @param  \Illuminate\Http\PostValidation $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostValidation $request)
    {
        $validatedData = $request->validated();
        $post = BlogPost::make($validatedData);

        $user = $request->user();
        $post->user()->associate($user)->save();

        if ($request->hasFile('thumbnail')) {
            $path = Storage::disk('s3')->put("thumbnails", $request->file('thumbnail'), 'public');
            $image = Image::make([
                'path' => $path,
                'url' => Storage::disk('s3')->url($path)
                ]);
            $post->image()->save($image);
        }

        event(new PostCreated($post));

        flash(__('Post was created successfully!'))->success()->important();

        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  BlogPost $post
     * @return \Illuminate\Http\Response
     */
    public function show(BlogPost $post)
    {
        $blogPost = Cache::remember("post-{$post->id}", now()->addHour(), function () use ($post) {
            return $post;
        });

        views($blogPost)->record();
        $viewsTotal = views($post)->remember()->count();

        return view('posts.show', ['post' => $blogPost, 'viewsTotal' => $viewsTotal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BlogPost $post
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $post)
    {
        $this->authorize($post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostValidation $request
     * @param  BlogPost $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostValidation $request, BlogPost $post)
    {
        $this->authorize($post);

        $validatedData = $request->validated();
        $post->update($validatedData);

        if ($request->hasFile('thumbnail')) {
            $path = Storage::disk('s3')->put("thumbnails", $request->file('thumbnail'), 'public');

            if ($post->image) {
                Storage::disk('s3')->delete($post->image->path);
                $post->image->delete();
            }

            $image = Image::make([
                'path' => $path,
                'url' => Storage::disk('s3')->url($path)
                ]);
            $post->image()->save($image);
        }

        flash(__('Post was updated successfully!'))->success()->important();

        return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BlogPost $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $post)
    {
        $this->authorize($post);
        $post->delete();

        flash(__('Post was deleted successfully!'))->success()->important();

        return redirect()->route('posts.index');
    }
}
