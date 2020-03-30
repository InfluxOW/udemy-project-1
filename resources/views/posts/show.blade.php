@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-8">
        <h1>
            {{ $post->title }}
            @component('components.badge', ['show' => now()->diffInMinutes($post->created_at) < 50])
                New!
            @endcomponent
        </h1>
        <p>{{ $post->content }}</p>
        @component('components.creation-info', ['date' => $post->created_at, 'name' => $post->user->name])
        @endcomponent

        @if ($post->tags->first())
            @component('components.tags', ['tags' => $post->tags])
            @endcomponent
        @endif

        <p>Current watchers: {{ $counter }}</p>

        <h4>Comments</h4>
        @if ($post->comments)
            @forelse ($post->comments as $comment)
                <p>{{ $comment->content }}</p>
                @component('components.creation-info', ['date' => $comment->created_at, 'name' => $comment->user->name])
                @endcomponent
            @empty
                No comments yet!<br>
            @endforelse
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
    </div>

    <div class="col-4 text-center">
        @include('posts._activity')
    </div>
</div>
@endsection('content')
