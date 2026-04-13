<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProviderFaq;
use Illuminate\Http\Request;

class ServiceProviderFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = ServiceProviderFaq::latest();

        if ($search) {
            $query->where('question', 'like', "%{$search}%")
                ->orWhere('answer', 'like', "%{$search}%");
        }

        $faqs = $query->paginate(15);

        return view('admin.service-provider-faqs.index', compact('faqs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service-provider-faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'faqs' => 'required|array|min:1',
            'faqs.*.question' => 'required|string|max:255',
            'faqs.*.answer' => 'required|string',
            'faqs.*.is_active' => 'nullable',
        ]);

        $createdCount = 0;
        foreach ($validated['faqs'] as $faqData) {
            // Handle checkbox values - if not present, default to false
            $isActive = isset($faqData['is_active']) && $faqData['is_active'] == '1';

            ServiceProviderFaq::create([
                'question' => $faqData['question'],
                'answer' => $faqData['answer'],
                'is_active' => $isActive,
            ]);
            $createdCount++;
        }

        $message = $createdCount == 1
            ? 'FAQ created successfully.'
            : "$createdCount FAQs created successfully.";

        return redirect()->route('service-provider-faqs.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceProviderFaq $service_provider_faq)
    {
        return view('admin.service-provider-faqs.show', [
            'faq' => $service_provider_faq
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceProviderFaq $service_provider_faq)
    {
        return view('admin.service-provider-faqs.edit', compact('service_provider_faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceProviderFaq $service_provider_faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $service_provider_faq->update($validated);

        return redirect()->route('service-provider-faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceProviderFaq $service_provider_faq)
    {
        $service_provider_faq->delete();
        return redirect()->route('service-provider-faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
