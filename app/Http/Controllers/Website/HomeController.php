<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $everythingWeOfferServices = Service::where('status', 'active')->where('everything_we_offer', 1)->latest()->get();
        $qwikpickServices = Service::where('status', 'active')->where('qwikpick', 1)->latest()->get();
        $beautyAndEasyServices = Service::where('status', 'active')->where('beauty_and_easy', 1)->latest()->get();

        return view('website.home', compact('categories', 'everythingWeOfferServices', 'qwikpickServices', 'beautyAndEasyServices'));
    }
}
