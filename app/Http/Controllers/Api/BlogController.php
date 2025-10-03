<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Blog::published()
            ->with('author')
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category')) {
            $query->category($request->category);
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
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'success' => true,
            'data' => BlogResource::collection($blogs->items()),
            'pagination' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ]
        ]);
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug): JsonResponse
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->with('author')
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        return response()->json([
            'success' => true,
            'data' => new BlogResource($blog)
        ]);
    }

    /**
     * Get featured blogs.
     */
    public function featured(): JsonResponse
    {
        $blogs = Blog::published()
            ->featured()
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => BlogResource::collection($blogs)
        ]);
    }

    /**
     * Get blog categories.
     */
    public function categories(): JsonResponse
    {
        $categories = Blog::published()
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
}
