<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Widget;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class FooWidgetController extends Controller
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
                ->where('B.module_name', '=', 'Widget Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $widget = Widget::all();

                if (sizeof($widget) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'widget Settings Deatils','response_data'=>array('data'=>$widget,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No widget Settings Deatils'), 200);
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
                ->where('B.module_name', '=', 'Widget Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                           
            	$widget = Widget::first();
            	if($widget) {
                	return View::make("settings.widget_setting")->with(array('widget'=>$widget,'page'=>$page));
            	} else {
                	return View::make('settings.widget_setting');
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
                ->where('B.module_name', '=', 'Widget Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$widget = Widget::first();
            	if($widget) {
        	        $rules = array(
        	            'first_title'         => 'required',
        	            'first_content'       => 'required',
        	            // 'first_url'           => 'required',
        	            'first_icon'          => 'required',
        	            'second_title'        => 'required',
        	            'second_content'      => 'required',
        	            // 'second_url'          => 'required',
        	            'second_icon'         => 'required',
        	            'third_title'         => 'required',
        	            'third_content'       => 'required',
        	            // 'third_url'           => 'required',
        	            'third_icon'          => 'required',
        	            'fourth_title'        => 'required',
        	            'fourth_content'      => 'required',
        	            // 'fourth_url'          => 'required',
        	            'fourth_icon'         => 'required',
        	            'fifth_title'         => 'required',
        	            'fifth_content'       => 'required',
        	            // 'fifth_url'           => 'required',
        	            'fifth_icon'          => 'required',
                        // 'start_sell_bg'           => 'required',
                        'start_sell_hd_1'         => 'required',
                        'start_sell_button'       => 'required',
                        'start_sell_button_link'  => 'required',
                        'start_sell_hd_2'         => 'required',
                        // 'app_img_1'               => 'required',
                        'app_link_1'              => 'required',
                        // 'app_img_2'               => 'required',
                        'app_link_2'              => 'required',
        	        );
                } else {
                	$rules = array(
        	            'first_title'         => 'required',
        	            'first_content'       => 'required',
        	            // 'first_url'           => 'required',
        	            'first_icon'          => 'required',
        	            'second_title'        => 'required',
        	            'second_content'      => 'required',
        	            // 'second_url'          => 'required',
        	            'second_icon'         => 'required',
        	            'third_title'         => 'required',
        	            'third_content'       => 'required',
        	            // 'third_url'           => 'required',
        	            'third_icon'          => 'required',
        	            'fourth_title'        => 'required',
        	            'fourth_content'      => 'required',
        	            // 'fourth_url'          => 'required',
        	            'fourth_icon'         => 'required',
        	            'fifth_title'         => 'required',
        	            'fifth_content'       => 'required',
        	            // 'fifth_url'           => 'required',
        	            'fifth_icon'          => 'required',
                        'start_sell_bg'           => 'required',
                        'start_sell_hd_1'         => 'required',
                        'start_sell_button'       => 'required',
                        'start_sell_button_link'  => 'required',
                        'start_sell_hd_2'         => 'required',
                        'app_img_1'               => 'required',
                        'app_link_1'              => 'required',
                        'app_img_2'               => 'required',
                        'app_link_2'              => 'required',
        	        );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($widget) {
                       return View::make('settings.widget_setting')->withErrors($validator)->with(array('widget'=>$widget,'page'=>$page));
                    } else {
                	   return View::make('settings.widget_setting')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('id');
                    $widget = '';
                    if($id != '') {
                    	$widget = Widget::Where('id', $id)->first();
                    } else {
                    	$widget = new Widget();
                    }

                    if($widget) {
        	            $widget->first_title      = $data['first_title'];
        	            $widget->first_content    = $data['first_content'];
        	            $widget->first_url        = $data['first_url'];
        	            $widget->first_icon       = $data['first_icon'];
        	            $widget->second_title     = $data['second_title'];
        	            $widget->second_content   = $data['second_content'];
        	            $widget->second_url       = $data['second_url'];
        	            $widget->second_icon      = $data['second_icon'];
        	            $widget->third_title      = $data['third_title'];
        	            $widget->third_content    = $data['third_content'];
        	            $widget->third_url        = $data['third_url'];
        	            $widget->third_icon       = $data['third_icon'];
        	            $widget->fourth_title     = $data['fourth_title'];
        	            $widget->fourth_content   = $data['fourth_content'];
        	            $widget->fourth_url       = $data['fourth_url'];
        	            $widget->fourth_icon      = $data['fourth_icon'];
        	            $widget->fifth_title      = $data['fifth_title'];
        	            $widget->fifth_content    = $data['fifth_content'];
        	            $widget->fifth_url        = $data['fifth_url'];
        	            $widget->fifth_icon       = $data['fifth_icon'];

                        $widget->start_sell_hd_1         = $data['start_sell_hd_1'];
                        $widget->start_sell_button       = $data['start_sell_button'];
                        $widget->start_sell_button_link  = $data['start_sell_button_link'];
                        $widget->start_sell_hd_2         = $data['start_sell_hd_2'];
                        $widget->app_link_1              = $data['app_link_1'];
                        $widget->app_link_2              = $data['app_link_2'];

                        if(isset($data['start_sell_bg'])) {
                            $file_name = $data['start_sell_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/widget/'.$date;
                            $data['start_sell_bg']->move($file_path, $file_name);
                            $widget->start_sell_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_start_sell_bg'])) {
                            $widget->start_sell_bg       = $data['old_start_sell_bg'];
                        } else {
                            $widget->start_sell_bg       = NULL;
                        }

                        if(isset($data['app_img_1'])) {
                            $file_name = $data['app_img_1']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/widget/'.$date;
                            $data['app_img_1']->move($file_path, $file_name);
                            $widget->app_img_1       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_app_img_1'])) {
                            $widget->app_img_1       = $data['old_app_img_1'];
                        } else {
                            $widget->app_img_1       = NULL;
                        }

                        if(isset($data['app_img_2'])) {
                            $file_name = $data['app_img_2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/widget/'.$date;
                            $data['app_img_2']->move($file_path, $file_name);
                            $widget->app_img_2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_app_img_2'])) {
                            $widget->app_img_2       = $data['old_app_img_2'];
                        } else {
                            $widget->app_img_2       = NULL;
                        }

                        if($widget->save()) {
                        	Session::flash('message', 'Update Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
                        	return View::make("settings.widget_setting")->with(array('widget'=>$widget,'page'=>$page));
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