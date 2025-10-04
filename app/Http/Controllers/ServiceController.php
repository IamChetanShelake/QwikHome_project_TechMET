<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use App\Models\ServiceRequirement;
use App\Models\Process;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path('Category_images/' . $category->image))) {
                unlink(public_path('Category_images/' . $category->image));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image && file_exists(public_path('Subcategory_images/' . $subcategory->image))) {
                unlink(public_path('Subcategory_images/' . $subcategory->image));
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
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|numeric',
            'subcategory_id' => 'nullable|exists:subcategories,id|numeric',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'whats_include' => 'nullable|array',
            'whats_include.*' => 'nullable|string|max:255',
            'price_onetime' => 'required|numeric|min:0|max:999999.99',
            'price_weekly' => 'nullable|numeric|min:0|max:999999.99',
            'price_monthly' => 'nullable|numeric|min:0|max:999999.99',
            'price_yearly' => 'nullable|numeric|min:0|max:999999.99',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_arabic' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'requirements' => 'nullable|array',
            'requirements.*.title' => 'required|string|max:255',
            'processes' => 'nullable|array',
            'processes.*.title' => 'required|string|max:255',
            'processes.*.description' => 'required|string',
        ]);

        // Handle main service image
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Service_images'), $imageName);
        } else {
            $imageName = '';
        }

        $validated['image'] = $imageName;

        // Remove requirements and processes from validated as they are handled separately
        unset($validated['requirements']);
        unset($validated['processes']);

        // Encode whats_include as JSON
        $validated['whats_include'] = $request->whats_include;

        $service = Service::create($validated);

        // Handle requirements
        if ($request->has('requirements') && is_array($request->requirements)) {
            foreach ($request->requirements as $index => $requirementData) {
                $reqImage = '';
                $fileKey = "requirements.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $reqImage = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $file->move(public_path('Service_requirement_images'), $reqImage);
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
                    $file->move(public_path('Process_images'), $processImage);
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

        return redirect()->route('services.services.index')->with('success', 'Service created successfully.');
    }

    public function servicesShow(Service $service)
    {
        $service->load(['category', 'subcategory', 'processes' => function($query) {
            $query->orderBy('order');
        }, 'requirements']);
        return view('admin.services.services.show', compact('service'));
    }

    public function servicesEdit(Service $service)
    {
        $service->load('processes', 'requirements');
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();
        return view('admin.services.services.edit', compact('service', 'categories', 'subcategories'));
    }

    public function servicesUpdate(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id|numeric',
            'subcategory_id' => 'nullable|exists:subcategories,id|numeric',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'whats_include' => 'nullable|array',
            'whats_include.*' => 'nullable|string|max:255',
            'price_onetime' => 'required|numeric|min:0|max:999999.99',
            'price_weekly' => 'nullable|numeric|min:0|max:999999.99',
            'price_monthly' => 'nullable|numeric|min:0|max:999999.99',
            'price_yearly' => 'nullable|numeric|min:0|max:999999.99',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_arabic' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'requirements' => 'nullable|array',
            'requirements.*.title' => 'required|string|max:255',
            'processes' => 'nullable|array',
            'processes.*.title' => 'required|string|max:255',
            'processes.*.description' => 'required|string',
        ]);

        // Handle main service image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && file_exists(public_path('Service_images/' . $service->image))) {
                unlink(public_path('Service_images/' . $service->image));
            }
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Service_images'), $imageName);
            $validated['image'] = $imageName;
        }

        // Remove requirements and processes from validated
        unset($validated['requirements']);
        unset($validated['processes']);

        // Handle whats_include
        $validated['whats_include'] = $request->whats_include;

        $service->update($validated);

        // Handle requirements: delete old and create new, preserving existing images
        $service->requirements()->delete();

        if ($request->has('requirements') && is_array($request->requirements)) {
            foreach ($request->requirements as $index => $requirementData) {
                $reqImage = $requirementData['existing_image'] ?? '';
                $fileKey = "requirements.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $reqImage = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $file->move(public_path('Service_requirement_images'), $reqImage);
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
                    $file->move(public_path('Process_images'), $processImage);
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

        return redirect()->route('services.services.index')->with('success', 'Service updated successfully.');
    }

    public function servicesDestroy(Service $service)
    {
        // Delete the service
        $service->delete();

        return redirect()->route('services.services.index')->with('success', 'Service deleted successfully.');
    }
}
