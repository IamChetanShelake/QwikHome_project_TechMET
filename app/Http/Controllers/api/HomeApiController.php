<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Service;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            // User address (authenticated user)
            $userAddress = null;
            $user = User::find($request->userid);
            if ($user) {
                $userAddress = $user->address;
            }

            // Search functionality
            $searchQuery = $request->query('search');
            $categories = Category::when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            })->get();

            $subcategories = Subcategory::when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            })->get();

            $services = Service::when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%')
                    ->orWhere('short_description', 'like', '%' . $searchQuery . '%');
            })->get();

            // Banners (active)
            $banners = Banner::where('status', 'active')->get();

            // Qwikpick and Beauty & Easy services
            $qwikpickBeautyEasyServices = Service::where('qwikpick', 1)
                ->where('beauty_and_easy', 1)
                ->get();

            // Offers (active)
            $offers = Offer::where('status', 'active')->get();

            // Campaigns (active)
            $campaigns = Campaign::where('status', 'active')->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Data retrieved successfully',
                'data' => [
                    'user_address' => $userAddress,
                    'search_results' => [
                        'categories' => $categories,
                        'subcategories' => $subcategories,
                        'services' => $services,
                    ],
                    'banners' => $banners,
                    'categories' => $categories,
                    'subcategories' => $subcategories,
                    'services' => $services,
                    'qwikpick_beauty_easy_services' => $qwikpickBeautyEasyServices,
                    'offers' => $offers,
                    'campaigns' => $campaigns,
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

    public function banners(Request $request)
    {
        try {
            // Banners (active or all?)

            $banners = Banner::where('status', 'active')->get();
            

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Banners retrieved successfully',
                'data' => [
                    'banners' => $banners,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Banner retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
