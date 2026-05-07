<?php

namespace App\Http\Controllers;

use App\HomeService;
use App\AboutUsCMSSettings;
use App\ContactUsPage;
use App\Contacts;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class FrontendController extends Controller
{
    public function products()
    {
        $products = Products::where('is_block', 1)->orderBy('created_at', 'DESC')->get();

        return view('frontend.products', compact('products'));
    }

    public function services()
    {
        $services = HomeService::where('is_block', 1)->orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();

        return view('frontend.services', compact('services'));
    }

    public function aboutUs()
    {
        $about_page = AboutUsCMSSettings::first();

        return view('frontend.about-us', compact('about_page'));
    }

    public function contactUs()
    {
        $contact_page = ContactUsPage::first();

        return view('frontend.contact-us', compact('contact_page'));
    }

    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_name' => 'required|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|max:255',
            'subject' => 'nullable|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact_us')->withErrors($validator)->withInput();
        }

        Contacts::create([
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_block' => 1,
        ]);

        Session::flash('message', 'Your message has been submitted successfully. Thank you.');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('contact_us');
    }
}
