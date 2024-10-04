<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Storage;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileTest extends TestCase
{
    
    public function test_user_can_view_profile()
    {
        
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        
        $token = $response->json('token');

        
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ]);

        
        $profileResponse = $this->getJson('/api/dashboard'); 

        
        $profileResponse->assertStatus(200)
                        ->assertJson([
                            'status' => true,
                            'message' => 'Profile information',
                            'data' => [
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                            ],
                        ]);
    }


    public function user_cannot_view_profile_without_authentication()
    {
        $response = $this->getJson('/api/dashboard');

        $response->assertStatus(401)
                 ->assertJson([
                     'status' => false,
                     'message' => 'User not authenticated',
                 ]);
    }

    public function user_can_update_profile()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->json('POST', '/api/profile_update', [
            'name' => 'New Name',
            'phone' => '1234567890',
            'address' => 'New Address',
            'gender' => 'Other',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Profile updated successfully',
                     'data' => [
                         'name' => 'New Name',
                         'email' => $user->email,
                         'phone' => '1234567890',
                         'address' => 'New Address',
                         'gender' => 'Other',
                         'profile_picture' => null,
                     ]
                 ]);

        $user->refresh();
        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('1234567890', $user->phone);
        $this->assertEquals('New Address', $user->address);
        $this->assertEquals('Other', $user->gender);
    }

    public function user_can_update_profile_with_profile_picture()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Passport::actingAs($user);

        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->json('POST', '/api/profile_update', [
            'name' => 'New Name',
            'phone' => '1234567890',
            'address' => 'New Address',
            'gender' => 'Other',
            'profile_picture' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Profile updated successfully',
                     'data' => [
                         'name' => 'New Name',
                         'email' => $user->email,
                         'phone' => '1234567890',
                         'address' => 'New Address',
                         'gender' => 'Other',
                         'profile_picture' => asset('storage/profile_pictures/' . $file->hashName()),
                     ]
                 ]);

        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('1234567890', $user->phone);
        $this->assertEquals('New Address', $user->address);
        $this->assertEquals('Other', $user->gender);
        Storage::disk('public')->assertExists('profile_pictures/' . $file->hashName());
    }

    public function user_can_remove_profile_picture()
    {
        Storage::fake('public');

        $user = User::factory()->create(['profile_picture' => 'profile_pictures/old_picture.jpg']);

        Storage::disk('public')->put('profile_pictures/old_picture.jpg', 'image content');

        Passport::actingAs($user);

        $response = $this->json('POST', '/api/remove_profile_picture');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                 ]);

        $user->refresh();
        $this->assertNull($user->profile_picture);
        Storage::disk('public')->assertMissing('profile_pictures/old_picture.jpg');
    }

    public function user_cannot_remove_profile_picture_when_none_exists()
    {
        $user = User::factory()->create(['profile_picture' => null]);

        Passport::actingAs($user);

        $response = $this->json('POST', '/api/remove_profile_picture');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => false,
                     'message' => 'No profile picture to remove.',
                 ]);
    }
}
