<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Campaign;
use App\Models\Offer;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get all services and format as items with name and image
            $services = Service::all()->map(function ($service) {
                return [
                    'name' => $service->name,
                    'image' => $service->image
                ];
            });

            // Get services where qwikpick == 1
            $qwikpickServices = Service::where('qwikpick', 1)->get()->map(function ($service) {
                return [
                    'name' => $service->name,
                    'image' => $service->image
                ];
            });

            // Get active offers and active campaigns, combine into one items array
            $offers = Offer::where('status', 'active')->get()->map(function ($offer) {
                return [
                    'name' => $offer->title,
                    'image' => $offer->image
                ];
            });

            $campaigns = Campaign::where('status', 'active')->get()->map(function ($campaign) {
                return [
                    'name' => $campaign->title,
                    'image' => $campaign->image
                ];
            });

            $offersAndCampaigns = $offers->concat($campaigns);

            // Get services where beauty_and_easy == 1
            $beautyAndEasyServices = Service::where('beauty_and_easy', 1)->get()->map(function ($service) {
                return [
                    'name' => $service->name,
                    'image' => $service->image
                ];
            });

            $sections = [
                [
                    'title' => 'everything we offer',
                    'items' => $services
                ],
                [
                    'title' => 'qwikpicks',
                    'items' => $qwikpickServices
                ],
                [
                    'title' => 'offers and campaigns',
                    'items' => $offersAndCampaigns
                ],
                [
                    'title' => 'beauty and easy',
                    'items' => $beautyAndEasyServices
                ]
            ];

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Data retrieved successfully',
                'data' => [
                    'sections' => $sections
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
