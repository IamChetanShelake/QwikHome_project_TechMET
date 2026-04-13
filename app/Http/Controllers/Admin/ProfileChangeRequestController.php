<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileChangeRequestController extends Controller
{
    public function index()
    {
        $requests = ProfileChangeRequest::with('serviceProvider')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.profile-change-requests.index', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $user = $changeRequest->serviceProvider;
        $requestedData = $changeRequest->requested_data;
        // dd($requestedData);
        // Update user data
        $updateData = [];

        if (isset($requestedData['name'])) {
            $updateData['name'] = $requestedData['name'];
        }
        if (isset($requestedData['email'])) {
            $updateData['email'] = $requestedData['email'];
        }
        if (isset($requestedData['phone'])) {
            $updateData['phone'] = $requestedData['phone'];
        }
        if (isset($requestedData['alternatePhone'])) {
            $updateData['alternatePhone'] = $requestedData['alternatePhone'];
        }
        if (isset($requestedData['biography'])) {
            $updateData['biography'] = $requestedData['biography'];
        }
        if (isset($requestedData['address'])) {
            $updateData['address'] = $requestedData['address'];
        }

        // Handle profile image
        if (isset($requestedData['profileImage']) && $requestedData['profileImage']) {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $user->image);
            if ($user->image && file_exists($oldfile)) {
                unlink($oldfile);
            }

            $updateData['image'] = $requestedData['profileImage'];
        }

        $user->update($updateData);

        // Update request status
        $changeRequest->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('success', 'Profile change request approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        // Delete image if exists
        if (isset($changeRequest->requested_data['profileImage']) && $changeRequest->requested_data['profileImage']) {
            $imagePath = public_path('user_images/' . $changeRequest->requested_data['profileImage']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Update request status
        $changeRequest->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
            'approved_at' => now()
        ]);

        return redirect()->back()->with('success', 'Profile change request rejected successfully.');
    }

    public function show($id)
    {
        $request = ProfileChangeRequest::with('serviceProvider')->findOrFail($id);
        return view('admin.profile-change-requests.show', compact('request'));
    }

    public function approveField(Request $request, $id, $field)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $user = $changeRequest->serviceProvider;
        $requestedData = $changeRequest->requested_data;

        $updateData = [];

        // Handle specific field approval
        switch ($field) {
            case 'name':
                if (isset($requestedData['name'])) {
                    $updateData['name'] = $requestedData['name'];
                    unset($requestedData['name']);
                }
                break;
            case 'email':
                if (isset($requestedData['email'])) {
                    $updateData['email'] = $requestedData['email'];
                    unset($requestedData['email']);
                }
                break;
            case 'phone':
                if (isset($requestedData['phone'])) {
                    $updateData['phone'] = $requestedData['phone'];
                    unset($requestedData['phone']);
                }
                break;
            case 'alternatePhone':
                if (isset($requestedData['alternatePhone'])) {
                    $updateData['alternate_phone'] = $requestedData['alternatePhone'];
                    unset($requestedData['alternatePhone']);
                }
                break;
            case 'biography':
                if (isset($requestedData['biography'])) {
                    $updateData['biography'] = $requestedData['biography'];
                    unset($requestedData['biography']);
                }
                break;
            case 'address':
                if (isset($requestedData['address'])) {
                    $updateData['address'] = $requestedData['address'];
                    unset($requestedData['address']);
                }
                break;
            case 'profileImage':
                if (isset($requestedData['profileImage']) && $requestedData['profileImage']) {
                    // Delete old image if exists
                    $oldfile = public_path('user_images/' . $user->image);
                    if ($user->image && file_exists($oldfile)) {
                        unlink($oldfile);
                    }

                    $updateData['image'] = $requestedData['profileImage'];
                    unset($requestedData['profileImage']);
                }
                break;
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        // Update the requested_data to remove the approved field
        $changeRequest->update([
            'requested_data' => $requestedData
        ]);

        // If no more changes remain, mark as approved
        if (empty($requestedData)) {
            $changeRequest->update([
                'status' => 'approved',
                'admin_id' => auth()->id(),
                'approved_at' => now()
            ]);
        }

        return redirect()->back()->with('success', ucfirst($field) . ' approved successfully.');
    }

    public function rejectField(Request $request, $id, $field)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $requestedData = $changeRequest->requested_data;

        // Remove the rejected field from requested data
        if (isset($requestedData[$field])) {
            // If it's an image, delete the file
            if ($field === 'profileImage' && $requestedData[$field]) {
                $imagePath = public_path('user_images/' . $requestedData[$field]);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            unset($requestedData[$field]);
        }

        // Update the requested_data
        $changeRequest->update([
            'requested_data' => $requestedData
        ]);

        // If no more changes remain, mark as approved (since remaining fields are approved)
        if (empty($requestedData)) {
            $changeRequest->update([
                'status' => 'approved',
                'admin_id' => auth()->id(),
                'approved_at' => now()
            ]);
        }

        return redirect()->back()->with('success', ucfirst($field) . ' rejected successfully.');
    }

    public function approveAll(Request $request, $id)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $user = $changeRequest->serviceProvider;
        $requestedData = $changeRequest->requested_data;

        $updateData = [];

        if (isset($requestedData['name'])) {
            $updateData['name'] = $requestedData['name'];
        }
        if (isset($requestedData['email'])) {
            $updateData['email'] = $requestedData['email'];
        }
        if (isset($requestedData['phone'])) {
            $updateData['phone'] = $requestedData['phone'];
        }
        if (isset($requestedData['alternatePhone'])) {
            $updateData['alternate_phone'] = $requestedData['alternatePhone'];
        }
        if (isset($requestedData['biography'])) {
            $updateData['biography'] = $requestedData['biography'];
        }
        if (isset($requestedData['address'])) {
            $updateData['address'] = $requestedData['address'];
        }

        // Handle profile image
        if (isset($requestedData['profileImage']) && $requestedData['profileImage']) {
            // Delete old image if exists
            $oldfile = public_path('user_images/' . $user->image);
            if ($user->image && file_exists($oldfile)) {
                unlink($oldfile);
            }

            $updateData['image'] = $requestedData['profileImage'];
        }



        if (!empty($updateData)) {
            $user->update($updateData);
        }

        // Update request status
        $changeRequest->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'approved_at' => now(),
            'requested_data' => [] // Clear all requested data
        ]);

        return redirect()->back()->with('success', 'All profile changes approved successfully.');
    }

    public function rejectAll(Request $request, $id)
    {
        $changeRequest = ProfileChangeRequest::findOrFail($id);

        if ($changeRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $requestedData = $changeRequest->requested_data;

        // Delete image if exists
        if (isset($requestedData['profileImage']) && $requestedData['profileImage']) {
            $imagePath = public_path('user_images/' . $requestedData['profileImage']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Update request status
        $changeRequest->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
            'approved_at' => now(),
            'requested_data' => [] // Clear all requested data
        ]);

        return redirect()->back()->with('success', 'All profile changes rejected successfully.');
    }
}
