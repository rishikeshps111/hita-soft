<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AboutUsCMSSettings;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class old_18_02_21_AboutUsCMSSettingsController extends Controller
{
    protected $respose;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS About Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $about_page = AboutUsCMSSettings::all();
            	return View::make("settings.aboutus.manage_about_page")->with(array('about_page'=>$about_page, 'page'=>$page));
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function create () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS About Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
                $about_page = AboutUsCMSSettings::first();
            	if($about_page) {
            		return View::make('settings.aboutus.add_about_page')->with(array('about_page'=>$about_page, 'page'=>$page));
            	} else {
            		return View::make('settings.aboutus.add_about_page')->with(array('page'=>$page));
            	}
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function store(Request $request) {
        $data = Input::all();
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS About Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $about_page = AboutUsCMSSettings::first();
                if($about_page) {
                    $rules = array(
                        'banner_image'        => 'nullable',
                        'banner_caption'         => 'nullable',
                        'abo_title'          => 'required',
                        'abo_desc'          => 'required',
                        'abo_img'        => 'nullable',
                        'abo_bg1'        => 'nullable',
                        'abo_bg2'        => 'nullable',
                        'mission_hd'        => 'required',
                        'mission_desc'        => 'required',
                        'mission_link_text'        => 'required',
                        'mission_link'        => 'required',
                        'vision_hd'        => 'required',
                        'vision_desc'        => 'required',
                        'vision_link_text'        => 'required',
                        'vision_link'        => 'required',
                    );
                } else {
                    $rules = array(
                        'banner_image'        => 'required',
                        'banner_caption'         => 'nullable',
                        'abo_title'          => 'required',
                        'abo_desc'          => 'required',
                        'abo_img'        => 'required',
                        'abo_bg1'        => 'required',
                        'abo_bg2'        => 'required',
                        'mission_hd'        => 'required',
                        'mission_desc'        => 'required',
                        'mission_link_text'        => 'required',
                        'mission_link'        => 'required',
                        'vision_hd'        => 'required',
                        'vision_desc'        => 'required',
                        'vision_link_text'        => 'required',
                        'vision_link'        => 'required',
                    );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($about_page) {
                        return View::make("settings.aboutus.add_about_page")->withErrors($validator)->with(array('about_page'=>$about_page,'page'=>$page));
                    } else {
                       return View::make('settings.aboutus.add_about_page')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('a_id');
                    $about_page = '';
                    if($id != '') {
                        $about_page = AboutUsCMSSettings::first();
                    } else {
                        $about_page = new AboutUsCMSSettings();
                    }

                    if($about_page) {
                        $about_page->banner_caption    = $data['banner_caption'];
                        $about_page->abo_title      = $data['abo_title'];
                        $about_page->abo_desc      = $data['abo_desc'];
                        $about_page->mission_hd      = $data['mission_hd'];
                        $about_page->mission_desc      = $data['mission_desc'];
                        $about_page->mission_link_text      = $data['mission_link_text'];
                        $about_page->mission_link      = $data['mission_link'];
                        $about_page->vision_hd      = $data['vision_hd'];
                        $about_page->vision_desc      = $data['vision_desc'];
                        $about_page->vision_link_text      = $data['vision_link_text'];
                        $about_page->vision_link      = $data['vision_link'];

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $about_page->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $about_page->banner_image       = $data['old_banner_image'];
                        } else {
                            $about_page->banner_image       = NULL;
                        }

                        if(isset($data['abo_img'])) {
                            $file_name = $data['abo_img']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['abo_img']->move($file_path, $file_name);
                            $about_page->abo_img       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_abo_img'])) {
                            $about_page->abo_img       = $data['old_abo_img'];
                        } else {
                            $about_page->abo_img       = NULL;
                        }

                        if(isset($data['abo_bg1'])) {
                            $file_name = $data['abo_bg1']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['abo_bg1']->move($file_path, $file_name);
                            $about_page->abo_bg1       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_abo_bg1'])) {
                            $about_page->abo_bg1       = $data['old_abo_bg1'];
                        } else {
                            $about_page->abo_bg1       = NULL;
                        }

                        if(isset($data['abo_bg2'])) {
                            $file_name = $data['abo_bg2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['abo_bg2']->move($file_path, $file_name);
                            $about_page->abo_bg2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_abo_bg2'])) {
                            $about_page->abo_bg2       = $data['old_abo_bg2'];
                        } else {
                            $about_page->abo_bg2       = NULL;
                        }

                        if($about_page->save()) {
                            Session::flash('message', 'Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            // return View::make("settings.aboutus.add_about_page")->with(array('about_page'=>$about_page,'about_page_cnt'=>$about_page_cnt,'about_page_lnk'=>$about_page_lnk,'about_page_slnk'=>$about_page_slnk,'about_page_pay'=>$about_page_pay,'page'=>$page));
                            return redirect()->route('add_about_page');
                        } else {
                            Session::flash('message', 'Update Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return Redirect::back();
                        }
                    } else {
                        Session::flash('message', 'Update Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return Redirect::back();
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }
}
