<?php

namespace Tests\Feature\Web;

use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $post = $this->createTestBlogPost();
        $tag = Tag::create(['name' => 'random']);
        $post->tags()->sync($tag);

        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }
}
