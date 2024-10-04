<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Str;

class PasswordController extends Controller
{
    public function password_update(PasswordUpdateRequest $request)
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not authenticated'], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password does not match.'
            ], 422);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['status' => true, 'message' => 'Password updated successfully!', 'data' => $user]);
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        $resetToken = Str::random(60);
        $user->reset_token = $resetToken;
        $user->reset_token_expiration = now()->addMinutes(5);
        $user->save();

        $url = url('/reset-password?token=' . urlencode($resetToken));

        SendEmailJob::dispatch($user->email, new ForgotPasswordMail($user->name, $url));


        return response()->json([
            'status' => true,
            'message' => 'Password reset link has been sent to your email.',
        ]);
    }

    public function showResetPasswordForm(Request $request)
    {
        $token = $request->query('token');
        $user = User::where('reset_token', $token)
                    ->where('reset_token_expiration', '>', now())
                    ->first();

        if (!$user) {
            return redirect()->route('404.page');
        }

        return view('reset_password', ['token' => $token]);
    }

    public function checkTokenValidity(Request $request)
    {
        $token = $request->query('token');
        $user = User::where('reset_token', $token)
                    ->where('reset_token_expiration', '>', now())
                    ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid or expired.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Token is valid.'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $user = User::where('reset_token', $request->token)
                    ->where('reset_token_expiration', '>', now())
                    ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired reset token.',
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->reset_token = null;
        $user->reset_token_expiration = null;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully. Please log in with your new credentials.',
        ]);
    }
}
