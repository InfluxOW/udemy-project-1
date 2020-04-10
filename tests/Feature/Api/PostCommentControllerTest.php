<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testing actions as a guest

    public function testGuestStore()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'Not authorized comment'];

        $response = $this->json('POST', route('api.posts.comments.store', $post), $data);
        $response->assertUnauthorized();
    }

    public function testGuestDestroy()
    {
        $post = $this->createTestBlogPost();

        $response = $this->json('DELETE', route('api.posts.comments.destroy', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]));
        $response->assertUnauthorized();
    }

    public function testGuestUpdate()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'shrt'];

        $response = $this->json('PATCH', route('api.posts.comments.update', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]), $data);
        $response->assertStatus(401)
            ->assertJsonMissing($data);
    }

    //Testing actions as a user

    public function testUserStoreSuccess()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'Good comment'];

        $response = $this->actingAs($post->user, 'api')->json('POST', route('api.posts.comments.store', $post), $data);
        $response->assertStatus(201);
    }

    public function testUserStoreFail()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'shrt'];

        $response = $this->actingAs($post->user, 'api')->json('POST', route('api.posts.comments.store', $post), $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors('content');
    }

    public function testUserUpdateSuccess()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'just a comment'];

        $response = $this->actingAs($post->user, 'api')->json('PATCH', route('api.posts.comments.update', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]), $data);
        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'content']);
    }

    public function testUserUpdateFail()
    {
        $post = $this->createTestBlogPost();
        $data = ['content' => 'shrt'];

        $response = $this->actingAs($post->user, 'api')->json('PATCH', route('api.posts.comments.update', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]), $data);
        $response->assertStatus(422)
            ->assertJsonMissing(['id', 'content']);
    }

    public function testUserDestroy()
    {
        $post = $this->createTestBlogPost();

        $response = $this->actingAs($post->user, 'api')->json('DELETE', route('api.posts.comments.destroy', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]));
        $response->assertStatus(204);
    }

    //Testing actions that both users and guests are able to perform

    public function testIndex()
    {
        $post = $this->createTestBlogPost();
        $response = $this->json('GET', route('api.posts.comments.index', $post));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'user']
                ],
                'links',
                'meta'])
            ->assertJsonCount(1, 'data');
    }

    public function testShow()
    {
        $post = $this->createTestBlogPost();

        $response = $this->json('GET', route('api.posts.comments.show', [
            'post' => $post, 'comment' => $post->comments()->first()
            ]));
        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'content']);
    }
}
