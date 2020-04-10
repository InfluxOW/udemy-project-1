<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCommentControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testing actions as a guest

    public function testGuestStoreSuccess()
    {
        $data = ['content' => 'Good comment'];

        $response = $this->post(route('users.comments.store', $this->user()), $data);
        $response->assertRedirect(route('login'));
    }

    //Testing actions as a user

    public function testUserStoreSuccess()
    {
        $data = ['content' => 'Good comment'];
        $user = $this->user();

        $response = $this->actingAs($user)->post(route('users.comments.store', $user), $data);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();
    }

    public function testUserStoreFail()
    {
        $data = ['content' => 'shrt'];
        $user = $this->user();

        $response = $this->actingAs($user)->post(route('users.comments.store', $user), $data);
        $response->assertStatus(302)
            ->assertSessionHasErrors();
    }
}
