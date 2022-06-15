<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Providers\RouteServiceProvider;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_display_login_view()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'invalid-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
        $response->assertRedirect(route('login'));
    }

    public function test_authenticate_user()
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
