@extends('layouts.app')

@section('content')
<x-errors/>

<div class="row">
    <div class="col-8">
        @forelse ($posts as $post)
        <p>
            <h3>
                @if ($post->trashed())
                    <del>
                @endif
                    <a class="{{$post->trashed() ? 'text-muted' : ''}}"
                href="{{ route('posts.show', ['post' => $post->id]) }}"> {{ $post->title }}
                    </a>
                @if ($post->trashed())
                    </del>
                @endif
            </h3>

            <x-creation-info :model="$post"/>

            @if ($post->tags->first())
                <x-tags :tags="$post->tags"/>
            @endif

            @if ($post->comments_count)
                {{ $post->comments_count }} {{ $post->comments_count == 1 ? 'comment' : 'comments' }}
            @else
                No comments yet!
            @endif

        </p>
        @empty
            <h3>No blog posts yet!</h3>
        @endforelse

        <div>{{$posts->links()}}</div>
    </div>

    <div class="col-4 text-center">
        @include('posts._activity')
    </div>

</div>
@endsection('content')
