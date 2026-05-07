<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FooterSetting;
use App\FooterContact;
use App\FooterLinks;
use App\FooterSocialLinks;
use App\FooterPayments;
use App\CMSPageManagement;
use App\TestimonialSetting;
use App\GeneralSettings;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class FooterSettingsController extends Controller
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
                ->where('B.module_name', '=', 'Footer Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $footer = FooterSetting::all();

                if (sizeof($footer) != 0) {
                    return response()->json(array('status_code'=>'1','response_msg'=>'Footer Settings Deatils','response_data'=>array('data'=>$footer,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No Footer Settings Deatils'), 200);
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
                ->where('B.module_name', '=', 'Footer Settings')
                ->where('A.role', '=', $loged->user_type)
                // ->where('A.edit', '=', 1)
                // ->orwhere('A.add', '=', 1)
                ->where(function ($query) {
                    $query->where('A.edit', '=', 1)
                        ->orWhere('A.add', '=', 1);
                })
                ->first();

            if($privil) {
                $page = "Settings";                           
                $footer = FooterSetting::first();
                $footer_cnt = FooterContact::all();
                $footer_lnk = FooterLinks::all();
                $footer_slnk = FooterSocialLinks::all();
                $footer_pay = FooterPayments::all();
                $cms_pages = CMSPageManagement::Where('is_block', 1)->get();
                if($footer) {
                    return View::make("settings.footer_setting")->with(array('footer'=>$footer,'footer_cnt'=>$footer_cnt,'footer_lnk'=>$footer_lnk,'footer_slnk'=>$footer_slnk,'footer_pay'=>$footer_pay,'cms_pages'=>$cms_pages,'page'=>$page));
                } else {
                    return View::make('settings.footer_setting');
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
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Footer Settings')
                ->where('A.role', '=', $loged->user_type)
                // ->where('A.edit', '=', 1)
                // ->orwhere('A.add', '=', 1)
                ->where(function ($query) {
                    $query->where('A.edit', '=', 1)
                        ->orWhere('A.add', '=', 1);
                })
                ->first();

            if($privil) {
                $page = "Settings";
                $footer = FooterSetting::first();
                $footer_cnt = FooterContact::all();
                $footer_lnk = FooterLinks::all();
                $footer_slnk = FooterSocialLinks::all();
                $footer_pay = FooterPayments::all();
                $cms_pages = CMSPageManagement::Where('is_block', 1)->get();
                if($footer) {
                    $rules = array(
                        'heading1'         => 'required',
                        'heading2'       => 'required',
                        'heading3'          => 'required',
                        // 'heading4'        => 'required',
                    );
                } else {
                    $rules = array(
                        'heading1'         => 'required',
                        'heading2'       => 'required',
                        'heading3'          => 'required',
                        // 'heading4'        => 'required',
                    );
                }
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    if($footer) {
                        return Redirect::to('/footer_setting/')->withErrors($validator);

                        // return View::make("settings.footer_setting")->withErrors($validator)->with(array('footer'=>$footer,'footer_cnt'=>$footer_cnt,'footer_lnk'=>$footer_lnk,'footer_slnk'=>$footer_slnk,'footer_pay'=>$footer_pay,'cms_pages'=>$cms_pages,'page'=>$page));
                    } else {
                       return view('settings.footer_setting')->withErrors($validator);
                    }
                } else {
                    $id = $request->get('id');
                    $footer = '';
                    if($id != '') {
                        $footer = FooterSetting::Where('id', $id)->first();
                    } else {
                        $footer = new FooterSetting();
                    }

                    if($footer) {
                        $footer->heading1      = $data['heading1'];
                        $footer->heading2      = $data['heading2'];
                        $footer->heading3      = $data['heading3'];
                        // $footer->heading4      = $data['heading4'];
                        $footer->footer_desc      = $data['footer_desc'];

                        if($footer->save()) {

                            if(isset($data['c_title']) && count($data['c_title']) != 0) {
                                FooterContact::Where('footer_id', $footer->id)->delete();
                                foreach ($data['c_title'] as $key => $value) {
                                    $foo_cnt = new FooterContact();

                                    if (isset($data['c_icon'][$key])) {
                                        $foo_cnt->icon       = $data['c_icon'][$key];
                                    } else {
                                        $foo_cnt->icon       = NULL;
                                    }

                                    $foo_cnt->title      = $value;     
                                    $foo_cnt->footer_id  = $footer->id;     
                                    $foo_cnt->save();
                                }
                            }

                            if(isset($data['l_title']) && count($data['l_title']) != 0) {
                                $all_d_fl = FooterLinks::Where('footer_id', $footer->id)->delete();
                                foreach ($data['l_title'] as $key => $value) {
                                    $foo_lnk = new FooterLinks();

                                    if (isset($data['l_url'][$key])) {
                                        $foo_lnk->url       = $data['l_url'][$key];
                                    } else {
                                        $foo_lnk->url       = NULL;
                                    }

                                    if (isset($data['l_type'][$key])) {
                                        $foo_lnk->type       = $data['l_type'][$key];
                                    } else {
                                        $foo_lnk->type       = NULL;
                                    }

                                    $foo_lnk->title      = $value;
                                    $foo_lnk->footer_id  = $footer->id;     

                                    $foo_lnk->save();
                                }
                            }

                            if(isset($data['s_icon']) && count($data['s_icon']) != 0) {
                                FooterSocialLinks::Where('footer_id', $footer->id)->delete();
                                foreach ($data['s_icon'] as $key => $value) {
                                    $foo_sl = new FooterSocialLinks();

                                    if (isset($data['s_url'][$key])) {
                                        $foo_sl->url       = $data['s_url'][$key];
                                    } else {
                                        $foo_sl->url       = NULL;
                                    }

                                    $foo_sl->icon      = $value; 
                                    $foo_sl->footer_id  = $footer->id;    

                                    $foo_sl->save();
                                }
                            }

                            if(isset($data['p_url']) && count($data['p_url']) != 0) {
                                FooterPayments::Where('footer_id', $footer->id)->delete();
                                foreach ($data['p_url'] as $key => $value) {
                                    $foo_pay = new FooterPayments();

                                    if(isset($data['p_image'][$key])) {
                                        $file_name = $data['p_image'][$key]->getClientOriginalName();
                                        $date = date('M-Y');
                                        // $file_path = '../public/images/products/'.$date;
                                        $file_path = 'images/payments/'.$date;
                                        $data['p_image'][$key]->move($file_path, $file_name);
                                        $foo_pay->image       = $file_path.'/'.$file_name;
                                    } else if (isset($data['old_p_image'][$key])) {
                                        $foo_pay->image       = $data['old_p_image'][$key];
                                    } else {
                                        $foo_pay->image       = NULL;
                                    }

                                    $foo_pay->url      = $value;
                                    $foo_pay->footer_id  = $footer->id;      

                                    $foo_pay->save();
                                }
                            }

                            Session::flash('message', 'Footer Setting Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            // return View::make("settings.footer_setting")->with(array('footer'=>$footer,'footer_cnt'=>$footer_cnt,'footer_lnk'=>$footer_lnk,'footer_slnk'=>$footer_slnk,'footer_pay'=>$footer_pay,'page'=>$page));
                            return redirect()->route('footer_setting');
                        } else {
                            Session::flash('message', 'Footer Setting Update Failed!'); 
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
    
   public function create_testimonial(){
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Footer Settings')
                ->where('A.role', '=', $loged->user_type)
                // ->where('A.edit', '=', 1)
                // ->orwhere('A.add', '=', 1)
                ->where(function ($query) {
                    $query->where('A.edit', '=', 1)
                        ->orWhere('A.add', '=', 1);
                })
                ->first();

            if($privil) {
                $page = "Settings";                           
                $testimonial = TestimonialSetting::all();
                $cms_pages = CMSPageManagement::Where('is_block', 1)->get();
                if($testimonial) {
                    return View::make("settings.testimonial_setting")->with(array('testimonial'=>$testimonial,'cms_pages'=>$cms_pages));
                } else {
                    return View::make('settings.testimonial_setting');
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
   
   public function store_testimonial(Request $request) {
    $data = $request->all();
    $loged = session()->get('user');

    if ($loged) {
        $privil = DB::table('previlages as A')
            ->leftJoin('modules as B', 'A.module', '=', 'B.id')
            ->select('A.id as pid', 'A.*', 'B.id as mid', 'B.*')
            ->where('B.module_name', '=', 'Footer Settings')
            ->where('A.role', '=', $loged->user_type)
            ->where(function ($query) {
                $query->where('A.edit', '=', 1)
                    ->orWhere('A.add', '=', 1);
            })
            ->first();

        if ($privil) {
            $rules = [
                'testimonial_name' => 'required|array',
                'testimonial_user_type' => 'nullable|array',
                'testimonial_message' => 'required|array',
                // 'testimonial_rating' => 'required|array',
                'testimonial_image' => 'nullable|array',
            ];

            // Validate data
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect()->route('testimonial_setting')->withErrors($validator);
            }

            if (isset($data['testimonial_name']) && count($data['testimonial_name']) != 0) {
                foreach ($data['testimonial_name'] as $key => $name) {
                    // Check if the testimonial entry exists (use an ID if available)
                    if (isset($data['testimonial_id'][$key]) && !empty($data['testimonial_id'][$key])) {
                        $testimonialEntry = TestimonialSetting::find($data['testimonial_id'][$key]);
                    } else {
                        $testimonialEntry = new TestimonialSetting();
                    }

                    // Handle image upload
                    if (isset($data['testimonial_image'][$key])) {
                        $file_name = time() . '_' . $data['testimonial_image'][$key]->getClientOriginalName();
                        $date = date('M-Y');
                        $file_path = 'images/testimonial/' . $date;
                        $data['testimonial_image'][$key]->move($file_path, $file_name);
                        $testimonialEntry->image = $file_path . '/' . $file_name;
                    } elseif (isset($data['old_testimonial_image'][$key])) {
                        $testimonialEntry->image = $data['old_testimonial_image'][$key]; // Keep old image if no new image is uploaded
                    }

                    // Update fields
                    $testimonialEntry->name = $name;
                    $testimonialEntry->user_type = $data['testimonial_user_type'][$key] ?? null;
                    $testimonialEntry->message = $data['testimonial_message'][$key] ?? null;
                    // $testimonialEntry->rating = $data['testimonial_rating'][$key] ?? null;

                    // Save (update or insert)
                    $testimonialEntry->save();
                }
            }

            Session::flash('message', 'Testimonial Update Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('testimonial_setting');
        } else {
            Session::flash('message', 'You Are Not Authorized To Access This Module!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    } else {
        Session::flash('message', 'Please Login Properly!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }
}

public function delete_testimonial(Request $request)
{
    $testimonial = TestimonialSetting::find($request->id);

    if ($testimonial) {
        if ($testimonial->image) {
            $imagePath = public_path($testimonial->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $testimonial->delete(); 
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Testimonial not found']);
    }
}

public function create_madeToOrder(){
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'General Settings')
                ->where('A.role', '=', $loged->user_type)
                // ->where('A.edit', '=', 1)
                // ->orwhere('A.add', '=', 1)
                ->where(function ($query) {
                    $query->where('A.edit', '=', 1)
                        ->orWhere('A.add', '=', 1);
                })
                ->first();

            if($privil) {
                $page = "Settings";                           
                $general= GeneralSettings::first();
                if($general) {
                    return View::make("settings.made_to_order_setting")->with(array('general'=>$general));
                } else {
                    return View::make('settings.made_to_order_setting');
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
    
public function store_madeToOrder(Request $request) {
    $data = $request->all();
    $loged = session()->get('user');

    if ($loged) {
        $privil = DB::table('previlages as A')
            ->leftJoin('modules as B', 'A.module', '=', 'B.id')
            ->select('A.id as pid', 'A.*', 'B.id as mid', 'B.*')
            ->where('B.module_name', '=', 'General Settings')
            ->where('A.role', '=', $loged->user_type)
            ->where(function ($query) {
                $query->where('A.edit', '=', 1)
                    ->orWhere('A.add', '=', 1);
            })
            ->first();

        if ($privil) {
            $rules = [
                'made_to_order_note' => 'required',
            ];

            // Validate data
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return redirect()->route('madeToOrder_setting')->withErrors($validator);
            }
            $id = $request->get('id');
                    $general = '';
                    if($id != '') {
                    	$general = GeneralSettings::where('id', $id)->first();
                    } else {
                    	$general = new GeneralSettings();
                    }

                    if($general) {
        	            $general->made_to_order_note         = $data['made_to_order_note'];
                        
                        if($general->save()) {
                            Session::flash('message', 'Made To Order Note Update Successfully!');
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('madeToOrder_setting');
                        } else{
                            return Redirect::back();
                        }
                    }

            
        } else {
            Session::flash('message', 'You Are Not Authorized To Access This Module!');
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
