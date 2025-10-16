<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::where('role', 'serviceprovider')->with('vendor');

        // If the authenticated user is a vendor, only show their service providers
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->role === 'vendor') {
                $query->where('vendor_id', $user->id);
            }
        }

        $serviceProviders = $query->get();
        return view('vendor.serviceProviders.index', compact('serviceProviders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = \App\Models\Service::with(['category', 'subcategory'])->where('status', 'active')->get();
        $categories = \App\Models\Category::where('status', 'active')->get();
        $subcategories = \App\Models\Subcategory::where('status', 'active')->get();

        // If the authenticated user is a vendor, only show that vendor in the list (or none for admin)
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->role === 'vendor') {
                // For vendor, only show their own ID as an option (or no vendors for selection)
                $vendors = collect([$user]); // Pass only the logged-in vendor
            } else {
                // For admin, show all vendors
                $vendors = \App\Models\User::where('role', 'vendor')->get();
            }
        } else {
            $vendors = \App\Models\User::where('role', 'vendor')->get();
        }

        $authUser = Auth::user();

        return view('vendor.serviceProviders.create', compact('services', 'categories', 'subcategories', 'vendors', 'authUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
            'vendor_id' => 'nullable|exists:users,id',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
        } else {
            $imageName = '';
        }

        // Determine vendor_id - if logged in user is vendor, only allow assigning to themselves
        if (Auth::check() && Auth::user()->role === 'vendor') {
            // If logged in user is vendor, force vendor_id to their own ID
            $vendorId = Auth::user()->id;
        } else {
            // For admin or other roles, use the provided vendor_id or null
            $vendorId = $request->filled('vendor_id') ? $request->vendor_id : null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageName,
            'role' => 'serviceprovider',
            'vendor_id' => $vendorId,
        ]);

        // Attach selected services
        if ($request->has('services') && is_array($request->services)) {
            $user->services()->attach($request->services);
        }

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceProvider = User::findOrFail($id);

        // Check if the logged-in user is a vendor and if so, ensure they can only view their own service providers
        if (Auth::check() && Auth::user()->role === 'vendor') {
            // If logged in user is vendor, only allow viewing if the service provider belongs to them
            if ($serviceProvider->vendor_id !== Auth::user()->id) {
                abort(403, 'You can only view service providers that belong to your vendor account.');
            }
        }

        return view('vendor.serviceProviders.view', compact('serviceProvider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceProvider = User::where('role', 'serviceprovider')->with('services', 'vendor')->findOrFail($id);
        $services = \App\Models\Service::with(['category', 'subcategory'])->where('status', 'active')->get();
        $categories = \App\Models\Category::where('status', 'active')->get();
        $subcategories = \App\Models\Subcategory::where('status', 'active')->get();

        // If the authenticated user is a vendor, only show that vendor in the list (or none for admin)
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->role === 'vendor') {
                // For vendor, only show their own ID as an option (or no vendors for selection)
                $vendors = collect([$user]); // Pass only the logged-in vendor
            } else {
                // For admin, show all vendors
                $vendors = \App\Models\User::where('role', 'vendor')->get();
            }
        } else {
            $vendors = \App\Models\User::where('role', 'vendor')->get();
        }

        $authUser = Auth::user();
        return view('vendor.serviceProviders.edit', compact('serviceProvider', 'services', 'categories', 'subcategories', 'vendors', 'authUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'vendor_id' => 'nullable|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        $serviceProvider = User::findOrFail($id);

        // Check if the logged-in user is a vendor and if so, ensure they can only update their own service providers
        if (Auth::check() && Auth::user()->role === 'vendor') {
            // If logged in user is vendor, only allow updating if the service provider belongs to them
            if ($serviceProvider->vendor_id !== Auth::user()->id) {
                abort(403, 'You can only update service providers that belong to your vendor account.');
            }
            // For vendor, force vendor_id to their own ID (can't reassign to other vendors)
            $vendorId = Auth::user()->id;
        } else {
            // For admin or other roles, use the provided vendor_id or null
            $vendorId = $request->filled('vendor_id') ? $request->vendor_id : null;
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'vendor_id' => $vendorId,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $serviceProvider->image);
            if ($serviceProvider->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
            $data['image'] = $imageName;
        }

        $serviceProvider->update($data);

        // Update services
        if ($request->has('services') && is_array($request->services)) {
            $serviceProvider->services()->sync($request->services);
        } else {
            $serviceProvider->services()->detach();
        }

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceProvider = User::findOrFail($id);

        // Check if the logged-in user is a vendor and if so, ensure they can only delete their own service providers
        if (Auth::check() && Auth::user()->role === 'vendor') {
            // If logged in user is vendor, only allow deleting if the service provider belongs to them
            if ($serviceProvider->vendor_id !== Auth::user()->id) {
                abort(403, 'You can only delete service providers that belong to your vendor account.');
            }
        }

        // Delete the image file if exists
        $oldfile = public_path('user_images/' . $serviceProvider->image);
        if ($serviceProvider->image && file_exists($oldfile)) {
            unlink($oldfile);
        }

        $serviceProvider->delete();

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider deleted successfully.');
    }

    /**
     * Search service providers by name, email, or phone.
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $userQuery = User::where('role', 'serviceprovider')->with('vendor');

        // If the authenticated user is a vendor, only show their service providers
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && $user->role === 'vendor') {
                $userQuery->where('vendor_id', $user->id);
            }
        }

        if (empty($query)) {
            // Return service providers based on user role when no query
            $users = $userQuery->get();
        } else {
            // Search by name, email, or phone
            $users = $userQuery
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('phone', 'like', "%{$query}%");
                })
                ->get();
        }

        return response()->json($users);
    }
}
