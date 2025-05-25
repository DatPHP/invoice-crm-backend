<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class OverallController extends Controller
{
    /**
     * Get counts of categories and products
     *
     * @return JsonResponse
     */
    public function getCounts(): JsonResponse
    {
        $categoryCount = Category::count();
        $productCount = Product::count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'categories_count' => $categoryCount,
                'products_count' => $productCount
            ]
        ]);
    }
} 