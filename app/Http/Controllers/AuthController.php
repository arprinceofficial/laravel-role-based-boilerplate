<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registration
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['access_token' => $token], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Login
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['access_token' => $token], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }

    }

    // Logout
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    // Get Current User
    public function currentUser(Request $request)
    {
        try {
            $user = Auth::user();
            return response()->json(['user' => $user], 200);


        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
