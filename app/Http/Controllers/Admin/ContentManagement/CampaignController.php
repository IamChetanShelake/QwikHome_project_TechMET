<?php

namespace App\Http\Controllers\Admin\ContentManagement;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('admin.contentManagement.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.contentManagement.campaigns.create');
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
            $campaignsData = [];
            foreach ($titles as $key => $title) {
                // Allow empty titles
                $campaignData = [
                    'title' => $title,
                    'description' => $descriptions[$key] ?? null,
                    'status' => $statuses[$key] ?? 'inactive',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Handle image for this campaign
                if (isset($uploadedImages[$key])) {
                    $imageFile = $uploadedImages[$key];
                    $imageName = time() . '_' . $key . '_' . uniqid() . '.' . $imageFile->extension();
                    $imageFile->move('campaign_images', $imageName);
                    $campaignData['image'] = $imageName;
                }

                $campaignsData[] = $campaignData;
            }

            if (!empty($campaignsData)) {
                Campaign::insert($campaignsData);
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
                $request->image->move('campaign_images', $imageName);
                $data['image'] = $imageName;
            }

            Campaign::create($data);
        }

        return redirect()->route('contentManagement.campaigns.index')
            ->with('success', 'Campaign(s) created successfully.');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.contentManagement.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.contentManagement.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['title', 'description', 'status']);

        if ($request->hasFile('image')) {
            $oldfile = public_path('campaign_images/' . $campaign->image);
            if ($campaign->image && file_exists($oldfile)) {
                unlink($oldfile);
            }
            $imageName = time() . '_.' . $request->image->extension();
            $request->image->move('campaign_images', $imageName);
            $data['image'] = $imageName;
        }

        $campaign->update($data);

        return redirect()->route('contentManagement.campaigns.index')
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $oldfile = public_path('campaign_images/' . $campaign->image);
        if ($campaign->image && file_exists($oldfile)) {
            unlink($oldfile);
        }

        $campaign->delete();

        return redirect()->route('contentManagement.campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }
}
