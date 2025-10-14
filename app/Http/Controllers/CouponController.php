<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function view($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.view', compact('coupon'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $services = Service::where('status', 1)->get();
        return view('admin.coupons.create', compact('categories', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0|max:100',
            'expiry_date' => 'required|date|after:today',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:0,1',
            'applicable_to' => 'required|in:all_services,specific_services',
            'service_ids' => 'required_if:applicable_to,specific_services|array',
            'service_ids.*' => 'exists:services,id'
        ]);

        $data = $request->only([
            'code', 'description', 'discount_value', 'expiry_date', 
            'usage_limit', 'status', 'applicable_to', 'service_ids'
        ]);
        $data['discount_type'] = 'percentage';

        // Handle service selection
        if ($request->applicable_to === 'all_services') {
            $data['service_ids'] = null; // null means applicable to all services
        } else {
            $data['service_ids'] = json_encode($request->service_ids);
        }

        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $services = Service::where('status', 1)->with(['category', 'subcategory'])->get();
        
        // Decode service_ids if it exists
        $selectedServiceIds = $coupon->service_ids ? json_decode($coupon->service_ids, true) : [];
        
        // Get the first selected service to determine default category/subcategory
        $defaultCategoryId = null;
        $defaultSubcategoryId = null;
        $subcategories = collect();
        
        if (!empty($selectedServiceIds)) {
            $firstSelectedService = Service::with(['category', 'subcategory'])->find($selectedServiceIds[0]);
            if ($firstSelectedService) {
                $defaultCategoryId = $firstSelectedService->category_id;
                $defaultSubcategoryId = $firstSelectedService->subcategory_id;
                
                // Get subcategories for the default category
                if ($defaultCategoryId) {
                    $subcategories = Subcategory::where('category_id', $defaultCategoryId)
                        ->where('status', 1)
                        ->get();
                }
            }
        }
        
        return view('admin.coupons.edit', compact(
            'coupon', 'categories', 'services', 'selectedServiceIds', 
            'defaultCategoryId', 'defaultSubcategoryId', 'subcategories'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons')->ignore($id)],
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0|max:100',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:0,1',
            'applicable_to' => 'required|in:all_services,specific_services',
            'service_ids' => 'required_if:applicable_to,specific_services|array',
            'service_ids.*' => 'exists:services,id'
        ]);

        $data = $request->only([
            'code', 'description', 'discount_value', 'expiry_date', 
            'usage_limit', 'status', 'applicable_to', 'service_ids'
        ]);
        $data['discount_type'] = 'percentage';

        // Handle service selection
        if ($request->applicable_to === 'all_services') {
            $data['service_ids'] = null; // null means applicable to all services
        } else {
            $data['service_ids'] = json_encode($request->service_ids);
        }

        $coupon = Coupon::findOrFail($id);
        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    // AJAX methods for cascading dropdowns
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)
            ->where('status', 1)
            ->select('id', 'name')
            ->get();
        
        return response()->json($subcategories);
    }

    public function getServices($categoryId, $subcategoryId = null)
    {
        $query = Service::where('category_id', $categoryId)
            ->where('status', 1);
        
        if ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }
        
        $services = $query->select('id', 'name')->get();
        
        return response()->json($services);
    }
}
