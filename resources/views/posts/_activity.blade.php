<div class="container">
    <div class="row">
        @component('components.card', ['title' => 'Most Commented Posts', 'subtitle' => 'What people are currently talking about?'])
            @slot('items')
                @foreach ($mostCommentedPosts as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', compact('post')) }}">
                        {{ $post->title }}
                    </a>
                </li>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="row mt-3">
        @component('components.card', ['title' => 'Most Active Users', 'subtitle' => 'Users with the most posts!'])
            @slot('items', collect($mostActiveUsers)->pluck('name'));
        @endcomponent
    </div>
    <div class="row mt-3">
        @component('components.card', ['title' => 'Most Active Last Month Users', 'subtitle' => 'Users with the most posts last month!'])
            @slot('items', collect($mostActiveLastMonthUsers)->pluck('name'));
        @endcomponent
    </div>
</div>
