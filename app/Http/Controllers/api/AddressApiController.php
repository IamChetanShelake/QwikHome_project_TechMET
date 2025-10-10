<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressApiController extends Controller
{
    /**
     * Get all addresses for a user
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $addresses = Address::with('user')->where('user_id', $request->user)
                ->orderBy('is_default', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Addresses retrieved successfully',
                'data' => $addresses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to retrieve addresses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new address
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'contact_details' => 'required',
                'address_details' => 'required',
                'type' => 'nullable|in:home,work,other',
                'is_default' => 'boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // If this address is set as default, unset other default addresses
            if ($request->is_default) {
                Address::where('user_id', $request->user)
                    ->where('is_default', true)
                    ->update(['is_default' => false]);
            }

            $address = Address::create([
                'user_id' => $request->user,
                'contact_details' => $request->contact_details,
                'address_details' => $request->address_details,
                'type' => $request->type ?? null,
                'is_default' => $request->is_default ?? true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'status_code' => 201,
                'message' => 'Address added successfully',
                'data' => $address,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to add address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit address
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'address_id' => 'required|exists:addresses,id',
                'contact_details' => 'required',
                'address_details' => 'required',
                'type' => 'nullable|in:home,work,other',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $address = Address::where('id', $request->address_id)
                ->where('user_id', $request->user)
                ->first();

            if (!$address) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Address not found or does not belong to user'
                ], 404);
            }




            $address->update([
                'contact_details' => $request->contact_details,
                'address_details' => $request->address_details,
                'type' => $request->type ?? null,
                'is_default' => $request->is_default ?? false,
            ]);

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Address updated successfully',
                'data' => $address,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to update address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove address
     */
    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user' => 'required|exists:users,id',
                'address_id' => 'required|exists:addresses,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $address = Address::where('id', $request->address_id)
                ->where('user_id', $request->user)
                ->first();

            if (!$address) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Address not found or does not belong to user'
                ], 404);
            }

            $address->delete();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Address removed successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Failed to remove address',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
