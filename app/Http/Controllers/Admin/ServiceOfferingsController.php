<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceOffering;
use Illuminate\Http\Request;

class ServiceOfferingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        \Log::info('ServiceOfferingsController index called', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user' => auth()->user() ? auth()->user()->id : 'not authenticated',
            'all_params' => $request->all()
        ]);

        $search = $request->get('search');
        $service_id = $request->get('service_id');
        $status = $request->get('status');

        $query = ServiceOffering::with('service');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($service_id) {
            $query->where('service_id', $service_id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $serviceOfferings = $query->paginate(15);
        $services = Service::where('status', 'active')->get();

        \Log::info('ServiceOfferingsController index returning view', [
            'offerings_count' => $serviceOfferings->count(),
            'total_offerings' => $serviceOfferings->total(),
            'services_count' => $services->count()
        ]);

        // Console logging for debugging
        if (app()->environment('local')) {
            echo "<script>console.log('ServiceOfferingsController index called', { url: '" . $request->fullUrl() . "', offeringsCount: " . $serviceOfferings->total() . ", servicesCount: " . $services->count() . " });</script>";
        }

        return view('admin.services.offerings.index', compact('serviceOfferings', 'services', 'search', 'service_id', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        return view('admin.services.offerings.create', compact('service'));
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

        ServiceOffering::create($request->all());
        return redirect()->route('services.services.index')->with('success', 'Service offering created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOffering $serviceOffering)
    {
        return view('admin.services.offerings.show', compact('serviceOffering'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOffering $serviceOffering)
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.services.offerings.edit', compact('serviceOffering', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOffering $serviceOffering)
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

        $serviceOffering->update($request->all());

        return redirect()->route('services.services.offerings.index')->with('success', 'Service offering updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOffering $serviceOffering)
    {
        $serviceOffering->delete();

        return redirect()->route('services.services.offerings.index')->with('success', 'Service offering deleted successfully.');
    }
}
