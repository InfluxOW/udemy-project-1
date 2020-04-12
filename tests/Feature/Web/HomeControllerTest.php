<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomeIndex()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function testContactIndex()
    {
        $response = $this->get(route('info'));
        $response->assertStatus(200);
    }
}
