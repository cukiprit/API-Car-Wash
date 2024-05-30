<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature for index services routes
     */
    public function testIndex()
    {
        $response = $this->getJson('/api/services');

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'car_type',
                    'price',
                    'description',
                    'created_at',
                    'update_at'
                ]
            ]
        ]);
    }

    /**
     * A basic feature for store services routes
     */
    public function testStore()
    {
        $data = [
            'car_type' => 'small/medium',
            'service_type' => 'Express Glow',
            'price' => 100.00,
            'description' => 'Quick and efficient service.'
        ];

        $response = $this->postJson('/api/services', $data);

        $response->assertStatus(201)->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'car_type',
                'service_type',
                'price',
                'description',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * A basic feature for show services routes
     */
    public function testShow()
    {
        $service = Service::factory()->create();

        $response = $this->getJson("/api/services/{$service->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'car_type',
                'service_type',
                'price',
                'description',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * A basic feature for update services routes
     */
    public function testUpdate()
    {
        $service = Service::factory()->create();

        $data = [
            'car_type' => 'large/big/suv',
            'service_type' => 'Hidrolik Glow',
            'price' => 150.00,
            'description' => 'Comprehensive service.'
        ];

        $response = $this->putJson("/api/services/{$service->id}", $data);

        $response->assertStatus(200)->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $service->id,
                'car_type' => 'large/big/suv',
                'service_type' => 'Hidrolik Glow',
                'price' => 150.00,
                'description' => 'Comprehensive service.'
            ]
        ]);
    }

    /**
     * A basic feature for destroy services routes
     */
    public function testDestroy()
    {
        $service = Service::factory()->create();

        $response = $this->deleteJson("/api/services/{$service->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => 'Service Deleted!'
            ]);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
