<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Models\User;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'assignedAdmin']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by complaint type
        if ($request->filled('complaint_type')) {
            $query->where('complaint_type', $request->complaint_type);
        }

        // Filter by user
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function view($id)
    {
        $complaint = Complaint::with(['user', 'assignedAdmin'])->findOrFail($id);
        $admins = User::where('role', 'admin')->orWhere('is_admin', 1)->get();

        return view('admin.complaints.view', compact('complaint', 'admins'));
    }

    public function assignAdmin(Request $request, $id)
    {
        $request->validate([
            'assigned_admin_id' => 'required|exists:users,id'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'assigned_admin_id' => $request->assigned_admin_id,
            'status' => 'in_review'
        ]);

        return redirect()->back()->with('success', 'Complaint has been assigned to an admin.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_review,resolved,rejected'
        ]);

        $complaint = Complaint::findOrFail($id);
        $data = ['status' => $request->status];

        // If resolved, set resolved_at timestamp
        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
        } elseif ($request->status === 'in_review') {
            // When changing to in_review, make sure an admin is assigned
            if (!$complaint->assigned_admin_id) {
                $data['assigned_admin_id'] = Auth::id();
            }
        }

        $complaint->update($data);

        return redirect()->back()->with('success', 'Complaint status has been updated.');
    }

    public function resolveComplaint(Request $request, $id)
    {
        $request->validate([
            'resolution_action' => 'required|in:refund,replacement,account_blocked,warning,none,other',
            'resolution_details' => 'required|string',
            'admin_notes' => 'nullable|string'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'status' => 'resolved',
            'resolution_action' => $request->resolution_action,
            'resolution_details' => $request->resolution_details,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => now()
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint has been resolved.');
    }

    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update(['admin_notes' => $request->admin_notes]);

        return redirect()->back()->with('success', 'Admin notes have been updated.');
    }

    public function getStats()
    {
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'in_review' => Complaint::where('status', 'in_review')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
        ];

        return response()->json($stats);
    }
}
