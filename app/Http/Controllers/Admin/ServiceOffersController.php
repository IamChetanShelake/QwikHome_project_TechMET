<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOffer;
use App\Models\ServiceOfferFrequencyOptionDiscount;
use Illuminate\Http\Request;

class ServiceOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $service_id = $request->get('service_id');
        $status = $request->get('status');

        $query = ServiceOffer::with('service');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($service_id) {
            $query->where('service_id', $service_id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $serviceOffers = $query->paginate(15);
        $services = Service::where('status', 'active')->get();

        return view('admin.services.offers.index', compact('serviceOffers', 'services', 'search', 'service_id', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        $frequencyOptions = $service->frequencyOptions;
        return view('admin.services.offers.create', compact('service', 'frequencyOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'discounted_price_onetime' => 'nullable|numeric|min:0',
            'discounted_price_weekly' => 'nullable|numeric|min:0',
            'discounted_price_monthly' => 'nullable|numeric|min:0',
            'discounted_price_yearly' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        // Extract frequency option fields to exclude them from the main service offer creation
        $frequencyOptionFields = [];
        $allInput = $request->all();
        $filteredInput = [];

        foreach ($allInput as $key => $value) {
            if (str_starts_with($key, 'frequency_option_')) {
                $frequencyOptionFields[$key] = $value;
            } else {
                $filteredInput[$key] = $value;
            }
        }

        // Create the service offer with filtered input (excluding frequency option fields)
        $serviceOffer = ServiceOffer::create($filteredInput);

        // Get the service to access its frequency options
        $service = Service::findOrFail($request->service_id);

        // Process frequency option discounts
        $frequencyOptions = $service->frequencyOptions;
        foreach ($frequencyOptions as $frequencyOption) {
            $discountedPrice = null;

            // Check if there's a specific discounted price provided for this frequency option
            $discountedPriceField = 'frequency_option_' . $frequencyOption->id;
            if (isset($frequencyOptionFields[$discountedPriceField]) && $frequencyOptionFields[$discountedPriceField] !== null && $frequencyOptionFields[$discountedPriceField] !== '') {
                $discountedPrice = $frequencyOptionFields[$discountedPriceField];
            } else {
                // Calculate discount based on the frequency option's price
                $discountedPrice = $this->calculateDiscountedPriceForFrequencyOption($frequencyOption, $request->discount_type, $request->discount_value);
            }

            // Create the discount record for this specific frequency option
            if ($discountedPrice !== null) {
                ServiceOfferFrequencyOptionDiscount::create([
                    'service_offer_id' => $serviceOffer->id,
                    'frequency_option_id' => $frequencyOption->id,
                    'discounted_price' => $discountedPrice
                ]);
            }
        }

        return redirect()->route('services.services.index')->with('success', 'Service offer created successfully.');
    }

    private function calculateDiscountedPriceForFrequencyOption($frequencyOption, $discountType, $discountValue)
    {
        if ($discountType === 'percentage') {
            return $frequencyOption->price_per_time * (1 - ($discountValue / 100));
        } else {
            return max(0, $frequencyOption->price_per_time - $discountValue);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOffer $serviceOffer)
    {
        $frequencyOptions = $serviceOffer->service->frequencyOptions;
        return view('admin.services.offers.show', compact('serviceOffer', 'frequencyOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOffer $serviceOffer)
    {
        $services = Service::where('status', 'active')->get();
        $frequencyOptions = $serviceOffer->service->frequencyOptions;
        return view('admin.services.offers.edit', compact('serviceOffer', 'services', 'frequencyOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOffer $serviceOffer)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,flat',
            'discount_value' => 'required|numeric|min:0',
            'discounted_price_onetime' => 'nullable|numeric|min:0',
            'discounted_price_weekly' => 'nullable|numeric|min:0',
            'discounted_price_monthly' => 'nullable|numeric|min:0',
            'discounted_price_yearly' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        // Extract frequency option fields to exclude them from the main service offer update
        $frequencyOptionFields = [];
        $allInput = $request->all();
        $filteredInput = [];

        foreach ($allInput as $key => $value) {
            if (str_starts_with($key, 'frequency_option_')) {
                $frequencyOptionFields[$key] = $value;
            } else {
                $filteredInput[$key] = $value;
            }
        }

        // Update the service offer with filtered input (excluding frequency option fields)
        $serviceOffer->update($filteredInput);

        // Get the service to access its frequency options
        $service = Service::findOrFail($request->service_id);

        // Process frequency option discounts
        $frequencyOptions = $service->frequencyOptions;
        foreach ($frequencyOptions as $frequencyOption) {
            $discountedPrice = null;

            // Check if there's a specific discounted price provided for this frequency option
            $discountedPriceField = 'frequency_option_' . $frequencyOption->id;
            if (isset($frequencyOptionFields[$discountedPriceField]) && $frequencyOptionFields[$discountedPriceField] !== null && $frequencyOptionFields[$discountedPriceField] !== '') {
                $discountedPrice = $frequencyOptionFields[$discountedPriceField];
            } else {
                // Calculate discount based on the frequency option's price
                $discountedPrice = $this->calculateDiscountedPriceForFrequencyOption($frequencyOption, $request->discount_type, $request->discount_value);
            }

            // Find or create the discount record for this specific frequency option
            $discountRecord = ServiceOfferFrequencyOptionDiscount::updateOrCreate(
                [
                    'service_offer_id' => $serviceOffer->id,
                    'frequency_option_id' => $frequencyOption->id,
                ],
                [
                    'discounted_price' => $discountedPrice
                ]
            );
        }

        // Clean up any discount records that are no longer needed (for frequency options that were removed)
        $frequencyOptionIds = $frequencyOptions->pluck('id')->toArray();
        $serviceOffer->frequencyOptionDiscounts()->whereNotIn('frequency_option_id', $frequencyOptionIds)->delete();

        return redirect()->route('offers.index')->with('success', 'Service offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOffer $serviceOffer)
    {
        $serviceOffer->delete();

        return redirect()->route('offers.index')->with('success', 'Service offer deleted successfully.');
    }
}
