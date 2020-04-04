<style>
    body {
        font-family: Arial, Helvetica, Sans-Serif;
    }
</style>

<p>Hi {{ $comment->commentable->user->name }}!</p>

<p>
    Comment has been added to your blog post
    <a href="{{ route('posts.show', ['post' => $comment->commentable]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>

<hr/>

<p>
    <img src="{{ $message->embed(storage_path("app/public") . '/' . $comment->user->image->path) }}" width=128 height=128>
    <a href="{{ route('users.show', ['user' => $comment->user]) }}">
        {{ $comment->user->name }}
    </a> said:
</p>

<p>
    "{{ $comment->content }}"
</p>
