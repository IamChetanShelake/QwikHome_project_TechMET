<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Disclaimer;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsCondition;
use Illuminate\Http\Request;

class PolicyApiController extends Controller
{
    public function getDisclaimer()
    {
        $disclaimer = Disclaimer::where('status', 'active')->latest()->first();

        if (!$disclaimer) {
            return response()->json([
                'status' => false,
                'message' => 'Disclaimer not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Disclaimer retrieved successfully',
            'data' => $disclaimer,
        ]);
    }

    public function getPrivacyPolicy()
    {
        $policy = PrivacyPolicy::where('status', 'active')->latest()->first();

        if (!$policy) {
            return response()->json([
                'status' => false,
                'message' => 'Privacy Policy not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Privacy Policy retrieved successfully',
            'data' => $policy,
        ]);
    }

    public function getRefundPolicy()
    {
        $policy = RefundPolicy::where('status', 'active')->latest()->first();

        if (!$policy) {
            return response()->json([
                'status' => false,
                'message' => 'Refund Policy not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Refund Policy retrieved successfully',
            'data' => $policy,
        ]);
    }

    public function getTermsConditions()
    {
        $policy = TermsCondition::where('status', 'active')->latest()->first();

        if (!$policy) {
            return response()->json([
                'status' => false,
                'message' => 'Terms and Conditions not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Terms and Conditions retrieved successfully',
            'data' => $policy,
        ]);
    }
}
