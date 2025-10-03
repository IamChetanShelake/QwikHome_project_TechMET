<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {


        $customers = User::where('role', 'user')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function toggleBlock(Request $request)
    {
        $customer = User::findOrFail($request->id);

        // Toggle active status
        $customer->active = $customer->active == 0 ? 1 : 0;
        $customer->save();

        return response()->json([
            'success' => true,
            'status' => $customer->active,
            'message' => $customer->active ? 'User blocked' : 'User unblocked'
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(10) // optional, limit results
            ->get();

        return response()->json($users);
    }

    public function view($id){
        $customer = User::find($id);
        return view('admin.customers.view', compact('customer'));   
    }
}
