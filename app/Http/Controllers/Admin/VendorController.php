<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = User::where('role', 'vendor')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = \App\Models\Service::all();
        return view('admin.vendors.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
            'application_document' => 'required|file|mimes:pdf,jpeg,png|max:5120',
            'trade_license_document' => 'required|file|mimes:pdf,jpeg,png|max:5120',
            'vat_certificate_document' => 'required|file|mimes:pdf,jpeg,png|max:5120',
            'staff_documents' => 'required|file|mimes:pdf,jpeg,png|max:5120',
            'contract_document' => 'required|file|mimes:pdf,jpeg,png|max:5120',
            'payment_type' => 'required|in:fixed_rate,commission,revenue_share',
            'fixed_rate_amount' => 'nullable|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'revenue_share_ratio' => 'nullable|string',
            'services' => 'array',
            'services.*' => 'exists:services,id',
        ]);

        // Handle image upload
        $imageName = '';
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
        }

        // Handle document uploads - store in public/vendor_documents directory
        $applicationDocument = '';
        if ($request->hasFile('application_document')) {
            $applicationDocument = time() . '_application.' . $request->application_document->extension();
            $request->application_document->move(public_path('vendor_documents'), $applicationDocument);
        }

        $tradeLicenseDocument = '';
        if ($request->hasFile('trade_license_document')) {
            $tradeLicenseDocument = time() . '_trade_license.' . $request->trade_license_document->extension();
            $request->trade_license_document->move(public_path('vendor_documents'), $tradeLicenseDocument);
        }

        $vatCertificateDocument = '';
        if ($request->hasFile('vat_certificate_document')) {
            $vatCertificateDocument = time() . '_vat_certificate.' . $request->vat_certificate_document->extension();
            $request->vat_certificate_document->move(public_path('vendor_documents'), $vatCertificateDocument);
        }

        $staffDocuments = '';
        if ($request->hasFile('staff_documents')) {
            $staffDocuments = time() . '_staff_documents.' . $request->staff_documents->extension();
            $request->staff_documents->move(public_path('vendor_documents'), $staffDocuments);
        }

        $contractDocument = '';
        if ($request->hasFile('contract_document')) {
            $contractDocument = time() . '_contract.' . $request->contract_document->extension();
            $request->contract_document->move(public_path('vendor_documents'), $contractDocument);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $imageName,
            'role' => 'vendor',
            // Document fields
            'application_document' => $applicationDocument,
            'trade_license_document' => $tradeLicenseDocument,
            'vat_certificate_document' => $vatCertificateDocument,
            'staff_documents' => $staffDocuments,
            'contract_document' => $contractDocument,
            // Payment terms fields
            'payment_type' => $request->payment_type,
            'fixed_rate_amount' => $request->payment_type === 'fixed_rate' ? $request->fixed_rate_amount : null,
            'commission_rate' => $request->payment_type === 'commission' ? $request->commission_rate : null,
            'revenue_share_ratio' => $request->payment_type === 'revenue_share' ? $request->revenue_share_ratio : null,
        ]);

        // Attach selected services
        if ($request->has('services') && is_array($request->services)) {
            $user->services()->attach($request->services);
        }

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
            'application_document' => 'nullable|file|mimes:pdf,jpeg,png|max:5120',
            'trade_license_document' => 'nullable|file|mimes:pdf,jpeg,png|max:5120',
            'vat_certificate_document' => 'nullable|file|mimes:pdf,jpeg,png|max:5120',
            'staff_documents' => 'nullable|file|mimes:pdf,jpeg,png|max:5120',
            'contract_document' => 'nullable|file|mimes:pdf,jpeg,png|max:5120',
            'payment_type' => 'required|in:fixed_rate,commission,revenue_share',
            'fixed_rate_amount' => 'nullable|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'revenue_share_ratio' => 'nullable|string',
        ]);

        $vendor = User::where('role', 'vendor')->findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            // Payment terms fields
            'payment_type' => $request->payment_type,
            'fixed_rate_amount' => $request->payment_type === 'fixed_rate' ? $request->fixed_rate_amount : null,
            'commission_rate' => $request->payment_type === 'commission' ? $request->commission_rate : null,
            'revenue_share_ratio' => $request->payment_type === 'revenue_share' ? $request->revenue_share_ratio : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $vendor->image);
            if ($vendor->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('user_images', $imageName);
            $data['image'] = $imageName;
        }

        // Handle document uploads
        if ($request->hasFile('application_document')) {
            // Delete old document if exists
            $oldfile = public_path('vendor_documents/' . $vendor->application_document);
            if ($vendor->application_document && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $applicationDocument = time() . '_application.' . $request->application_document->extension();
            $request->application_document->move(public_path('vendor_documents'), $applicationDocument);
            $data['application_document'] = $applicationDocument;
        }

        if ($request->hasFile('trade_license_document')) {
            // Delete old document if exists
            $oldfile = public_path('vendor_documents/' . $vendor->trade_license_document);
            if ($vendor->trade_license_document && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $tradeLicenseDocument = time() . '_trade_license.' . $request->trade_license_document->extension();
            $request->trade_license_document->move(public_path('vendor_documents'), $tradeLicenseDocument);
            $data['trade_license_document'] = $tradeLicenseDocument;
        }

        if ($request->hasFile('vat_certificate_document')) {
            // Delete old document if exists
            $oldfile = public_path('vendor_documents/' . $vendor->vat_certificate_document);
            if ($vendor->vat_certificate_document && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $vatCertificateDocument = time() . '_vat_certificate.' . $request->vat_certificate_document->extension();
            $request->vat_certificate_document->move(public_path('vendor_documents'), $vatCertificateDocument);
            $data['vat_certificate_document'] = $vatCertificateDocument;
        }

        if ($request->hasFile('staff_documents')) {
            // Delete old document if exists
            $oldfile = public_path('vendor_documents/' . $vendor->staff_documents);
            if ($vendor->staff_documents && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $staffDocuments = time() . '_staff_documents.' . $request->staff_documents->extension();
            $request->staff_documents->move(public_path('vendor_documents'), $staffDocuments);
            $data['staff_documents'] = $staffDocuments;
        }

        if ($request->hasFile('contract_document')) {
            // Delete old document if exists
            $oldfile = public_path('vendor_documents/' . $vendor->contract_document);
            if ($vendor->contract_document && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $contractDocument = time() . '_contract.' . $request->contract_document->extension();
            $request->contract_document->move(public_path('vendor_documents'), $contractDocument);
            $data['contract_document'] = $contractDocument;
        }

        $vendor->update($data);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = User::where('role', 'vendor')->findOrFail($id);

        // Delete the image file if exists
        $oldfile = public_path('user_images/' . $vendor->image);
        if ($vendor->image && file_exists($oldfile)) {
            unlink($oldfile);
        }

        // Delete vendor documents if they exist
        $docPaths = [
            $vendor->application_document,
            $vendor->trade_license_document,
            $vendor->vat_certificate_document,
            $vendor->staff_documents,
            $vendor->contract_document
        ];

        foreach ($docPaths as $docPath) {
            if ($docPath) {
                $docFile = public_path('vendor_documents/' . $docPath);
                if (file_exists($docFile)) {
                    unlink($docFile);
                }
            }
        }

        $vendor->delete();

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
