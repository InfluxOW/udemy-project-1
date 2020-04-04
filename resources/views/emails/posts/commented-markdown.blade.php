@component('mail::message')
# You have new comment!

Hi {{ $comment->commentable->user->name }}!

New comment has been added to your blog post "{{ $comment->commentable->title }}".

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable])])
your blogpost
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user])])
author profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
