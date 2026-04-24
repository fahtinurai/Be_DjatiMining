<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET ALL USERS
    public function index()
    {
        $users = User::all();

        return response()->json([
            'message' => 'List users',
            'data' => $users
        ]);
    }

    // CREATE USER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'role' => 'nullable|string',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role ?? 'Mechanic',
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    // UPDATE USER
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string',
            'username' => 'sometimes|string|unique:users,username,' . $id,
            'role' => 'sometimes|string',
            'status' => 'sometimes|string'
        ]);

        $user->update($request->only([
            'name',
            'username',
            'role',
            'status'
        ]));

        return response()->json([
            'message' => 'User updated',
            'data' => $user
        ]);
    }

    // DISABLE USER (soft logic manual)
    public function disable($id)
    {
        $user = User::findOrFail($id);

        $user->status = 'inactive';
        $user->save();

        return response()->json([
            'message' => 'User disabled',
            'data' => $user
        ]);
    }

    // RESET PASSWORD
    public function resetPassword($id, Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6'
        ]);

        $user = User::findOrFail($id);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password reset successful'
        ]);
    }
}