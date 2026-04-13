<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Campaign;
use App\Models\Offer;
use App\Models\ServiceOffer;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get all services and format as items with name and image

            $services =
                [
                    'items' => Service::all(),
                ];


            // Get services where qwikpick == 1
            $qwikpickServices =
                [
                    'items' => Service::where('qwikpick', 1)->get()

                ];


            // Get active offers and active campaigns, combine into one items array
            $offers =
                [

                    'items' => ServiceOffer::where('status', 'active')->get()
                ];


            $campaigns =
                [
                    'items' => Campaign::where('status', 'active')->get()

                ];


            // $offersAndCampaigns = $offers->concat($campaigns);

            // Get services where beauty_and_easy == 1
            $beautyAndEasyServices =
                [
                    'items' => Service::where('beauty_and_easy', 1)->get()

                ];


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
                   
                        'items' => $offers,
                        // 'campaigns'=>$campaigns,
            
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
