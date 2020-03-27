<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostsIndex()
    {
        $this->createTestBlogPost();
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }

    public function testPostsShow()
    {
        $post = $this->createTestBlogPost();
        $response = $this->get(route('posts.show', compact('post')));
        $response->assertStatus(200);
    }

    public function testStoreValid()
    {
        $params = ['title' => 'test title', 'content' => 'test content'];
        $this->actingAs($this->user())
            ->post(route('posts.index', $params))
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
    }

    public function testStoreFail()
    {
        $params = ['title' => 'test', 'content' => str_repeat('test', 300)];
        $this->actingAs($this->user())
            ->post(route('posts.index'), $params)
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    public function testUpdateValid()
    {
        $post = $this->createTestBlogPost();

        $editedParams = ['title' => 'edited test title', 'content' => 'edited test content'];
        $this->actingAs($post->user)
            ->put(route('posts.update', $post), $editedParams)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("blog_posts", $editedParams);
    }

    public function testDeleteValid()
    {
        $post = $this->createTestBlogPost();
        $this->assertDatabaseHas("blog_posts", ['id' => $post->id]);

        $this->actingAs($post->user)
            ->delete(route('posts.destroy', $post))
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertSoftDeleted("blog_posts", ['id' => $post->id]);
    }

    private function createTestBlogPost($userId = null): BlogPost
    {
        $post = factory(BlogPost::class)->create();
        $user = factory(User::class)->create();
        $post->user()->associate($user)->save();
        return $post;
    }
}
