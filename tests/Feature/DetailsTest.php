<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        $response = $this->post('/api/details', [
            "name" => "John Doe",
            "email" => "jd@test.com",
            "ip_address" => "192.168.0.0"
        ]);

        $response->assertStatus(200);
    }

    public function test_index()
    {
        $response = $this->get('/api/details', [
            "name" => "John Doe",
            "email" => "jd@test.com",
            "ip_address" => "192.168.0.0"
        ]);

        $response->assertStatus(200);
    }

    public function test_show()
    {
        $response = $this->get('/api/details/1', [
            "name" => "John Doe",
            "email" => "jd@test.com",
            "ip_address" => "192.168.0.0"
        ]);

        $response->assertStatus(200);
    }
}
