<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
    /**
     * Display a listing of published portfolios.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Portfolio::published()
            ->with('author')
            ->ordered();

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
        }

        // Filter by industry
        if ($request->has('industry')) {
            $query->industry($request->industry);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured) {
            $query->featured();
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $portfolios = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => PortfolioResource::collection($portfolios->items()),
            'pagination' => [
                'current_page' => $portfolios->currentPage(),
                'last_page' => $portfolios->lastPage(),
                'per_page' => $portfolios->perPage(),
                'total' => $portfolios->total(),
            ]
        ]);
    }

    /**
     * Display the specified portfolio project.
     */
    public function show(string $slug): JsonResponse
    {
        $portfolio = Portfolio::published()
            ->where('slug', $slug)
            ->with(['author', 'testimonials'])
            ->firstOrFail();

        // Increment view count
        $portfolio->increment('views');

        return response()->json([
            'success' => true,
            'data' => new PortfolioResource($portfolio)
        ]);
    }

    /**
     * Get featured portfolios.
     */
    public function featured(): JsonResponse
    {
        $portfolios = Portfolio::published()
            ->featured()
            ->with('author')
            ->ordered()
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => PortfolioResource::collection($portfolios)
        ]);
    }

    /**
     * Get portfolio categories.
     */
    public function categories(): JsonResponse
    {
        $categories = Portfolio::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get portfolio industries.
     */
    public function industries(): JsonResponse
    {
        $industries = Portfolio::published()
            ->select('industry')
            ->distinct()
            ->pluck('industry')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $industries
        ]);
    }
}
