<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use App\Models\CartItem;
use App\Models\ServiceOffer;
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
            $userId =  $request->input('user');

            if (!$subcategoryId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'subcategory is required'
                ], 400);
            }

            // $services = Service::where('subcategory_id', $subcategoryId)->get();
            
              $services = Service::where('subcategory_id', $subcategoryId)
            ->get()
            ->map(function ($service) use ($userId) {
                // Check if wishlisted
                $isWishlisted = \App\Models\Wishlist::where('user_id', $userId)
                    ->where('service_id', $service->id)
                    ->exists();

                $service->is_wishlisted = $isWishlisted;
                return $service;
            });

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
            $userId = $request->input('user');
            $serviceId = $request->input('service');
            $type = $request->input('type');
            
            if(!$userId){
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'user is required'
                ], 400);
            }

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }
            
            $query = Service::with([
    'category',
    'subcategory',
    'requirements',
    'processes',
    'faq',
    'subscriptionPlans',
    'materials',
    'servicePersons'
]);

            if ($type == 'qwikpick') {
                $service = $query->where('qwikpick', 1)->find($serviceId);
            } elseif ($type == 'beauty_and_easy') {
                $service = $query->where('beauty_and_easy', 1)->find($serviceId);
            } elseif (!$type) {
                $service = $query->find($serviceId);
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
            
            $serviceData['is_wishlisted'] = $service->wishlists->isNotEmpty();
            unset($serviceData['wishlists']); // clean up response

             // Add onetime_price array before subscription_plans
            $onetimeOptions = $service->subscriptionPlans->where('frequency_type', 'onetime');
            $serviceData['onetime_price'] = null;
            if ($onetimeOptions->isNotEmpty()) {
                $serviceData['onetime_price'] = $onetimeOptions->first()->price_per_time;
            }
            
             
            if ($service->materials && $service->materials->count() > 0) {
                
                $serviceData['withMaterialPrice'] = $service->materials->sum('material_price');
                  $serviceData['withoutMaterialPrice'] = 0;
                
                // $withMaterialPrice = $service->materials->sum('material_price');
                //   $withoutMaterialPrice = 0;
                  
                // $serviceData['Do You Need Cleaning Materials ?'] =
                
                // [
                //     'withMaterialPrice' => $withMaterialPrice,
                //     'withoutMaterialPrice' => $withoutMaterialPrice,
                // ];
            }
            
            // Restructure prices into array
            // $priceFields = [
            //     'price_onetime',
            //     'price_onetime_description',
            //     'duration_onetime',
            //     'price_weekly',
            //     'price_weekly_description',
            //     'price_monthly',
            //     'price_monthly_description',
            //     'price_yearly',
            //     'price_yearly_description'
            // ];
            // $serviceData['prices'] = [];
            // foreach ($priceFields as $field) {
            //     $serviceData['prices'][$field] = $serviceData[$field] ?? null;
            //     unset($serviceData[$field]);
            // }

            // Modify requirements if exactly 3 items
            if (isset($serviceData['requirements']) && is_array($serviceData['requirements']) && count($serviceData['requirements']) === 3) {
                $serviceData['requirements'] = [[], [], []];
            }
            
            //check this service in cart
            $incart = CartItem::where('item_id',$serviceData['id'])->where('user_id',$userId)->first();
            
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Service details retrieved successfully',
                'data' => [
                    'in_cart_quantity' => $incart['quantity'] ?? 0,
                      'allow_increment' => $serviceData['allow_quantity_increment'],
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
            $userId = $request->input('user');

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }

            $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'users', 'faq', 'wishlists' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])->where('id', $serviceId)->where('qwikpick', 1)->first();

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
            // $serviceData = $service->toArray();
            // $serviceData['faq'] = $faq;
            // Add wishlist status
            $serviceData = $service->toArray();
            $serviceData['faq'] = $faq;
            $serviceData['is_wishlisted'] = $service->wishlists->isNotEmpty();
            unset($serviceData['wishlists']); // clean up response

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
            $userId = $request->input('user');

            if (!$serviceId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'service_id is required'
                ], 400);
            }

            $service = Service::with(['category', 'subcategory', 'requirements', 'processes', 'users', 'faq', 'wishlists' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])->where('id', $serviceId)->where('beauty_and_easy', 1)->first();

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
            // Add wishlist status
            $serviceData = $service->toArray();
            $serviceData['faq'] = $faq;
            $serviceData['is_wishlisted'] = $service->wishlists->isNotEmpty();
            unset($serviceData['wishlists']); // clean up response

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

            $offer = ServiceOffer::find($offerId);

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
    
     public function searchServices(Request $request)
    {
        try {
            $query = $request->input('query');
            $categoryId = $request->input('category');
            $subcategoryId = $request->input('subcategory');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $sortBy = $request->input('sort_by', 'name'); // name, price, rating, popularity
            $sortOrder = $request->input('sort_order', 'asc'); // asc, desc
            $limit = $request->input('limit', 20);
            $page = $request->input('page', 1);
    
            if (!$query && !$categoryId && !$subcategoryId) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'At least one search parameter (query, category, or subcategory) is required'
                ], 400);
            }

            $servicesQuery = Service::with(['category', 'subcategory', 'offers','wishlists']);

            // Text search
            if ($query) {
                $servicesQuery->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', '%' . $query . '%')
                      ->orWhere('description', 'LIKE', '%' . $query . '%')
                      ->orWhere('short_description', 'LIKE', '%' . $query . '%')
                      ->orWhereHas('category', function ($categoryQuery) use ($query) {
                          $categoryQuery->where('name', 'LIKE', '%' . $query . '%');
                      })
                      ->orWhereHas('subcategory', function ($subcategoryQuery) use ($query) {
                          $subcategoryQuery->where('name', 'LIKE', '%' . $query . '%');
                      });
                });
            }

            // Category filter
            if ($categoryId) {
                $servicesQuery->where('category_id', $categoryId);
            }

            // Subcategory filter
            if ($subcategoryId) {
                $servicesQuery->where('subcategory_id', $subcategoryId);
            }

            // Price range filter
            if ($minPrice !== null || $maxPrice !== null) {
                $servicesQuery->where(function ($q) use ($minPrice, $maxPrice) {
                    if ($minPrice !== null) {
                        $q->where(function ($priceQuery) use ($minPrice) {
                            $priceQuery->where('price_onetime', '>=', $minPrice)
                                      ->orWhere('price_weekly', '>=', $minPrice)
                                      ->orWhere('price_monthly', '>=', $minPrice)
                                      ->orWhere('price_yearly', '>=', $minPrice);
                        });
                    }
                    if ($maxPrice !== null) {
                        $q->where(function ($priceQuery) use ($maxPrice) {
                            $priceQuery->where('price_onetime', '<=', $maxPrice)
                                      ->orWhere('price_weekly', '<=', $maxPrice)
                                      ->orWhere('price_monthly', '<=', $maxPrice)
                                      ->orWhere('price_yearly', '<=', $maxPrice);
                        });
                    }
                });
            }

            // Sorting
            switch ($sortBy) {
                case 'price':
                    $servicesQuery->orderBy('price_onetime', $sortOrder);
                    break;
                case 'rating':
                    $servicesQuery->orderBy('average_rating', $sortOrder === 'desc' ? 'desc' : 'asc');
                    break;
                case 'popularity':
                    // Assuming there's a popularity field, otherwise sort by created_at or total_reviews
                    $servicesQuery->orderBy('total_reviews', $sortOrder === 'desc' ? 'desc' : 'asc');
                    break;
                case 'name':
                default:
                    $servicesQuery->orderBy('name', $sortOrder);
                    break;
            }

            // Paginate results
            $services = $servicesQuery->paginate($limit, ['*'], 'page', $page);

            // Transform services to include formatted data
            $services->getCollection()->transform(function ($service) {
               
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'short_description' => $service->short_description,
                    'image_url' => $service->image_url,
                    'media_urls' => $service->media_urls,
                    'is_wishlisted' => $service->wishlists->isNotEmpty(),
                    'category' => $service->category ? [
                        'id' => $service->category->id,
                        'name' => $service->category->name,
                        'image_url' => $service->category->image_url ?? null
                    ] : null,
                    'subcategory' => $service->subcategory ? [
                        'id' => $service->subcategory->id,
                        'name' => $service->subcategory->name,
                        'image_url' => $service->subcategory->image_url ?? null
                    ] : null,
                    'prices' => [
                        'onetime' => $service->price_onetime,
                        'weekly' => $service->price_weekly,
                        'monthly' => $service->price_monthly,
                        'yearly' => $service->price_yearly
                    ],
                    'average_rating' => $service->average_rating ?? 0,
                    'total_reviews' => $service->total_reviews ?? 0,
                    'qwikpick' => $service->qwikpick,
                    'beauty_and_easy' => $service->beauty_and_easy,
                    'is_arabic' => $service->is_arabic,
                    'has_offers' => $service->offers->isNotEmpty(),
                    'created_at' => $service->created_at
                ];
            });

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Services search completed successfully',
                'data' => [
                    'services' => $services->items(),
                    'pagination' => [
                        'current_page' => $services->currentPage(),
                        'last_page' => $services->lastPage(),
                        'per_page' => $services->perPage(),
                        'total' => $services->total(),
                        'from' => $services->firstItem(),
                        'to' => $services->lastItem()
                    ],
                    'filters_applied' => [
                        'query' => $query,
                        'category_id' => $categoryId,
                        'subcategory_id' => $subcategoryId,
                        'min_price' => $minPrice,
                        'max_price' => $maxPrice,
                        'sort_by' => $sortBy,
                        'sort_order' => $sortOrder
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Service search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
