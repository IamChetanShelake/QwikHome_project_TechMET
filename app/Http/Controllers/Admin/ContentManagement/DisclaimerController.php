<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\Disclaimer;
use Illuminate\Http\Request;

class DisclaimerController extends Controller
{
    public function index()
    {
        $disclaimers = Disclaimer::latest()->paginate(10);
        return view('admin.contentManagement.disclaimers.index', compact('disclaimers'));
    }

    public function create()
    {
        return view('admin.contentManagement.disclaimers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Disclaimer::create($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.disclaimers.index')
            ->with('success', 'Disclaimer created successfully.');
    }

    public function show(Disclaimer $disclaimer)
    {
        return view('admin.contentManagement.disclaimers.show', compact('disclaimer'));
    }

    public function edit(Disclaimer $disclaimer)
    {
        return view('admin.contentManagement.disclaimers.edit', compact('disclaimer'));
    }

    public function update(Request $request, Disclaimer $disclaimer)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $disclaimer->update($request->only(['title', 'content', 'status']));

        return redirect()->route('contentManagement.disclaimers.index')
            ->with('success', 'Disclaimer updated successfully.');
    }

    public function destroy(Disclaimer $disclaimer)
    {
        $disclaimer->delete();

        return redirect()->route('contentManagement.disclaimers.index')
            ->with('success', 'Disclaimer deleted successfully.');
    }
}
