<p>
    @foreach ($tags as $tag)
        <a href="{{ route('posts.tags.index', ['tag' => $tag->name]) }}" class="badge badge-success badge-lg" style="font-size:1.0rem">
            {{ $tag->name }}
        </a>
    @endforeach
</p>
