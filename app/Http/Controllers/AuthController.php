<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeRoleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $request->validated();
        $userData['password'] = Hash::make($request->input('password'));
        User::create($userData);

        return response()->sucess(['success' => true], 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (auth()->attempt($request->validated())) {
            $token = auth()->user()->createToken('MyTask')->accessToken;
            return response()->sucess(['token' => $token], 200);
        } else {
            return response()->error(['error' => 'Unauthorised'], 401);
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 400);
        }

        $user->update([
            'password' => Hash::make($request->input('new_password'))
        ]);

        return response()->sucess(['success' => true], 200);
    }

    public function changeRole(ChangeRoleRequest $request): JsonResponse
    {
        User::findOrFail($request->input("user_id"))
            ->update(['type' => $request->input('new_role')]);

        return response()->sucess(['success' => true], 200);
    }

    public function blockUser(User $user): JsonResponse
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->type !== 2) {
            return response()->error(['error' => 'You do not have permission to block users'], 403);
        }

        $user->update(['blocked' => true]);

        return response()->sucess(['success' => true], 200);
    }

}
