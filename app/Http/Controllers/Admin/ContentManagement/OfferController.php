<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->paginate(10);
        return view('admin.contentManagement.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('admin.contentManagement.offers.create');
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
            $offersData = [];
            foreach ($titles as $key => $title) {
                // Allow empty titles
                $offerData = [
                    'title' => $title,
                    'description' => $descriptions[$key] ?? null,
                    'status' => $statuses[$key] ?? 'inactive',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Handle image for this offer
                if (isset($uploadedImages[$key])) {
                    $imageFile = $uploadedImages[$key];
                    $imageName = time() . '_' . $key . '_' . uniqid() . '.' . $imageFile->extension();
                    $imageFile->move('offer_images', $imageName);
                    $offerData['image'] = $imageName;
                }

                $offersData[] = $offerData;
            }

            if (!empty($offersData)) {
                Offer::insert($offersData);
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
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move('offer_images', $imageName);
                $data['image'] = $imageName;
            }

            Offer::create($data);
        }

        return redirect()->route('contentManagement.offers.index')
            ->with('success', 'Offer(s) created successfully.');
    }

    public function show(Offer $offer)
    {
        return view('admin.contentManagement.offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        return view('admin.contentManagement.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['title', 'description', 'status']);

        if ($request->hasFile('image')) {
            $oldfile = public_path('offer_images/' . $offer->image);
            if ($offer->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('offer_images', $imageName);
            $data['image'] = $imageName;
        }

        $offer->update($data);

        return redirect()->route('contentManagement.offers.index')
            ->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer)
    {
        $oldfile = public_path('offer_images/' . $offer->image);
        if ($offer->image && file_exists($oldfile)) {
            unlink($oldfile);
        }

        $offer->delete();

        return redirect()->route('contentManagement.offers.index')
            ->with('success', 'Offer deleted successfully.');
    }
}
