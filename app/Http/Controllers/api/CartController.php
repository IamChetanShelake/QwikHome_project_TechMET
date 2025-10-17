<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\ServiceFrequencyOption;
use App\Models\ServiceMaterial;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Add service to cart
     */

    public function addToCart(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'service' => 'required|exists:services,id',
            'package' => 'required|exists:service_frequency_options,id',
            'material' => 'required|boolean',
            'providersCount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Fetch the selected service
        $service = Service::findOrFail($request->service);

        // Fetch selected frequency/package
        $frequencyOption = ServiceFrequencyOption::where('id', $request->package)
            ->where('service_id', $service->id)
            ->first();

        if (!$frequencyOption) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid service frequency option'
            ], 400);
        }

        // Simulated available providers count
        $availableProviders = 10;

        if ($request->providersCount > $availableProviders) {
            return response()->json([
                'status' => false,
                'message' =>  'Limited executives available , please select maximum 10 or below 10 executives'
            ], 400);
        }

        // Base price from the selected package
        $basePrice = $frequencyOption->price_per_time;

        // Material handling — if true, include all materials of that service
        $materialsTotal = 0;
        $selectedMaterialIds = [];

        if ($request->material) {
            $materials = ServiceMaterial::where('service_id', $service->id)->get();
            $materialsTotal = $materials->sum('material_price');
            $selectedMaterialIds = $materials->pluck('id')->toArray();
        }

        // Total price calculation
        $totalPrice = ($basePrice + $materialsTotal) * $request->providersCount;

        // Get or create cart
        $cart = Cart::firstOrCreate(['user_id' => $request->user]);

        // Create cart item
        $cartItem = CartItem::create([
            'cart_id' => $cart->id,
            'item_type' => 'service',
            'item_id' => $service->id,
            'item_name' => $service->name,
            'service_frequency_id' => $frequencyOption->id,
            'quantity' => 1,
            'providers_count' => $request->providersCount,
            'include_material' => $request->material,
            'selected_addons' => json_encode($selectedMaterialIds),
            'base_price' => $basePrice,
            'addons_price' => $materialsTotal,
            'unit_price' => $basePrice + $materialsTotal,
            'total_price' => $totalPrice,
        ]);

        // Update cart totals
        $cart->recalculateTotals();

        return response()->json([
            'status' => true,
            'message' => 'Service added to cart successfully',
            'cart_item' => $cartItem
        ]);
    }



    // public function addToCart(Request $request)
    // {
    //     // Validation rules
    //     $validator = Validator::make($request->all(), [

    //         'user' => 'required|exists:users,id',
    //         'service' => 'required|exists:services,id',
    //         'package' => 'nullable|exists:service_frequency_options,id',
    //         'material' => 'boolean',
    //         'materialid' => 'nullable|array',
    //         'materialids.*' => 'exists:service_materials,id',
    //         'providersCount' => 'required|integer|min:1',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // Fetch service
    //     $service = Service::findOrFail($request->service);

    //     // Fetch service frequency option if provided
    //     $frequencyOption = null;
    //     if ($request->frequency_type) {
    //         $frequencyOption = ServiceFrequencyOption::where('id', $request->frequency_type)
    //             ->where('service_id', $service->id)
    //             ->first();

    //         if (!$frequencyOption) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid service frequency option'
    //             ], 400);
    //         }
    //     }

    //     // Count available providers using relationship
    //     $availableProviders = 10;

    //     if ($request->providersCount > $availableProviders) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Limited executives available'
    //         ], 400);
    //     }

    //     // Price calculation
    //     $basePrice = $frequencyOption ?
    //         $frequencyOption->price_per_time :
    //         $service->price_onetime;

    //     $materialsTotal = 0;
    //     if ($request->material && $request->materialids) {
    //         $materialsTotal = ServiceMaterial::whereIn('id', $request->materialids)
    //             ->where('service_id', $service->id)
    //             ->sum('material_price');
    //     }

    //     $totalPrice = ($basePrice + $materialsTotal) * $request->providersCount;

    //     // Get or create cart
    //     $cart = Cart::firstOrCreate(['user_id' => $request->user]);

    //     // Create cart item
    //     $cartItem = CartItem::create([
    //         'cart_id' => $cart->id,
    //         'service_id' => $service->id,
    //         'item_type' => 'service',
    //         'item_id' => $service->id,
    //         'item_name' => $service->name,
    //         'service_frequency_id' => $frequencyOption ? $frequencyOption->id : null,
    //         'quantity' => 1,
    //         'providers_count' => $request->providersCount,
    //         'include_material' => $request->material,
    //         'selected_addons' => json_encode($request->materialids),
    //         'base_price' => $basePrice,
    //         'addons_price' => $materialsTotal,
    //         'unit_price' => $basePrice + $materialsTotal,
    //         'total_price' => $totalPrice,
    //     ]);

    //     // Update cart totals
    //     $cart->recalculateTotals();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Service added to cart successfully',
    //         'cart_item' => $cartItem
    //     ]);
    // }
}
