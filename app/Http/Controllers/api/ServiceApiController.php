<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use App\Models\Offer;
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

    public function viewService(Request $request)
    {
        try {
            $serviceId = $request->input('service');
            $type = $request->input('type');

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }

            if ($type == 'qwikpick') {
                $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'faq'])->where('qwikpick', 1)->find($serviceId);
            } elseif ($type == 'beauty_and_easy') {
                $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'faq'])->where('beauty_and_easy', 1)->find($serviceId);
            } elseif (!$type) {

                $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'faq'])->find($serviceId);
            }


            if (!$service) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service not found'
                ], 404);
            }

            // Restructure FAQ data to nested array format (faq1, faq2, faq3...)
            $faq = [];
            if ($service->faq && $service->faq->count() > 0) {
                foreach ($service->faq as $index => $faqItem) {
                    $faqIndex = (int)$index + 1; // Start from 1 instead of 0, cast to int
                    $faq['faq' . $faqIndex] = $faqItem;
                }
            }

            // Create custom service data with restructured FAQ
            $serviceData = $service->toArray();
            $serviceData['faq'] = $faq;

            // Restructure prices into array
            $priceFields = [
                'price_onetime',
                'price_onetime_description',
                'duration_onetime',
                'price_weekly',
                'price_weekly_description',
                'price_monthly',
                'price_monthly_description',
                'price_yearly',
                'price_yearly_description'
            ];
            $serviceData['prices'] = [];
            foreach ($priceFields as $field) {
                $serviceData['prices'][$field] = $serviceData[$field] ?? null;
                unset($serviceData[$field]);
            }

            // Modify requirements if exactly 3 items
            if (isset($serviceData['requirements']) && is_array($serviceData['requirements']) && count($serviceData['requirements']) === 3) {
                $serviceData['requirements'] = [[], [], []];
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service details retrieved successfully',
                'data' => [
                    'service' => $serviceData,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function qwikpickService(Request $request)
    {
        try {
            $serviceId = $request->input('service');

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }

            $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'users', 'faq'])->where('id', $serviceId)->where('qwikpick', 1)->first();

            if (!$service) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service not found or not a qwikpick service'
                ], 404);
            }

            // Restructure FAQ data to nested array format (faq1, faq2, faq3...)
            $faq = [];
            if ($service->faq && $service->faq->count() > 0) {
                foreach ($service->faq as $index => $faqItem) {
                    $faqIndex = (int)$index + 1; // Start from 1 instead of 0, cast to int
                    $faq['faq' . $faqIndex] = $faqItem;
                }
            }

            // Create custom service data with restructured FAQ
            $serviceData = $service->toArray();
            $serviceData['faq'] = $faq;

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Qwikpick service details retrieved successfully',
                'data' => $serviceData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function beautyAndEasyService(Request $request)
    {
        try {
            $serviceId = $request->input('service');

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }

            $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'users', 'faq'])->where('id', $serviceId)->where('beauty_and_easy', 1)->first();

            if (!$service) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Service not found or not a beauty & easy service'
                ], 404);
            }

            // Restructure FAQ data to nested array format (faq1, faq2, faq3...)
            $faq = [];
            if ($service->faq && $service->faq->count() > 0) {
                foreach ($service->faq as $index => $faqItem) {
                    $faqIndex = (int)$index + 1; // Start from 1 instead of 0, cast to int
                    $faq['faq' . $faqIndex] = $faqItem;
                }
            }

            // Create custom service data with restructured FAQ
            $serviceData = $service->toArray();
            $serviceData['faq'] = $faq;

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Beauty & Easy service details retrieved successfully',
                'data' => $serviceData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function viewOffer(Request $request)
    {
        try {
            $offerId = $request->input('offer');

            if (!$offerId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'offer_id is required'
                ], 400);
            }

            $offer = Offer::find($offerId);

            if (!$offer) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Offer not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Offer details retrieved successfully',
                'data' => $offer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Offer retrieval failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
