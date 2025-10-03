<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Admin login.
     */
    public function login(Request $request): JsonResponse
    {
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

        // Check if user has admin role
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            throw ValidationException::withMessages([
                'email' => ['Access denied. Admin privileges required.'],
            ]);
        }

        // Update last login
        $user->update(['last_login' => now()]);

        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar,
                ],
                'token' => $token,
            ]
        ]);
    }

    /**
     * Admin logout.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }

    /**
     * Get admin profile.
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar' => $user->avatar,
                'last_login' => $user->last_login,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * Get admin dashboard data.
     */
    public function dashboard(): JsonResponse
    {
        $stats = [
            'blogs' => [
                'total' => \App\Models\Blog::count(),
                'published' => \App\Models\Blog::published()->count(),
                'drafts' => \App\Models\Blog::where('published', false)->count(),
            ],
            'portfolios' => [
                'total' => \App\Models\Portfolio::count(),
                'published' => \App\Models\Portfolio::published()->count(),
                'featured' => \App\Models\Portfolio::featured()->count(),
            ],
            'contacts' => [
                'total' => \App\Models\Contact::count(),
                'new' => \App\Models\Contact::status('new')->count(),
                'this_month' => \App\Models\Contact::whereMonth('created_at', now()->month)->count(),
            ],
            'testimonials' => [
                'total' => \App\Models\Testimonial::count(),
                'published' => \App\Models\Testimonial::published()->count(),
                'featured' => \App\Models\Testimonial::featured()->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
