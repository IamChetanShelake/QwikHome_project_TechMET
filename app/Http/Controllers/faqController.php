<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Category;
use App\Models\Subcategory;

class faqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('service')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function view($id)
    {
        $faq = Faq::with('service.category', 'service.subcategory')->findOrFail($id);
        return view('admin.faqs.view', compact('faq'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get(); // Only active categories
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('faqs')->where(function ($query) use ($request) {
                    return $query->where('service_id', $request->service_id);
                })
            ],
            'answer' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        Faq::create($request->all());

        return redirect()->route('faq')->with('success', 'FAQ created successfully.');
    }

    public function edit($id)
    {
        $faq = Faq::with('service.subcategory.category')->findOrFail($id);
        $categories = Category::where('status', 1)->get(); // Only active categories

        // Get current service to get category and subcategory for pre-selection
        $currentService = $faq->service;
        $currentCategory = $currentService ? $currentService->category : null;
        $currentSubcategory = $currentService ? $currentService->subcategory : null;

        return view('admin.faqs.edit', compact('faq', 'categories', 'currentService', 'currentCategory', 'currentSubcategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('faqs')->where(function ($query) use ($request) {
                    return $query->where('service_id', $request->service_id);
                })->ignore($id)
            ],
            'answer' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return redirect()->route('faq')->with('success', 'FAQ updated successfully.');
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq')->with('success', 'FAQ deleted successfully.');
    }

    // AJAX API methods for cascading dropdowns
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)
                                  ->where('status', 1)
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

        $services = $query->get();
        return response()->json($services);
    }
}
