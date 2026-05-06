<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FAQPage;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class FAQPagesController extends Controller
{
    protected $response;
 
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
                ->where('B.module_name', '=', 'FAQ Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $faq = FAQPage::all();

                if (sizeof($faq) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'FAQ Page Deatils','response_data'=>array('data'=>$faq,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No FAQ Page Deatils'), 200);
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

    public function create () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'FAQ Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                           
            	$faq = FAQPage::first();
            	if($faq) {
                	return View::make("settings.faq_page_setting")->with(array('faq'=>$faq,'page'=>$page));
            	} else {
                	return View::make('settings.faq_page_setting');
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
                ->where('B.module_name', '=', 'FAQ Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$faq = FAQPage::first();
            	if($faq) {
        	        $rules = array(
        	            'banner_caption'         => 'nullable',
                        'title'       => 'required',
                        // 'desc'       => 'required',
                        // 'next_main_hd'        => 'required',
                        'banner_image'        => 'nullable',
        	        );
                } else {
                	$rules = array(
        	            'banner_caption'         => 'nullable',
        	            'title'       => 'required',
                        // 'desc'       => 'required',
                        // 'next_main_hd'        => 'required',
                        'banner_image'        => 'required',
        	        );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($faq) {
                        return View::make("settings.faq_page_setting")->withErrors($validator)->with(array('faq'=>$faq,'page'=>$page));
                    } else {
                	   return View::make('settings.faq_page_setting')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('id');
                    $faq = '';
                    if($id != '') {
                    	$faq = FAQPage::Where('id', $id)->first();
                    } else {
                    	$faq = new FAQPage();
                    }

                    if($faq) {
        	            $faq->banner_caption    = $data['banner_caption'];
        	            $faq->title      = $data['title'];
                        // $faq->desc      = $data['desc'];
                        // $faq->next_main_hd      = $data['next_main_hd'];

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/faq/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $faq->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $faq->banner_image       = $data['old_banner_image'];
                        } else {
                            $faq->banner_image       = NULL;
                        }

                        if($faq->save()) {
                        	Session::flash('message', 'Update Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
                            return redirect()->route('faq_page_setting');
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