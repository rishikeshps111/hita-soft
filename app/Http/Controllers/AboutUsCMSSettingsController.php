<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AboutUsCMSSettings;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use View;
use Session;
use Redirect;

class AboutUsCMSSettingsController extends Controller
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index()
    {
        $loged = session()->get('user');
        if (!$loged) {
            Session::flash('message', 'Please Login Properly!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        if (!$this->canManage($loged, 'list')) {
            Session::flash('message', 'You Are Not Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

        $page = 'Settings';
        $about_page = AboutUsCMSSettings::all();

        return View::make('settings.aboutus.manage_about_page')->with(compact('about_page', 'page'));
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
        $about_page = AboutUsCMSSettings::first();
        $defaults = AboutUsCMSSettings::defaults();

        return view('settings.aboutus.add_about_page')->with(compact('about_page', 'defaults', 'page'));
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
            'who_title' => 'required',
            'who_content' => 'required',
            'what_title' => 'required',
            'what_content' => 'required',
            'what_items' => 'required',
            'mission_title' => 'required',
            'mission_content' => 'required',
            'vision_title' => 'required',
            'vision_content' => 'required',
            'core_values_title' => 'required',
            'core_value_title' => 'required|array',
            'core_value_description' => 'required|array',
            'leadership_label' => 'required',
            'leadership_name' => 'required',
            'leadership_designation' => 'required',
            'leadership_content' => 'required',
            'presence_label' => 'required',
            'presence_name' => 'required',
            'presence_address' => 'required',
            'presence_phone' => 'nullable',
            'presence_email' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('add_about_page')->withErrors($validator)->withInput();
        }

        $about_page = AboutUsCMSSettings::first();
        if (!$about_page) {
            $about_page = new AboutUsCMSSettings();
        }

        $about_page->banner_title = $request->banner_title;
        $about_page->banner_image = $this->storeUpload($request, 'banner_image', $request->old_banner_image);
        $about_page->who_title = $request->who_title;
        $about_page->who_image = $this->storeUpload($request, 'who_image', $request->old_who_image);
        $about_page->who_content = $this->lines($request->who_content);
        $about_page->what_title = $request->what_title;
        $about_page->what_content = $request->what_content;
        $about_page->what_items = $this->lines($request->what_items);
        $about_page->what_image = $this->storeUpload($request, 'what_image', $request->old_what_image);
        $about_page->mission_title = $request->mission_title;
        $about_page->mission_content = $request->mission_content;
        $about_page->vision_title = $request->vision_title;
        $about_page->vision_content = $request->vision_content;
        $about_page->core_values_title = $request->core_values_title;
        $about_page->core_values = $this->coreValues($request);
        $about_page->leadership_bg_image = $this->storeUpload($request, 'leadership_bg_image', $request->old_leadership_bg_image);
        $about_page->leadership_label = $request->leadership_label;
        $about_page->leadership_name = $request->leadership_name;
        $about_page->leadership_designation = $request->leadership_designation;
        $about_page->leadership_content = $request->leadership_content;
        $about_page->presence_label = $request->presence_label;
        $about_page->presence_name = $request->presence_name;
        $about_page->presence_address = $request->presence_address;
        $about_page->presence_phone = $request->presence_phone;
        $about_page->presence_email = $request->presence_email;
        $about_page->is_block = 1;

        // Keep key legacy fields populated for older frontend routes that may still read them.
        $about_page->banner_caption = $request->banner_title;
        $about_page->abo_title = $request->who_title;
        $about_page->abo_desc = implode("\n", $this->lines($request->who_content));
        $about_page->sec1_desc = $request->what_content;
        $about_page->sec2_desc = $request->mission_content;

        if ($about_page->save()) {
            Session::flash('message', 'About Us Page Updated Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('add_about_page');
        }

        Session::flash('message', 'Update Failed!');
        Session::flash('alert-class', 'alert-danger');
        return Redirect::back();
    }

    private function canManage($loged, $ability = null)
    {
        $query = DB::table('previlages as A')
            ->leftJoin('modules as B', 'A.module', '=', 'B.id')
            ->select('A.id as pid', 'A.*', 'B.id as mid', 'B.*')
            ->where('B.module_name', '=', 'CMS About Us Page')
            ->where('A.role', '=', $loged->user_type);

        if ($ability === 'list') {
            return $query->where('A.list', '=', 1)->first();
        }

        return $query->where(function ($query) {
            $query->where('A.edit', '=', 1)
                ->orWhere('A.add', '=', 1);
        })->first();
    }

    private function lines($value)
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(function ($line) {
                return trim($line);
            })
            ->filter()
            ->values()
            ->all();
    }

    private function coreValues(Request $request)
    {
        $values = [];
        foreach ((array) $request->core_value_title as $key => $title) {
            if (!$title && empty($request->core_value_description[$key])) {
                continue;
            }

            $values[] = [
                'title' => $title,
                'description' => $request->core_value_description[$key] ?? '',
            ];
        }

        return $values;
    }

    private function storeUpload(Request $request, $key, $old = null)
    {
        if (!$request->hasFile($key)) {
            return $old;
        }

        $file = $request->file($key);
        $fileName = time() . '_' . $file->getClientOriginalName();
        $date = date('M-Y');
        $filePath = 'images/about_page/' . $date;
        $file->move($filePath, $fileName);

        return $filePath . '/' . $fileName;
    }
}
