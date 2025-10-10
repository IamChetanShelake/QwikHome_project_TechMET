<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function categories(Request $request)
    {
        try {
            $categories = Category::all();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Categories retrieved successfully',
                'data' => [
                    'categories' => $categories,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Categories retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function services(Request $request)
    {
        try {
            $categoryId = $request->input('category');
            $subcategoryId = $request->input('subcategory');

            if (!$categoryId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'category is required'
                ], 400);
            }

            // Get services based on filters
            $query = Service::where('category_id', $categoryId);

            if ($subcategoryId) {
                $query->where('subcategory_id', $subcategoryId);
            }

            $services = $query->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Services retrieved successfully',
                'data' => [
                    'services' => $services,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Data retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function everythingWeOffer(Request $request)
    {
        try {
            $subcategories = Subcategory::all();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Subcategories retrieved successfully',
                'data' => [
                    'subcategories' => $subcategories,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Subcategories retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function subcategoryServices(Request $request)
    {
        try {
            $subcategoryId = $request->input('subcategory');

            if (!$subcategoryId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'subcategory is required'
                ], 400);
            }

            $services = Service::where('subcategory_id', $subcategoryId)->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Services retrieved successfully by subcategory',
                'data' => [
                    'services' => $services,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Services retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
