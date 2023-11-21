<?php

namespace Tests\Feature;

use Database\Factories\PlaceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaceControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_index_places(): void
    {
        $places = PlaceFactory::new()->count(5)->create();

        $response = $this->get('/api/places');

        $response->assertStatus(200);

        foreach ($places as $place)
            $response->assertJsonFragment([
                'name' => $place->name,
                'city' => $place->city,
                'state' => $place->state,
            ]);
    }

    /** @test */
    public function it_can_filter_places_by_name(): void
    {
        PlaceFactory::new()->count(3);

        $data = [
            'name' => 'A Very Specific Name',
            'city' => 'A Very Specific City',
            'state' => 'A Very Specific State',
        ];
        
        PlaceFactory::new()->create($data);

        $response = $this->json('GET', 'api/places', ['name' => 'A Very Specific']);

        $response->assertStatus(200)
                    ->assertJsonFragment($data);
    }
    
    /** @test */
    public function it_can_store_a_place(): void
    {
        $data = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State',
        ];
        
        $response = $this->json('POST', 'api/places', $data);

        $response->assertStatus(201)
                    ->assertJsonFragment($data);

        $this->assertDatabaseHas('places', $data);
    }

    /** @test */
    public function it_cant_store_a_place_without_name(): void
    {
        $data = [
            'city' => 'Test City',
            'state' => 'Test State',
        ];

        $response = $this->json('POST', 'api/places', $data);

        $response->assertStatus(422)
                    ->assertJsonFragment([
                        "message" => "The name field is required.",
                        "errors" => [
                            "name" => [
                                "The name field is required."
                            ]
                        ]
                    ]);
    }

    /** @test */
    public function it_cant_store_a_place_without_city(): void
    {
        $data = [
            'name' => 'Test name',
            'state' => 'Test State',
        ];

        $response = $this->json('POST', 'api/places', $data);

        $response->assertStatus(422)
                    ->assertJsonFragment([
                        "message" => "The city field is required.",
                        "errors" => [
                            "city" => [
                                "The city field is required."
                            ]
                        ]
                    ]);   
    }

    /** @test */
    public function it_cant_store_a_place_without_state(): void
    {
        $data = [
            'name' => 'Test name',
            'city' => 'Test City',
        ];

        $response = $this->json('POST', 'api/places', $data);

        $response->assertStatus(422)
                    ->assertJsonFragment([
                        "message" => "The state field is required.",
                        "errors" => [
                            "state" => [
                                "The state field is required."
                            ]
                        ]
                    ]);
    }

    /** @test */
    public function it_can_update_a_place(): void
    {
        $place = PlaceFactory::new()->create();

        $updatedData = [
            'name' => 'Updated Place',
            'city' => 'Updated City',
            'state' => 'Updated State',
        ];

        $response = $this->json('PUT', "/api/places/{$place->slug}", $updatedData);

        $response->assertStatus(200)
                    ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('places', $updatedData);
    }

    /** @test */
    public function it_can_show_a_place(): void
    {
        $data = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State',
        ];
        
        $response = $this->json('POST', 'api/places', $data);
        
        $response = $this->get('/api/places/test-place');

        $response->assertStatus(200)
                    ->assertJsonFragment($data);
    }

    /** @test */
    public function it_can_delete_a_place(): void
    {
        $data = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'state' => 'Test State',
        ];
        
        $this->json('POST', 'api/places', $data);   

        $this->delete('/api/places/test-place')
                ->assertStatus(204);

        $this->assertDatabaseMissing('places', $data);
    }
}
