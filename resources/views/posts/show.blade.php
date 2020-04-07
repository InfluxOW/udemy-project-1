@extends('layouts.app')

@section('content')
<x-errors/>
<div class="row">
    <div class="col-8">
        <div class="polaroid-post">
            <div class="container">
                <h1>
                    <div class="text-center">{{ $post->title }}
                        <x-badge :date="$post->created_at">
                            {{__('New')}}!
                        </x-badge>
                    </div>
                </h1>
            </div>
            @if ($post->image)
                <img src="{{ $post->image->url() }}"style="width:100%">
            @endif
        </div>
        <div class="container">
            <p class="text-center">{{ $post->content }}</p>
        </div>

        <p>
            @if ($post->tags->first())
                <x-tags :tags="$post->tags"/>
            @endif
        </p>

        <x-creation-info :model="$post"/>

        @auth
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            @endcan
            @if (!$post->trashed())
                @can('delete', $post)
                    <a href="{{ route('posts.destroy', $post) }}" data-confirm="Are you sure?" data-method="delete" rel="nofollow" class="btn btn-primary">{{ __('Delete') }}</a>
                @endcan
            @endif
        @endauth

        <hr>
        <h4>{{__('Comments')}}</h4>

        <x-comment-form :route="route('posts.comments.store', compact('post'))"/>
        <x-comment-list :item="$post"/>

    </div>


    <div class="col-4 text-center">
        @include('posts._activity')
    </div>
</div>
@endsection('content')
