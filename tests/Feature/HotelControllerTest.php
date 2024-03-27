<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelControllerTest extends TestCase
{
    public function test_success_search()
    {
        $response = $this->get('/hotels/search?name=Media One Hotel');
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'name' => 'Media One Hotel'
            ]);
    }

    public function test_failed_API()
    {
        config(['services.hotels_api_url' => 'invalid-url']);

        $response = $this->get('/hotels/search?name=Media One Hotel');
        $response->assertStatus(500)
            ->assertJson(['error' => 'Failed to fetch hotel data']);
    }
}
