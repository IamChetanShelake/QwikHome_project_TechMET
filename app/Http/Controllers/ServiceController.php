<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
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
        ]);

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
        ]);

        $category->update($validated);

        return redirect()->route('services.categories.index')->with('success', 'Category updated successfully.');
    }

    public function categoriesDestroy(Category $category)
    {
        // Soft delete by setting status to inactive
        $category->update(['status' => 'inactive']);

        return redirect()->route('services.categories.index')->with('success', 'Category deactivated successfully.');
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
        ]);

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
        ]);

        $subcategory->update($validated);

        return redirect()->route('services.subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function subcategoriesDestroy(Subcategory $subcategory)
    {
        $subcategory->update(['status' => 'inactive']);

        return redirect()->route('services.subcategories.index')->with('success', 'Subcategory deactivated successfully.');
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
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Service::create($validated);

        return redirect()->route('services.services.index')->with('success', 'Service created successfully.');
    }

    public function servicesEdit(Service $service)
    {
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
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0|max:999999.99',
            'duration' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        return redirect()->route('services.services.index')->with('success', 'Service updated successfully.');
    }

    public function servicesDestroy(Service $service)
    {
        $service->update(['status' => 'inactive']);

        return redirect()->route('services.services.index')->with('success', 'Service deactivated successfully.');
    }
}
