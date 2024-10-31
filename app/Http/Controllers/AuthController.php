<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
class AuthController extends Controller
{
    // Registration
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);
            $token = $user->createToken('auth_token')->plainTextToken;
            $get_user = User::where('id', $user->id)->first();

            $response = [
                'code' => 201,
                'status' => 'success',
                'data' => [
                    'access_token' => $token,
                    'user' => $get_user
                ]
            ];

            return response()->json($response, 201);

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
                'loginInput' => 'required|string',
                'password' => 'required|string',
            ]);

            $loginInput = $request->loginInput;
            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $loginInput)->first();
            } elseif (preg_match('/^01\d{9}$/', $loginInput)) {
                $user = User::where('mobile_number', $loginInput)->first();
            } else {
                $user = User::where('id', $loginInput)->first();
            }
            if (!$user) {
                throw ValidationException::withMessages([
                    'errors' => ['User not found.'],
                ]);
            } elseif (!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'errors' => ['Password is incorrect.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'access_token' => $token,
                    'user' => $user
                ]
            ];

            return response()->json($response, 200);

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

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Logged out successfully'
            ];

            return response()->json($response, 200);

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

            $response = [
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'access_token' => $request->bearerToken(),
                    'user' => $user
                ]
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
