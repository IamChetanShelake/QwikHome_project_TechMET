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

        $services = Service::with(['category', 'subcategory'])
            ->withCount('faq')
            ->whereHas('faq')
            ->get();
        return view('admin.faqs.index', compact('services'));
    }

    public function view($id)
    {
        $faq = Faq::with('service.category', 'service.subcategory')->findOrFail($id);
        return view('admin.faqs.view', compact('faq'));
    }

    // View all FAQs for a specific service
    public function viewByService($serviceId)
    {
        // Load service with explicit relationships
        $service = Service::with(['category', 'subcategory'])->findOrFail($serviceId);
        $faqs = Faq::where('service_id', $serviceId)->orderBy('created_at', 'asc')->get();

        return view('admin.faqs.view_service', compact('service', 'faqs'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get(); // Only active categories
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Accept both array-style and single inputs
        $isArrayInput = $request->has('questions');

        if ($isArrayInput) {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'status' => 'required|in:0,1',
                'questions' => 'required|array|min:1',
                'questions.*' => 'required|string|max:255',
                'answers' => 'required|array|min:1',
                'answers.*' => 'required|string',
            ]);

            $serviceId = $request->input('service_id');
            $status = (int)$request->input('status');
            $questions = $request->input('questions', []);
            $answers = $request->input('answers', []);

            // Create FAQs for each pair
            foreach ($questions as $idx => $q) {
                if (!isset($answers[$idx])) { continue; }

                // Enforce uniqueness per service like previous rule
                $exists = Faq::where('service_id', $serviceId)
                    ->where('question', $q)
                    ->exists();
                if ($exists) { continue; }

                Faq::create([
                    'service_id' => $serviceId,
                    'question' => $q,
                    'answer' => $answers[$idx],
                    'status' => $status,
                ]);
            }

            return redirect()->route('faq')->with('success', 'FAQ(s) created successfully.');
        } else {
            // Backward compatibility for single fields
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'question' => [
                    'required', 'string', 'max:255',
                    Rule::unique('faqs')->where(function ($query) use ($request) {
                        return $query->where('service_id', $request->service_id);
                    })
                ],
                'answer' => 'required|string',
                'status' => 'required|in:0,1'
            ]);

            Faq::create($request->only(['service_id','question','answer','status']));

            return redirect()->route('faq')->with('success', 'FAQ created successfully.');
        }
    }

    // Update FAQs for a specific service (bulk update/create/delete)
    public function updateByService(Request $request, $serviceId)
    {
        $originalService = Service::findOrFail($serviceId);

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string|max:255',
            'answers' => 'required|array|min:1',
            'answers.*' => 'required|string',
            'statuses' => 'array',
            'statuses.*' => 'nullable|in:0,1',
            'faq_ids' => 'array',
            'faq_ids.*' => 'nullable|integer',
            'remove_ids' => 'array',
            'remove_ids.*' => 'integer',
        ]);

        $newServiceId = $request->input('service_id');
        $questions = $request->input('questions', []);
        $answers = $request->input('answers', []);
        $statuses = $request->input('statuses', []);
        $faqIds = $request->input('faq_ids', []);
        $removeIds = $request->input('remove_ids', []);

        // 1) Delete removed FAQs (only those belonging to the original service)
        if (!empty($removeIds)) {
            Faq::whereIn('id', $removeIds)->where('service_id', $originalService->id)->delete();
        }

        // 2) Upsert remaining items
        foreach ($questions as $idx => $q) {
            if (!isset($answers[$idx])) { continue; }
            $answer = $answers[$idx];
            $idAtIdx = $faqIds[$idx] ?? null;

            if ($idAtIdx) {
                // Update existing FAQ
                $existing = Faq::where('id', $idAtIdx)->where('service_id', $originalService->id)->first();
                if ($existing) {
                    // Check for duplicates in the new service (excluding self)
                    $duplicate = Faq::where('service_id', $newServiceId)
                        ->where('question', $q)
                        ->where('id', '!=', $idAtIdx)
                        ->exists();
                    if ($duplicate) { continue; }

                    $existing->update([
                        'service_id' => $newServiceId,
                        'question' => $q,
                        'answer' => $answer,
                        'status' => isset($statuses[$idx]) ? (int)$statuses[$idx] : $existing->status,
                    ]);
                }
            } else {
                // Create new FAQ in the new service
                $exists = Faq::where('service_id', $newServiceId)
                    ->where('question', $q)
                    ->exists();
                if ($exists) { continue; }

                Faq::create([
                    'service_id' => $newServiceId,
                    'question' => $q,
                    'answer' => $answer,
                    'status' => isset($statuses[$idx]) ? (int)$statuses[$idx] : 1,
                ]);
            }
        }

        return redirect()->route('faqs.service.view', $newServiceId)->with('success', 'FAQs updated and moved to the selected service.');
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

    // Edit all FAQs for a specific service
    public function editByService($serviceId)
    {
        // Load service with explicit relationships
        $service = Service::with(['category', 'subcategory'])->findOrFail($serviceId);
        $faqs = Faq::where('service_id', $serviceId)->orderBy('created_at', 'asc')->get();

        // Load all categories for dropdown
        $categories = Category::where('status', 1)->get();

        // Get current service details for pre-selection
        $currentCategory = $service->category;
        $currentSubcategory = $service->subcategory;
        $currentService = $service;

        return view('admin.faqs.edit_service', compact('service', 'faqs', 'categories', 'currentCategory', 'currentSubcategory', 'currentService'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $isArrayInput = $request->has('questions');
        if ($isArrayInput) {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'status' => 'required|in:0,1',
                'questions' => 'required|array|min:1',
                'questions.*' => 'required|string|max:255',
                'answers' => 'required|array|min:1',
                'answers.*' => 'required|string',
            ]);

            $serviceId = $request->input('service_id');
            $status = (int)$request->input('status');
            $questions = $request->input('questions', []);
            $answers = $request->input('answers', []);

            // 1) Update current FAQ with first pair
            $firstQ = $questions[0] ?? $faq->question;
            $firstA = $answers[0] ?? $faq->answer;

            // Ensure uniqueness for firstQ within service, ignoring current id
            $exists = Faq::where('service_id', $serviceId)
                ->where('question', $firstQ)
                ->where('id', '!=', $faq->id)
                ->exists();
            if (!$exists) {
                $faq->update([
                    'service_id' => $serviceId,
                    'question' => $firstQ,
                    'answer' => $firstA,
                    'status' => $status,
                ]);
            }

            // 2) Create additional FAQs for remaining pairs
            if (count($questions) > 1) {
                foreach ($questions as $idx => $q) {
                    if ($idx === 0) { continue; }
                    if (!isset($answers[$idx])) { continue; }
                    $dup = Faq::where('service_id', $serviceId)
                        ->where('question', $q)
                        ->exists();
                    if ($dup) { continue; }
                    Faq::create([
                        'service_id' => $serviceId,
                        'question' => $q,
                        'answer' => $answers[$idx],
                        'status' => $status,
                    ]);
                }
            }

            return redirect()->route('faq')->with('success', 'FAQ updated. Additional FAQ(s) added if provided.');
        } else {
            // Backward compatible single update
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'question' => [
                    'required', 'string', 'max:255',
                    Rule::unique('faqs')->where(function ($query) use ($request) {
                        return $query->where('service_id', $request->service_id);
                    })->ignore($id)
                ],
                'answer' => 'required|string',
                'status' => 'required|in:0,1'
            ]);

            $faq->update($request->only(['service_id','question','answer','status']));

            return redirect()->route('faq')->with('success', 'FAQ updated successfully.');
        }
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq')->with('success', 'FAQ deleted successfully.');
    }

    // Delete all FAQs for a specific service
    public function deleteAllByService($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $faqCount = Faq::where('service_id', $serviceId)->count();

        if ($faqCount > 0) {
            Faq::where('service_id', $serviceId)->delete();
            $message = "Successfully deleted {$faqCount} FAQ(s) for service '{$service->name}'.";
        } else {
            $message = "No FAQs found for service '{$service->name}'.";
        }

        return redirect()->route('faq')->with('success', $message);
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
