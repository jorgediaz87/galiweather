<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
class UserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Basic test to persist 5 users in the database
     *
     * @return void
     */
    public function test_create_db_users()
    {
        $user = User::factory()->count(5)->create();

        $this->assertDatabaseCount('users', 5);
    }

    /**
     * Creating a test user in the db, then deletes it.
     *
     * @return void
     */
    public function test_delete_db_users()
    {
        $user = User::factory()->create([
            'name' => 'Test Delete User',
        ]);

        $user->delete();

        $this->assertDeleted($user);
    }
}
