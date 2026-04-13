<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ServiceProviderFaq;
use App\Models\Setting;
use Illuminate\Http\Request;

class SupportApiController extends Controller
{
    /**
     * Get support information including contact details and FAQs
     */
    public function support(Request $request)
    {
        // Get dynamic contact information from settings
        $supportEmail = "qwikhom@gmail.com";
        $supportPhone = 1234567890;

        // Get all active FAQs from service_provider_faqs table
        $faqs = ServiceProviderFaq::where('is_active', true)
            ->orderBy('created_at', 'asc')
            ->get();

        // Build the response structure as requested
        $response = [
            "contact" => [
                "livechat" => [
                    "title" => "Live Chat",
                    "data" => "get instant help from our team"
                ],
                "email_support" => [
                    "title" => "Email Support",
                    "data" => $supportEmail
                ],
                "phone_support" => [
                    "title" => "Phone Support",
                    "data" => $supportPhone
                ]
            ],
            "Frequently Asked Questions (FAQs)" => []
        ];

        // Add FAQs to the response
        $faqCounter = 1;
        foreach ($faqs as $faq) {
            $response["Frequently Asked Questions (FAQs)"]["q" . $faqCounter] = [
                "question" => $faq->question,
                "answer" => $faq->answer
            ];
            $faqCounter++;
        }

        return response()->json($response);
    }
}
