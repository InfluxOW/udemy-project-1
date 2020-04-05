@component('mail::message')
# You have new comment!

Hi {{ $comment->commentable->user->name }}!

New comment has been added to your blog post "{{ $comment->commentable->title }}".

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable])])
your blogpost
@endcomponent

{{-- <img src="{{ $message->embed(storage_path("app/public") . '/' . $comment->user->image->path) }}" width=128 height=128> --}}
@component('mail::button', ['url' => route('users.show', ['user' => $comment->user])])
author profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent