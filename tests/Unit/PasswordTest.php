<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordTest extends TestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'password' => Hash::make('current_password')
        ]);
    }

    public function test_user_can_update_password()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/password_update', [
            'current_password' => 'current_password',
            'password' => 'Newpassword@123'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => true, 'message' => 'Password updated successfully!']);
        
        $this->assertTrue(Hash::check('Newpassword@123', $this->user->fresh()->password));
    }

    public function test_user_cannot_update_password_with_invalid_current_password()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/password_update', [
            'current_password' => 'WrongPassword@123',
            'password' => 'Newpassword@123'
        ]);

        $response->assertStatus(422)
                 ->assertJson(['message' => 'Current password does not match.']);
    }

    public function test_user_cannot_update_password_if_not_authenticated()
    {
        $response = $this->postJson('/api/password_update', [
            'current_password' => 'current_password',
            'password' => 'new_password'
        ]);

        $response->assertStatus(401);
    }

    public function test_user_can_request_forgot_password()
    {
        // Ensure the user exists
        $userEmail = fake()->unique()->safeEmail();
        User::factory()->create(['email' => $userEmail]);

        $response = $this->postJson('/api/forgotPassword', [
            'email' => $userEmail,
        ]);

        $response->assertStatus(200);
    }


    public function test_user_cannot_request_forgot_password_for_nonexistent_email()
    {
        $response = $this->postJson('/api/forgotPassword', [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertStatus(404) // Expecting a 404 status
                ->assertJson(['status' => false, 'message' => 'User not found']);
    }

    public function test_user_cannot_reset_password_with_invalid_token()
    {
        $response = $this->postJson('/api/reset-password', [
            'token' => 'invalid-token',
            'new_password' => 'Newpassword@123'
        ]);

        $response->assertStatus(400)
                 ->assertJson(['status' => false, 'message' => 'Invalid or expired reset token.']);
    }

    public function test_user_can_check_token_validity()
    {
        $resetToken = 'valid-reset-token';
        $this->user->reset_token = $resetToken;
        $this->user->reset_token_expiration = now()->addMinutes(5);
        $this->user->save();

        $response = $this->getJson('/api/check-token-validity?token=' . $resetToken);

        $response->assertStatus(200)
                 ->assertJson(['status' => true, 'message' => 'Token is valid.']);
    }

    public function test_user_cannot_check_token_validity_with_invalid_token()
    {
        $response = $this->getJson('/api/check-token-validity?token=invalid-token');

        $response->assertStatus(400)
                 ->assertJson(['status' => false, 'message' => 'Token is invalid or expired.']);
    }
}
