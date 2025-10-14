<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOffer;
use Illuminate\Http\Request;

class ServiceOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $search = $request->get('search');
        // $service_id = $request->get('service_id');
        // $status = $request->get('status');

        // $query = ServiceOffer::with('service');

        // if ($search) {
        //     $query->where('name', 'like', '%' . $search . '%');
        // }

        // if ($service_id) {
        //     $query->where('service_id', $service_id);
        // }

        // if ($status) {
        //     $query->where('status', $status);
        // }

        // $serviceOffers = $query->paginate(15);
        $services = Service::where('status', 'active')->get();

        return view('admin.services.offers.index', compact('serviceOffers', 'services', 'search', 'service_id', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        return view('admin.services.offers.create', compact('service'));
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

        ServiceOffer::create($request->all());
        return redirect()->route('services.services.index')->with('success', 'Service offer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOffer $serviceOffer)
    {
        return view('admin.services.offers.show', compact('serviceOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOffer $serviceOffer)
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.services.offers.edit', compact('serviceOffer', 'services'));
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

        $serviceOffer->update($request->all());

        return redirect()->route('services.services.offers.index')->with('success', 'Service offer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOffer $serviceOffer)
    {
        $serviceOffer->delete();

        return redirect()->route('services.services.offers.index')->with('success', 'Service offer deleted successfully.');
    }
}
