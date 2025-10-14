<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\RefundPolicy;
use Illuminate\Http\Request;

class RefundPolicyController extends Controller
{
    public function index()
    {
        $refundPolicies = RefundPolicy::latest()->paginate(10);
        return view('admin.contentManagement.refund-policies.index', compact('refundPolicies'));
    }

    public function create()
    {
        return view('admin.contentManagement.refund-policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        RefundPolicy::create($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.refund-policies.index')
            ->with('success', 'Refund Policy created successfully.');
    }

    public function show(RefundPolicy $refundPolicy)
    {
        return view('admin.contentManagement.refund-policies.show', compact('refundPolicy'));
    }

    public function edit(RefundPolicy $refundPolicy)
    {
        return view('admin.contentManagement.refund-policies.edit', compact('refundPolicy'));
    }

    public function update(Request $request, RefundPolicy $refundPolicy)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $refundPolicy->update($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.refund-policies.index')
            ->with('success', 'Refund Policy updated successfully.');
    }

    public function destroy(RefundPolicy $refundPolicy)
    {
        $refundPolicy->delete();

        return redirect()->route('contentManagement.refund-policies.index')
            ->with('success', 'Refund Policy deleted successfully.');
    }

    public function refundPolicy()
    {
        $refundPolicies = RefundPolicy::all();
        return view('pages.refund-policy', compact('refundPolicy'));
    }
}
