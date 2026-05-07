<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUsPage;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use View;
use Session;
use Redirect;

class ContactUsPagesController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function create()
    {
        $loged = session()->get('user');
        if (!$loged) {
            Session::flash('message', 'Please Login Properly!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (!$this->canManage($loged)) {
            Session::flash('message', 'You Are Not Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $page = 'Settings';
        $contact = ContactUsPage::first();
        $defaults = ContactUsPage::defaults();

        return View::make('settings.contact_page_setting')->with(compact('contact', 'defaults', 'page'));
    }

    public function store(Request $request)
    {
        $loged = session()->get('user');
        if (!$loged) {
            Session::flash('message', 'Please Login Properly!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (!$this->canManage($loged)) {
            Session::flash('message', 'You Are Not Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'banner_title' => 'required',
            'form_intro' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'map_iframe' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact_page_setting')->withErrors($validator)->withInput();
        }

        $contact = ContactUsPage::first();
        if (!$contact) {
            $contact = new ContactUsPage();
        }

        $contact->banner_title = $request->banner_title;
        $contact->banner_caption = $request->banner_title;
        $contact->form_intro = $request->form_intro;
        $contact->address = $request->address;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->map_iframe = $request->map_iframe;
        $contact->main_hd = $request->banner_title;
        $contact->content_1 = $request->address;
        $contact->content_2 = $request->email;
        $contact->content_3 = $request->phone;
        $contact->touch_hd = 'Contact Form';
        $contact->banner_image = $this->storeUpload($request, 'banner_image', $request->old_banner_image);

        if ($contact->save()) {
            Session::flash('message', 'Contact Page Settings Updated Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('contact_page_setting');
        }

        Session::flash('message', 'Update Failed!');
        Session::flash('alert-class', 'alert-danger');
        return Redirect::back();
    }

    private function canManage($loged)
    {
        return DB::table('previlages as A')
            ->leftJoin('modules as B', 'A.module', '=', 'B.id')
            ->select('A.id as pid', 'A.*', 'B.id as mid', 'B.*')
            ->where('B.module_name', '=', 'Contact Us Page')
            ->where('A.role', '=', $loged->user_type)
            ->where(function ($query) {
                $query->where('A.edit', '=', 1)
                    ->orWhere('A.add', '=', 1);
            })
            ->first();
    }

    private function storeUpload(Request $request, $key, $old = null)
    {
        if (!$request->hasFile($key)) {
            return $old;
        }

        $file = $request->file($key);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $date = date('M-Y');
        $filePath = 'images/contact/' . $date;
        $file->move($filePath, $fileName);

        return $filePath . '/' . $fileName;
    }
}
