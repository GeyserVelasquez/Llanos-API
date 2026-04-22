<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{

    public function test_guest_cannot_register_new_user(): void
    {
        $response = $this->postJson('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_authenticated_user_can_register_new_user(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->postJson('/register', [
                'name' => 'New Veterinarian',
                'email' => 'vet@finca.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', [
            'email' => 'vet@finca.com'
        ]);
    }
}
