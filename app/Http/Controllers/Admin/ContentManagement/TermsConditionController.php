<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    public function index()
    {
        $termsConditions = TermsCondition::latest()->paginate(10);
        return view('admin.contentManagement.terms-conditions.index', compact('termsConditions'));
    }

    public function create()
    {
        return view('admin.contentManagement.terms-conditions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        TermsCondition::create($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.terms-conditions.index')
            ->with('success', 'Terms and Conditions created successfully.');
    }

    public function show(TermsCondition $termsCondition)
    {
        return view('admin.contentManagement.terms-conditions.show', compact('termsCondition'));
    }

    public function edit(TermsCondition $termsCondition)
    {
        return view('admin.contentManagement.terms-conditions.edit', compact('termsCondition'));
    }

    public function update(Request $request, TermsCondition $termsCondition)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $termsCondition->update($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.terms-conditions.index')
            ->with('success', 'Terms and Conditions updated successfully.');
    }

    public function destroy(TermsCondition $termsCondition)
    {
        $termsCondition->delete();

        return redirect()->route('contentManagement.terms-conditions.index')
            ->with('success', 'Terms and Conditions deleted successfully.');
    }

    public function terms_and_conditions()
    {
        $termsConditions = TermsCondition::all();
        return view('pages.terms-conditions', compact('termsConditions'));
    }
}
