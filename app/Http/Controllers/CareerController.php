<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Career;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class CareerController extends Controller
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
                ->where('B.module_name', '=', 'CMS Career Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $career = Career::all();
            	return View::make("settings.carr_pages.manage_career")->with(array('career'=>$career, 'page'=>$page));
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
                ->where('B.module_name', '=', 'CMS Career Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
                $career = Career::first();
            	if($career) {
            		return View::make('settings.carr_pages.add_career')->with(array('career'=>$career, 'page'=>$page));
            	} else {
            		return View::make('settings.carr_pages.add_career')->with(array('page'=>$page));
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
                ->where('B.module_name', '=', 'CMS Career Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $career = Career::first();
                if($career) {
                    $rules = array(
                        'banner_image'        => 'nullable',
                        'banner_caption'         => 'nullable',
                        'career_hd'          => 'required',
                        'career_desc'          => 'required',
                        'career_img'        => 'nullable',
                        'career_bg'        => 'nullable',
                    );
                } else {
                    $rules = array(
                        'banner_image'        => 'required',
                        'banner_caption'         => 'nullable',
                        'career_hd'          => 'required',
                        'career_desc'          => 'required',
                        'career_img'        => 'required',
                        'career_bg'        => 'required',
                    );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($career) {
                        return View::make("settings.carr_pages.add_career")->withErrors($validator)->with(array('career'=>$career,'page'=>$page));
                    } else {
                       return View::make('settings.carr_pages.add_career')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('cr_id');
                    $career = '';
                    if($id != '') {
                        $career = Career::first();
                    } else {
                        $career = new Career();
                    }

                    if($career) {
                        $career->banner_caption    = $data['banner_caption'];
                        $career->career_hd      = $data['career_hd'];
                        $career->career_desc      = $data['career_desc'];

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/career/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $career->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $career->banner_image       = $data['old_banner_image'];
                        } else {
                            $career->banner_image       = NULL;
                        }

                        if(isset($data['career_img'])) {
                            $file_name = $data['career_img']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/career/'.$date;
                            $data['career_img']->move($file_path, $file_name);
                            $career->career_img       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_career_img'])) {
                            $career->career_img       = $data['old_career_img'];
                        } else {
                            $career->career_img       = NULL;
                        }

                        if(isset($data['career_bg'])) {
                            $file_name = $data['career_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/career/'.$date;
                            $data['career_bg']->move($file_path, $file_name);
                            $career->career_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_career_bg'])) {
                            $career->career_bg       = $data['old_career_bg'];
                        } else {
                            $career->career_bg       = NULL;
                        }

                        if($career->save()) {
                            Session::flash('message', 'Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            // return View::make("settings.carr_pages.add_career")->with(array('career'=>$career,'career_cnt'=>$career_cnt,'career_lnk'=>$career_lnk,'career_slnk'=>$career_slnk,'career_pay'=>$career_pay,'page'=>$page));
                            return redirect()->route('add_career');
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
