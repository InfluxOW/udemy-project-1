{{-- @if ($item->comments)
    @forelse ($item->comments()->with('user', 'tags')->get() as $comment)
        <p>{{ $comment->content }}</p>
        <x-tags :tags="$comment->tags"/>
        <x-creation-info :model="$comment"/>
    @empty
        {{ __('No comments yet!') }}<br>
    @endforelse
@endif --}}

@forelse ($comments as $comment)
    <p>{{ $comment->content }}</p>
    <x-tags :tags="$comment->tags"/>
    <x-creation-info :model="$comment"/>
@empty
    {{ __('No comments yet!') }}<br>
@endforelse



<div>{{ $comments->links() }}</div>
