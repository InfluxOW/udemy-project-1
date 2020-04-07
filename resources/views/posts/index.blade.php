@extends('layouts.app')

@section('content')
<x-errors/>

<div class="row">
    <div class="col-8">
        @foreach ($posts as $post)
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

            <p>
                {{ trans_choice('messages.comments', $post->comments_count) }}
            </p>

        </p>
        @endforeach

        <div>{{$posts->links()}}</div>
    </div>

    <div class="col-4 text-center">
        @include('posts._activity')
    </div>

</div>
@endsection('content')
