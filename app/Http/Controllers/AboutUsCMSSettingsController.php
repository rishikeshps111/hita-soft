<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AboutUsCMSSettings;
use App\AboutAwards;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class AboutUsCMSSettingsController extends Controller
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
                $aaws = array();
                $about_page = AboutUsCMSSettings::first();
            	if($about_page) {
                    $aaws = AboutAwards::Where('about_id', $about_page->id)->get();
            		return view('settings.aboutus.add_about_page')->with(array('about_page'=>$about_page, 'page'=>$page, 'aaws'=>$aaws));
            	} else {
            		return view('settings.aboutus.add_about_page')->with(array('page'=>$page, 'aaws'=>$aaws));
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
        $data = $request->all();
        // print_r($data);die();
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
                $aaws = array();
                $about_page = AboutUsCMSSettings::first();
                if($about_page) {
                    $aaws = AboutAwards::Where('about_id', $about_page->id)->get();

                    $rules = array(
                        'banner_image'        => 'nullable',
                        'banner_caption'         => 'nullable',
                        'abo_title'          => 'required',
                        'abo_desc'          => 'required',
                        // 'abo_img'        => 'nullable',
                         'abo_bg1'        => 'nullable',
                        //  'abo_bg2'        => 'nullable',
                        // 'mission_hd'        => 'required',
                        // 'mission_desc'        => 'required',
                        // 'mission_link_text'        => 'required',
                        // 'mission_link'        => 'required',
                        // 'vision_hd'        => 'required',
                        // 'vision_desc'        => 'required',
                        // 'vision_link_text'        => 'required',
                        // 'vision_link'        => 'required',

                        //'abo_sub_title'        => 'required',
                        // 'stat_first_icon'        => 'required',
                        // 'stat_first_value'        => 'required',
                        // 'stat_first_title'        => 'required',
                        // 'stat_second_icon'        => 'required',
                        // 'stat_second_value'        => 'required',
                        // 'stat_second_title'        => 'required',
                        // 'stat_third_icon'        => 'required',
                        // 'stat_third_value'        => 'required',
                        // 'stat_third_title'        => 'required',
                        // 'stat_fourth_icon'        => 'required',
                        // 'stat_fourth_value'        => 'required',
                        // 'stat_fourth_title'        => 'required',
                        // 'award_hd'        => 'required',
                        // 'award_desc'        => 'required',
                    );
                } else {
                    $rules = array(
                        'banner_image'        => 'required',
                        'banner_caption'         => 'nullable',
                        'abo_title'          => 'required',
                        'abo_desc'          => 'required',
                        // 'abo_img'        => 'required',
                         'abo_bg1'        => 'required',
                        //  'abo_bg2'        => 'required',
                        // 'mission_hd'        => 'required',
                        // 'mission_desc'        => 'required',
                        // 'mission_link_text'        => 'required',
                        // 'mission_link'        => 'required',
                        // 'vision_hd'        => 'required',
                        // 'vision_desc'        => 'required',
                        // 'vision_link_text'        => 'required',
                        // 'vision_link'        => 'required',

                        //'abo_sub_title'        => 'required',
                        // 'stat_first_icon'        => 'required',
                        // 'stat_first_value'        => 'required',
                        // 'stat_first_title'        => 'required',
                        // 'stat_second_icon'        => 'required',
                        // 'stat_second_value'        => 'required',
                        // 'stat_second_title'        => 'required',
                        // 'stat_third_icon'        => 'required',
                        // 'stat_third_value'        => 'required',
                        // 'stat_third_title'        => 'required',
                        // 'stat_fourth_icon'        => 'required',
                        // 'stat_fourth_value'        => 'required',
                        // 'stat_fourth_title'        => 'required',
                        // 'award_hd'        => 'required',
                        // 'award_desc'        => 'required',
                    );
                }
                
               
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    //dd($validator->errors());
                    if($about_page) {
                        return view("settings.aboutus.add_about_page")->withErrors($validator)->with(array('about_page'=>$about_page,'page'=>$page,'aaws'=>$aaws));
                    } else {
                       return view('settings.aboutus.add_about_page')->withErrors($validator);
                    }
                } else {
                    $id = $request->get('a_id');
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
                        $about_page->sec1_desc      = $data['sec1_desc'];
                        $about_page->sec2_desc      = $data['sec2_desc'];
                        // $about_page->sec3_desc      = $data['sec3_desc'];
                        // $about_page->sec4_desc      = $data['sec4_desc'];
                        // $about_page->sec5_desc      = $data['sec5_desc'];
                        // $about_page->sec6_desc      = $data['sec6_desc'];
                        // $about_page->sec7_desc      = $data['sec7_desc'];
                        // $about_page->vision_link      = $data['vision_link'];

                        //$about_page->abo_sub_title      = $data['abo_sub_title'];
                        // $about_page->stat_first_icon      = $data['stat_first_icon'];
                        // $about_page->stat_first_value      = $data['stat_first_value'];
                        // $about_page->stat_first_title      = $data['stat_first_title'];
                        // $about_page->stat_second_icon      = $data['stat_second_icon'];
                        // $about_page->stat_second_value      = $data['stat_second_value'];
                        // $about_page->stat_second_title      = $data['stat_second_title'];
                        // $about_page->stat_third_icon      = $data['stat_third_icon'];
                        // $about_page->stat_third_value      = $data['stat_third_value'];
                        // $about_page->stat_third_title      = $data['stat_third_title'];
                        // $about_page->stat_fourth_icon      = $data['stat_fourth_icon'];
                        // $about_page->stat_fourth_value      = $data['stat_fourth_value'];
                        // $about_page->stat_fourth_title      = $data['stat_fourth_title'];
                        // $about_page->award_hd      = $data['award_hd'];
                        // $about_page->award_desc      = $data['award_desc'];

                         
                           if ($request->hasFile('video')) {
                                $video = $request->file('video');
                                $fileName = time() . '.' . $video->getClientOriginalExtension();
                                
                                $video->move(public_path('uploads/videos'), $fileName);
                                
                                $about_page->video = 'uploads/videos/' . $fileName;
                            }
                          $about_page->video_desc      = $data['video_desc'];

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

                        /*if(isset($data['abo_img'])) {
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
                        }*/

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

                        if(isset($data['section1_image'])) {
                            $file_name = $data['section1_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section1_image']->move($file_path, $file_name);
                            $about_page->section1_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section1_image'])) {
                            $about_page->section1_image       = $data['old_section1_image'];
                        } else {
                            $about_page->section1_image       = NULL;
                        }
                        
                        if(isset($data['section1_image2'])) {
                            $file_name = $data['section1_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section1_image2']->move($file_path, $file_name);
                            $about_page->section1_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section1_image2'])) {
                            $about_page->section1_image2       = $data['old_section1_image2'];
                        } else {
                            $about_page->section1_image2       = NULL;
                        }
                        
                        if(isset($data['section2_image'])) {
                            $file_name = $data['section2_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section2_image']->move($file_path, $file_name);
                            $about_page->section2_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section2_image'])) {
                            $about_page->section2_image       = $data['old_section2_image'];
                        } else {
                            $about_page->section2_image       = NULL;
                        }
                        
                        if(isset($data['section2_image2'])) {
                            $file_name = $data['section2_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section2_image2']->move($file_path, $file_name);
                            $about_page->section2_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section2_image2'])) {
                            $about_page->section2_image2       = $data['old_section2_image2'];
                        } else {
                            $about_page->section2_image2       = NULL;
                        }
                        
                         if(isset($data['section3_image'])) {
                            $file_name = $data['section3_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section3_image']->move($file_path, $file_name);
                            $about_page->section3_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section3_image'])) {
                            $about_page->section3_image       = $data['old_section3_image'];
                        } else {
                            $about_page->section3_image       = NULL;
                        }
                        
                         if(isset($data['section3_image2'])) {
                            $file_name = $data['section3_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section3_image2']->move($file_path, $file_name);
                            $about_page->section3_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section3_image2'])) {
                            $about_page->section3_image2       = $data['old_section3_image2'];
                        } else {
                            $about_page->section3_image2       = NULL;
                        }
                        
                         if(isset($data['section4_image'])) {
                            $file_name = $data['section4_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section4_image']->move($file_path, $file_name);
                            $about_page->section4_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section4_image'])) {
                            $about_page->section4_image       = $data['old_section4_image'];
                        } else {
                            $about_page->section4_image       = NULL;
                        }
                        
                         if(isset($data['section4_image2'])) {
                            $file_name = $data['section4_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section4_image2']->move($file_path, $file_name);
                            $about_page->section4_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section4_image2'])) {
                            $about_page->section4_image2       = $data['old_section4_image2'];
                        } else {
                            $about_page->section4_image2       = NULL;
                        }
                        
                        
                         if(isset($data['section5_image'])) {
                            $file_name = $data['section5_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section5_image']->move($file_path, $file_name);
                            $about_page->section5_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section5_image'])) {
                            $about_page->section5_image       = $data['old_section5_image'];
                        } else {
                            $about_page->section5_image       = NULL;
                        }
                        
                        
                         if(isset($data['section5_image2'])) {
                            $file_name = $data['section5_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section5_image2']->move($file_path, $file_name);
                            $about_page->section5_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section5_image2'])) {
                            $about_page->section5_image2       = $data['old_section5_image2'];
                        } else {
                            $about_page->section5_image2       = NULL;
                        }
                        
                         if(isset($data['section6_image'])) {
                            $file_name = $data['section6_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section6_image']->move($file_path, $file_name);
                            $about_page->section6_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section6_image'])) {
                            $about_page->section6_image       = $data['old_section6_image'];
                        } else {
                            $about_page->section6_image       = NULL;
                        }
                        
                        
                         if(isset($data['section6_image2'])) {
                            $file_name = $data['section6_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section6_image2']->move($file_path, $file_name);
                            $about_page->section6_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section6_image2'])) {
                            $about_page->section6_image2       = $data['old_section6_image2'];
                        } else {
                            $about_page->section6_image2       = NULL;
                        }
                        
                         if(isset($data['section7_image'])) {
                            $file_name = $data['section7_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section7_image']->move($file_path, $file_name);
                            $about_page->section7_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section7_image'])) {
                            $about_page->section7_image       = $data['old_section7_image'];
                        } else {
                            $about_page->section7_image       = NULL;
                        }
                        
                        
                         if(isset($data['section7_image2'])) {
                            $file_name = $data['section7_image2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/about_page/'.$date;
                            $data['section7_image2']->move($file_path, $file_name);
                            $about_page->section7_image2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_section7_image2'])) {
                            $about_page->section7_image2       = $data['old_section7_image2'];
                        } else {
                            $about_page->section7_image2       = NULL;
                        }

                        if($about_page->save()) {
                            // if(isset($data['aaw_title']) && count($data['aaw_title']) != 0) {
                            //     AboutAwards::Where('about_id', $about_page->id)->delete();
                            //     foreach ($data['aaw_title'] as $key => $value) {
                            //         $aaw = new AboutAwards();

                            //         // if(isset($data['aaw_image'][$key])) {
                            //         //     $file_name = $data['aaw_image'][$key]->getClientOriginalName();
                            //         //     $date = date('M-Y');
                            //         //     // $file_path = '../public/images/products/'.$date;
                            //         //     $file_path = 'images/about_page/'.$date;
                            //         //     $data['aaw_image'][$key]->move($file_path, $file_name);
                            //         //     $aaw->image       = $file_path.'/'.$file_name;
                            //         // } else if (isset($data['old_aaw_image'][$key])) {
                            //         //     $aaw->image       = $data['old_aaw_image'][$key];
                            //         // } else {
                            //         //     $aaw->image       = NULL;
                            //         // }

                            //         $aaw->title      = $value;     
                            //         $aaw->description = isset($data['aaw_description'][$key]) ? $data['aaw_description'][$key] : null;
                            //         $aaw->about_id  = $about_page->id;
                                         
                            //         $aaw->save();
                            //     }
                            // }

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
