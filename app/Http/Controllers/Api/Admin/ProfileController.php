<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return $this->respondUnauthorized();
        }

        return $this->respondWithProfileData($user);
    }

    private function getAuthenticatedUser()
    {
        return Auth::user();
    }

    private function respondUnauthorized()
    {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated'
        ], 401);
    }

    private function respondWithProfileData($user)
    {
        $userData = $user->toArray();
        $userData['profile_picture'] = $this->getProfilePictureUrl($user->profile_picture);

        return response()->json([
            'status' => true,
            'message' => 'Profile information',
            'data' => $userData
        ]);
    }

    private function getProfilePictureUrl($profilePicture)
    {
        return $profilePicture ? asset('storage/' . $profilePicture) : null;
    }


    public function profile_update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        
        if ($request->hasFile('profile_picture')) {
            $profilePictureUpdated = $this->handleProfilePictureUpload($request, $user);

            if (!$profilePictureUpdated) {
                return $this->respondProfilePictureError();
            }
        }

        $this->updateUserProfile($user, $request);

        return $this->respondProfileUpdateSuccess($user);
    }


    private function handleProfilePictureUpload($request, $user)
    {
        try {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            return true;
        } catch (\Exception $e) {
            // $this->profilePictureError = $e->getMessage();
            return false;
        }
    }

    private function updateUserProfile($user, $request)
    {
        $user->update($request->only(['name', 'phone', 'address', 'gender']));
    }


    private function respondProfilePictureError()
    {
        return response()->json([
            'status' => false,
            'message' => 'The profile picture failed to upload.',
            // 'errors' => [
            //     'profile_picture' => [$this->profilePictureError]
            // ]
        ], 500);
    }

    private function respondProfileUpdateSuccess($user)
    {
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $this->formatUserProfileResponse($user)
        ]);
    }

    private function formatUserProfileResponse($user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'gender' => $user->gender,
            'profile_picture' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
        ];
    }


    public function removeProfilePicture(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            $path = str_replace('/storage/', '', $user->profile_picture);
            Storage::disk('public')->delete($path);

            $user->profile_picture = null;
            $user->save();


            return response()->json([
                'status' => true,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No profile picture to remove.',
        ]);
    }
}
