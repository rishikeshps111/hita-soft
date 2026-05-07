<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\loginSecurity;
use App\CityManagement;
use App\StateManagements;
use App\CountriesManagement;
use App\EmailSettings;
use App\MerchantsDocuments;
use App\Carts;
use App\Address;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class UsersController extends Controller
{   
    protected $respose;
    protected $sub_domain;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->sub_domain = "";
    }

    public function Login () {
        $sub_domain = $this->sub_domain;
        $loged = session()->get('user');
        if(isset($_COOKIE["user"]) && !empty($_COOKIE["user"])) {
            $cook = $_COOKIE["user"];
            $cook = json_decode($cook);
            $user = User::Where('id', $cook->id)->first();
            // dd($user);
            if($user) {
                if(($user->user_type == 4)) {
                    return redirect()->back();
                    /*if($user->verification == 1) {
                        if($user->is_block == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if(isset($ses_carts)) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            return redirect()->route('home');
                        } else {
                            session()->forget('user');
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                            Session::flash('message', 'Admin Has Blocked Your Account!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('home');
                        }
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('home');
                    }*/
                } else {
                    session()->forget('user');
                    
                    Session::flash('message', 'Login Successfully!'); 
                    Session::flash('alert-class', 'alert-success');
                    Session::put('user', $user);
                    
                    // session(['user' => $user]);
                    if($user->user_type == 1 || ($user->user_type == 2)){
                        // $ses = Session::get('user');
                        // session()->get('user');
                        return redirect()->route('dashboard');
                    } else if( ($user->user_type == 3)) {
                        if($user->is_block == 1) {
                            if($user->is_approved == 1) {
                                return redirect()->route('merchants_dashboard');
                            } else {
                                session()->forget('user');
                                if(isset($_COOKIE["user"])) {
                                    setcookie ("user","");
                                }
                                Session::flash('message', 'Admin Has Blocked Your Account!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('merchant');
                            } 
                        } else {
                            session()->forget('user');
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                            Session::flash('message', 'Admin Has Blocked Your Account!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('merchant');
                        }
                    } else if(($user->user_type == 4)){
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        return redirect()->back();
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        return redirect()->back();
                    }
                }
            } else {
                Session::flash('message', 'Login Failed!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('logout');
            }
        } else if($loged) {
            if(($loged->user_type == 4)) {
                return redirect()->back();
                /*if($loged->verification == 1) {
                    if($loged->is_block == 1) {
                        session()->forget('user');
                        Session::flash('message', 'Login Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $loged);

                        $users = session()->get('user');
                        $ses_carts = session()->get('cart');
                        $cartData = array();

                        if(isset($ses_carts)) {
                            Carts::Where('user_id', $users->id)->delete();
                            foreach ($ses_carts as $key => $value) {
                                $carts = new Carts();
                                if($carts) {
                                    $carts->product_id  = $value['product_id'];
                                    $carts->user_id     = $users->id;
                                    $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                    $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                    $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                    $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                    $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                    $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                    $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                    $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                    $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                    $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                    $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                    $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                    $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                    $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                    $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                    $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                    $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                    $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                    $carts->is_block    = 1;

                                    $carts->save();
                                }
                            }
                        }

                        return redirect()->route('home');
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        Session::flash('message', 'Admin Has Blocked Your Account!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('home');
                    }
                } else {
                    session()->forget('user');
                    if(isset($_COOKIE["user"])) {
                        setcookie ("user","");
                    }
                    Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('home');
                }*/
            } else {
                session()->forget('user');
                
                Session::flash('message', 'Login Successfully!'); 
                Session::flash('alert-class', 'alert-success');
                Session::put('user', $loged);
                
                // session(['user' => $user]);
                if($loged->user_type == 1 || ($loged->user_type == 2) ){
                    // $ses = Session::get('user');
                    // session()->get('user');
                    return redirect()->route('dashboard');
                } else if( ($loged->user_type == 3)) {
                    if($loged->is_block == 1) {
                        if($loged->is_approved == 1) {
                            return redirect()->route('merchants_dashboard');
                        } else {
                            session()->forget('user');
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                            Session::flash('message', 'Admin Has Blocked Your Account!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('merchant');
                        } 
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        Session::flash('message', 'Admin Has Blocked Your Account!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('merchant');
                    }
                } else if(($loged->user_type == 4)){
                    session()->forget('user');
                    if(isset($_COOKIE["user"])) {
                        setcookie ("user","");
                    }
                    return redirect()->back();
                } else {
                    session()->forget('user');
                    if(isset($_COOKIE["user"])) {
                        setcookie ("user","");
                    }
                    return redirect()->back();
                }
            }
        } else {
            return View::make('user.admin')->with(array('sub_domain'=>$sub_domain));
        }
    }

    public function CheckLogin (Request $request) {
        $rules = array(
            'email'                   => 'required',
            // 'email'                   => 'required|email|exists:users,email',
            'password'                => 'required',
        );

        $messages=[
            'password.required'=>'The password field is required.',
            'email.required'=>'The email or mobile no field is required.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return view('user.admin')->withErrors($validator);
        } else {
            $data = $request->all();
            $user = User::where('email', $data['email'])->where('is_block', 1)->where('is_approved', 1)->first();
            if(!$user) {
                $user = User::where('phone', $data['email'])->where('is_block', 1)->where('is_approved', 1)->first();
            }

            if($user) {
                $pass = md5($data['password']);
                
                if ($user->password == $pass) {
                    if(($user->user_type == 4)) {
                        Session::flash('message', 'Wrong User Name And Password!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->back();
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        
                        Session::flash('message', 'Login Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $user);
                        
                        if(isset($data["remember"]) && !empty($data["remember"])) {
                            setcookie ("user",$user,time()+ (60 * 60 * 5));
                        } else {
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                        }
                        // session(['user' => $user]);
                        if($user->user_type == 1 || ($user->user_type == 2)){
                            // $ses = Session::get('user');
                            // session()->get('user');
                            return redirect()->route('dashboard');
                        } else if( ($user->user_type == 3)){
                            return redirect()->route('merchants_dashboard');
                        } else if(($user->user_type == 4)){
                            session()->forget('user');
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                            return redirect()->back();
                        } else {
                            session()->forget('user');
                            return redirect()->back();
                        }
                    }
                } else {
                    Session::flash('message', 'Your Password is Wrong!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                    // return redirect()->route('admin');
                }
            } else{
                Session::flash('message', 'Login Failed!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->route('admin');
                return redirect()->back();
            }
        }
    }

    public function CheckSignInEmail (Request $request) {
        $data = Input::all();
        $rules = array(
            // 'email'                   => 'required',
            'email'                   => 'required|email|exists:users,email',
            'password'                => 'required',
            'bk_log_with'             => 'nullable',
        );

        $messages=[
            'password.required'=>'The password field is required.',
            // 'email.required'=>'The email or mobile no field is required.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return View::make('front_end.signin')->withErrors($validator)->with(array('bk_log_with'=>'email'));
        } else {
            $user = User::where('email', $data['email'])->where('is_block', 1)->where('is_approved', 1)->first();

            if($user) {
                $pass = md5($data['password']);
                if ($user->password == $pass) {
                    if(($user->user_type == 4)) {
                        if($user->verification == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);
                            $user->{'pass'} = $data['password'];
                            $ck = json_encode($user);
                            if(isset($data["remember"]) && !empty($data["remember"])) {
                                // setcookie("user",$ck, time() + (60 * 60 * 5), "/");
                                setcookie("user",$ck, time() + (60 * 60 * 5));
                            } else {
                                if(isset($_COOKIE["user"])) {
                                    setcookie ("user","");
                                }
                            }

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if(isset($ses_carts) != 0) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                        $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            return redirect()->route('home');
                        } else {
                            session()->forget('user');
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                            Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('signin');
                        }
                    } else {
                        Session::flash('message', 'Wrong User Name And Password!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Your Password is Wrong!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else{
                Session::flash('message', 'Login Failed!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        }
    }

    public function LoginOTP( Request $request) {    
        $mobile = 0;

        if($request->ajax() && isset($request->mobile)){
            $mobile = $request->mobile;
            $error = 1;

            if($mobile) {
                $user = User::where('phone', $mobile)->where('is_block', 1)->where('is_approved', 1)->first();
                if($user) {
                    $otp = mt_rand(100000, 999999);
                    $user->signin_verify = $otp;
                    if($user->save()) {
                        $text = "Please Use this ".$otp." otp code to your SignIn process,Folkgems.";
                        $text = urlencode($text);
     
                        $curl = curl_init();
                     
                        // Send the POST request with cURL
                        curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                        CURLOPT_POST => 1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                        CURLOPT_POSTFIELDS => array(
                            'mobile' => $user->phone,
                            'route' => 'TL',
                            'text' => $text,
                            'sender' => 'GJICAM')));
                     
                        // Send the request & save response to $response
                        $response = curl_exec($curl);
                     
                        // Close request to clear up some resources
                        curl_close($curl);
                        $response = json_decode($response);
                        // Print response
                        if(isset($response->data->status) && $response->data->status == "success") {
                            $error = 0;
                        } else {
                            Session::flash('message', 'OTP Code Send Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }
                    } else {
                        Session::flash('message', 'OTP Code Send Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                } else {
                    Session::flash('message', 'Invalid Mobile Number!, Please Enter Your Authenticate Mobile Number!'); 
                    Session::flash('alert-class', 'alert-danger');  
                }

            } else {
                Session::flash('message', 'Must Enter Valid Mobile Number!'); 
                Session::flash('alert-class', 'alert-danger');
            }

            echo $error;
        }
    }

    public function CheckSignInMobile (Request $request) {
        $data = Input::all();
        $rules = array(
            'mobile'                  => 'nullable',
            'otp'                     => 'required|exists:users,signin_verify',
        );

        $messages=[
            'mobile.nullable'=>'',
        ];
        $validator = Validator::make(Input::all(), $rules,$messages);

        if ($validator->fails()) {
            return View::make('front_end.signin')->withErrors($validator)->with(array('bk_log_with'=>'mobile'));
        } else {
            $user = User::where('signin_verify', $data['otp'])->where('is_block', 1)->where('is_approved', 1)->first();

            if($user) {
                if(($user->user_type == 4)) {
                    if($user->verification == 1) {
                        session()->forget('user');
                        Session::flash('message', 'Login Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $user);
                        $ck = json_encode($user);
                        if(isset($data["mob_rem"]) && !empty($data["mob_rem"])) {
                            // setcookie("user",$ck, time() + (60 * 60 * 5), "/");
                            setcookie("user",$ck, time() + (60 * 60 * 5));
                        } else {
                            if(isset($_COOKIE["user"])) {
                                setcookie ("user","");
                            }
                        }

                        $users = session()->get('user');
                        $ses_carts = session()->get('cart');
                        $cartData = array();

                        if(isset($ses_carts) != 0) {
                            Carts::Where('user_id', $users->id)->delete();
                            foreach ($ses_carts as $key => $value) {
                                $carts = new Carts();
                                if($carts) {
                                    $carts->product_id  = $value['product_id'];
                                    $carts->user_id     = $users->id;
                                    $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                    $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                    $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                    $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                    $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                    $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                    $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                    $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                    $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                    $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                    $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                    $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                    $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                    $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                    $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                    $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                    $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                    $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                    $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                    $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                    $carts->is_block    = 1;

                                    $carts->save();
                                }
                            }
                        }

                        $user->signin_verify = NULL;
                        $user->mobile_verify = 1;
                        $user->save();

                        return redirect()->route('home');
                    } else {
                        session()->forget('user');
                        if(isset($_COOKIE["user"])) {
                            setcookie ("user","");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Wrong User Name And Password!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else{
                Session::flash('message', 'Login Failed!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        }
    }

    public function Logout () {
        session_start();
        session_unset(); 
        $value = session()->get('user');
        if(isset($_COOKIE["user"])) {
            setcookie ("user","");
        }
        session()->forget('cart');
        session()->forget('chk_verify');
        // print_r($value);die();
        if($value) {
            if($value->user_type == 4) {
                session()->forget('user');
                session()->forget('cart');
                return redirect()->route('home');
            } else if( $value->user_type == 3) {
                session()->forget('user');
                return redirect()->route('merchant');
            } else {
                session()->forget('user');
                return redirect()->route('admin');
            } 
        } else {
            session()->forget('cart');
            session()->forget('user');
            return redirect()->route('home');
        }
    }

    public function Forgot () {
        return View::make('user.forgot');
    }

    public function changePassword () {
         $user = session()->get('user');;
        return View::make('user.changePassword',compact('user'));
    }
  
   public function CheckForgot(Request $request) {
 
     $user = User::find($request->input('user_id'));

    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    if ($validator->fails()) {
       // dd($validator);
        return redirect()->back()->withErrors($validator)->withInput();
    }

    if (md5($request->current_password) === $user->password) {
        
        if ($request->new_password === $request->current_password) {
            Session::flash('message', 'New password should be different than the old password!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back()->with('error', 'New password should be different than the old password.');
        }
        
        $user->password = md5($request->new_password);
        $user->save();
        
          Session::flash('message', 'Password Changed Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
        return redirect()->back()->with('success', 'Password updated successfully.');
    } else {
         Session::flash('message', 'Password Change Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
        return redirect()->back()->with('error', 'Current password does not match.');
    }
}

    
    public function admin_CheckForgot (Request $request) {
        $data = $request->all();

        if(isset($data['mobnumber'])) {
            $rules = array(
                'email_id'       => 'nullable|email|exists:users,email',
                'mobnumber'      => 'nullable|numeric|digits:10|exists:users,phone',
            );
        } else {
            $rules = array(
                'email_id'       => 'nullable|email|exists:users,email',
            );
        }


        $messages=[
            'mobnumber.numeric' => 'The Mobile Number field is only numbers.',
            'mobnumber.digits'  => 'The Mobile Number field is only 10 numbers allowed.',
            'mobnumber.exists'  => 'The Mobile Number has not Exist.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            // return View::make('user.forgot')->withErrors($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user = false;
            $mob_user = false;
            // print_r($data);die();
            if(isset($data['mobnumber'])) {
                $user = User::where('email', $data['email_id'])->where('is_block', 1)->first();
                $mob_user = User::where('phone', $data['mobnumber'])->where('is_block', 1)->first();
            } else {
                $user = User::where('email', $data['email_id'])->where('is_block', 1)->first();
            }

            if ($user) {
                
                
                $user->remember_token = time();
                if($user->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    if ($user->email !== $adm->email) {
                        return redirect()->back()->with('error', 'It\'s not Admin Email');
                    }
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

                    $name = $user->full_name;
                    $email = $user->email;
                    $reset_pw = $user->remember_token;

                    $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers.= "MIME-Version: 1.0\r\n";
                    $headers.= "From: Rang by Bhavana <jgrrylvmgyxm>" . "\r\n";
                    $to = $email;
                    $subject = "Verify your Account";

                    $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                            <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                <h2 style="color: #ff5c00;margin-top: 0px;">Reset Password Code</h2>
                                <table align="center" style=" text-align: center;">
                                    <tr>
                                        <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$name.'</td>
                                    </tr>
                                    <tr>
                                        <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:'.$email.'" target="_blank" style="color: #333;text-decoration: none;">'.$email.'</a></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;text-transform: uppercase;color: #333;padding-bottom: 12px;font-weight:bold;width: 120px;">Password</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$reset_pw.'</td>
                                    </tr>
                                </table>
                                <p>Your Password Reset Code is '.$reset_pw.'</p>
                                <p>Use this Code to change your Password</p>
                                <p>Thank You.</p>
                                <p></p>
                                <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p>Thanks & Regards,</p>
                                <p><a href="'.route('home').'">'.$site_name.'</a></p>
                            </div>
                        </div>';
                    
                    if(mail($to,$subject,$txt,$headers)){
                        Session::flash('message', 'Reset code has been sent to email successfully !'); 
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('reset');
                    } else {
                        Session::flash('message', 'Mail Send Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('forgot'); 
                    }
                }
            } elseif ($mob_user) {
                $otp = mt_rand(100000, 999999);
                $mob_user->remember_token = $otp;
                if($mob_user->save()) {
                    $text = "Please Use this ".$otp." reference code to reset the password.";
                    $text = urlencode($text);
                       $senderid = 'WEBSMS'; // Must be 6 chars
                        $route = '5'; // as per SMSIndiaHub
                        $mobile = $mob_user->phone;
                        $apikey = 'HbIkrciaNUyvecWAgU7PXA'; // Your real API Key here
                    
                        $postData = array(
                            'APIKey' => $apikey,
                            'msisdn' => $mobile,
                            'sid' => $senderid,
                            'msg' => $text,
                            'fl' => '0',
                            'gwid' => $route
                        );
                    
                        $url = "http://cloud.smsindiahub.in/api/mt/SendSMS";
                    
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => http_build_query($postData), // POST fields here
                        ));
                    
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);
                    
                        // dd($response);

                    if(isset($response->data->status) && $response->data->status == "success") {
                        Session::flash('message', 'OTP Message Send Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('reset');
                    } else {
                        Session::flash('message', 'OTP Message Send Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('forgot');
                    }
                }
            } else{
                Session::flash('message', 'It\'s Invalid Input!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('home');
            }
        }
    }

    public function Reset () {
        return View::make('user.reset');
    }

    public function ResetPassword (Request $request) {
        $rules = array(
            'remember_token'          => 'required|exists:users,remember_token',
            'password'                => 'required|min:5',
            'password_salt'           => 'required|min:5|same:password',
        );

        $messages=[
            'remember_token.required' => 'The reset code field is required.',
            'remember_token.exists'   => 'Wrong reset code.',
            'password_salt.required' => 'The confirm password field is required.',
            'password_salt.min'      => 'The confirm password must be at least 5 characters.',
            'password_salt.same'     => 'The confirm password and password must match.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) {
            return View::make('user.reset')->withErrors($validator);
        } else {
            $data = Input::all();
            $ps = "gj";
            $pe = "ja";

            $user = User::where('remember_token', $data['remember_token'])->where('is_block', 1)->first();

            if($user) {
                $user->password                  = md5($data['password']);
                $user->password_salt             = $ps.$data['password_salt'].$pe;
                $user->remember_token            = NULL;


                $pass = $data['password'];
                if($user->save()) {
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

                    $name = $user->full_name;
                    $email = $user->email;
                    $password = $pass;

                    $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers.= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers.= "From: Rang by Bhavana <jgrrylvmgyxm>" . "\r\n";
                    $to = $email;
                    $subject = "Change your Password";
                    $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                            <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                <h2 style="color: #ff5c00;margin-top: 0px;">Reset Password Code</h2>
                                <table align="center" style=" text-align: center;">
                                    <tr>
                                        <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$name.'</td>
                                    </tr>
                                    <tr>
                                        <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:'.$email.'" target="_blank" style="color: #333;text-decoration: none;">'.$email.'</a></td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;text-transform: uppercase;color: #333;padding-bottom: 12px;font-weight:bold;width: 120px;">Password</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$password.'</td>
                                    </tr>
                                </table>
                                <p>Your Password is <span style="font-weight:bold"> '.$password.' </span></p>
                                <p>Use this password to Login</p>
                                <p>Thank You.</p>
                                 <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p>Thanks & Regards,</p>
                                <p><a href="'.route('home').'">'.$site_name.'</a></p>
                            </div>
                        </div>';
                    
                    
                    if(mail($to,$subject,$txt,$headers)){
                        Session::flash('message', 'Password Changed and Mail Send Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        session()->forget('user');
                        if($user->user_type == 4) {
                            return redirect()->route('signin');
                        } else if($user->user_type == 2 || $user->user_type == 3) {
                            return redirect()->route('merchant');
                        } else {
                            return redirect()->route('admin');
                        }
                    } else {
                        Session::flash('message', 'Password Changed Successfully!'); 
                        Session::flash('alert-class', 'alert-success');
                        session()->forget('user');
                        if($user->user_type == 4) {
                            return redirect()->route('signin');
                        } else if($user->user_type == 2 || $user->user_type == 3) {
                            return redirect()->route('merchant');
                        } else {
                            return redirect()->route('admin');
                        }
                    }
                } else{
                    Session::flash('message', 'Password Changed Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('forgot');
                } 
            } else{
                Session::flash('message', 'You\'re Reset Code Is Not Valid!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('reset');
            }
        }
    }

    public function ChkRepwdQuestion () {
        $secure = loginSecurity::all();
        return View::make('user.chk_repwd_question')->with(array('secure'=>$secure));
    }

    public function ChkRepwdAnswer (Request $request) {
        $rules = array(
            'mobno'                   => 'required',
            'question'                => 'required',
            'answer'                  => 'required',
            'password'                => 'required|min:5',
            'password_salt'           => 'required|min:5|same:password',
        );

        $messages=[
            'password_salt.required' => 'The confirm password field is required.',
            'password_salt.min'      => 'The confirm password must be at least 5 characters.',
            'password_salt.same'     => 'The confirm password and password must match.',
        ];
        $validator = Validator::make(Input::all(), $rules,$messages);

        if ($validator->fails()) {
            return redirect()->route('chk_repwd_question')->withErrors($validator);
        } else {
            $data = Input::all();
            $ps = "gj";
            $pe = "ja";
            $user = User::where('email', $data['mobno'])->where('is_block', 1)->first();
            if(!$user) {
                $user = User::where('phone', $data['mobno'])->where('is_block', 1)->first();
            }

            if($user) {
                $act = User::where('id', $user->id)->where('is_block', 1)->where('question', $data['question'])->first();

                if($act) {
                    if($act->answer == $data['answer']) {
                        $user->password                  = md5($data['password']);
                        $user->password_salt             = $ps.$data['password_salt'].$pe;


                        $pass = $data['password'];
                        if($user->save()) {
                            $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                            $admin_email = "info@folkgems.com";
                            if($adm) {
                                $admin_email = $adm->email;
                            }

                            $logos = \DB::table('logo_settings')->first();
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

                            $name = $user->first_name.' '.$user->last_name;
                            $email = $user->email;
                            $password = $pass;

                            $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers.= "MIME-Version: 1.0\r\n";
                            // $headers.= "From: $admin_email" . "\r\n";
                            $headers.= "From: noreply@folkgems.com" . "\r\n";
                            $to = $email;
                            $subject = "Password Changed";
                            $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                                <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                                <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                    <h2 style="color: #ff5c00;margin-top: 0px;">Changed Password Successfully</h2>
                                    <table align="center" style=" text-align: center;">
                                        <tr>
                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$name.'</td>
                                        </tr>
                                        <tr>
                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:'.$email.'" target="_blank" style="color: #333;text-decoration: none;">'.$email.'</a></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center;text-transform: uppercase;color: #333;padding-bottom: 12px;font-weight:bold;width: 120px;">Password</th>
                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$password.'</td>
                                        </tr>
                                    </table>
                                    <p>Your Password is <span style="font-weight:bold"> '.$password.' </span></p>
                                    <p>Use this password to Login</p>
                                    <p>Thank You.</p>
                                    <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                    <p>Thanks & Regards,</p>
                                    <p><a href="'.route('home').'">'.$site_name.'</a></p>
                                </div>
                            </div>';
                            
                            if(mail($to,$subject,$txt,$headers)){
                                Session::flash('message', 'Password Changed and Mail Send Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                session()->forget('user');
                                if($user->user_type == 4) {
                                    return redirect()->route('signin');
                                } else if($user->user_type == 2 || $user->user_type == 3) {
                                    return redirect()->route('merchant');
                                } else {
                                    return redirect()->route('admin');
                                }
                            } else {
                                Session::flash('message', 'Password Changed Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                session()->forget('user');
                                if($user->user_type == 4) {
                                    return redirect()->route('signin');
                                } else if($user->user_type == 2 || $user->user_type == 3) {
                                    return redirect()->route('merchant');
                                } else {
                                    return redirect()->route('admin');
                                }
                            }
                        } else{
                            Session::flash('message', 'Password Changed Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('chk_repwd_question');
                        } 
                    } else {
                        Session::flash('message', 'Your Security Answer is Wrong!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('chk_repwd_question');
                    }
                } else {
                    Session::flash('message', 'Your Security Question is Wrong!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('chk_repwd_question');
                }                         
            } else{
                Session::flash('message', 'Your E-Mail or Mobile Number is Not Valid!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('chk_repwd_question');
            }
        }
    }

    public function MyProfile () {
        $page = "Users";
        $profile = session()->get('user');
        if($profile) {
            return View::make('user.my_profile')->with(array('profile'=>$profile, 'page'=>$page));
        } else if( $profile->user_type == 3) {
            return redirect()->route('merchant');
        } else {
            return redirect()->route('admin');
        }
    }

    public function EditProfile () {
        $page = "Users";
        $user = session()->get('user');;
        if($user) {
            $docs = MerchantsDocuments::Where('merchant', $user->id)->get();
            if($docs) {
                $user['docs'] = $docs;
            } else {
                $user['docs'] = NULL;
            }
            return View::make('user.edit_profile')->with(array('user'=>$user, 'page'=>$page));
        } else {
            return redirect()->back();
        }
    }

    public function UpdateProfile (Request $request) {
        // dd($request->all());
        $page = "Users";
        $id = $request->get('user_id');
        $user = '';
        if($id != '') {
            $user = User::Where('id', $id)->first();
        }

        if($user) {
            $rules = array(
                // 'full_name'               => 'required',
                'first_name'              => 'nullable',
                'last_name'               => 'nullable', 
                'bussiness_name'          => 'nullable',
                'buss_reg_no'             => 'nullable',
                'email'                   => 'required|email:rfc,dns|unique:users,email,'.$id.',id',
                'country'                 => 'nullable',
                'state'                   => 'nullable', 
                // 'city'                    => 'required', 
                'phone'                   => 'required|numeric|unique:users,phone,'.$id.',id',
                'phone2'                  => 'nullable|numeric|unique:users,phone2,'.$id.',id',
                'gender'                  => 'nullable',
                'customer_type'           => 'nullable',
                'dob'                     => 'nullable|date',
                'address1'                => 'nullable',
                'address2'                => 'nullable',
                'pincode'                 => 'nullable|numeric|digits:6',
                'commission'              => 'nullable|numeric',
                'return_commission'       => 'nullable|numeric',
                'question'                => 'nullable',
                'answer'                  => 'nullable',
                // 'payment_account_details' => 'nullable',
                'profile_img'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_approved'             => 'nullable',
                'is_block'                => 'nullable',
                'user_type'               => 'nullable', 
                'login_type'              => 'nullable',

                'd_name'                  => 'nullable',
                'd_image'                 => 'nullable',
            );
             $messages=[
                'profile_img.image' => 'The Profile Image must be an image.',
                'profile_img.mimes' => 'The Profile Image must be a file of type: jpeg, png, jpg.',
                'profile_img.max' => 'The Profile Image may not be greater than 2MB.',
            ];
            
            
            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {
                // dd($validator->errors()); 
                // return View::make('user.edit_profile')->withErrors($validator)->with(array('user'=>$user));
                return Redirect::back()->withInput()->withErrors($validator)->with(array('page'=>$page));
            } else {
                $data = $request->all();
                $img_files = $request->file('profile_img');
                if(isset($img_files)) {
                    $file_name = $img_files->getClientOriginalName();
                    $date = date('M-Y');
                    // $file_path = '../public/images/profile_img/'.$date;
                    $file_path = 'images/profile_img/'.$date;
                    $img_files->move($file_path, $file_name);
                    $user->profile_img = $date.'/'.$file_name;
                } else {
                    // $user->profile_img = NULL;
                }

                // $user->first_name                = $data['first_name'];
                // $user->last_name                 = $data['last_name'];
              

                if(isset($data['bussiness_name'])) {
                    $user->bussiness_name        = $data['bussiness_name'];
                }

                if(isset($data['buss_reg_no'])) {
                    $user->buss_reg_no           = $data['buss_reg_no'];
                }

                if(isset($data['question'])) {
                    $user->question              = $data['question'];
                }

                if(isset($data['answer'])) {
                    $user->answer                = $data['answer'];
                }

                $fullName = trim($data['full_name'] ?? '');
                $nameParts = preg_split('/\s+/', $fullName, 2);

                $user->full_name                 = $fullName;
                $user->first_name                = $data['first_name'] ?? ($nameParts[0] ?? $user->first_name);
                $user->last_name                 = $data['last_name'] ?? ($nameParts[1] ?? $user->last_name);
                $user->email                     = $data['email'];
                $user->dob                       = $data['dob'] ?? null;
                $user->country                   = $data['country'] ?? '0';
                $user->state                     = $data['state'] ?? '0';
                $user->city                      = $data['city'] ?? '0';
                $user->phone                     = $data['phone'];
                $user->phone2                    = $data['phone2'] ?? null;
                $user->gender                    = $data['gender'] ?? null;
                $user->customer_type             = $data['customer_type'] ?? null;
                $user->address1                  = $data['address1'] ?? null;
                $user->address2                  = $data['address2'] ?? null;
                $user->pincode                   = $data['pincode'] ?? null;

                /*if (isset($data['commission'])) {
                    $user->commission            = $data['commission'];
                } else {
                    $user->commission            = 0;
                }

                if (isset($data['return_commission'])) {
                    $user->return_commission     = $data['return_commission'];
                } else {
                    $user->return_commission     = 0;
                }*/

                // if (isset($data['payment_account_details'])) {
                //     $user->payment_account_details  = $data['payment_account_details'];
                // } else {
                //     $user->payment_account_details  = NULL;
                // }
                
                if (isset($data['user_type'])) {
                    $user->user_type                 = $data['user_type'];
                } else {
                    $user->user_type                 = $user->user_type;                    
                }

                // $user->is_approved               = 1;
                // $user->is_block                  = 1;
                // $user->login_type                = 1;

                if($user->save()) {
                    if(isset($data['d_name'])) {
                        if($data['d_name'] && count($data['d_name']) != 0) {
                            MerchantsDocuments::where('merchant', $user->id)->delete();
                            foreach ($data['d_name'] as $key => $value) {
                                $d_images = new MerchantsDocuments();

                                if(isset($data['d_image'][$key])) {
                                    $file_name = $data['d_image'][$key]->getClientOriginalName();
                                    $date = date('M-Y');
                                    // $file_path = '../public/documents/'.$date;
                                    $file_path = 'documents/'.$date;
                                    $data['d_image'][$key]->move($file_path, $file_name);
                                    $d_images->image       = $date.'/'.$file_name;
                                } else if (isset($data['old_d_image'][$key])) {
                                    $d_images->image       = $data['old_d_image'][$key];
                                } else {
                                    $d_images->image       = NULL;
                                }

                                $d_images->merchant  = $user->id; 

                                $d_images->d_name      = $value;     
                                $d_images->is_block    = 1;

                                $d_images->save();
                            }
                        }
                    }

                    session()->forget('user');
                    Session::flash('message', 'Profile updated Successfully!'); 
                    Session::flash('alert-class', 'alert-success');
                    Session::put('user', $user);

                    if($user->user_type == 4) {
                        return redirect()->route('my_account', ['tab' => 'profile']);
                    } else {
                        return redirect()->route('my_profile');
                    }
                } else{
                    Session::flash('message', 'update profile Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    // return redirect()->route('my_profile');
                    // return Redirect::back();
                    if($user->user_type == 4) {
                        return redirect()->route('my_account', ['tab' => 'profile']);
                    } else {
                        return redirect()->route('my_profile');
                    }
                }   
            }
        } else{
            Session::flash('message', 'update profile Failed!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('my_profile');
        }
    }

    public function index () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                // $user = User::all();
                $filteredUserId = request()->get('user_id');

                    $userQuery = User::query();
                    if (!empty($filteredUserId)) {
                        $userQuery->where('user_type', $filteredUserId);
                    }
                
                    $user = $userQuery->orderBy('created_at', 'desc')->get();
                if($user) {
                    foreach ($user as $key => $mer) {
                        $country = CountriesManagement::where('id',$mer->country)->first();
                        $state = StateManagements::where('id',$mer->state)->first();
                        $city = CityManagement::where('id',$mer->city)->first();
                        
                        if($country) {
                            $user[$key]['country'] = $country->country_name;
                        } else {
                            $user[$key]['country'] = "-------";
                        }

                        if($state) {
                            $user[$key]['state'] = $state->state;
                        } else {
                            $user[$key]['state'] = "-------";
                        }

                        if($city) {
                            $user[$key]['city'] = $city->city_name;
                        } else {
                            $user[$key]['city'] = "-------";
                        }
                    }
                }
                return View::make("user.manage_user")->with(array('user'=>$user, 'page'=>$page));
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
    
    public function admin_staff () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                $user = User::where('user_type',2)->get();
                // $filteredUserId = request()->get('user_id');

                //     $userQuery = User::query();
                //     if (!empty($filteredUserId)) {
                //         $userQuery->where('user_type', $filteredUserId);
                //     }
                
                //     $user = $userQuery->get();
                if($user) {
                    foreach ($user as $key => $mer) {
                        $country = CountriesManagement::where('id',$mer->country)->first();
                        $state = StateManagements::where('id',$mer->state)->first();
                        $city = CityManagement::where('id',$mer->city)->first();
                        
                        if($country) {
                            $user[$key]['country'] = $country->country_name;
                        } else {
                            $user[$key]['country'] = "-------";
                        }

                        if($state) {
                            $user[$key]['state'] = $state->state;
                        } else {
                            $user[$key]['state'] = "-------";
                        }

                        if($city) {
                            $user[$key]['city'] = $city->city_name;
                        } else {
                            $user[$key]['city'] = "-------";
                        }
                    }
                }
                return View::make("user.manage_admin_staff")->with(array('user'=>$user, 'page'=>$page));
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
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                return View::make('user.add_user')->with(array('page'=>$page));
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

    public function SelectCity (Request $request) {
        $country = 0;
        $city_val = 0;
        if($request->ajax() && isset($request->country)){
            $country = $request->country;

            if(isset($request->city)) {
                $city_val = $request->city;
            }

            $data = "";
            if($country != 0) {
                $city = CityManagement::where('country_name',$country)->get();
                if(($city) && (sizeof($city) != 0)){
                    if($city_val != 0) {
                        foreach ($city as $key => $value) {
                            if($city_val == $value->id) {
                                $data.='<option selected value="'.$value->id.'">'.$value->city_name.'</option>';
                            } else {
                                $data.='<option value="'.$value->id.'">'.$value->city_name.'</option>';
                            }
                        }
                    } else {
                        $data = '<option value="0" selected disabled>Select City</option>';
                        foreach ($city as $key => $value) {
                            $data.='<option value="'.$value->id.'">'.$value->city_name.'</option>';
                        }
                    }
                }           
            }
            echo $data;
        }
    }

    public function store(Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                $rules = array(
                    'role'  =>'required',
                    'full_name'              => 'required',
                    'first_name'              => 'nullable',
                    'last_name'               => 'nullable',
                    'email'                   => 'required|email:rfc,dns|unique:users,email',
                    'phone'                   => 'required|numeric|regex:/^\d{10}$/|unique:users,phone',
                    'phone2'                  => 'nullable|numeric|unique:users,phone2',
                    'password'                => 'required|min:5',
                    'password_salt'           => 'required|min:5|same:password',
                    'profile_img'             => 'nullable',
                    'remember_token'          => 'nullable',
                    'gender'                  => 'nullable',
                    'address1'                  => 'nullable',
                    'address2'                  => 'required',
                    'dob'                       => 'required',
                    'pincode'                  => 'required',
                    'is_approved'             => 'nullable',
                    'is_block'                => 'nullable',
                    'user_type'               => 'nullable',
                    'login_type'              => 'nullable',
                );

                $messages=[
                    'password_salt.required'=>'The confirm password field is required.',
                    'password_salt.min'=>'The confirm password must be at least 5 characters.',
                    'password_salt.same'=>'The confirm password and password must match.',
                ];
                $validator = Validator::make($request->all(), $rules,$messages);

                if ($validator->fails()) {
                    return redirect()->back()->withInput()->withErrors($validator)->with(array('page'=>$page));
                } else {
                    $data = $request->all();
                    $ps = "gj";
                    $pe = "ja";
                    $user = new User();

                    if($user) {
                        $img_files = $request->file('profile_img');
                        if(isset($img_files)) {
                            $file_name = $img_files->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/profile_img/'.$date;
                            $file_path = 'images/profile_img/'.$date;
                            $img_files->move($file_path, $file_name);
                            $user->profile_img = $date.'/'.$file_name;
                        } else {
                            $user->profile_img = NULL;
                        }

                        $user->full_name                = $data['full_name'] ?? '';
                        $user->first_name                = $data['first_name'] ?? '';
                        $user->last_name                 = $data['last_name'] ?? '';
                        $user->email                     = $data['email'];
                        $user->password                  = md5($data['password']);
                        $user->password_salt             = $ps.$data['password_salt'].$pe;
                        $user->country                  = $data['country_code'] ?? '';
                        $user->phone                     = $data['phone'];
                        $user->phone2                    = $data['phone2'] ?? '0';
                        $user->gender                    = $data['gender'] ?? '0';
                        $user->address1                     = $data['address1'];
                        $user->address2                     = $data['address2'];
                        $user->dob                     = $data['dob'];
                        $user->pincode                     = $data['pincode'];
                        $user->user_type                 = $data['role'];

                        if (isset($data['is_approved'])) {
                           $user->is_approved            = $data['is_approved'];
                        } else {
                            $user->is_approved           = 1;
                        }
                        $user->is_block                  = 1;
                        $user->verification                  = 1;
                        $user->email_verify                  = 1;
                        $user->login_type                = 1;

                        $pass = $data['password'];
                        if($user->save()) {
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

                            $name = $user->full_name;
                            $email = $user->email;
                            $password = $pass;
                            $dash = route('home');
                            if ($user->user_type == 1 || $user->user_type == 2 ) {
                                $dash = route('admin');
                            } else if ( $user->user_type == 3) {
                                $dash = route('merchant');
                            } else {
                                $dash = route('home');
                            }

                            $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers.= "MIME-Version: 1.0\r\n";
                            // $headers.= "From: $admin_email" . "\r\n";
                            $headers.= "From: Rang by Bhavana <jgrrylvmgyxm>" . "\r\n";
                            $to = $email;
                            $subject = "RANG BY BHAVANA : Registration Successful.";
                             $txt = '
                                <div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                                    <a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                </div>
                                 <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                 <h2 style="color: #B73182;margin-top: 0px;">Registration Successful</h2>
                                    <p style="font-size:15px;font-weight:600;">Dear '.$name.', </p>
                                                       
                                    <p style="font-size:12px;font-weight:600;">Congratulations and welcome to the RANG BY BHAVANA family ! We are thrilled to have you join us.</p>
                                    <p style="font-size:12px;font-weight:600;">Your RANG BY BHAVANA account has been successfully created with the following details:</p>
                                    <table align="center" style=" text-align: center;width: 100%;">
                                         <tr>
                                                <td style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;"> <b>Phone Number</b> </td>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> <b>'.$user->phone.'</b> </td>
                                            </tr>
                                    
                                            <tr>
                                                <td style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;"> <b>Email</b> </td>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> <b>'.$user->email.'</b> </td>
                                            </tr>
                                    </table>
                                     <p style="font-size:13px;font-weight:600;">Now that you are registered, you can explore our wide range of unique and handcrafted silver jewelry, place orders, and take advantage of our exclusive offers and promotions.</p>
                                        <p  style="font-size:13px;font-weight:600;">Please subscribe to our newsletter <a href="'.route('home').'">here</a> to keep yourself updated on our latest collections. </p>
                                        <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>.</p>
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                        <p style="font-size:13px;font-weight:600;">Best Regards,</p>
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
                                </div>
                            ';

                            if (mail($to,$subject,$txt,$headers)) {
                                Session::flash('message', 'User Added Successfully !'); 
                                Session::flash('alert-class', 'alert-success');
                                return redirect()->route('manage_user');
                            } else {
                                Session::flash('message', 'User Added Successfully!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('manage_user');
                            }
                        } else{
                            Session::flash('message', 'User Added Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_user');
                        }  
                    } else{
                        Session::flash('message', 'User Added Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_user');
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
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                $user = User::where('id',$id)->first();
                if($user) {
                    $docs = MerchantsDocuments::Where('merchant', $user->id)->get();
                    if($docs) {
                        $user['docs'] = $docs;
                    } else {
                        $user['docs'] = NULL;
                    }
                }
                return View::make("user.edit_user")->with(array('user'=>$user, 'page'=>$page));
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
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();
                
            if($privil) {
                $page = "Users";
                $id = $request->get('user_id');
                $user = '';
                if($id != '') {
                    $user = User::Where('id', $id)->first();
                }
                
                if($user) {
                    $rules = array(
                        'full_name'              => 'required',
                        'first_name'              => 'nullable',
                        'last_name'               => 'nullable',
                        'email'                   => 'required|email:rfc,dns|unique:users,email,'.$id.',id',
                        'phone'                   => 'required|numeric|unique:users,phone,'.$id.',id',
                        'phone2'                  => 'nullable|numeric|unique:users,phone2,'.$id.',id',
                        'gender'                  => 'nullable',
                        'address1'                  => 'required',
                        'address2'                  => 'required',
                        'dob'                       => 'required',
                        'pincode'                  => 'required|numeric|digits:6',
                        'profile_img'             => 'nullable',
                        'is_approved'             => 'nullable',
                        'is_block'                => 'nullable',
                        'user_type'               => 'nullable',
                        'login_type'              => 'nullable',
                    );
                    $validator = Validator::make($request->all(), $rules);

                //  dd($validator);

                    if ($validator->fails()) {
                        if($user) {
                            $docs = MerchantsDocuments::Where('merchant', $user->id)->get();
                            if($docs) {
                                $user['docs'] = $docs;
                            } else {
                                $user['docs'] = NULL;
                            }
                        }
                        return redirect()->back()->withInput()->withErrors($validator)->with(array('user'=>$user, 'page'=>$page));
                    } else {
                        $data = $request->all();

                        $img_files = $request->file('profile_img');
                        if(isset($img_files)) {
                            $file_name = $img_files->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/profile_img/'.$date;
                            $file_path = 'images/profile_img/'.$date;
                            $img_files->move($file_path, $file_name);
                            $user->profile_img = $date.'/'.$file_name;
                        } else if (isset($data['old_profile_img'])) {
                            $user->profile_img = $data['old_profile_img'];
                        } else {
                            $user->profile_img = NULL;
                        }

                        $user->full_name                = $data['full_name'] ?? '';
                        $user->first_name                = $data['first_name'] ?? '';
                        $user->last_name                 = $data['last_name'] ?? '';
                        $user->email                     = $data['email'];
                        $user->country                  = $data['country_code'] ?? '';
                        $user->phone                     = $data['phone'];
                        $user->phone2                    = $data['phone2'] ?? '0';
                        $user->gender                    = $data['gender'] ?? '0';
                        $user->address1                     = $data['address1'];
                        $user->address2                     = $data['address2'];
                        $user->dob                     = $data['dob'];
                        $user->pincode                     = $data['pincode'];
                        $user->user_type                 = $data['role'];

                        if (isset($data['is_approved'])) {
                            $user->is_approved           = $data['is_approved'];
                        } else {
                            $user->is_approved           = 0;
                        }

                        $user->is_block                  = 1;
                        $user->login_type                = 1;

                        if($user->save()) {
                            Session::flash('message', 'update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_user');

                        } else{
                            Session::flash('message', 'update Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_user');
                        }   
                    }
                } else{
                    Session::flash('message', 'update Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_user');
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

    public function view ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.view', '=', 1)
                ->first();

            if($privil) {
                $page = "Users";
                $user = User::where('id',$id)->first();
                if($user) {
                    $docs = MerchantsDocuments::Where('merchant', $user->id)->get();
                    if($docs) {
                        $user['docs'] = $docs;
                    } else {
                        $user['docs'] = NULL;
                    }
                }
                return View::make("user.view_user")->with(array('user'=>$user, 'page'=>$page));
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
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id)){
                    $id = $request->id;
                    if($id != 0) {
                        $user = User::where('id',$id)->where('user_type', '!=', 1)->first();
                        if($user) {
                            if($user->delete()) {
                                Session::flash('message', 'Deleted Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            } else {
                                Session::flash('message', 'Deleted Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Deleted Failed!'); 
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
                // return redirect()->back();
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $error = 1;
        }
        
        echo $error;
    }

    public function DeleteAll( Request $request) {  
        $ids = array();
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    if(sizeof($ids) != 0) {
                        foreach ($ids as $key => $value) {
                            $user = User::where('id',$value)->where('user_type', '!=', 1)->first();
                            if($user){
                                if($user->delete()) {
                                    Session::flash('message', 'Deleted Successfully!'); 
                                    Session::flash('alert-class', 'alert-success');
                                    $error = 0;
                                } else {
                                    Session::flash('message', 'Deleted Failed!'); 
                                    Session::flash('alert-class', 'alert-danger');

                                }
                            }   else {
                                Session::flash('message', 'Deleted Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                            }           
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
                // return redirect()->back();
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $error = 1;
        }
        
        echo $error;
    }

    public function Statususer ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                $user = '';
                $msg = '';
                if($id != '') {
                    $user = User::where('id',$id)->where('user_type', '!=', 1)->first();
                }

                if($user) {
                    if($user->is_block == 1) {
                        $user->is_block        = 0;
                        $msg = "Blocked Successfully";
                    } else {
                        $user->is_block        = 1;
                        $msg = "Unblocked Successfully";
                    }
                    
                    if($user->save()) {
                        Session::flash('message', $msg); 
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('manage_user');
                    } else{
                        Session::flash('message', 'Failed Block or Unblock!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_user');
                    }
                } else{
                    Session::flash('message', 'Failed Block or Unblock!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_user');
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

    public function ApprovedUser ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                $user = '';
                $msg = '';
                if($id != '') {
                    $user = User::where('id',$id)->where('user_type', '!=', 1)->first();
                }

                if($user) {
                    $user->approved_date = date('Y-m-d');
                    if($user->is_approved == 1) {
                        $user->is_approved        = 0;
                        $msg = "Rejected Successfully";
                    } else {
                        $user->is_approved        = 1;
                        $msg = "Approved Successfully";
                    }
                    
                    if($user->save()) {
                        if($user->is_approved == 1) {
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

                            $name = $user->first_name.' '.$user->last_name;
                            if(isset($user->email) && $user->email) {
                                $email = $user->email;
                                $dash = route('home');
                                if ($user->user_type == 1) {
                                    $dash = route('admin');
                                } else if ($user->user_type == 2 || $user->user_type == 3) {
                                    $dash = route('merchant');
                                } else {
                                    $dash = route('home');
                                }

                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rang by Bhavana <jgrrylvmgyxm>" . "\r\n";
                                $to = $email;
                                $subject = "Register Successful";

                                $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                            <h2 style="color: #ff5c00;margin-top: 0px;">Registration Process Successful</h2>
                                            <table align="center" style=" text-align: center;">
                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$name.'</td>
                                                </tr>
                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:'.$email.'" target="_blank" style="color: #333;text-decoration: none;">'.$email.'</a></td>
                                                </tr>
                                            </table>
                                            <p>Please Login and continue our service</p>
                                            <p>Dashboard url : <a href="'.$dash.'">'.$dash.'</a></p>
                                            <p></p>
                                            <p>Thank You.</p>
                                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p>Thanks & Regards,</p>
                                            <p><a href="'.route('home').'">'.$site_name.'</a></p>
                                        </div>
                                    </div>';

                                if (mail($to,$subject,$txt,$headers)) {
                                    Session::flash('message', $msg.' and Mail Sent Successfully!');
                                    Session::flash('alert-class', 'alert-success');
                                    return redirect()->route('manage_user');
                                } else {
                                    Session::flash('message', $msg.' and Mail Send Failed!');  
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('manage_user');
                                }
                            } else {
                                Session::flash('message', $msg.' and Mail Send Failed!');  
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('manage_user');
                            }                              
                        } else {
                            Session::flash('message', $msg); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_user');
                        }
                    } else{
                        Session::flash('message', 'Failed Approved or Rejected!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_user');
                    }
                } else{
                    Session::flash('message', 'Failed Approved or Rejected!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_user');
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

    public function UserBlock( Request $request) {  
        $ids = array();
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    if(sizeof($ids) != 0) {
                        foreach ($ids as $key => $value) {
                            $user = User::where('id',$value)->where('user_type', '!=', 1)->first();
                            if($user){
                                $user->is_block = 0;
                                $user->save();
                                Session::flash('message', 'Blocked Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            }   else {
                                Session::flash('message', 'Blocked Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                            }           
                        }
                    } else {
                        Session::flash('message', 'Blocked Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $error = 1;
        }
        
        echo $error;
    }

    public function UserUnblock( Request $request) {    
        $ids = array();
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All User')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    if(sizeof($ids) != 0) {
                        foreach ($ids as $key => $value) {
                            $user = User::where('id',$value)->where('user_type', '!=', 1)->first();
                            if($user){
                                $user->is_block = 1;
                                $user->save();
                                Session::flash('message', 'Unblocked Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            }   else {
                                Session::flash('message', 'Unblocked Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                            }           
                        }
                    } else {
                        Session::flash('message', 'Unblocked Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $error = 1;
        }

        echo $error;
    }
    
    
    public function address_store(Request $request)
    {
        // dd($request->all()); 
        $page = "Users";
        $id = $request->get('user_id');
        $user = '';
        if($id != '') {
            $user = User::Where('id', $id)->first();
        }

            if($user) {
                $page = "Users";
                $rules = array(
                    'title' => 'required|string|max:255',
                    'address2' => 'required|string',
                    'address3' => 'required|string',
                    'locality' => 'required|string',
                    'pincode' => 'required',
                );
                
                $messages = [
                    'title.required'     => 'The title is required.',
                    'address2.required'  => 'The Address is required.',
                    'address3.required'  => 'Street Address is required.',
                    'locality.required'  => 'Locality is required.',
                    'pincode.required'   => 'Pincode is required.',
                    'pincode.digits'     => 'Pincode must be exactly 6 digits.',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    // return View('front_end.my_account')->withErrors($validator);
                    return redirect()->route('my_account', ['tab' => 'myAddress'])->withErrors($validator)->withInput()->with('show_address_modal', true);

                } else {
                    $data = $request->all();
                   
                        // $address = new Address();
                        $address = $request->address_id ? Address::findOrFail($request->address_id) : new Address();

                    if($address) {
                        
                        if ($request->has('default')) {
                            Address::where('user_id', $id)->update(['is_default' => 0]);
                            $address->is_default = 1;
                        } else {
                            $address->is_default = $address->exists ? $address->is_default : 0;
                        }

                        $address->user_id                      = $id;
                        $address->address_type = !empty($data['title']) ? $data['title'] : ($data['address1'] ?? '');
                        $address->title                        = $data['title'] ?? '0';
                        $address->address2                     = $data['address2'];
                        $address->address3                  = $data['address3'];
                        $address->locality                     = $data['locality'];
                        $address->pincode                    = $data['pincode'] ?? '0';

                        if($address->save()) {
                                session()->forget('user');
                                Session::flash('message', 'Address saved Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                Session::put('user', $user);
                                return redirect()->route('my_account', ['tab' => 'myAddress']);
                            
                        } else{
                            Session::flash('message', 'Added Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('my_account', ['tab' => 'myAddress']);
                        }  
                    } else{
                        Session::flash('message', 'Added Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account', ['tab' => 'myAddress']);
                    }
                
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        
    }
    
    
    public function address_delete($id)
        {
            $address = Address::findOrFail($id);
            if ($address->is_default) {
                Session::flash('message', 'Default address cannot be deleted!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('my_account', ['tab' => 'myAddress']);
            }
        
            $address->delete();
        
            Session::flash('message', 'Address deleted successfully!');
            Session::flash('alert-class', 'alert-success');
        
            return redirect()->route('my_account', ['tab' => 'myAddress']);
        }
        
        public function address_edit($id)
        {
            $address = Address::find($id);
           if (!$address) {
                return response()->json(['success' => false, 'message' => 'Address not found'], 404);
            }

            return response()->json(['success' => true, 'data' => $address]);
        }
        
     public function makeDefault($id)
    {
        $address = Address::find($id);
        
        if (!$address) {
            return response()->json(['status' => 'error', 'message' => 'Address not found']);
        }
    
        // Set all addresses for the user to non-default
        Address::where('user_id', $address->user_id)->update(['is_default' => 0]);
    
        // Set the selected address as default
        $address->is_default = 1;
        $address->save();
        
        Session::flash('message', 'Default Address Updated Successfully!');
        Session::flash('alert-class', 'alert-success');
        // return response()->json(['status' => 'success', 'message' => 'Default address updated']);
    }

    
}
