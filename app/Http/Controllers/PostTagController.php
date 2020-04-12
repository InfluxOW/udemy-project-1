<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();
        $posts = $tag->blogposts()->latestWithRelations()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function store($tagName, BlogPost $post, Request $request)
    {
        $tag = Tag::where('name', $tagName)->first();
        $posts = $tag->blogposts()->latestWithRelations()->paginate(10);

        return view('posts.index', compact('posts'));
    }
}
