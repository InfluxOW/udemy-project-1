<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testing actions as a guest

    public function testGuestStoreSuccess()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'Good comment'];

        $response = $this->post(route('posts.comments.store', $post), $data);
        $response->assertRedirect(route('login'));
    }

    //Testing actions as a user

    public function testUserStoreSuccess()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'Good comment'];

        $response = $this->actingAs($post->user)->post(route('posts.comments.store', $post), $data);
        $response->assertStatus(302)
        ->assertSessionHasNoErrors();
    }

    public function testUserStoreFail()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'shrt'];

        $response = $this->actingAs($post->user)->post(route('posts.comments.store', $post), $data);
        $response->assertStatus(302)
        ->assertSessionHasErrors();
    }
}
