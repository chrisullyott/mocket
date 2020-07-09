<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run test setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
    }

    /**
     * @test A user is redirected to the login screen.
     */
    public function user_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * @test An existing user can log in and is taken to the home screen.
     */
    public function existing_user_can_log_in(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }
}
