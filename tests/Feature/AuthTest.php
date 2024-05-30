<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test for handling register
     */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'password' => 'password123'
        ]);

        $response->assertStatus(201)->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'username'
            ],
            'access_token',
            'token_type'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $response->json('data.username')
        ]);
    }

    /**
     * Test for handling login
     */
    public function user_can_login()
    {
        $password = 'password';
        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        $response = $this->postJson('/api/login', [
            'username' => $user->username,
            'password' => $password
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'access_token',
            'token_type'
        ]);
    }

    /**
     * Test for handling logout
     */
    public function user_can_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

        $response->assertstatus(200)->assertJson([
            'status' => 'success',
            'message' => 'Logout successful'
        ]);
    }
}
