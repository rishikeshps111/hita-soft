<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeaderMenus;
use App\CategoryManagementSettings;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class HeaderMenusController extends Controller
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
                ->where('B.module_name', '=', 'Header Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $header = HeaderMenus::all();

                if (sizeof($header) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'Header Settings Deatils','response_data'=>array('data'=>$header,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No Header Settings Deatils'), 200);
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
                ->where('B.module_name', '=', 'Header Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                           
            	$header = HeaderMenus::all();
                $all_cats = CategoryManagementSettings::Where('is_block', 1)->get();
            	if($header) {
                	return View::make("settings.header_setting")->with(array('header'=>$header,'all_cats'=>$all_cats,'page'=>$page));
            	} else {
                	return View::make('settings.header_setting');
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
                ->where('B.module_name', '=', 'Header Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$header = HeaderMenus::all();
                $all_cats = CategoryManagementSettings::Where('is_block', 1)->get();
            	if($header && sizeof($header) != 0) {
        	        $rules = array(
        	            // 'heading1'         => 'required',
        	        );
                } else {
                	$rules = array(
        	            // 'heading1'         => 'required',
        	        );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($header) {
                        return View::make("settings.header_setting")->withErrors($validator)->with(array('header'=>$header,'all_cats'=>$all_cats,'page'=>$page));
                    } else {
                	   return View::make('settings.header_setting')->withErrors($validator);
                    }
                } else {
                    if(isset($data['category']) && count($data['category']) != 0) {
                        HeaderMenus::Where('header_id', 1)->delete();
                        foreach ($data['category'] as $key => $value) {
                            $thdr = new HeaderMenus();

                            if (isset($data['priority'][$key])) {
                                $thdr->priority       = $data['priority'][$key];
                            } else {
                                $thdr->priority       = NULL;
                            }

                            $thdr->category      = $value;     
                            $thdr->header_id  = 1;     
                            $thdr->save();
                        }
                        
                        Session::flash('message', 'Update Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('header_setting');
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