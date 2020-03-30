@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-8">
        <h1>
            {{ $post->title }}
            <x-badge :date="$post->created_at">
                New!
            </x-badge>
        </h1>
        <p>{{ $post->content }}</p>
        <x-creation-info :name="$post->user->name" :date="$post->created_at"/>

        @if ($post->tags->first())
            <x-tags :tags="$post->tags"/>
        @endif

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
        
        <br><br>

        {{-- <p>Current watchers: {{ $counter }}</p> --}}

        <h4>Comments</h4>

        @include('comments._form')

        @if ($post->comments)
            @forelse ($post->comments as $comment)
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
