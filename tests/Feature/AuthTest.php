<?php

namespace Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a user using the API requests.
     *
     * @return void
     */
    public function test_api_register_user()
    {

        $user = [
            'name' => 'Test User',
            'email' => 'testuser@galiweather.com',
            'password' => 'secret',
            'confirm_password' => 'secret'
        ];

        $response = $this->post('/api/register', $user);
        $response->assertStatus(200);
    }
}
