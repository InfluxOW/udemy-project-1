<div class="mb-2 mt-2">
    @auth
    {{ Form::model(['url' => '#']) }}
        {{ Form::textarea('content', $comment->content ?? '', ['class' => 'form-control', 'rows' => 3]) }}<br>
        {{ Form::submit('Add comment', ['class' => 'btn btn-primary btn-block']) }}
    {{ Form::close() }}
    @else
        <hr>
        You have to <a href="{{ route('login') }}">sign in</a> to post a comment.
    @endauth
</div>
<hr>
