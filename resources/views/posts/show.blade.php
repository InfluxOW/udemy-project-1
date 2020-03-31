@extends('layouts.app')

@section('content')
<x-errors/>

<div class="row">
    <div class="col-8">
        <h1>
            {{ $post->title }}
            <x-badge :date="$post->created_at">
                New!
            </x-badge>
        </h1>
        <p>{{ $post->content }}</p>

        <p>
            @if ($post->tags->first())
                <x-tags :tags="$post->tags"/>
            @endif
        </p>

        <x-creation-info :name="$post->user->name" :date="$post->created_at"/>

        @auth
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary"> Edit </a>
            @endcan
            @if (!$post->trashed())
                @can('delete', $post)
                    <a href="{{ route('posts.destroy', $post) }}" data-confirm="Are you sure?" data-method="delete" rel="nofollow" class="btn btn-primary">Delete</a>
                @endcan
            @endif
        @endauth

        {{-- <p>Current watchers: {{ $counter }}</p> --}}

        <hr>
        <h4>Comments</h4>

        @include('comments._form')

        @if ($post->comments())
            @forelse ($post->comments()->with('user')->get() as $comment)
                <p>{{ $comment->content }}</p>
                <x-creation-info :name="$comment->user->name" :date="$comment->created_at"/>
            @empty
                No comments yet!<br>
            @endforelse
        @endif
    </div>

    <div class="col-4 text-center">
        @include('posts._activity')
    </div>
</div>
@endsection('content')
