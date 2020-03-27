@extends('layouts.app')

@section('content')
<div class="row">

@if (Session::has('success'))
<div class="container">
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('success') }}</strong>
    </div>
</div>
@endif
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

        @if ($post->comments_count)
            {{ $post->comments_count }} {{ $post->comments_count == 1 ? 'comment' : 'comments' }}
        @else
            No comments yet!
        @endif

        @component('components.creation-info', ['date' => $post->created_at, 'name' => $post->user->name])
        @endcomponent

    </p>
    @empty
        <h3>No blog posts yet!</h3>
    @endforelse
    <div>{{$posts->links()}}</div>
    </div>
    <div class="col-4 text-center">
        <div class="container">
            <div class="row">
                @component('components.card', ['title' => 'Most Commented Posts', 'subtitle' => 'What people are currently talking about?'])
                    @slot('items')
                        @foreach ($mostCommentedPosts as $post)
                        <li class="list-group-item">
                            <a href="{{ route('posts.show', compact('post')) }}">
                                {{ $post->title }}
                            </a>
                        </li>
                        @endforeach
                    @endslot
                @endcomponent
            </div>
            <div class="row mt-3">
                @component('components.card', ['title' => 'Most Active Users', 'subtitle' => 'Users with the most posts!'])
                    @slot('items', collect($mostActiveUsers)->pluck('name'));
                @endcomponent
            </div>
            <div class="row mt-3">
                @component('components.card', ['title' => 'Most Active Last Month Users', 'subtitle' => 'Users with the most posts last month!'])
                    @slot('items', collect($mostActiveLastMonthUsers)->pluck('name'));
                @endcomponent
            </div>
        </div>
    </div>
</div>
@endsection('content')
