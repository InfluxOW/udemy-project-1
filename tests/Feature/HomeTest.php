<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function testContactPageIsWorkingCorrectly()
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }
}
