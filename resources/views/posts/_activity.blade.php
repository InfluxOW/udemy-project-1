<div class="container">
    <div class="row">
        <x-card title="Most Commented Posts" subtitle="What people are currently talking about?">
            <x-slot name="items">
                @foreach ($mostCommentedPosts as $post)
                <li class="list-group-item">
                    <a href="{{ route('posts.show', compact('post')) }}">
                        {{ $post->title }}
                    </a>
                </li>
                @endforeach
            </x-slot>
        </x-card>
    </div>
    <div class="row mt-3">
        <x-card title="Most Active Users" subtitle="Users with the most posts!"
        :items="collect($mostActiveUsers)->pluck('name')"/>
    </div>
    <div class="row mt-3">
        <x-card title="Most Active Last Month Users" subtitle="Users with the most posts last month!"
        :items="collect($mostActiveLastMonthUsers)->pluck('name')"/>
    </div>
</div>
