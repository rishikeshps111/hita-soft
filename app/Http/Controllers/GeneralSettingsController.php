<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings;
use App\ShippingSetting;
use App\WebsiteLock;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class GeneralSettingsController extends Controller
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
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $general = GeneralSettings::all();
                $page = "Settings";

                if (sizeof($general) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'General Settings Deatils','response_data'=>array('data'=>$general,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No General Settings Deatils'), 200);
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
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
            	$general = GeneralSettings::first();
            	if($general) {
                	return View::make("settings.general_setting")->with(array('general'=>$general,'page'=>$page));
            	} else {
                	return View::make('settings.general_setting');
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
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
            	$rules = array(
                    'site_name'          => 'required',
                    'site_description'   => 'nullable',
                    'meta_title'         => 'required',
                    'meta_keywords'      => 'required',
                    'meta_description'   => 'required',
                    'cod'                => 'nullable',
                    'paypal'             => 'nullable',
                    'pay_Umoney'         => 'nullable',
                    'frontend_url'       => 'required',
                    // 'backend_url'        => 'required', 
                    'play_store_url'     => 'nullable',
                    'ios_store_url'      => 'nullable',
                    'cancel_terms'       => 'required',
                    'return_terms'       => 'nullable',
                );
                $validator = Validator::make($request->all(), $rules);
                

                if ($validator->fails()) {
                    // dd($validator->errors()); 
                    $general = GeneralSettings::first();
                    if($general) {
                       return view('settings.general_setting')->withErrors($validator)->with(array('general'=>$general,'page'=>$page));
                    } else {
                	   return view('settings.general_setting')->withErrors($validator)->with(array('page'=>$page));
                    }
                } else {
                    //  dd($request->all()); 
                    $data = $request->all();
                    $id = $request->get('id');
                    $general = '';
                    if($id != '') {
                    	$general = GeneralSettings::where('id', $id)->first();
                    } else {
                    	$general = new GeneralSettings();
                    }

                    if($general) {
        	            $general->site_name         = $data['site_name'];
        	            // $general->site_description  = $data['site_description'];
        	            $general->meta_title        = $data['meta_title'];
        	            $general->meta_keywords     = $data['meta_keywords'];
        	            $general->meta_description  = $data['meta_description'];
        	            if(isset($data['cod'])) {
        		            if($data['cod'] == TRUE){
        		            	$general->cod  = 1;
        		            } else {
        		            	if($data['cod'] == 1) {
        		            		$general->cod  = 1;
        		            	} else {
        		            		$general->cod  = 0;
        		            	}
        		            }
        	            } else {
                    		$general->cod  = 0;
        	            }

        	            if(isset($data['paypal'])) {
        		            if($data['paypal'] == TRUE){
        		            	$general->paypal  = 1;
        		            } else {
        		            	if($data['paypal'] == 1) {
        		            		$general->paypal  = 1;
        		            	} else {
        		            		$general->paypal  = 0;
        		            	}
        		            }
        	            } else {
        	            	$general->paypal  = 0;
        	            }

        	            /*if(isset($data['pay_Umoney'])) {
        		            if($data['pay_Umoney'] == TRUE){
        		            	$general->pay_Umoney  = 1;
        		            } else {
        		            	if($data['pay_Umoney'] == 1) {
        		            		$general->pay_Umoney  = 1;
        		            	} else {
        		            		$general->pay_Umoney  = 0;
        		            	}
        		            }
        	            } else {
        	            	$general->pay_Umoney  = 0;
        	            }*/
        	            $general->frontend_url      = $data['frontend_url'];
                        // $general->backend_url       = $data['backend_url'];
                        $general->play_store_url    = $data['play_store_url'];
        	            $general->ios_store_url     = $data['ios_store_url'];
                        $general->cancel_terms      = $data['cancel_terms'];
                        // $general->return_terms      = $data['return_terms'];
                        
                        if($general->save()) {
                            Session::flash('message', 'Settings Updated Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                        	return view("settings.general_setting")->with(array('general'=>$general,'page'=>$page));
                        } else{
                            return Redirect::back();
                        }
                    } else{
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
    
    
    public function create_shipping () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
            	$general = ShippingSetting::first();
            	if($general) {
                	return View::make("settings.shipping_setting")->with(array('general'=>$general,'page'=>$page));
            	} else {
                	return View::make('settings.shipping_setting');
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
    
      public function store_shipping(Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
            	$rules = array(
                    'domestic_shipping'          => 'required',
                    'text'   => 'nullable',
                    'inter_shipping'         => 'required',
                );
                $validator = Validator::make($request->all(), $rules);
                

                if ($validator->fails()) {
                    // dd($validator->errors()); 
                    $general = ShippingSetting::first();
                    if($general) {
                       return view('settings.shipping_setting')->withErrors($validator)->with(array('general'=>$general,'page'=>$page));
                    } else {
                	   return view('settings.shipping_setting')->withErrors($validator)->with(array('page'=>$page));
                    }
                } else {
                    //  dd($request->all()); 
                    $data = $request->all();
                    $id = $request->get('id');
                    $general = '';
                    if($id != '') {
                    	$general = ShippingSetting::where('id', $id)->first();
                    } else {
                    	$general = new ShippingSetting();
                    }

                    if($general) {
        	            $general->domestic_shipping         = $data['domestic_shipping'];
        	            $general->inter_shipping        = $data['inter_shipping'];
        	            $general->free_shipping     =$data['free_shipping'];
        	            $general->text     = $data['text'];
        	            
                        if($general->save()) {
                            Session::flash('message', 'Settings Updated Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                        	return view("settings.shipping_setting")->with(array('general'=>$general,'page'=>$page));
                        } else{
                            return Redirect::back();
                        }
                    } else{
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
    
    public function create_lock() {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
            	$lock = WebsiteLock::first();
            	if($lock) {
                	return View::make("settings.website_lock_setting")->with(array('lock'=>$lock,'page'=>$page));
            	} else {
                	return View::make('settings.website_lock_setting');
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
    
    public function updateWebsiteLock(Request $request)
    {
        $request->validate([
            'passcode' => 'required|string|max:4',
            'is_enabled' => 'nullable|boolean',
        ]);
    
        $lock = WebsiteLock::first();
        if(!$lock){
            $lock = new WebsiteLock();
        }
    
        $lock->passcode = $request->passcode;
        $lock->is_enabled = $request->has('is_enabled') ? 1 : 0;
        $lock->save();
        
        Session::flash('message', 'Website lock updated successfully!'); 
        Session::flash('alert-class', 'alert-success');
    
        return redirect()->back();
    }

    
}