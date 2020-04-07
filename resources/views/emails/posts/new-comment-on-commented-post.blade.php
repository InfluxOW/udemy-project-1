@component('mail::message')
# {{ __("Post that you've commented has new comment!") }}

{{ __('Hi') }} {{ $user->name }}!

{{ __('New comment has been added to the blog post') }} "{{ $comment->commentable->title}}" {{ __("where you've left a comment") }}

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable])])
{{ __('the blogpost') }}
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user])])
{{ __("comment's author profile") }}
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

{{ __('Thanks') }},<br>
{{ config('app.name') }}
@endcomponent
