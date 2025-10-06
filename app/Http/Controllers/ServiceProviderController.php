<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceProviders = User::where('role', 'serviceprovider')->get();
        return view('vendor.serviceProviders.index', compact('serviceProviders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = \App\Models\Service::all();
        return view('vendor.serviceProviders.create', compact('services'));
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
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
        } else {
            $imageName = '';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageName,
            'role' => 'serviceprovider',
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
        return view('vendor.serviceProviders.view', compact('serviceProvider'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceProvider = User::findOrFail($id);
        return view('vendor.serviceProviders.edit', compact('serviceProvider'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        $serviceProvider = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
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

        return redirect()->route('serviceProviders.index')->with('success', 'Service Provider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceProvider = User::findOrFail($id);

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

        if (empty($query)) {
            // Return all service providers when no query
            $users = User::where('role', 'serviceprovider')->get();
        } else {
            // Search by name, email, or phone
            $users = User::where('role', 'serviceprovider')
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
