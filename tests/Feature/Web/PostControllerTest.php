<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testing actions as a guest

    public function testGuestStore()
    {
        $params = ['title' => 'test title', 'content' => 'test content'];
        $response = $this->post(route('posts.store'), $params);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('blog_posts', $params);
    }

    public function testGuestUpdate()
    {
        $post = $this->createTestBlogPost();
        $editedParams = ['title' => 'edited test title', 'content' => 'edited test content'];
        $response = $this->patch(route('posts.update', $post), $editedParams);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('blog_posts', $editedParams);
    }

    public function testGuestDelete()
    {
        $post = $this->createTestBlogPost();
        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'content' => $post->content]);
    }

    //Testing actions as a user

    public function testUserStoreSuccess()
    {
        $params = ['title' => 'test title', 'content' => 'test content'];
        $this->actingAs($this->user())
            ->post(route('posts.store'), $params)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
    }

    public function testUserStoreFail()
    {
        $params = ['title' => 'test', 'content' => str_repeat('test', 300)];
        $this->actingAs($this->user())
            ->post(route('posts.index'), $params)
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    public function testUserUpdateSuccess()
    {
        $post = $this->createTestBlogPost();

        $editedParams = ['title' => 'edited test title', 'content' => 'edited test content'];
        $this->actingAs($post->user)
            ->patch(route('posts.update', $post), $editedParams)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("blog_posts", $editedParams);
    }

    public function testUserUpdateFail()
    {
        $post = $this->createTestBlogPost();

        $editedParams = ['title' => 'short', 'content' => 'short'];
        $this->actingAs($post->user)
            ->patch(route('posts.update', $post), $editedParams)
            ->assertStatus(302)
            ->assertSessionHasErrors();
        $this->assertDatabaseMissing("blog_posts", $editedParams);
    }

    public function testUserDeleteSuccess()
    {
        $post = $this->createTestBlogPost();
        $this->assertDatabaseHas("blog_posts", ['id' => $post->id]);

        $this->actingAs($post->user)
            ->delete(route('posts.destroy', $post))
            ->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertSoftDeleted("blog_posts", ['id' => $post->id]);
    }

    //Testing actions that both users and guests are able to perform

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
}
