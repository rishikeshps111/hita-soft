<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use App\CouponUsage;
use App\User;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use View;
use Session;
use Redirect;
use URL;

class CouponController extends Controller
{
    protected $respose;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(){
         $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Manage Coupon";
                
                $coupons=Coupon::all();

                return View::make("coupons.manage_coupon")->with(array('coupons'=>$coupons,'page'=>$page));
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
    
    public function create(){
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Add Coupon";
                return View::make('coupons.add_coupon')->with(array('page'=>$page));
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
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $rules = array(
                    'code'    => 'required',
                    'type'   => 'required',
                    'value'   => 'required',
                    'start_date'       => 'required',
                     'end_date'       => 'required',
                     'usage_limit'       => 'required',
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    $data = $request->all();
                    
                    $coupon = new Coupon();

                    if($coupon) {

                        $coupon->code   = $data['code'];
                        $coupon->type       = $data['type'];
                        $coupon->value       = $data['value'];
                        $coupon->start_date       = $data['start_date'];
                        $coupon->end_date       = $data['end_date'];
                        $coupon->usage_limit       = $data['usage_limit'];
                        // $coupon-> usage_limit_per_user =$data['usage_limit_per_user'];
                        $coupon->status       = $data['status'];
                        
                        if($coupon->save()) {
                            Session::flash('message', 'Coupon Added Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_coupons');
                        } else{
                            Session::flash('message', 'Coupon Added Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_coupons');
                        }
                    } else{
                        Session::flash('message', 'Coupon Added Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_coupons');
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
    
     public function edit ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $coupon = Coupon::where('id',$id)->first();
                if($coupon) {
                    return view("coupons.edit_coupon")->with(array('coupon'=>$coupon,'page'=>$page));
                } else {
                    Session::flash('message', 'Edit Not Possible!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_$coupons'); 
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
    
     public function update (Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $id = $request->get('coupon_id');
                $coupon = '';
                if($id != '') {
                    $coupon = Coupon::Where('id', $id)->first();
                }

                if($coupon) {
                    $rules = array(
                        'code'    => 'required',
                    'type'   => 'required',
                    'value'   => 'required',
                    'start_date'       => 'required',
                     'end_date'       => 'required',
                     'usage_limit'       => 'required',
                    );
                    $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return Redirect()->back()->withErrors($validator)->with(array('banner'=>$banner, 'page'=>$page));
                    } else {
                        $data = $request->all();
                        
                        $coupon->code   = $data['code'];
                        $coupon->type       = $data['type'];
                        $coupon->value       = $data['value'];
                        $coupon->start_date       = $data['start_date'];
                        $coupon->end_date       = $data['end_date'];
                        $coupon->usage_limit       = $data['usage_limit'];
                        // $coupon-> usage_limit_per_user =$data['usage_limit_per_user'];
                        $coupon->status       = $data['status'];
                        
                        if($coupon->save()) {
                            Session::flash('message', 'Coupon Updated Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_coupons');
                        } else{
                            Session::flash('message', 'Coupon Updated Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_coupons');
                        }               
                    }
                } else{
                    Session::flash('message', 'Coupon Updated Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_coupons');
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
    
     public function delete( Request $request) { 
        $id = 0;
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id)){
                    $id = $request->id;
                    if($id != 0) {
                        $coupon = Coupon::where('id',$id)->first();
                        if($coupon){
                            if($coupon->delete()) {
                                Session::flash('message', 'Coupon Deleted Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            } else {
                                Session::flash('message', 'Coupon Deleted Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Coupon Deleted Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }           
                    } else {
                        Session::flash('message', 'Deleted Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
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

        echo $error;
    }

    public function viewCouponUsers()
    {
         $loged = session()->get('user');
         if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Coupon Usage Report";
                
                  $coupons = Coupon::withCount('usages')->get();

                return View::make("coupons.view")->with(array('coupons'=>$coupons,'page'=>$page));
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


    public function redeem_list($id){
        
         $loged = session()->get('user');
         if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Banner Image Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Redeem List";
                
                  $coupon = Coupon::where('id', $id)->firstOrFail();

                $usages = CouponUsage::with('user', 'order')
                            ->where('coupon_code', $coupon->code)
                            ->orderByDesc('used_at')
                            ->get();

                return View::make("coupons.redeem_list")->with(array('coupon'=>$coupon,'usages'=>$usages,'page'=>$page));
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
    
    public function StatusCoupon ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		$tag = '';
        		$msg = '';
            	if($id != '') {
                	$product = Coupon::Where('id', $id)->first();
                }

                if($product) {
                	if($product->status == 1) {
                    	$product->status        = 0;
                    	$msg = "Blocked Successfully";
                	} else {
                		$product->status        = 1;
                    	$msg = "Unblocked Successfully";
                	}
        	        
        	        if($product->save()) {
        	        	Session::flash('message', $msg); 
        				Session::flash('alert-class', 'alert-success');
        				return redirect()->route('manage_coupons');
        	        } else{
        	        	Session::flash('message', 'Failed Block or Unblock!'); 
        				Session::flash('alert-class', 'alert-danger');
        	            return redirect()->route('manage_coupons');
        	        }
                } else{
                	Session::flash('message', 'Failed Block or Unblock!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_coupons');
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
    
      
      public function showShareForm($id)
    {
        $coupon = Coupon::findOrFail($id);
        $users = User::where('is_block', 1)->get(); 
        return view('coupons.share', compact('coupon', 'users'));
    }
    
    public function sendCouponToUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'coupon_id' => 'required|exists:coupons,id',
        ]);
    
        $coupon = Coupon::findOrFail($request->coupon_id);
        $users = User::whereIn('id', $request->user_ids)->get();
    
         foreach ($users as $user) {
             
            $adm = User::where('user_type', 1)->where('is_block', 1)->first();
            $admin_email = "info@folkgems.com";
            if($adm) {
                $admin_email = $adm->email;
            }

            $logos = \DB::table('logo_settings')->latest()->first();
            $logo_path = 'images/logo';
            $logo = "";
            if($logos) {
                $logo = asset($logo_path.'/'.$logos->logo_image);
            } else {
                $logo = asset('images/logo.png');
            }

            $general = \DB::table('general_settings')->first();
            $site_name = "Folkgems";
            if($general){
                $site_name = $general->site_name;
            } else {
                $site_name = "Folkgems";
            } 
            
        $to = $user->email;
        $message = $request->message;
        $subject = $request->subject ?: 'Exclusive Coupon Inside!';

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";
        $headers .= "From: Rang by Bhavana <jgrrylvmgyxm>\r\n";
        $headers .= "Reply-To: rangbybhavana@gmail.com\r\n";

        $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
            <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                <a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
            </div>
            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                <p style="font-size:15px;font-weight:600;">Hey '.$user->full_name.',</p>
                <p style="font-size:15px;font-weight:600;">Here is your exclusive coupon from '.$site_name.'!</p>
                
                <p style="font-size:15px;font-weight:900;">'.nl2br(htmlspecialchars($message)).'</p>



                <p style="font-size:13px;font-weight:600;">Use it before it expires!</p>
                <p style="font-size:13px;font-weight:600;">Happy Shopping 💖</p>
                
                <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>

                <p style="font-size:13px;font-weight:600;">Warm Regards,</p>
                <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>

                <div style="padding: 20px 0; text-align: center;">
                    <a href="https://www.instagram.com/rang_by_bhavana" target="_blank" style="margin: 0 10px; display: inline-block;">
                        <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                    </a>
                    <a href="https://wa.me/message/MZ5AXIY3K4QBE1" target="_blank" style="margin: 0 10px; display: inline-block;">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                    </a>
                    <a href="mailto:rangbybhavana@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                    </a>
                </div>
            </div>
        </div>';

        // Send the email
        mail($to, $subject, $txt, $headers);
    }
    
        Session::flash('message', 'Coupon shared Successfully!'); 
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('manage_coupons');
    }

        

}
