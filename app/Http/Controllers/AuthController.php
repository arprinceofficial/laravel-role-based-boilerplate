<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Kreait\Firebase\Auth as FirebaseAuth;

class AuthController extends Controller
{
    // Registration
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
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
                $user = User::with('role.permissions')->where('email', $loginInput)->first();
            } elseif (preg_match('/^01\d{9}$/', $loginInput)) {
                $user = User::with('role.permissions')->where('mobile_number', $loginInput)->first();
            } else {
                $user = User::with('role.permissions')->where('id', $loginInput)->first();
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

            if ($user->status == 0) {
                throw ValidationException::withMessages([
                    'errors' => ['User is not active.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'access_token' => $token,
                    'user' => $user,
                    // 'permissions' => $user->role->permissions->pluck('name') // Return only permission names
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
            $user = Auth::user()->load('role.permissions');
            if ($user->status == 0) {
                throw ValidationException::withMessages([
                    'errors' => ['User is not active.'],
                ]);
            }

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

    // Send OTP
    public function otpRequest(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
            ]);

            $otp = rand(1000, 9999);
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->otp_verification_code = $otp;
                $user->save();
            } else {
                $data = [
                    'email' => $request->email,
                    'otp_verification_code' => $otp,
                    'status' => 0
                ];
                $user = User::create($data);
            }

            // Send OTP
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)->subject('OTP Verification');
            });
            // $this->sendOtpToMobileNumber($request->email, $otp);

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    // Verify OTP
    public function otpVerify(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
                'otp' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'errors' => ['User not found.'],
                ]);
            }

            if ($user->otp_verification_code != $request->otp) {
                throw ValidationException::withMessages([
                    'errors' => ['OTP is incorrect.'],
                ]);
            }

            $user->otp_verification_code = null;
            $user->status = 1;
            $user->save();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'OTP verified successfully'
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    // ssoFirebaseLogin
    public function ssoFirebaseLogin(Request $request)
    {
        try {
            $request->validate([
                'idToken' => 'required|string',
            ]);

            $idToken = $request->idToken;

            // Access the firebase instance through the app container
            $auth = app('firebase');
            $verifiedIdToken = $auth->verifyIdToken($idToken);

            $email = $verifiedIdToken->claims()->get('email');
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = User::with('role')->where('email', $email)->first();

            if (!$user) {
                $user = User::with('role')->create([
                    'email' => $verifiedIdToken->claims()->get('email'),
                    'first_name' => $verifiedIdToken->claims()->get('name'),
                    'password' => $uid,
                    'profile_image' => $verifiedIdToken->claims()->get('picture'),
                ]);

                $user->role_id = 3;
            }

            $user->status = 1;
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->load('role.permissions');

            $response = [
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'access_token' => $token,
                    'user' => $user,
                ],
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    // Upload Profile Image
    public function uploadProfileImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Get user and set image name
            $user = Auth::user();
            $profile_image = $request->file('profile_image');
            $profile_image_name = $user->id . uniqid() . '_' . time() . '.' . $profile_image->extension();

            // Compress and save image
            $manager = new ImageManager(new Driver());
            $image = $manager->read($profile_image);
            $image->resize(300, 300);
            $image->save(public_path('storage/profile_images/' . $profile_image_name));

            // Save image name to database
            $user->profile_image = $profile_image_name;
            $user->save();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Profile image uploaded successfully',
                'data' => $user
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }

    // Delete Profile Image
    public function deleteProfileImage(Request $request)
    {
        try {
            $user = Auth::user();
            $profile_image = $user->profile_image;
            if ($profile_image) {
                Storage::disk('public')->delete('profile_images/' . $profile_image);
                $user->profile_image = null;
                $user->save();
            }

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Profile image deleted successfully',
                'data' => $user
            ];

            return response()->json($response, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
