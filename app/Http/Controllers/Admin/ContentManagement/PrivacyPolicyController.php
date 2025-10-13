<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicies = PrivacyPolicy::latest()->paginate(10);
        return view('admin.contentManagement.privacy-policies.index', compact('privacyPolicies'));
    }

    public function create()
    {
        return view('admin.contentManagement.privacy-policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        PrivacyPolicy::create($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.privacy-policies.index')
            ->with('success', 'Privacy Policy created successfully.');
    }

    public function show(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.contentManagement.privacy-policies.show', compact('privacyPolicy'));
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.contentManagement.privacy-policies.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $privacyPolicy->update($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.privacy-policies.index')
            ->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();

        return redirect()->route('contentManagement.privacy-policies.index')
            ->with('success', 'Privacy Policy deleted successfully.');
    }
}
