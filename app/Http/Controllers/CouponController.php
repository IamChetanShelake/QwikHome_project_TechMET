<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
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
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0|max:100',
            'expiry_date' => 'required|date|after:today',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:0,1'
        ]);

        $data = $request->all();
        $data['discount_type'] = 'percentage';

        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons')->ignore($id)],
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0|max:100',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:0,1'
        ]);

        $data = $request->all();
        $data['discount_type'] = 'percentage';

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
}
