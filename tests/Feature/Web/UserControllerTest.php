<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testing actions as a guest

    public function testGuestShow()
    {
        $user = $this->user();
        $response = $this->get(route('users.show', $user));
        $response->assertRedirect(route('login'));
    }

    public function testGuestEdit()
    {
        $user = $this->user();
        $response = $this->get(route('users.edit', $user));
        $response->assertRedirect(route('login'));
    }

    public function testGuestUpdate()
    {
        $user = $this->user();
        $response = $this->patch(route('users.show', $user), ['name' => 'Random Name']);
        $response->assertRedirect(route('login'));
    }

    //Testing actions as a user

    public function testUserShow()
    {
        $user = $this->user();
        $response = $this->actingAs($user)->get(route('users.show', $user));
        $response->assertStatus(200);
    }

    public function testUserEdit()
    {
        $user = $this->user();
        $response = $this->actingAs($user)->get(route('users.edit', $user));
        $response->assertStatus(200);
    }

    public function testUserUpdateSuccess()
    {
        $user = $this->user();
        $params = ['name' => 'Random Name', 'locale' => 'ru'];

        $response = $this->actingAs($user)->patch(route('users.show', $user), $params);
        $response->assertStatus(302)
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("users", $params);
    }

    public function testUserUpdateFail()
    {
        $user = $this->user();
        $params = ['name' => ''];

        $response = $this->actingAs($user)->patch(route('users.show', $user), $params);
        $response->assertStatus(302)
            ->assertSessionHasErrors();
        $this->assertDatabaseMissing("users", $params);
    }
}
