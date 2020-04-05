@component('mail::message')
# Post that you've commented has new comment!

Hi {{ $user->name }}!

New comment has been added to the blog post "{{ $comment->commentable->title }}" where you've left a comment.

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable])])
the blogpost
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user])])
comment's author profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
