<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use App\Models\ServiceRequirement;
use App\Models\Process;
use App\Models\ServiceMaterial;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // CATEGORIES

    public function categoriesIndex(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status) {
            $query->where('status', $status);
        }

        $categories = $query->paginate(15);

        return view('admin.services.categories.index', compact('categories', 'search', 'status'));
    }

    public function categoriesCreate()
    {
        return view('admin.services.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|file',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('Category_images', $imageName);
        } else {
            $imageName = '';
        }

        $validated['image'] = $imageName;

        Category::create($validated);

        return redirect()->route('services.categories.index')->with('success', 'Category created successfully.');
    }

    public function categoriesEdit(Category $category)
    {
        return view('admin.services.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|file',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldfile = public_path('Category_images/' . $category->image);
            if ($category->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('Category_images', $imageName);
            $validated['image'] = $imageName;
        }

        $category->update($validated);

        return redirect()->route('services.categories.index')->with('success', 'Category updated successfully.');
    }

    public function categoriesDestroy(Category $category)
    {
        // Check if category has related subcategories or services
        if ($category->subcategories()->count() > 0 || $category->services()->count() > 0) {
            return redirect()->route('services.categories.index')->with('error', 'Cannot delete category with existing subcategories or services.');
        }

        // Delete the category
        $category->delete();

        return redirect()->route('services.categories.index')->with('success', 'Category deleted successfully.');
    }

    // SUBCATEGORIES

    public function subcategoriesIndex(Request $request)
    {
        $search = $request->get('search');
        $category_id = $request->get('category_id');
        $status = $request->get('status');

        $query = Subcategory::with('category');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $subcategories = $query->paginate(15);
        $categories = Category::where('status', 'active')->get();

        return view('admin.services.subcategories.index', compact('subcategories', 'categories', 'search', 'category_id', 'status'));
    }

    public function subcategoriesCreate()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.services.subcategories.create', compact('categories'));
    }

    public function subcategoriesStore(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|numeric',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|file',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('Subcategory_images', $imageName);
        } else {
            $imageName = '';
        }

        $validated['image'] = $imageName;

        Subcategory::create($validated);

        return redirect()->route('services.subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function subcategoriesEdit(Subcategory $subcategory)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.services.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function subcategoriesUpdate(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|numeric',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|file',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldfile = public_path('Subcategory_images/' . $subcategory->image);
            if ($subcategory->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('Subcategory_images', $imageName);
            $validated['image'] = $imageName;
        }

        $subcategory->update($validated);

        return redirect()->route('services.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function subcategoriesDestroy(Subcategory $subcategory)
    {
        // Check if subcategory has related services
        if ($subcategory->services()->count() > 0) {
            return redirect()->route('services.subcategories.index')->with('error', 'Cannot delete subcategory with existing services.');
        }

        // Delete the subcategory
        $subcategory->delete();

        return redirect()->route('services.subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

    // SERVICES

    public function servicesIndex(Request $request)
    {
        $search = $request->get('search');
        $category_id = $request->get('category_id');
        $subcategory_id = $request->get('subcategory_id');
        $status = $request->get('status');

        $query = Service::with(['category', 'subcategory']);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        if ($subcategory_id) {
            $query->where('subcategory_id', $subcategory_id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $services = $query->paginate(15);
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();

        return view('admin.services.services.index', compact('services', 'categories', 'subcategories', 'search', 'category_id', 'subcategory_id', 'status'));
    }

    public function servicesCreate()
    {
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();
        return view('admin.services.services.create', compact('categories', 'subcategories'));
    }

    public function servicesStore(Request $request)
    {
        // Build dynamic validation rules based on enabled subscriptions
        $validationRules = [
            'category_id' => 'required|exists:categories,id|numeric',
            'subcategory_id' => 'nullable|exists:subcategories,id|numeric',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'whats_include' => 'nullable|array',
            'whats_include.*' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_arabic' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file',
            'requirements' => 'nullable|array',
            'requirements.*.title' => 'required|string|max:255',
            'processes' => 'nullable|array',
            'processes.*.title' => 'required|string|max:255',
            'processes.*.description' => 'required|string',
            'materials' => 'nullable|array',
            'materials.*.material_name' => 'required|string|max:255',
            'materials.*.material_description' => 'nullable|string',
            'materials.*.applicable_to' => 'required|in:onetime,weekly,monthly,yearly,all',
            'materials.*.material_price' => 'required|numeric|min:0|max:999999.99',
            'materials.*.material_image' => 'nullable|file',
            // Frequency options validation
            'onetime_frequencies' => 'nullable|array',
            'onetime_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'onetime_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'onetime_frequencies.*.description' => 'nullable|string',
            'weekly_frequencies' => 'nullable|array',
            'weekly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:7',
            'weekly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'weekly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'weekly_frequencies.*.description' => 'nullable|string',
            'monthly_frequencies' => 'nullable|array',
            'monthly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:30',
            'monthly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'monthly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'monthly_frequencies.*.description' => 'nullable|string',
            'yearly_frequencies' => 'nullable|array',
            'yearly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:12',
            'yearly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'yearly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'yearly_frequencies.*.description' => 'nullable|string',
        ];

        $validated = $request->validate($validationRules);

        // Handle multiple service images
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $image->move('Service_images', $imageName);
                $imageNames[] = $imageName;
            }
        }

        // Store all images as array in media column (model will cast to JSON)
        $validated['media'] = !empty($imageNames) ? $imageNames : null;

        // Remove requirements, processes, materials, and frequencies from validated as they are handled separately
        unset($validated['requirements']);
        unset($validated['processes']);
        unset($validated['materials']);
        unset($validated['images']);
        unset($validated['onetime_frequencies']);
        unset($validated['weekly_frequencies']);
        unset($validated['monthly_frequencies']);
        unset($validated['yearly_frequencies']);

        // Encode whats_include as JSON
        $validated['whats_include'] = $request->whats_include;

        $service = Service::create($validated);

        // Handle frequency options - store in ServiceFrequencyOption table
        $this->storeFrequencyOptions($service, $request);

        // Handle requirements
        if ($request->has('requirements') && is_array($request->requirements)) {
            foreach ($request->requirements as $index => $requirementData) {
                $reqImage = '';
                $fileKey = "requirements.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $reqImage = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Service_requirement_images', $reqImage);
                }

                ServiceRequirement::create([
                    'service_id' => $service->id,
                    'title' => $requirementData['title'],
                    'image' => $reqImage,
                ]);
            }
        }

        // Handle processes
        if ($request->has('processes') && is_array($request->processes)) {
            foreach ($request->processes as $index => $processData) {
                $processImage = '';
                $fileKey = "processes.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $processImage = time() . '_process_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Process_images', $processImage);
                }

                Process::create([
                    'service_id' => $service->id,
                    'title' => $processData['title'],
                    'description' => $processData['description'],
                    'image' => $processImage,
                    'order' => $index,
                ]);
            }
        }

        // Handle materials
        if ($request->has('materials') && is_array($request->materials)) {
            // Debug: Log the materials data
            \Log::info('CREATE - Materials data received:', [
                'count' => count($request->materials),
                'data' => $request->materials
            ]);

            foreach ($request->materials as $index => $materialData) {
                // Skip empty materials
                if (empty($materialData['material_name'])) {
                    \Log::info('CREATE - Skipping empty material at index: ' . $index);
                    continue;
                }

                $materialImage = '';
                $fileKey = "materials.{$index}.material_image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    // Use uniqid to prevent filename collisions
                    $materialImage = time() . '_' . uniqid() . '_material_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Material_images', $materialImage);
                }

                $createdMaterial = ServiceMaterial::create([
                    'service_id' => $service->id,
                    'material_name' => $materialData['material_name'],
                    'material_description' => $materialData['material_description'] ?? null,
                    'applicable_to' => $materialData['applicable_to'],
                    'material_price' => $materialData['material_price'],
                    'material_image' => $materialImage,
                ]);

                \Log::info('CREATE - Material created successfully:', [
                    'id' => $createdMaterial->id,
                    'name' => $createdMaterial->material_name,
                    'index' => $index
                ]);
            }
        }

        return redirect()->route('services.services.index')->with('success', 'Service created successfully.');
    }

    private function storeFrequencyOptions($service, $request)
    {
        // Store one-time frequency options
        if ($request->has('onetime_frequencies') && is_array($request->onetime_frequencies)) {
            foreach ($request->onetime_frequencies as $frequency) {
                if (!empty($frequency['price_per_time']) || !empty($frequency['duration'])) {
                    \App\Models\ServiceFrequencyOption::create([
                        'service_id' => $service->id,
                        'frequency_type' => 'onetime',
                        'no_of_times' => 1,
                        'duration' => $frequency['duration'] ?? null,
                        'price_per_time' => $frequency['price_per_time'] ?? null,
                        'description' => $frequency['description'] ?? null,
                    ]);
                }
            }
        }

        // Store weekly frequency options
        if ($request->has('weekly_frequencies') && is_array($request->weekly_frequencies)) {
            foreach ($request->weekly_frequencies as $frequency) {
                if (!empty($frequency['price_per_time'])) {
                    \App\Models\ServiceFrequencyOption::create([
                        'service_id' => $service->id,
                        'frequency_type' => 'weekly',
                        'no_of_times' => $frequency['no_of_times'] ?? 1,
                        'duration' => $frequency['duration'] ?? null,
                        'price_per_time' => $frequency['price_per_time'] ?? null,
                        'description' => $frequency['description'] ?? null,
                    ]);
                }
            }
        }

        // Store monthly frequency options
        if ($request->has('monthly_frequencies') && is_array($request->monthly_frequencies)) {
            foreach ($request->monthly_frequencies as $frequency) {
                if (!empty($frequency['price_per_time'])) {
                    \App\Models\ServiceFrequencyOption::create([
                        'service_id' => $service->id,
                        'frequency_type' => 'monthly',
                        'no_of_times' => $frequency['no_of_times'] ?? 1,
                        'duration' => $frequency['duration'] ?? null,
                        'price_per_time' => $frequency['price_per_time'] ?? null,
                        'description' => $frequency['description'] ?? null,
                    ]);
                }
            }
        }

        // Store yearly frequency options
        if ($request->has('yearly_frequencies') && is_array($request->yearly_frequencies)) {
            foreach ($request->yearly_frequencies as $frequency) {
                if (!empty($frequency['price_per_time'])) {
                    \App\Models\ServiceFrequencyOption::create([
                        'service_id' => $service->id,
                        'frequency_type' => 'yearly',
                        'no_of_times' => $frequency['no_of_times'] ?? 1,
                        'duration' => $frequency['duration'] ?? null,
                        'price_per_time' => $frequency['price_per_time'] ?? null,
                        'description' => $frequency['description'] ?? null,
                    ]);
                }
            }
        }
    }

    public function servicesShow(Service $service)
    {
        $service->load(['category', 'subcategory', 'processes' => function ($query) {
            $query->orderBy('order');
        }, 'requirements', 'materials']);
        return view('admin.services.services.show', compact('service'));
    }

    public function servicesEdit(Service $service)
    {
        $service->load('processes', 'requirements', 'materials', 'frequencyOptions');
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();
        return view('admin.services.services.edit', compact('service', 'categories', 'subcategories'));
    }

    public function servicesUpdate(Request $request, Service $service)
    {
        // Build dynamic validation rules based on enabled subscriptions
        $validationRules = [
            'category_id' => 'required|exists:categories,id|numeric',
            'subcategory_id' => 'nullable|exists:subcategories,id|numeric',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'whats_include' => 'nullable|array',
            'whats_include.*' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_arabic' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file',
            'requirements' => 'nullable|array',
            'requirements.*.title' => 'required|string|max:255',
            'processes' => 'nullable|array',
            'processes.*.title' => 'required|string|max:255',
            'processes.*.description' => 'required|string',
            'materials' => 'nullable|array',
            'materials.*.material_name' => 'required|string|max:255',
            'materials.*.material_description' => 'nullable|string',
            'materials.*.applicable_to' => 'required|in:onetime,weekly,monthly,yearly,all',
            'materials.*.material_price' => 'required|numeric|min:0|max:999999.99',
            'materials.*.material_image' => 'nullable|file',
            // Frequency options validation
            'onetime_frequencies' => 'nullable|array',
            'onetime_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'onetime_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'onetime_frequencies.*.description' => 'nullable|string',
            'weekly_frequencies' => 'nullable|array',
            'weekly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:7',
            'weekly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'weekly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'weekly_frequencies.*.description' => 'nullable|string',
            'monthly_frequencies' => 'nullable|array',
            'monthly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:30',
            'monthly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'monthly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'monthly_frequencies.*.description' => 'nullable|string',
            'yearly_frequencies' => 'nullable|array',
            'yearly_frequencies.*.no_of_times' => 'nullable|integer|min:1|max:12',
            'yearly_frequencies.*.duration' => 'nullable|integer|min:1|max:10',
            'yearly_frequencies.*.price_per_time' => 'nullable|numeric|min:0|max:999999.99',
            'yearly_frequencies.*.description' => 'nullable|string',
        ];

        $validated = $request->validate($validationRules);

        // Handle multiple service images
        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $image->move('Service_images', $imageName);
                $imageNames[] = $imageName;
            }
            // Update media with all uploaded images
            if (!empty($imageNames)) {
                // Delete old images if exists
                if ($service->media) {
                    $oldImages = is_array($service->media) ? $service->media : json_decode($service->media, true);
                    if (is_array($oldImages)) {
                        foreach ($oldImages as $oldImage) {
                            $oldfile = public_path('Service_images/' . $oldImage);
                            if (file_exists($oldfile)) {
                                unlink($oldfile);
                            }
                        }
                    }
                }
                $validated['media'] = $imageNames;
            }
        }

        // Remove requirements, processes, materials, and frequencies from validated
        unset($validated['requirements']);
        unset($validated['processes']);
        unset($validated['materials']);
        unset($validated['images']);
        unset($validated['onetime_frequencies']);
        unset($validated['weekly_frequencies']);
        unset($validated['monthly_frequencies']);
        unset($validated['yearly_frequencies']);

        // Handle whats_include
        $validated['whats_include'] = $request->whats_include;

        $service->update($validated);

        // Handle frequency options - delete old and create new
        $service->frequencyOptions()->delete();
        $this->storeFrequencyOptions($service, $request);

        // Handle requirements: delete old and create new, preserving existing images
        $service->requirements()->delete();

        if ($request->has('requirements') && is_array($request->requirements)) {
            foreach ($request->requirements as $index => $requirementData) {
                $reqImage = $requirementData['existing_image'] ?? '';
                $fileKey = "requirements.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $reqImage = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Service_requirement_images', $reqImage);
                }

                ServiceRequirement::create([
                    'service_id' => $service->id,
                    'title' => $requirementData['title'],
                    'image' => $reqImage,
                ]);
            }
        }

        // Handle processes: delete old and create new
        $service->processes()->delete();

        if ($request->has('processes') && is_array($request->processes)) {
            foreach ($request->processes as $index => $processData) {
                $processImage = '';
                $fileKey = "processes.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $processImage = time() . '_process_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Process_images', $processImage);
                }

                Process::create([
                    'service_id' => $service->id,
                    'title' => $processData['title'],
                    'description' => $processData['description'],
                    'image' => $processImage,
                    'order' => $index,
                ]);
            }
        }

        // Handle materials: delete old and create new
        $service->materials()->delete();

        if ($request->has('materials') && is_array($request->materials)) {
            // Debug: Log the materials data
            \Log::info('Materials data received:', [
                'count' => count($request->materials),
                'data' => $request->materials
            ]);

            foreach ($request->materials as $index => $materialData) {
                // Skip empty materials
                if (empty($materialData['material_name'])) {
                    \Log::info('Skipping empty material at index: ' . $index);
                    continue;
                }

                $materialImage = '';
                $fileKey = "materials.{$index}.material_image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    // Use microtime to prevent filename collisions
                    $materialImage = time() . '_' . uniqid() . '_material_' . $index . '_' . $file->getClientOriginalName();
                    $file->move('Material_images', $materialImage);
                }

                $createdMaterial = ServiceMaterial::create([
                    'service_id' => $service->id,
                    'material_name' => $materialData['material_name'],
                    'material_description' => $materialData['material_description'] ?? null,
                    'applicable_to' => $materialData['applicable_to'],
                    'material_price' => $materialData['material_price'],
                    'material_image' => $materialImage,
                ]);

                \Log::info('Material created successfully:', [
                    'id' => $createdMaterial->id,
                    'name' => $createdMaterial->material_name,
                    'index' => $index
                ]);
            }
        }

        return redirect()->route('services.services.index')->with('success', 'Service updated successfully.');
    }

    public function toggleField(Service $service, string $field)
    {
        // Validate the field
        if (!in_array($field, ['qwikpick', 'beauty_and_easy'])) {
            return response()->json(['success' => false, 'message' => 'Invalid field'], 400);
        }

        // Toggle the field value
        $service->$field = !$service->$field;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' status updated',
            'value' => $service->$field
        ]);
    }

    public function servicesDestroy(Service $service)
    {
        // Delete the service
        $service->delete();

        return redirect()->route('services.services.index')->with('success', 'Service deleted successfully.');
    }
}
