<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Prevent emails from being sent
        Queue::fake();
    }

    /**
     * Test successful user registration.
     */
    public function test_successful_user_registration()
    {
        // Generate fake user data
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Str::random(10),
        ];

        // Send the registration request
        $response = $this->postJson('/api/register', $userData);

        // Check if response contains success message
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'User Registered Successfully',
                 ]);

        // Check if user is stored in the database
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'is_first_login' => true
        ]);

        // Check if the email was dispatched
        Queue::assertPushed(SendEmailJob::class, function ($job) use ($userData) {
            return $job->email === $userData['email'];
        });
    }
    public function test_registration_fails_when_name_is_missing()
    {
        $userData = [
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Str::random(10),
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422) // 422 Unprocessable Entity (validation error)
                 ->assertJsonValidationErrors('name');
    }

    /**
     * Test registration fails when email is missing.
     */
    public function test_registration_fails_when_email_is_missing()
    {
        $userData = [
            'name' => $this->faker->name,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => Str::random(10),
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422) // 422 Unprocessable Entity (validation error)
                 ->assertJsonValidationErrors('email');
    }

    /**
     * Test registration fails when phone is missing.
     */
    public function test_registration_fails_when_phone_is_missing()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Str::random(10),
            // Assume 'phone' is a required field in your form validation
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422) // 422 Unprocessable Entity (validation error)
                 ->assertJsonValidationErrors('phone');
    }

    /**
     * Test registration fails when all required fields are missing.
     */
    public function test_registration_fails_when_all_required_fields_are_missing()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422) // 422 Unprocessable Entity (validation error)
                 ->assertJsonValidationErrors(['name', 'email', 'phone']);
    }
}
