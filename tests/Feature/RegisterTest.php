<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Providers\RouteServiceProvider;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_display_register_view()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_register_user()
    {
        $response = $this->post(route('register'), [
            'name'                  => 'New User',
            'email'                 => 'new.user@micasino.com',
            'password'              => 'micasino',
            'password_confirmation' => 'micasino',
        ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'New User',
            'email' => 'new.user@micasino.com'
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
