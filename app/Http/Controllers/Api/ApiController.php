<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\FirstRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\welcomeemail;
use App\Mail\ForgotPasswordMail;
use App\Mail\welcomeUser;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    private $request;

    // public function register(RegisterRequest $request)
    // {
    //     //job, lang
    //     $password = Str::random(10);

    //     $request->merge(['is_first_login' => true, 'password' => Hash::make($password)]);
    //     $user =User::create($request->all());


    //     SendEmailJob::dispatch($user->email, new welcomeemail($user->name, $user->email, $password));

    //     return response()->json([
    //         "status" => true,
    //         "message" => "User Registered Successfully",
    //     ]);
    // }

    // public function login(LoginRequest $request)
    // {
    //     $user = $this->getUserByEmail($request->email);

    //     if ($user) {
    //         return $this->handleLogin($user, $request->password);
    //     }

    //     return $this->respondInvalidEmail();
    // }

    // private function getUserByEmail($email)
    // {
    //     return User::where('email', $email)->first();
    // }

    // private function handleLogin(User $user, $password)
    // {
    //     if ($this->validatePassword($password, $user->password)) {

    //         $token = $this->generateAccessToken($user);

    //         if ($user->is_first_login) {
    //             return $this->respondFirstTimeLogin($token);
    //         }

    //         return $this->respondLoginSuccess($token);
    //     }

    //     return $this->respondInvalidPassword();
    // }

    // private function validatePassword($inputPassword, $hashedPassword)
    // {
    //     return Hash::check($inputPassword, $hashedPassword);
    // }

    // private function generateAccessToken(User $user)
    // {
    //     return $user->createToken('mytoken')->accessToken;
    // }

    // private function respondFirstTimeLogin($token)
    // {
    //     return response()->json([
    //         "status" => true,
    //         "message" => "First-time login detected. Redirecting to reset password.",
    //         "token" => $token,
    //         "reset_password_required" => true
    //     ]);

    // }

    // private function respondLoginSuccess($token)
    // {
    //     return response()->json([
    //         "status" => true,
    //         "message" => "Login successful",
    //         "token" => $token,
    //         "data" => []
    //     ]);
    // }

    // private function respondInvalidEmail()
    // {
    //     return response()->json([
    //         "status" => false,
    //         "message" => "Invalid Email value",
    //         "data" => []
    //     ]);
    // }

    // private function respondInvalidPassword()
    // {
    //     return response()->json([
    //         "status" => false,
    //         "message" => "Password didn't match",
    //         "data" => []
    //     ]);
    // }



    // public function profile()
    // {
    //     $user = $this->getAuthenticatedUser();

    //     if (!$user) {
    //         return $this->respondUnauthorized();
    //     }

    //     return $this->respondWithProfileData($user);
    // }

    // private function getAuthenticatedUser()
    // {
    //     return Auth::user();
    // }

    // private function respondUnauthorized()
    // {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'User not authenticated'
    //     ], 401);
    // }

    // private function respondWithProfileData($user)
    // {
    //     $userData = $user->toArray();
    //     $userData['profile_picture'] = $this->getProfilePictureUrl($user->profile_picture);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Profile information',
    //         'data' => $userData
    //     ]);
    // }

    // private function getProfilePictureUrl($profilePicture)
    // {
    //     return $profilePicture ? asset('storage/' . $profilePicture) : null;
    // }


    // public function profile_update(ProfileUpdateRequest $request)
    // {
    //     $user = Auth::user();

    //     if ($request->hasFile('profile_picture')) {
    //         $profilePictureUpdated = $this->handleProfilePictureUpload($request, $user);

    //         if (!$profilePictureUpdated) {
    //             return $this->respondProfilePictureError();
    //         }
    //     }

    //     $this->updateUserProfile($user, $request);

    //     return $this->respondProfileUpdateSuccess($user);
    // }

    // private function handleProfilePictureUpload($request, $user)
    // {
    //     try {
    //         if ($user->profile_picture) {
    //             Storage::disk('public')->delete($user->profile_picture);
    //         }

    //         $path = $request->file('profile_picture')->store('profile_pictures', 'public');
    //         $user->profile_picture = $path;
    //         return true;
    //     } catch (\Exception $e) {
    //         // $this->profilePictureError = $e->getMessage();
    //         return false;
    //     }
    // }

    // private function updateUserProfile($user, $request)
    // {
    //     $user->update($request->only(['name', 'phone', 'address', 'gender']));
    // }


    // private function respondProfilePictureError()
    // {
    //     return response()->json([
    //         'status' => false,
    //         'message' => 'The profile picture failed to upload.',
    //         // 'errors' => [
    //         //     'profile_picture' => [$this->profilePictureError]
    //         // ]
    //     ], 500);
    // }

    // private function respondProfileUpdateSuccess($user)
    // {
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Profile updated successfully',
    //         'data' => $this->formatUserProfileResponse($user)
    //     ]);
    // }

    // private function formatUserProfileResponse($user)
    // {
    //     return [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'phone' => $user->phone,
    //         'address' => $user->address,
    //         'gender' => $user->gender,
    //         'profile_picture' => $user->profile_picture ? asset('storage/' . $user->profile_picture) : null,
    //     ];
    // }


    // public function removeProfilePicture(Request $request)
    // {
    //     $user = Auth::user();

    //     if ($user->profile_picture) {
    //         $path = str_replace('/storage/', '', $user->profile_picture);
    //         Storage::disk('public')->delete($path);

    //         $user->profile_picture = null;
    //         $user->save();

    //         return response()->json([
    //             'status' => true,
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => false,
    //         'message' => 'No profile picture to remove.',
    //     ]);
    // }
    // public function password_update(PasswordUpdateRequest $request)
    // {

    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
    //     }

    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return response()->json([
    //             'message' => 'Current password does not match.'
    //         ], 422);
    //     }

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     return response()->json(['status' => true, 'message' => 'Password updated successfully!', 'data' => $user]);
    // }

    // public function logout()
    // {
    //    $token = auth()->user()->token();
    //    $token->delete();

    //    return response()->json([
    //        "status" => true,
    //        "message" => "User Logged out successfully"
    //    ]);
    // }

    // public function forgotPassword(ForgotPasswordRequest $request)
    // {

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found',
    //         ], 404);
    //     }

    //     $resetToken = Str::random(60);
    //     $user->reset_token = $resetToken;
    //     $user->reset_token_expiration = now()->addMinutes(5);
    //     $user->save();

    //     $url = url('/reset-password?token=' . urlencode($resetToken));

    //     SendEmailJob::dispatch($user->email, new ForgotPasswordMail($user->name, $url));


    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Password reset link has been sent to your email.',
    //     ]);
    // }

    // public function showResetPasswordForm(Request $request)
    // {
    //     $token = $request->query('token');
    //     $user = User::where('reset_token', $token)
    //                 ->where('reset_token_expiration', '>', now())
    //                 ->first();

    //     if (!$user) {
    //         return redirect()->route('404.page');
    //     }

    //     return view('reset_password', ['token' => $token]);
    // }



    // public function checkTokenValidity(Request $request)
    // {
    //     $token = $request->query('token');
    //     $user = User::where('reset_token', $token)
    //                 ->where('reset_token_expiration', '>', now())
    //                 ->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Token is invalid or expired.'
    //         ], 400);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Token is valid.'
    //     ]);
    // }



    // public function resetPassword(ResetPasswordRequest $request)
    // {

    //     $user = User::where('reset_token', $request->token)
    //                 ->where('reset_token_expiration', '>', now())
    //                 ->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid or expired reset token.',
    //         ], 400);
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->reset_token = null;
    //     $user->reset_token_expiration = null;
    //     $user->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Password has been reset successfully. Please log in with your new credentials.',
    //     ]);
    // }

    // public function first(FirstRequest $request)
    // {

    //     $user = Auth::user();

    //     if (!$user || !$user->is_first_login) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User is not authorized for this action.',
    //         ], 403);
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->is_first_login = false;
    //     $user->save();

    //     $user->token()->delete();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Password has been reset successfully. Please log in with your new credentials.',
    //     ]);
    // }


    // public function addUser(AddUserRequest $request)
    // {

    //     $password = Str::random(10);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'address' => $request->address,
    //         'gender' => $request->gender,
    //         'role' => $request->role,
    //         'password' => Hash::make($password),
    //         'is_first_login' => true,
    //         'country_id' => $request->country_id,
    //         'state_id' => $request->state_id,
    //         'city_id' => $request->city_id,
    //         'branch_id' => $request->branch_id,
    //         'product_id' => $request->product_id,
    //     ]);

    //     SendEmailJob::dispatch($user->email, new welcomeUser($user->name, $user->email, $password));

    //     return response()->json([
    //         "status" => true,
    //         "message" => "User Added Successfully",
    //     ]);
    // }

    // public function viewUsers()
    // {
    //     $users = User::all();
    //     return response()->json($users);
    // }
    // public function viewUserById($id)
    // {
    //     $users = User::find($id);
    //     if (!$users) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }
    //     return response()->json($users, 200);
    // }

    // public function editUser($id, EditUserRequest $request)
    // {
    //     {
    //         $user = User::find($id);

    //         if (!$user) {
    //             return response()->json([
    //                 "status" => false,
    //                 "message" => "User not found",
    //             ]);
    //         }

    //         $user->update($request->all());

    //         return response()->json([
    //             "status" => true,
    //             "message" => "User updated successfully",
    //             "data" => $user,
    //         ]);
    //     }
    // }

    // public function deleteUser(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $user->delete();

    //     return response()->json(['message' => 'User deleted successfully']);
    // }

}

