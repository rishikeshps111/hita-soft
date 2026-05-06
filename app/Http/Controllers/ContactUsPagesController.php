<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactUsPage;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class ContactUsPagesController extends Controller
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
                ->where('B.module_name', '=', 'Contact Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $contact = ContactUsPage::all();

                if (sizeof($contact) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'Contact Us Page Deatils','response_data'=>array('data'=>$contact,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No Contact Us Page Deatils'), 200);
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
                ->where('B.module_name', '=', 'Contact Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                           
            	$contact = ContactUsPage::first();
            	if($contact) {
                	return View::make("settings.contact_page_setting")->with(array('contact'=>$contact,'page'=>$page));
            	} else {
                	return View::make('settings.contact_page_setting');
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
                ->where('B.module_name', '=', 'Contact Us Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$contact = ContactUsPage::first();
            	if($contact) {
        	        $rules = array(
                        'banner_image'    => 'nullable',
        	            'banner_caption'  => 'nullable',
                        'main_hd'         => 'required',
                        'content_1'       => 'required',
                        'content_2'       => 'required',
                        'content_3'       => 'required',
                        'touch_hd'        => 'required',
        	        );
                } else {
                	$rules = array(
                        'banner_image'    => 'required',
        	            'banner_caption'  => 'nullable',
        	            'main_hd'         => 'required',
                        'content_1'       => 'required',
                        'content_2'       => 'required',
                        'content_3'       => 'required',
                        'touch_hd'        => 'required',
        	        );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($contact) {
                        return View::make("settings.contact_page_setting")->withErrors($validator)->with(array('contact'=>$contact,'page'=>$page));
                    } else {
                	   return View::make('settings.contact_page_setting')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('id');
                    $contact = '';
                    if($id != '') {
                    	$contact = ContactUsPage::Where('id', $id)->first();
                    } else {
                    	$contact = new ContactUsPage();
                    }

                    if($contact) {
        	            $contact->banner_caption   = $data['banner_caption'];
        	            $contact->main_hd          = $data['main_hd'];
                        $contact->content_1        = $data['content_1'];
                        $contact->content_2        = $data['content_2'];
                        $contact->content_3        = $data['content_3'];
                        $contact->touch_hd         = $data['touch_hd'];

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/contact/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $contact->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $contact->banner_image       = $data['old_banner_image'];
                        } else {
                            $contact->banner_image       = NULL;
                        }

                        if($contact->save()) {
                        	Session::flash('message', 'Update Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
                            return redirect()->route('contact_page_setting');
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