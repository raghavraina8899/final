<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    /**
     * Test successful login process.
     */
    public function test_successful_login()
    {
        // Create a mock user
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'), // Hashed password
            'is_first_login' => false,
        ]);

        // Send login request
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Assert the response contains the token and successful login message
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Login successful',
            ]);

        // Assert that the user received an access token
        $this->assertArrayHasKey('token', $response->json());
    }

    /**
     * Test login fails with an invalid password.
     */
    public function test_login_fails_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Send login request with wrong password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Assert the response contains an invalid password message
        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
                'message' => "Password didn't match",
            ]);
    }

    /**
     * Test login fails with non-existent email.
     */
    public function test_login_fails_with_nonexistent_email()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        // Assert the response contains an invalid email message
        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
                'message' => 'Invalid Email value',
            ]);
    }

    /**
     * Test first-time login redirects to reset password.
     */
    public function test_first_time_login_redirects_to_reset_password()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'is_first_login' => true,
        ]);

        // Send login request
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Assert the response contains first-time login message
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'First-time login detected. Redirecting to reset password.',
                'reset_password_required' => true,
            ]);
    }

    /**
     * Test login fails when email is missing.
     */
    public function test_login_fails_when_email_is_missing()
    {
        // Send login request without email
        $response = $this->postJson('/api/login', [
            'password' => 'password123',
        ]);

        // Assert the response contains validation error for email
        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /**
     * Test login fails when password is missing.
     */
    public function test_login_fails_when_password_is_missing()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
        ]);

        // Assert the response contains validation error for password
        $response->assertStatus(422)
            ->assertJsonValidationErrors('password');
    }

    /**
     * Test first-time password reset.
     */
    public function test_first_time_password_reset()
    {
        // Create a user who is logging in for the first time
        $user = User::factory()->create([
            'is_first_login' => true,
            'password' => Hash::make('password123'),
        ]);

        // Act as this user with a valid API token
        Passport::actingAs($user);

        // Send the request to reset the password
        $response = $this->postJson('/api/first', [
            'new_password' => 'ValidPassword123!',
        ]);

        // Assert success
        $response->assertStatus(200);
    }

    /**
     * Test unauthorized first-time password reset.
     */
    public function test_unauthorized_first_time_password_reset()
    {
        // Simulate unauthorized user or already logged in user who is not in first login state
        $user = User::factory()->create([
            'is_first_login' => false,
        ]);

        Passport::actingAs($user);

        $response = $this->postJson('/api/first', [
            'new_password' => 'Newpassword@123',
        ]);

        // Assert unauthorized response
        $response->assertStatus(403)
            ->assertJson([
                'status' => false,
                'message' => 'User is not authorized for this action.',
            ]);
    }


    public function tearDown(): void
{
    // Clean up users with the same email
    User::where('email', 'user@example.com')->delete();

    parent::tearDown();
}

}
