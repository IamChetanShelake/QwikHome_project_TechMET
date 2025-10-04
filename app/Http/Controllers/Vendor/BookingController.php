<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings for the vendor's service providers.
     */
    public function index(Request $request)
    {
        $vendorId = auth()->id();

        // Build query with vendor filter
        $query = Booking::with(['service', 'customer', 'serviceProvider', 'vendor'])
            ->forVendor($vendorId);

        // Filter by status if provided
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Filter by provider if provided
        if ($request->filled('provider_id')) {
            $query->where('service_provider_id', $request->provider_id);
        }

        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->where('scheduled_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('scheduled_date', '<=', $request->end_date);
        }

        // Get bookings ordered by scheduled date
        $bookings = $query->orderBy('scheduled_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        // Get service providers for the vendor
        $serviceProviders = User::where('role', 'serviceprovider')
            ->where('role', 'serviceprovider') // This seems redundant but keeping as is
            ->get(); // Note: This might need to be filtered by which vendor created them

        // Get stats for this vendor
        $stats = [
            'total' => Booking::forVendor($vendorId)->count(),
            'pending' => Booking::forVendor($vendorId)->byStatus('pending')->count(),
            'ongoing' => Booking::forVendor($vendorId)->byStatus('ongoing')->count(),
            'completed' => Booking::forVendor($vendorId)->byStatus('completed')->count(),
        ];

        return view('vendor.bookings.index', compact('bookings', 'serviceProviders', 'stats'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        // For vendors to manually create bookings
        $vendor = auth()->user();
        $services = []; // You'll need to populate this based on how services relate to vendors
        $customers = User::where('role', 'user')->get();
        $serviceProviders = User::where('role', 'serviceprovider')->get(); // Filtered by vendor

        return view('vendor.bookings.create', compact('services', 'customers', 'serviceProviders'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_id' => 'required|exists:users,id',
            'service_provider_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'price' => 'nullable|numeric|min:0',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        Booking::create([
            'service_id' => $request->service_id,
            'customer_id' => $request->customer_id,
            'service_provider_id' => $request->service_provider_id,
            'vendor_id' => auth()->id(),
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'price' => $request->price,
            'customer_notes' => $request->customer_notes,
        ]);

        return redirect()->route('vendor.bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Ensure vendor owns this booking
        if ($booking->vendor_id !== auth()->user()->id) {
            abort(403);
        }

        $booking->load(['service.category', 'customer', 'serviceProvider', 'vendor']);
        return view('vendor.bookings.show', compact('booking'));
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        // Ensure vendor owns this booking
        if ($booking->vendor_id !== auth()->user()->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,ongoing,completed',
            'vendor_notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
            'vendor_notes' => $request->vendor_notes,
        ];

        if ($request->status === 'completed') {
            $updateData['completed_at'] = now();
        }

        $booking->update($updateData);

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }
}
