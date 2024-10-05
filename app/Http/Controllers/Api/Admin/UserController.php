<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Jobs\SendEmailJob;
use App\Mail\welcomeUser;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Str;

class UserController extends Controller
{
    public function addUser(AddUserRequest $request)
    {

        $password = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'role' => $request->role,
            'password' => Hash::make($password),
            'is_first_login' => true,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'branch_id' => $request->branch_id,
            'product_id' => $request->product_id,
        ]);

        SendEmailJob::dispatch($user->email, new welcomeUser($user->name, $user->email, $password));

        return response()->json([
            "status" => true,
            "message" => "User Added Successfully",
        ]);
    }

    public function viewUsers()
    {
        $users = User::paginate(8);
        return response()->json($users);
    }
    public function viewUserById($id)
    {
        $users = User::find($id);
        if (!$users) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($users, 200);
    }

    public function editUser($id, EditUserRequest $request)
    {
        {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "User not found",
                ]);
            }

            $user->update($request->all());

            return response()->json([
                "status" => true,
                "message" => "User updated successfully",
                "data" => $user,
            ]);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

}
