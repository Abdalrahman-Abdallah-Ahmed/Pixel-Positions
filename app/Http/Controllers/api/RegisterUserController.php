<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class RegisterUserController extends Controller
{
    /**
     * Handle API registration.
     */
    public function store(Request $request)
    {
        // ✅ Validate incoming request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'employer' => ['required', 'string', 'max:255'],
            // 'logo' => ['required', File::types(['png', 'jpg', 'jpeg', 'webp', 'svg'])],
        ]);

        try {
            // ✅ Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // if ($request->has('logo_base64')) {
            //     // Decode base64 logo
            //     $logoData = $request->input('logo_base64');
            //     $logoData = preg_replace('#^data:image/\w+;base64,#i', '', $logoData);
            //     $logoBinary = base64_decode($logoData);
            //     $logoName = 'logos/' . uniqid() . '.png';
            //     Storage::disk('public')->put($logoName, $logoBinary);
            //     $logoPath = $logoName;
            // } else {
            //     // Fallback for file upload
            //     $logoPath = $request->file('logo')->store('logos', 'public');
            // }

            // ✅ Create employer relation
            $user->employer()->create([
                'name' => $validated['employer'],
                'logo' => "D:\pixel-positions\public\storage\logos\0wcHjWEZNqc4s0ad2JdOegdmMGzEV1sem1wGYEQK.svg",
            ]);

            // ✅ Optionally log in user and create token (for API)
            // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'employer' => $user->employer,
                    // 'token' => $token,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
