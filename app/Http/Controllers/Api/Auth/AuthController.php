<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendEmailJob;
use App\Mail\welcomeemail;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Str;

class AuthController extends Controller
{
    private $request;

    public function register(RegisterRequest $request)
    {
        
        $password = Str::random(10);

        $request->merge(['is_first_login' => true, 'password' => Hash::make($password)]);
        $user =User::create($request->all());


        SendEmailJob::dispatch($user->email, new welcomeemail($user->name, $user->email, $password));

        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully",
        ],200);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->getUserByEmail($request->email);

        if ($user) {
            return $this->handleLogin($user, $request->password);
        }

        return $this->respondInvalidEmail();
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    private function handleLogin(User $user, $password)
    {
        if ($this->validatePassword($password, $user->password)) {
            $token = $this->generateAccessToken($user);

            if ($user->is_first_login) {
                return $this->respondFirstTimeLogin($token);
            }

            
            if ($user->role === 'admin') {
                return $this->respondLoginSuccess($token, route('admin.dashboard'));
            } else {
                return $this->respondLoginSuccess($token, route('events.all_events'));
            }
        }

        return $this->respondInvalidPassword();
    }

    private function validatePassword($inputPassword, $hashedPassword)
    {
        return Hash::check($inputPassword, $hashedPassword);
    }

    private function generateAccessToken(User $user)
    {
        return $user->createToken('mytoken')->accessToken;
    }

    private function respondFirstTimeLogin($token)
    {
        return response()->json([
            "status" => true,
            "message" => "First-time login detected. Redirecting to reset password.",
            "token" => $token,
            "reset_password_required" => true
        ]);
    }

    private function respondLoginSuccess($token, $redirectUrl)
    {
        return response()->json([
            "status" => true,
            "message" => "Login successful",
            "token" => $token,
            "redirect_url" => $redirectUrl,
        ]);
    }

    private function respondInvalidEmail()
    {
        return response()->json([
            "status" => false,
            "message" => "Invalid Email value",
            "data" => []
        ]);
    }

    private function respondInvalidPassword()
    {
        return response()->json([
            "status" => false,
            "message" => "Password didn't match",
            "data" => []
        ]);
    }


    public function first(FirstRequest $request)
    {

        $user = Auth::user();

        if (!$user || !$user->is_first_login) {
            return response()->json([
                'status' => false,
                'message' => 'User is not authorized for this action.',
            ], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->is_first_login = false;
        $user->save();

        $user->token()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully. Please log in with your new credentials.',
        ]);
    }

    public function logout()
    {
        $token = auth()->user()->token();
        $token->delete();

        return response()->json([
            "status" => true,
            "message" => "User Logged out successfully"
        ]);
    }
}
