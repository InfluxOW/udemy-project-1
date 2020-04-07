@component('mail::message')
# {{ __('You have new comment!') }}

{{ __('Hi') }} {{ $comment->commentable->user->name }}!

{{ __('New comment has been added to your blog post') }} "{{ $comment->commentable->title }}".

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable])])
{{ __('your blogpost') }}
@endcomponent

{{-- <img src="{{ $message->embed(storage_path("app/public") . '/' . $comment->user->image->path) }}" width=128 height=128> --}}
@component('mail::button', ['url' => route('users.show', ['user' => $comment->user])])
{{ __('author profile') }}
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
