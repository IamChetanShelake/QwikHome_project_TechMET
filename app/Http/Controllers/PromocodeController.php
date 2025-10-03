<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocode;
use Illuminate\Validation\Rule;

class PromocodeController extends Controller
{
    public function index()
    {
        $promocodes = Promocode::all();
        return view('admin.promocodes.index', compact('promocodes'));
    }

    public function view($id)
    {
        $promocode = Promocode::findOrFail($id);
        return view('admin.promocodes.view', compact('promocode'));
    }

    public function create()
    {
        return view('admin.promocodes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|regex:/^[A-Za-z0-9]+$/|unique:promocodes,code',
            'discount' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
        ]);

        Promocode::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'for_active_subscription' => true, // promocodes are only for active subscription users
            'expiry_date' => $request->expiry_date,
            'is_used' => false, // always start as not used
        ]);

        return redirect()->route('promocodes.index')->with('success', 'Promocode created successfully.');
    }

    public function edit($id)
    {
        $promocode = Promocode::findOrFail($id);
        return view('admin.promocodes.edit', compact('promocode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9]+$/', Rule::unique('promocodes')->ignore($id)],
            'discount' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $promocode = Promocode::findOrFail($id);
        $promocode->update([
            'code' => $request->code,
            'discount' => $request->discount,
            'for_active_subscription' => true, // promocodes are only for active subscription users
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('promocodes.index')->with('success', 'Promocode updated successfully.');
    }

    public function delete($id)
    {
        $promocode = Promocode::findOrFail($id);
        $promocode->delete();

        return redirect()->route('promocodes.index')->with('success', 'Promocode deleted successfully.');
    }
}
