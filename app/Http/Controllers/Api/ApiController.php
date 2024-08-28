<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\welcomeemail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'is_first_login' => true,
        ]);

        event(new Registered($user));
        Mail::to($user->email)->send(new welcomeemail($user->name, $user->email, $password));

        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully",
            "data" => [$password],
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {

                // Generate the token regardless of first login
                $token = $user->createToken("mytoken")->accessToken;

                if ($user->is_first_login) {
                    // First-time login: Redirect to reset password page
                    return response()->json([
                        "status" => true,
                        "message" => "First-time login detected. Redirecting to reset password.",
                        "token" => $token,
                        "reset_password_required" => true
                    ]);
                } else {
                    // Regular login
                    return response()->json([
                        "status" => true,
                        "message" => "Login successful",
                        "token" => $token,
                        "data" => []
                    ]);
                }
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                    "data" => []
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid Email value",
                "data" => []
            ]);
        }
    }

    public function profile()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "data" => $user,
            "id" => auth()->user()->id
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:14',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'data' => $user,
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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Generate OTP and expiration time
        $otp = random_int(100000, 999999);
        $expiration = now()->addMinutes(10);

        // Store OTP and expiration in database
        $user->otp = $otp;
        $user->otp_expiration = $expiration;
        $user->save();

        // Generate reset link with token instead of OTP
        $resetToken = Str::random(60);
        $user->reset_token = $resetToken;
        $user->save();

        $url = url('/reset-password?token=' . urlencode($resetToken));

        // Send email with reset link
        Mail::to($user->email)->send(new ForgotPasswordMail($user->name, $url));

        return response()->json([
            'status' => true,
            'message' => 'Password reset link has been sent to your email.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ]);

        $user = User::where('reset_token', $request->token)->first();

        if (!$user || now()->greaterThan($user->otp_expiration)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired reset token.',
            ], 400);
        }

        // Update password and clear the reset token and OTP
        $user->password = Hash::make($request->new_password);
        $user->reset_token = null;
        $user->otp = null;
        $user->otp_expiration = null;
        $user->is_first_login = false; // Clear the first login flag
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully. Please log in with your new credentials.',
        ]);
    }

    public function first(Request $request)
    {
        $request->validate([
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ]);

        $user = Auth::user();

        if (!$user || !$user->is_first_login) {
            return response()->json([
                'status' => false,
                'message' => 'User is not authorized for this action.',
            ], 403); // 403 Forbidden instead of 400 Bad Request
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
}
