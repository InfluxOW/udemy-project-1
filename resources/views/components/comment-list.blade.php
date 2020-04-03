@if ($item->comments)
    @forelse ($item->comments()->with('user')->get() as $comment)
        <p>{{ $comment->content }}</p>
        <x-creation-info :model="$comment"/>
    @empty
        No comments yet!<br>
    @endforelse
@endif