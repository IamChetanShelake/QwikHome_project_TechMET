<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.contentManagement.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.contentManagement.banners.create');
    }

    public function store(Request $request)
    {
        // Handle bulk insert
        $titles = $request->input('titles', []);
        $descriptions = $request->input('descriptions', []);
        $statuses = $request->input('statuses', []);
        $uploadedImages = $request->file('images', []);

        if (count($titles) > 0) {
            // Bulk insert from array data
            $bannersData = [];
            foreach ($titles as $key => $title) {
                // Allow empty titles
                $bannerData = [
                    'title' => $title,
                    'description' => $descriptions[$key] ?? null,
                    'status' => $statuses[$key] ?? 'inactive',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Handle image for this banner
                if (isset($uploadedImages[$key])) {
                    $imageFile = $uploadedImages[$key];
                    $imageName = time() . '_.' . $imageFile->extension();
                    $imageFile->move('banner_images', $imageName);
                    $bannerData['image'] = $imageName;
                }

                $bannersData[] = $bannerData;
            }

            if (!empty($bannersData)) {
                Banner::insert($bannersData);
            }
        } else {
            // Single insert for backward compatibility
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->only(['title', 'description', 'status']);

            if ($request->hasFile('image')) {
                $imageName = time() . '_.' . $request->image->extension();
                $request->image->move('banner_images', $imageName);
                $data['image'] = $imageName;
            }

            Banner::create($data);
        }

        return redirect()->route('contentManagement.banners.index')
            ->with('success', 'Banner(s) created successfully.');
    }

    public function show(Banner $banner)
    {
        return view('admin.contentManagement.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.contentManagement.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['title', 'description', 'status']);

        if ($request->hasFile('image')) {
            $oldfile = public_path('banner_images/' . $banner->image);
            if ($banner->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '_.' . $request->image->extension();
            $request->image->move('banner_images', $imageName);
            $data['image'] = $imageName;
        }

        $banner->update($data);

        return redirect()->route('contentManagement.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $oldfile = public_path('banner_images/' . $banner->image);
        if ($banner->image && file_exists($oldfile)) {
            unlink($oldfile);
        }

        $banner->delete();

        return redirect()->route('contentManagement.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
