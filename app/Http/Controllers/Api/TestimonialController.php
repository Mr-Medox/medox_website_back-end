<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    /**
     * Display a listing of published testimonials.
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::published()
            ->verified()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => TestimonialResource::collection($testimonials)
        ]);
    }

    /**
     * Get featured testimonials.
     */
    public function featured(): JsonResponse
    {
        $testimonials = Testimonial::published()
            ->featured()
            ->verified()
            ->ordered()
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => TestimonialResource::collection($testimonials)
        ]);
    }
}
