<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use App\OrderDetails;
use App\OrdersTransactions;
use App\Products;
use App\ProductsAttributes;
use App\User;
use App\ShippingAddress;
use App\NoimageSettings;
use App\CityManagement;
use App\CountriesManagement;
use App\StateManagements;
use App\StockTransactions;
use App\ReturnOrder;
use App\ReturnOrderDetails;
use App\StockManagement;
use App\GrvOrders;
use App\GrvOrdersDetails;
use App\CreditsNotes;
use App\AdminCommision;
use App\GeneralSettings;
use App\EmailSettings;
use App\LogoSettings;
use App\CustomiseProduct;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;
use Hash;

class OrdersController extends Controller
{
    protected $respose;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function AllOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                // ->where('cancel_approved','!=',3)
                if($sess) {
                    if($sess->user_type == 1 || $sess->user_type == 2) {
                        $orders = Orders::OrderBy('id', 'DESC')->get();
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det)) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    } else if( $sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = Orders::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                            if(sizeof($orders) != 0) {
                                foreach ($orders as $key => $value) {
                                    $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                    if(sizeof($det) != 0) {
                                        $orders[$key]->{'details'} = $det;
                                    } else {
                                        $orders[$key]->{'details'} =  '';
                                    }
                                }
                            }
                        }
                    }
                }

            	return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
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
    
    public function AllDeletedOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                // ->where('cancel_approved','!=',3)
                if($sess) {
                    if($sess->user_type == 1 || $sess->user_type == 2) {
                        $orders = Orders::onlyTrashed()->OrderBy('id', 'DESC')->get();
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det)) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    } else if( $sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = Orders::onlyTrashed()->WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                            if(sizeof($orders) != 0) {
                                foreach ($orders as $key => $value) {
                                    $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                    if(sizeof($det) != 0) {
                                        $orders[$key]->{'details'} = $det;
                                    } else {
                                        $orders[$key]->{'details'} =  '';
                                    }
                                }
                            }
                        }
                    }
                }

            	return View::make("transaction.orders.all_deleted_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

    public function ReplaceOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Replace New Order')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                
                if($sess) {
                    if($sess->user_type == 1) {
                        $orders = Orders::Where('replace_order', "Yes")->OrderBy('id', 'DESC')->paginate(10);
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det)) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    } else if($sess->user_type == 2 || $sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('A.replace_order', '=', 'Yes')
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = Orders::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                            if(sizeof($orders) != 0) {
                                foreach ($orders as $key => $value) {
                                    $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                    if(sizeof($det)) {
                                        $orders[$key]->{'details'} = $det;
                                    } else {
                                        $orders[$key]->{'details'} =  '';
                                    }
                                }
                            }
                        }
                    }
                }

                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

    public function CancelAllOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Cancel Order')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                
                if($sess) {
                    if($sess->user_type == 1 || $sess->user_type == 2) {
                        $orders = Orders::WhereIn('cancel_approved',[1,2])->OrderBy('id', 'DESC')->get();
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det)) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    } else if( $sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('A.cancel_approved', '!=', 0)
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = Orders::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                            if(sizeof($orders) != 0) {
                                foreach ($orders as $key => $value) {
                                    $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                    if(sizeof($det)) {
                                        $orders[$key]->{'details'} = $det;
                                    } else {
                                        $orders[$key]->{'details'} =  '';
                                    }
                                }
                            }
                        }
                    }
                }

                return View::make("transaction.orders.cancel_all_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

    public function CancelReqOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Cancel Order Requests')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                
                if($sess) {
                    if($sess->user_type == 1 || $sess->user_type == 2) {
                        $orders = Orders::Where('cancel_approved', 3)->OrderBy('id', 'DESC')->paginate(10);
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det)) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    } else if($sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('A.cancel_approved', '=', 2)
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = Orders::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                            if(sizeof($orders) != 0) {
                                foreach ($orders as $key => $value) {
                                    $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                    if(sizeof($det)) {
                                        $orders[$key]->{'details'} = $det;
                                    } else {
                                        $orders[$key]->{'details'} =  '';
                                    }
                                }
                            }
                        }
                    }
                }

                return View::make("transaction.orders.cancel_req_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

    public function CancelReqAccept ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Cancel Order Requests')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $orders = Orders::Where('cancel_approved', 3)->where('id',$id)->first();
                if($orders) {
                    return View::make("transaction.orders.cancel_order_sts")->with(array('orders'=>$orders, 'page'=>$page));
                } else {
                   Session::flash('message', 'Could Not Accepted/Reject Cancel Order Request!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('cancel_req_orders'); 
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
    
  public function approveCancelOrders(Request $request)
        {
            $loged = session()->get('user');
        
            if (!$loged) {
                Session::flash('message', 'Please Login Properly!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Cancel Order Requests')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();
        
            if (!$privil) {
                Session::flash('message', 'You Are Not Allowed to Access This Module!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        
            $rules = [
                'order_ids' => 'required|array',
                'order_ids.*' => 'required|exists:orders,id',
            ];
        
            $messages = [
                'order_ids.required' => 'At least one order must be selected.',
            ];
        
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('message', 'Validation Error!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back()->withErrors($validator);
            }
        
            $orderIds = $request->order_ids;
            $orders = Orders::whereIn('id', $orderIds)->where('cancel_approved', 3)->get();
        
            // Process all orders
            foreach ($orders as $order) {
                $order->cancel_approved = 1;
                $order->order_status = 5;
                $order->cancel_date = now();
                $order->save();
            }
        
            // Send emails & SMS after processing all orders
            foreach ($orders as $order) {
                $text = $order->cancel_approved == 1
                    ? "Your Order Cancel Request is Accepted. Order Code - {$order->order_code}, rukminifashions.com"
                    : "Your Order Cancel Request is Rejected. Order Code - {$order->order_code}, rukminifashions.com";
                $subject = $order->cancel_approved == 1 ? "Your Rukmini Fashions Cancel Order requested was Accepted" : "Cancel Order Request Rejected";
                
                
                $user = User::find($order->user_id);
                if ($user) {
                    $admin_email = User::where('user_type', 1)->where('is_block', 1)->value('email') ?? 'info@ecambiar.com';
        
                    $logo = asset('images/logo.png');
                    $logos = DB::table('logo_settings')->latest()->first();
                    if ($logos && $logos->logo_image) {
                        $logo = asset('images/logo/' . $logos->logo_image);
                    }
                    
                    $product_path= 'images/featured_products';
                     $noimage = \DB::table('noimage_settings')->first();
                    $noimage_path = 'images/noimage';
                    $details = '';
                    $discount = '';
                    $img = '';

                        foreach($order->orderDetails as $orderDetail){
                                        if ($orderDetail->Products->featured_product_img) {
                                            $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                        } else {
                                            $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                        }
                            $details .= '<tr>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                    <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                        '.$img.'
                                    </a>
                                </td>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.'</td>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                            </tr>';
                        }
                        
                        if ($order->coupon_code) {
                            $discount = '
                            <tr>
                                <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                    Coupon Discount
                                </th>
                                <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                    - Rs. '.number_format($order->coupon_discount, 2).'
                                </td>
                            </tr>';
                        }
        
                    $site_name = DB::table('general_settings')->value('site_name') ?? 'ECambiar';
                    $name = $user->full_name;
                    $net_tot = $order->net_amount;
        
                    $headers  = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
        
                    $to1 = $user->email; 
                    $to2 = $admin_email;
        
                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                            <h2 style="color: #B73182;margin-top: 0px;">'.$subject.'</h2>
                                <p style="font-size:15px;font-weight:600;">Dear '.$name.', </p>
                                           
                                <p style="font-size:12px;font-weight:600;">We are writing to confirm that your request to cancel order #'.$order->order_code.' from Rukmini Fashions has been <b>Accepted</b>.</p>
                                           
                            <table align="center" style=" text-align: center;width: 100%;">
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$name.'</td>
                                </tr>

                                <tr>
                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->phone.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Email</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->email.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->order_code.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->order_date.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Request Cancel Date</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->cancel_date.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Remarks</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->cancel_remarks.'</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order->payment->name.'</td>
                                </tr>
                            </table>
                            
                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                <tr>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                </tr>'.$details.'
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->total_amount.'</td>
                                </tr>
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->shipping_charge.'</td>
                                </tr>
                                
                                '.$discount.'
                               
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                </tr>
                            </table>

                            <p style="font-size:13px;font-weight:600;">The cancellation has been processed. If already paid, you will receive a full refund for the order amount within the next 3-5 business days.</p>
                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>.</p>
                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                            <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                             <div style="padding: 20px 0; text-align: center;">
                                <a href="https://www.instagram.com/parislabellenta" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:parisnta91@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                            
                        </div>
                    </div>';
        
                    // mail($to1, $subject, $txt, $headers);
                    // mail($to2, $subject, $txt, $headers);
                    
                    Session::put('cancel_email_data', [
                        'to' => $to1,
                        'to2' => $to2,
                        'subject' => $subject,
                        'body' => $txt,
                        'headers' => $headers,
                    ]);
                }
            }
        
            Session::flash('message', 'Selected Cancel Order Requests have been Approved.');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'success' => true,
                'redirect' => route('cancel_req_orders')
            ]);
        }
        
        public function sendCancelReqEmail(Request $request)
        {
            $data = session()->pull('cancel_email_data'); 
        
            if ($data) {
                mail($data['to'], $data['subject'], $data['body'], $data['headers']);
                mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
                return response()->json(['status' => 'sent']);
            }
        
            return response()->json(['status' => 'no_data']);
        }
        
        public function rejectCancelOrders(Request $request)
{
    $loged = session()->get('user');

    if (!$loged) {
        Session::flash('message', 'Please Login Properly!'); 
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }

    // Check privilege
    $privil = DB::table('previlages as A')
        ->leftjoin('modules as B', 'A.module', '=', 'B.id')
        ->select('A.id as pid','A.*','B.id as mid','B.*')
        ->where('B.module_name', '=', 'Cancel Order Requests')
        ->where('A.role', '=', $loged->user_type)
        ->where('A.status', '=', 1)
        ->first();

    if (!$privil) {
        Session::flash('message', 'You Are Not Allowed to Access This Module!'); 
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }

    // Validation
    $rules = [
        'order_ids'         => 'required|array',
        'order_ids.*'       => 'required|exists:orders,id',
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        Session::flash('message', 'Validation Error!'); 
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back()->withErrors($validator);
    }

    $orderIds = $request->order_ids;
    $orders = Orders::whereIn('id', $orderIds)->where('cancel_approved', 3)->get();

    foreach ($orders as $order) {
        if ($order) {
            $order->cancel_approved = '2';
            // $order->order_status = 1;
            $order->cancel_date = now();
            $order->save();
            
            $orderDetail = $order->orderDetails->first();

                if ($orderDetail) {
                    
                     $product = Products::find($orderDetail->product_id);
                        if($product){
                            $product->onhand_qty += $orderDetail->order_qty;
                            $product->save();
                        }
                    
                    $stock_manag = StockManagement::where('product_id', $orderDetail->product_id)->latest()->first();
                
                    if ($stock_manag) {
                        $stock_manag->current_qty += $orderDetail->order_qty;
                        $stock_manag->save();
                    }
                }

            // Prepare notification
            $text = "Your Order Cancel Request is Rejected. Order Code - {$order->order_code}, parisnta91@gmail.com";
            $subject = "Your Rukmini Fashions Cancel Order requested was Rejected";

            // Send email and SMS
            $user = User::find($order->user_id);
            if ($user) {
                $admin_email = User::where('user_type', 1)->where('is_block', 1)->value('email') ?? 'info@ecambiar.com';

                $logo = asset('images/logo.png');
                $logos = DB::table('logo_settings')->latest()->first();
                if ($logos && $logos->logo_image) {
                    $logo = asset('images/logo/' . $logos->logo_image);
                }
                
                
                $product_path= 'images/featured_products';
                $noimage = \DB::table('noimage_settings')->first();
                $noimage_path = 'images/noimage';
                $details = '';
                $discount = '';
                $img = '';

                    foreach($order->orderDetails as $orderDetail){
                        if ($orderDetail->Products->featured_product_img) {
                                            $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                        } else {
                                            $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                        }
                        $details .= '<tr>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                    '.$img.'
                                </a>
                            </td>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.'</td>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                        </tr>';
                    }
                    
                    if ($order->coupon_code) {
                            $discount = '
                            <tr>
                                <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                    Coupon Discount
                                </th>
                                <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                    - Rs. '.number_format($order->coupon_discount, 2).'
                                </td>
                            </tr>';
                        }

                $site_name = DB::table('general_settings')->value('site_name') ?? 'ECambiar';
                $name = $user->full_name;
                $net_tot = $order->net_amount;

                $headers  = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";

                $to1 = $user->email;
                $to2 = $admin_email;

                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                            <h2 style="color: #B73182;margin-top: 0px;">'.$subject.'</h2>
                            
                             <p style="font-size:15px;font-weight:600;">Dear '.$name.', </p>
                                           
                            <p style="font-size:12px;font-weight:600;">We have reviewed your request to cancel order #'.$order->order_code.' from Rukmini Fashions, and unfortunately, we are <b>unable to proceed with the cancellation</b>.Find More details below.</p>
                                           
                            <table align="center" style=" text-align: center;width: 100%;">
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$name.'</td>
                                </tr>

                                <tr>
                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->phone.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Email</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->email.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->order_code.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->order_date.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Request Cancel Date</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->cancel_date.'</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Remarks</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order->cancel_remarks.'</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order->payment->name.'</td>
                                </tr>
                            </table>
                            
                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                <tr>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                </tr>'.$details.'
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->total_amount.'</td>
                                </tr>
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->shipping_charge.'</td>
                                </tr>
                                
                                 '.$discount.'
                               
                                <tr>
                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                </tr>
                            </table>

                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please donot hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>. </p>
                            
                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                            <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                             <div style="padding: 20px 0; text-align: center;">
                                <a href="https://www.instagram.com/parislabellenta" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:parisnta91@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                        </div>
                    </div>'; // Your mail HTML here

                // Send mail — optional: you may check success or not but don't return inside loop
                // mail($to1, $subject, $txt, $headers);
                // mail($to2, $subject, $txt, $headers);
                Session::put('cancel_reject_email_data', [
                        'to' => $to1,
                        'to2' => $to2,
                        'subject' => $subject,
                        'body' => $txt,
                        'headers' => $headers,
                    ]);
            }
        }
    }

    // After all orders processed
    Session::flash('message', 'Selected Cancel Order Requests have been Rejected.');
    Session::flash('alert-class', 'alert-success');
    return response()->json([
        'success' => true,
        'redirect' => route('cancel_req_orders')
    ]);
}

  public function sendCancelRejectEmail(Request $request)
        {
            $data = session()->pull('cancel_reject_email_data'); 
        
            if ($data) {
                mail($data['to'], $data['subject'], $data['body'], $data['headers']);
                mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
                return response()->json(['status' => 'sent']);
            }
        
            return response()->json(['status' => 'no_data']);
        }


    
  

    public function CancelReqStatus (Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Cancel Order Requests')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $data = $request->all();

                $rules = array(
                    'order_id'          => 'required|exists:orders,id',
                    'cancel_remarks'    => 'required',
                    'cancel_approved'   => 'required',
                );

                $messages=[
                    'cancel_approved.required'=>'The Cancel Order Status field is required.',
                ];
                $validator = Validator::make($request->all(), $rules,$messages);

                if ($validator->fails()) {
                    Session::flash('message', 'Fix Validation Error!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return Redirect::to('/cancel_req_accept/'.$data['order_id'])->withErrors($validator);
                    // return redirect()->route('cancel_req_accept'.$data['order_id'])->withErrors($validator);
                } else {
                    $orders = Orders::Where('cancel_approved', 3)->where('id',$data['order_id'])->first();
                    if($orders) {
                        $orders->cancel_approved = $data['cancel_approved'];
                        $orders->cancel_remarks  = $data['cancel_remarks'];

                        if($data['cancel_approved'] == 1) {
                            $orders->order_status = 5;
                            $orders->cancel_date = date('Y-m-d');
                        }else{
                           $orderDetail = $orders->orderDetails->first();

                            if ($orderDetail) {
                                $product = Products::find($orderDetail->product_id);
                                if($product){
                                    $product->onhand_qty += $orderDetail->order_qty;
                                    $product->save();
                                }
                                $stock_manag = StockManagement::where('product_id', $orderDetail->product_id)->latest()->first();
                            
                                if ($stock_manag) {
                                    $stock_manag->current_qty += $orderDetail->order_qty;
                                    $stock_manag->save();
                                }
                            }
                        }

                        if($orders->save()) {
                            if($orders->cancel_approved == 1) {
                                $text = "Your Order Cancel Request is Accepted. Plz note the Order Code - ".$orders->order_code.", rukminifashions.com";
                                $subject = "Your Rukmini Fashions Cancel Order requested was Accepted";
                                $feedtxt=' <p style="font-size:12px;font-weight:600;">We are writing to confirm that your request to cancel order #'.$orders->order_code.' from Rukmini Fashions has been <b>Accepted</b>.</p>
                                           ';
                                $feedtxt1=' The cancellation has been processed. If already paid, you will receive a full refund for the order amount within the next 3-5 business days.';
                            } elseif ($orders->cancel_approved == 2) {
                                $text = "Your Order Cancel Request is Rejected. Plz note the Order Code - ".$orders->order_code.", rukminifashions.com";
                                $subject = "Your Rukmini Fashions Cancel Order requested was Rejected.";
                                $feedtxt=' <p style="font-size:12px;font-weight:600;">We have reviewed your request to cancel order #'.$orders->order_code.' from Rukmini Fashions, and unfortunately, we are <b>unable to proceed with the cancellation</b>.Find More details below. </p>';
                                $feedtxt1=' ';
                            }

                            $text = urlencode($text);

                            $curl = curl_init();
                            $user = User::Where('id', $orders->user_id)->first();
                            if($user) { 
                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@ecambiar.com";
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
                                $site_name = "ECambiar";
                                if($general){
                                    $site_name = $general->site_name;
                                } else {
                                    $site_name = "ECambiar";
                                } 
                                
                                 $product_path= 'images/featured_products';
                                $details = '';

                                  foreach($orders->orderDetails as $orderDetail){
                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                            <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                                <img src="'.asset($product_path.'/'.$orderDetail->Products->featured_product_img).'" style="max-width:80px; max-height:80px;">
                                            </a>
                                        </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                                    </tr>';
                                }


                                $name = $user->full_name;
                                $net_tot = $orders->net_amount;

                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to1 = $user->email;
                                $to2 = $admin_email;

                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                        
                                            <h2 style="color: #B73182;margin-top: 0px;">'.$subject.'</h2>
                                            <p style="font-size:15px;font-weight:600;">Dear '.$name.', </p>
                                           
                                           <p style="font-size:12px;font-weight:600;">'.$feedtxt.'</p>
                                           
                                            <table align="center" style=" text-align: center;width: 100%;">
                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">customer Name</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$name.'</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->phone.'</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Email</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$user->email.'</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$orders->order_code.'</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$orders->order_date.'</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Request Replied Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$orders->cancel_date.'</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Remarks</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$orders->cancel_remarks.'</td>
                                                </tr>
                                            </table>
                                            
                                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                                <tr>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                                </tr>'.$details.'
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->total_amount.'</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->shipping_charge.'</td>
                                                </tr>
                                               
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                                </tr>
                                            </table>

                                                  '.$feedtxt1.'
                                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>. </p>
                                            
                                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                            <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                            <div style="padding: 20px 0; text-align: center;">
                                                <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>';
                                    
                                    
                                // if(1==1){
                                if(mail($to1,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers)) {
                                    Session::flash('message', $subject); 
                                    Session::flash('alert-class', 'alert-success');
                                     return redirect()->route('cancel_req_orders');
                                }

                                // Send the POST request with cURL
                                // curl_setopt_array($curl, array(
                                // CURLOPT_RETURNTRANSFER => 1,
                                // CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                // CURLOPT_POST => 1,
                                // CURLOPT_CUSTOMREQUEST => 'POST',
                                // CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                // CURLOPT_POSTFIELDS => array(
                                //     'mobile' => $user->phone,
                                //     'route' => 'TL',
                                //     'text' => $text,
                                //     'sender' => 'GJICAM')));
                             
                                // Send the request & save response to $response
                                // $response = curl_exec($curl);
                             
                                // Close request to clear up some resources
                                // curl_close($curl);
                                // $response = json_decode($response);
                                // // Print response
                                // if(isset($response->data->status) && $response->data->status == "success") {
                                //     Session::flash('message', $subject); 
                                //     Session::flash('alert-class', 'alert-success');
                                //     return redirect()->route('cancel_req_orders');
                                // } else {
                                //     Session::flash('message', $subject); 
                                //     Session::flash('alert-class', 'alert-danger');
                                //     return redirect()->route('cancel_req_orders');
                                // }
                            } else {
                                Session::flash('message', 'Could Not Accept/Reject Cancel Order Request!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('cancel_req_orders');
                            }
                        } else {
                            Session::flash('message', 'Could Not Accepted/Reject Cancel Order Request!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('cancel_req_orders');
                        }
                    } else {
                       Session::flash('message', 'Could Not Accepted/Reject Cancel Order Request!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('cancel_req_orders'); 
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

    public function NewOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Replace New Order')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $grv = GrvOrders::Where('grv_status', 1)->get();
                return View::make("transaction.orders.new_orders")->with(array('grv'=>$grv, 'page'=>$page));
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

    public function CreateCreditNotes () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Credit Notes')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $grv = GrvOrders::Where('grv_status', 1)->get();
                return View::make("transaction.orders.create_credit_notes")->with(array('grv'=>$grv, 'page'=>$page));
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

    public function SaveNewOrders (Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Replace New Order')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $data = $request->all();

                $rules = array(
                    'return_type'       => 'nullable',
                    'grv_id'            => 'nullable',
                    'remarks'           => 'required',
                );

                $messages=[
                    'grv_id.required'=>'The Grv field is required.',
                ];
                $validator = Validator::make($request->all(), $rules,$messages);

                if ($validator->fails()) {
                    Session::flash('message', 'Fix Validation Error, Remark Fields is required!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('create_credit_notes')->withErrors($validator);
                } else {
                    $sus1 = 0;
                    $sus2 = 0;
                    $sus3 = 0;

                    $user = User::Where('id', $data['user_id'])->Where('is_block', 1)->first();
                    if($user) {
                        if($data['return_type'] == "Refund") {
                            if (isset($data['det_return_type']) && count($data['det_return_type']) != 0) {
                                if (in_array("Exchange", $data['det_return_type'])) {
                                    Session::flash('message', 'Only Refund is Available!'); 
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('create_credit_notes');
                                } else {
                                    if (in_array("Replacement", $data['det_return_type'])) {
                                        Session::flash('message', 'Only Refund is Available!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('create_credit_notes');
                                    } else {
                                        $cn = new CreditsNotes();

                                        if($cn) {
                                            $max = CreditsNotes::max('cn_code');
                                            $max_id = "00001";
                                            $max_st = "CN";
                                            if($max) {
                                                $max_no = substr($max, 2);
                                                $increment = (int)$max_no + 1;
                                                $data['cn_code'] = $max_st.sprintf("%05d", $increment);
                                            } else {
                                                $data['cn_code'] = $max_st.$max_id;
                                            }

                                            $cn->cn_code = $data['cn_code'];
                                            $cn->grv_id = $data['grv_id'];
                                            $cn->amount = $data['det_sub_tot'];
                                            $cn->remarks = $data['remarks'];
                                            $cn->date = date('Y-m-d');
                                            $cn->is_paid = 'Un Paid';

                                            if($cn->save()) {
                                                if (isset($data['grv_det_id']) && count($data['grv_det_id']) != 0) {
                                                    foreach ($data['grv_det_id'] as $keys => $values) {
                                                        $grv_details = GrvOrdersDetails::Where('id', $values)->first();
                                                        if($grv_details) {
                                                            $grv_details->grv_issued = "Yes";
                                                            $grv_details->save();

                                                            $com_per = $grv_details->Products->Creatier->commission;
                                                            $t_pce = $cn->amount;
                                                            $admin_com = round($t_pce * ($com_per / 100), 2);
                                                            $mer_amt = round($t_pce - $admin_com, 2);

                                                            $comis = new AdminCommision();
                                                            $comis->type         = 'Credit Notes';
                                                            $comis->cn_id        = $cn->id;
                                                            $comis->order_code   = null;
                                                            $comis->order_dets   = null;
                                                            $comis->product_id   = $grv_details->product_id;
                                                            $comis->att_name     = $grv_details->att_name;
                                                            $comis->att_value    = $grv_details->att_value;
                                                            $comis->merchant_id  = $grv_details->Products->Creatier->id;
                                                            $comis->amount       = $admin_com;
                                                            $comis->merchant_amount = $mer_amt;
                                                            $comis->paid_status  = 0;
                                                            $comis->remarks      = $grv_details->product_title.' product against Admin Commision is Rs. '.$admin_com.' set.';
                                                            $comis->save();
                                                        }
                                                    }
                                                }

                                                $odr_cde = "";
                                                $grv = GrvOrders::Where('id', $data['grv_id'])->first();
                                                if($grv) {
                                                    $odr_cde = $grv->Orders->order_code;
                                                    $grv_dets = GrvOrdersDetails::Where('grv_id', $grv->id)->get();
                                                    if($grv_dets->contains('grv_issued', 'No')){
                                                        $grv->grv_status = 1;
                                                    } else {
                                                        $grv->grv_status = 2;
                                                    }
                                                    $grv->save();
                                                }

                                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                                $admin_email = "info@ecambiar.com";
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
                                                $site_name = "ECambiar";
                                                if($general){
                                                    $site_name = $general->site_name;
                                                } else {
                                                    $site_name = "ECambiar";
                                                }

                                                $customer_name = $user->full_name;
                                                $address = $user->address1.','.$user->address2.','.$user->City->city_name.','.$user->pincode.','.$user->State->state.','.$user->Country->country_name;
                                                $contact = $user->phone.','.$user->phone2;

                                                $name = $user->full_name;
                                                $email = $user->email;

                                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                                $headers.= "MIME-Version: 1.0\r\n";
                                                // $headers.= "From: $admin_email" . "\r\n";
                                                $headers.= "From: jgrrylvmgyxm" . "\r\n";
                                                $to = $email;
                                                $to2 = $admin_email;
                                                $subject = "Credit Notes Details";
                                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat;  background-size: 100% 102%;">
                                                    <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></div>
                                                    <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                                        <h2 style="color: #ff5c00;margin-top: 0px;">Credit Notes Details</h2>
                                                        <table align="center" style=" text-align: center;">
                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$customer_name.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Contact No</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$contact.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Address</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$address.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Code</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$odr_cde.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Credit Notes Code</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$cn->cn_code.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Amount</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : Rs. '.$cn->amount.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Date</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.date('d-m-Y', strtotime($cn->date)).'</td>
                                                            </tr>
                                                        </table>
                                                        <p></p>
                                                        <p style="font-size:13px;font-weight:600;">Thank You.</p>
                                                         <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                                        <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                                        <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                                    </div>
                                                </div>';
                                
                                                // if(1==1) {
                                                if(mail($to,$subject,$txt,$headers)){
                                                    mail($to2,$subject,$txt,$headers);
                                                    if($user->phone) {
                                                        $text = "Your Order Refund Request against Credit Notes Create Successful - Reference Code  - ".$cn->cn_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Credit Notes Created and confirm  Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Credit Notes Created & Email Send Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Credit Notes Created & Mail Send Successfully!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                } else {
                                                    if($user->phone) {
                                                        $text = "Your Order Refund Request against Credit Notes Create Successful - Reference Code  - ".$cn->cn_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Credit Notes Created and  Confirm Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Credit Notes Created Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Credit Notes Created!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                }
                                            } else {
                                                Session::flash('message', 'Credit Notes Created Failed!'); 
                                                Session::flash('alert-class', 'alert-danger');
                                                return redirect()->route('create_credit_notes');
                                            }
                                        } else {
                                            Session::flash('message', 'Credit Notes Created Not Possible!'); 
                                            Session::flash('alert-class', 'alert-danger');
                                            return redirect()->route('create_credit_notes');      
                                        }
                                    }
                                }
                            } else {
                                Session::flash('message', 'Please Enter All Details!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('create_credit_notes');
                            }
                        } else if(($data['return_type'] == "Replacement")) {
                            if (isset($data['det_return_type']) && count($data['det_return_type']) != 0) {
                                if (in_array("Refund", $data['det_return_type'])) {
                                    Session::flash('message', 'Only Replacement is Available!'); 
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('new_orders');
                                } else {
                                    $order = new Orders();

                                    if($order) {
                                        $max = Orders::max('order_code');
                                        $max_id = "00001";
                                        $max_st = "Order";
                                        if($max) {
                                            $max_no = substr($max, 5);
                                            $increment = (int)$max_no + 1;
                                            $data['order_code'] = $max_st.sprintf("%05d", $increment);
                                        } else {
                                            $data['order_code'] = $max_st.$max_id;
                                        }

                                        $order->order_code = $data['order_code'];
                                        $order->order_date = date('Y-m-d');
                                        $order->user_id = $data['user_id'];
                                        $order->payment_mode = $data['payment_mode'];
                                        $order->contact_person = $data['contact_person'];
                                        $order->contact_email = $data['contact_email'];
                                        $order->contact_no = $data['contact_no'];
                                        $order->shipping_address_flag = $data['shipping_address_flag'];
                                        $order->shipping_address = $data['shipping_address'];
                                        $order->city = $data['city'];
                                        $order->pincode = $data['pincode'];
                                        $order->total_items = $data['total_items'];
                                        // $order->tax_amount = $data['tax_amount'];
                                        $order->total_amount = $data['det_sub_tot'];
                                        $order->service_charge = $data['det_serv_charge'];
                                        $order->shipping_charge = $data['det_shipping_charge'];
                                        $order->net_amount = $data['det_net_amount'];
                                        $order->ref_order_id = $data['order_id'];
                                        $order->grv_id = $data['grv_id'];
                                        $order->order_status = 1;
                                        $order->payment_status = 0;
                                        $order->remarks = NULL;
                                        $order->replace_order = 'Yes';
                                        $order->is_block = 1;

                                        if($order->save()) {
                                            if (isset($data['det_product_id']) && count($data['det_product_id']) != 0) {
                                                foreach ($data['det_product_id'] as $key => $value) {
                                                    $order_details = new OrderDetails();
                                                    $order_details->order_id = $order->id;
                                                    $order_details->product_id = $value;
                                                    
                                                    if(isset($data['det_product_title'][$key])) {
                                                        $order_details->product_title = $data['det_product_title'][$key];
                                                    } else {
                                                        $order_details->product_title = NULL;
                                                    }
                                                    
                                                    if(isset($data['det_return_qty'][$key])) {
                                                        $order_details->order_qty = $data['det_return_qty'][$key];
                                                    } else {
                                                        $order_details->order_qty = NULL;
                                                    }

                                                    if(isset($data['det_att_name'][$key])) {
                                                        $order_details->att_name = $data['det_att_name'][$key];
                                                    } else {
                                                        $order_details->att_name = NULL;
                                                    }

                                                    if(isset($data['det_att_value'][$key])) {
                                                        $order_details->att_value = $data['det_att_value'][$key];
                                                    } else {
                                                        $order_details->att_value = NULL;
                                                    }

                                                    if(isset($data['det_tax'][$key])) {
                                                        $order_details->tax = $data['det_tax'][$key];
                                                    } else {
                                                        $order_details->tax = NULL;
                                                    }

                                                    if(isset($data['det_tax_type'][$key])) {
                                                        $order_details->tax_type = $data['det_tax_type'][$key];
                                                    } else {
                                                        $order_details->tax_type = NULL;
                                                    }

                                                    if(isset($data['det_unitprice'][$key])) {
                                                        $order_details->unitprice = $data['det_unitprice'][$key];
                                                    } else {
                                                        $order_details->unitprice = NULL;
                                                    }

                                                    // if(isset($data['det_return_tax_amount'][$key])) {
                                                    //     $order_details->tax_amount = $data['det_return_tax_amount'][$key];
                                                    // } else {
                                                    //     $order_details->tax_amount = NULL;
                                                    // }

                                                    if(isset($data['det_totalprice'][$key])) {
                                                        $order_details->totalprice = $data['det_totalprice'][$key];
                                                    } else {
                                                        $order_details->totalprice = NULL;
                                                    }
                                                    
                                                    $order_details->is_block = 1;

                                                    if($order_details->save()) {
                                                        $sus2 = 1;
                                                    }                                
                                                }                            
                                            }

                                            if($data['payment_mode'] == 1) {
                                                $order_trans = new OrdersTransactions();
                                                $t_max = OrdersTransactions::max('trans_code');
                                                $t_max_id = "00001";
                                                $t_max_st = "Trans";
                                                if($t_max) {
                                                    $t_max_no = substr($t_max, 5);
                                                    $t_increment = (int)$t_max_no + 1;
                                                    $data['trans_code'] = $t_max_st.sprintf("%05d", $t_increment);
                                                } else {
                                                    $data['trans_code'] = $t_max_st.$t_max_id;
                                                }

                                                $order_trans->trans_code = $data['trans_code'];
                                                $order_trans->trans_date = date('Y-m-d H:i:s');
                                                $order_trans->order_id = $order->id;
                                                $order_trans->net_amount = $order->net_amount;
                                                $order_trans->amountpaid = "Unpaid";
                                                $order_trans->paymentmode = $data['payment_mode'];
                                                $order_trans->gatewaytransactionid = NULL;
                                                $order_trans->trans_status = "PENDING";
                                                $order_trans->remarks = NULL;
                                                $order_trans->is_block = 1;

                                                if($order_trans->save()) {
                                                    $sus3 = 1;
                                                }
                                            } else if($data['payment_mode'] == 2) {
                                                if($order) {
                                                    $order->order_status = 1;
                                                    $order->payment_status = 0;
                                                    $order->save();
                                                    $sus3 = 1;
                                                }
                                            } 

                                            if($sus2 == 1 && $sus3 == 1) {
                                                if (isset($data['grv_det_id']) && count($data['grv_det_id']) != 0) {
                                                    foreach ($data['grv_det_id'] as $keys => $values) {
                                                        $grv_details = GrvOrdersDetails::Where('id', $values)->first();
                                                        $grv_details->grv_issued = "Yes";
                                                        $grv_details->save();
                                                    }
                                                }

                                                $grv = GrvOrders::Where('id', $data['grv_id'])->first();
                                                if($grv) {
                                                    $grv_dets = GrvOrdersDetails::Where('grv_id', $grv->id)->get();
                                                    if($grv_dets->contains('grv_issued', 'No')){
                                                        $grv->grv_status = 1;
                                                    } else {
                                                        $grv->grv_status = 2;
                                                    }
                                                    $grv->save();
                                                }

                                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                                $admin_email = "info@ecambiar.com";
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
                                                $site_name = "ECambiar";
                                                if($general){
                                                    $site_name = $general->site_name;
                                                } else {
                                                    $site_name = "ECambiar";
                                                }

                                                $net_comis = 0.00;
                                                $net_mer_amt = 0.00;
                                                $customer_name = "";
                                                $contact = "";
                                                $address = "";
                                                $order_code = $order->order_code;
                                                $order_date = date('d-m-Y', strtotime($order->order_date));
                                                $net_tot = $order->net_amount;
                                                // $tax_tot = $order->tax_amount;
                                                $details = "";
                                                $order_detail = OrderDetails::Where('is_block', 1)->Where('order_id', $order->id)->get();
                                                $details="";
                                                if($order_detail) {
                                                    foreach ($order_detail as $key => $value) {
                                                        $stock = Products::Where('id', $value->product_id)->first();

                                                        if($stock && ($stock->onhand_qty != 0)) {
                                                            $stock_trans = new StockTransactions();
                                                            $stock_trans->order_code   = $order_code;
                                                            $stock_trans->product_id   = $value->product_id;
                                                            $stock_trans->att_name     = $value->att_name;
                                                            $stock_trans->att_value    = $value->att_value;
                                                            $stock_trans->previous_qty = $stock->onhand_qty;
                                                            $stock_trans->current_qty  = $stock->onhand_qty - $value->order_qty;
                                                            $stock_trans->date         = date('Y-m-d');
                                                            $stock_trans->remarks      = $value->product_title.' is ordered.';

                                                            $stock->onhand_qty = $stock->onhand_qty - $value->order_qty;
                                                            
                                                            $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                                            if($p_atts) {
                                                                $stock_trans->att_previous_qty = $p_atts->att_qty;
                                                                $stock_trans->att_current_qty  = $p_atts->att_qty - $value->order_qty;
                                                                
                                                                $p_atts->att_qty = $p_atts->att_qty - $value->order_qty;
                                                                $p_atts->save();
                                                            }

                                                            if($stock->save() && $stock_trans->save()) {
                                                                $sck = 1;
                                                            }

                                                        }

                                                        if($stock && $stock->created_user != 1) {
                                                            if($stock->Creatier->user_type == 2 || $stock->Creatier->user_type == 3) {
                                                                $com_per = $stock->Creatier->commission;
                                                                $t_pce = $value->totalprice;
                                                                $admin_com = round($t_pce * ($com_per / 100), 2);
                                                                $mer_amt = round($t_pce - $admin_com, 2);

                                                                $comis = new AdminCommision();
                                                                $comis->order_code   = $order_code;
                                                                $comis->order_dets   = $value->id;
                                                                $comis->product_id   = $value->product_id;
                                                                $comis->att_name     = $value->att_name;
                                                                $comis->att_value    = $value->att_value;
                                                                $comis->merchant_id  = $stock->Creatier->id;
                                                                $comis->amount       = $admin_com;
                                                                $comis->merchant_amount = $mer_amt;
                                                                $comis->paid_status  = 0;
                                                                $comis->remarks      = $value->product_title.' product against Admin Commision is Rs. '.$admin_com.' set.';
                                                                $comis->save();

                                                                $net_comis   = $net_comis + $admin_com;
                                                                $net_mer_amt = $net_mer_amt + $mer_amt;
                                                            }
                                                        }

                                                        $att_tit = "";
                                                        if(isset($value->att_name) && $value->att_name != 0) {
                                                            if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                                                $att_tit = '<span>('.$value->AttName->att_name.' : '.$value->AttValue->att_value.')</span>';
                                                            }
                                                        }

                                                        $details.= '<tr>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;"> '.$value->product_title.' '. $att_tit .'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;"> '.$value->order_qty.'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;">Rs.  '.$value->unitprice.'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs.  '.$value->totalprice.'</td>
                                                        </tr>';
                                                    }
                                                }

                                                if($order) {
                                                    $order->net_commision = $net_comis;
                                                    $order->net_merchant_amout = $net_mer_amt;
                                                    $order->save();
                                                }

                                                $ships = ShippingAddress::Where('user_id', $user->id)->Where('is_block', 1)->first();
                                                if(isset($data['shipping_address_flag']) && $data['shipping_address_flag'] == 1) {
                                                    if($ship) {
                                                        $customer_name = $ship->first_name.' '.$ship->last_name;
                                                        $address = $ship->address.','.$ship->City->city_name.','.$ship->pincode.','.$ship->State->state.','.$ship->Country->country_name;
                                                        $contact = $ship->contact_no;
                                                    } else if ($user) {
                                                        $customer_name = $user->full_name;
                                                        $address = $user->address1.','.$user->address2.','.$user->City->city_name.','.$user->pincode.','.$user->State->state.','.$user->Country->country_name;
                                                        $contact = $user->phone.','.$user->phone2;
                                                    }
                                                } else if ($user) {
                                                    $customer_name = $user->full_name;
                                                    $address = $user->address1.','.$user->address2.','.$user->City->city_name.','.$user->pincode.','.$user->State->state.','.$user->Country->country_name;
                                                    $contact = $user->phone.','.$user->phone2;
                                                }

                                                $name = $user->full_name;
                                                $email = $user->email;

                                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                                $headers.= "MIME-Version: 1.0\r\n";
                                                // $headers.= "From: $admin_email" . "\r\n";
                                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                                $to = $email;
                                                $to2 = $admin_email;
                                                $subject = "Orders Details";
                                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat;  background-size: 100% 102%;">
                                                    <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                                                    <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                                        <h2 style="color: #ff5c00;margin-top: 0px;">Orders Details</h2>
                                                        <table align="center" style=" text-align: center;">
                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$customer_name.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Contact No</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$contact.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Address</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$address.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Code</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$order_code.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Date</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$order_date.'</td>
                                                            </tr>
                                                        </table>

                                                        <table style="width: 100%;border: 1px solid black;">
                                                            <tr>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Product Title</th>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Quantity</th>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Price</th>
                                                                <th style="width: 100px;text-align: right;text-transform: uppercase;padding-bottom: 5px;color: black;border: 1px solid black;font-size: 13px;font-weight: 700;">Total</th>
                                                            </tr>'.$details.'
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Sub Total</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->total_amount.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Shipping Charge</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->shipping_charge.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">COD Charge</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->cod_charge.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Net Total</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$net_tot.'</td>
                                                            </tr>
                                                        </table>

                                                        <p></p>
                                                        <p>Thank You.</p>
                                                         <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                                        <p>Thanks & Regards,</p>
                                                        <p><a href="'.route('home').'">'.$site_name.'</a></p>
                                                    </div>
                                                </div>';
                                
                                                // if(1==1) {
                                                if(mail($to,$subject,$txt,$headers)){
                                                    mail($to2,$subject,$txt,$headers);
                                                    if($user->phone) {
                                                        $text = "Replacement order successful - Order Reference Code  - ".$order_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Order Confirm Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Order placed & Email Send Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Order Placed & Mail Send Successfully!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                } else {
                                                    if($user->phone) {
                                                        $text = "Thanks for shopping with us.Plz note the Order Code - ".$order_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Order Confirm Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Order placed Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Order Placed Successfully!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                }
                                            } else {
                                                Orders::where('id', $order->id)->delete();
                                                Session::flash('message', 'Replace New Orders Placed Failed!'); 
                                                Session::flash('alert-class', 'alert-danger');
                                                return redirect()->route('new_orders');
                                            }
                                        } else {
                                            Session::flash('message', 'Replace New Orders Placed Failed!'); 
                                            Session::flash('alert-class', 'alert-danger');
                                            return redirect()->route('new_orders');
                                        }
                                    } else {
                                        Session::flash('message', 'New Order Created Not Possible!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('new_orders');      
                                    }
                                }
                            } else {
                                Session::flash('message', 'Please Enter All Details!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('new_orders');
                            }
                        } else if(($data['return_type'] == "Exchange")) {
                            if (isset($data['det_return_type']) && count($data['det_return_type']) != 0) {
                                if (in_array("Refund", $data['det_return_type'])) {
                                    Session::flash('message', 'Only Exchange is Available!'); 
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('new_orders');
                                } else {
                                    $order = new Orders();

                                    if($order) {
                                        $max = Orders::max('order_code');
                                        $max_id = "00001";
                                        $max_st = "Order";
                                        if($max) {
                                            $max_no = substr($max, 5);
                                            $increment = (int)$max_no + 1;
                                            $data['order_code'] = $max_st.sprintf("%05d", $increment);
                                        } else {
                                            $data['order_code'] = $max_st.$max_id;
                                        }

                                        $order->order_code = $data['order_code'];
                                        $order->order_date = date('Y-m-d');
                                        $order->user_id = $data['user_id'];
                                        $order->payment_mode = $data['payment_mode'];
                                        $order->contact_person = $data['contact_person'];
                                        $order->contact_email = $data['contact_email'];
                                        $order->contact_no = $data['contact_no'];
                                        $order->shipping_address_flag = $data['shipping_address_flag'];
                                        $order->shipping_address = $data['shipping_address'];
                                        $order->city = $data['city'];
                                        $order->pincode = $data['pincode'];
                                        $order->total_items = $data['total_items'];
                                        // $order->tax_amount = $data['tax_amount'];
                                        $order->total_amount = $data['det_sub_tot'];
                                        $order->service_charge = $data['det_serv_charge'];
                                        $order->shipping_charge = $data['det_shipping_charge'];
                                        $order->net_amount = $data['det_net_amount'];
                                        $order->ref_order_id = $data['order_id'];
                                        $order->grv_id = $data['grv_id'];
                                        $order->order_status = 1;
                                        $order->payment_status = 0;
                                        $order->remarks = NULL;
                                        $order->replace_order = 'Yes';
                                        $order->is_block = 1;

                                        if($order->save()) {
                                            if (isset($data['det_product_id']) && count($data['det_product_id']) != 0) {
                                                foreach ($data['det_product_id'] as $key => $value) {
                                                    $order_details = new OrderDetails();
                                                    $order_details->order_id = $order->id;
                                                    $order_details->product_id = $value;
                                                    
                                                    if(isset($data['det_product_title'][$key])) {
                                                        $order_details->product_title = $data['det_product_title'][$key];
                                                    } else {
                                                        $order_details->product_title = NULL;
                                                    }
                                                    
                                                    if(isset($data['det_return_qty'][$key])) {
                                                        $order_details->order_qty = $data['det_return_qty'][$key];
                                                    } else {
                                                        $order_details->order_qty = NULL;
                                                    }

                                                    if(isset($data['cge_atts'][$key]) && ($data['cge_atts'][$key] == "Yes")) {
                                                        if(isset($data['cge_att_name'][$key]) && $data['cge_att_name'][$key]) {
                                                            $order_details->att_name = $data['cge_att_name'][$key];
                                                        } else {
                                                            if(isset($data['det_att_name'][$key])) {
                                                                $order_details->att_name = $data['det_att_name'][$key];
                                                            } else {
                                                                $order_details->att_name = NULL;
                                                            }
                                                        }

                                                        if(isset($data['cge_att_value'][$key]) && $data['cge_att_value'][$key]) {
                                                            $order_details->att_value = $data['cge_att_value'][$key];
                                                        } else {
                                                            if(isset($data['det_att_value'][$key])) {
                                                                $order_details->att_value = $data['det_att_value'][$key];
                                                            } else {
                                                                $order_details->att_value = NULL;
                                                            }
                                                        }
                                                    } else {
                                                        if(isset($data['det_att_name'][$key])) {
                                                            $order_details->att_name = $data['det_att_name'][$key];
                                                        } else {
                                                            $order_details->att_name = NULL;
                                                        }

                                                        if(isset($data['det_att_value'][$key])) {
                                                            $order_details->att_value = $data['det_att_value'][$key];
                                                        } else {
                                                            $order_details->att_value = NULL;
                                                        }
                                                    }          

                                                    if(isset($data['det_tax'][$key])) {
                                                        $order_details->tax = $data['det_tax'][$key];
                                                    } else {
                                                        $order_details->tax = NULL;
                                                    }

                                                    if(isset($data['det_tax_type'][$key])) {
                                                        $order_details->tax_type = $data['det_tax_type'][$key];
                                                    } else {
                                                        $order_details->tax_type = NULL;
                                                    }

                                                    if(isset($data['det_unitprice'][$key])) {
                                                        $order_details->unitprice = $data['det_unitprice'][$key];
                                                    } else {
                                                        $order_details->unitprice = NULL;
                                                    }

                                                    // if(isset($data['det_return_tax_amount'][$key])) {
                                                    //     $order_details->tax_amount = $data['det_return_tax_amount'][$key];
                                                    // } else {
                                                    //     $order_details->tax_amount = NULL;
                                                    // }

                                                    if(isset($data['det_totalprice'][$key])) {
                                                        $order_details->totalprice = $data['det_totalprice'][$key];
                                                    } else {
                                                        $order_details->totalprice = NULL;
                                                    }
                                                    
                                                    $order_details->is_block = 1;

                                                    if($order_details->save()) {
                                                        $sus2 = 1;
                                                    }                                
                                                }                            
                                            }

                                            if($data['payment_mode'] == 1) {
                                                $order_trans = new OrdersTransactions();
                                                $t_max = OrdersTransactions::max('trans_code');
                                                $t_max_id = "00001";
                                                $t_max_st = "Trans";
                                                if($t_max) {
                                                    $t_max_no = substr($t_max, 5);
                                                    $t_increment = (int)$t_max_no + 1;
                                                    $data['trans_code'] = $t_max_st.sprintf("%05d", $t_increment);
                                                } else {
                                                    $data['trans_code'] = $t_max_st.$t_max_id;
                                                }

                                                $order_trans->trans_code = $data['trans_code'];
                                                $order_trans->trans_date = date('Y-m-d H:i:s');
                                                $order_trans->order_id = $order->id;
                                                $order_trans->net_amount = $order->net_amount;
                                                $order_trans->amountpaid = "Unpaid";
                                                $order_trans->paymentmode = $data['payment_mode'];
                                                $order_trans->gatewaytransactionid = NULL;
                                                $order_trans->trans_status = "PENDING";
                                                $order_trans->remarks = NULL;
                                                $order_trans->is_block = 1;

                                                if($order_trans->save()) {
                                                    $sus3 = 1;
                                                }
                                            } else if($data['payment_mode'] == 2) {
                                                if($order) {
                                                    $order->order_status = 1;
                                                    $order->payment_status = 0;
                                                    $order->save();
                                                    $sus3 = 1;
                                                }
                                            } 

                                            if($sus2 == 1 && $sus3 == 1) {
                                                if (isset($data['grv_det_id']) && count($data['grv_det_id']) != 0) {
                                                    foreach ($data['grv_det_id'] as $keys => $values) {
                                                        $grv_details = GrvOrdersDetails::Where('id', $values)->first();
                                                        $grv_details->grv_issued = "Yes";
                                                        $grv_details->save();
                                                    }
                                                }

                                                $grv = GrvOrders::Where('id', $data['grv_id'])->first();
                                                if($grv) {
                                                    $grv_dets = GrvOrdersDetails::Where('grv_id', $grv->id)->get();
                                                    if($grv_dets->contains('grv_issued', 'No')){
                                                        $grv->grv_status = 1;
                                                    } else {
                                                        $grv->grv_status = 2;
                                                    }
                                                    $grv->save();
                                                }

                                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                                $admin_email = "info@ecambiar.com";
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
                                                $site_name = "ECambiar";
                                                if($general){
                                                    $site_name = $general->site_name;
                                                } else {
                                                    $site_name = "ECambiar";
                                                }

                                                $net_comis = 0.00;
                                                $net_mer_amt = 0.00;
                                                $customer_name = "";
                                                $contact = "";
                                                $address = "";
                                                $order_code = $order->order_code;
                                                $order_date = date('d-m-Y', strtotime($order->order_date));
                                                $net_tot = $order->net_amount;
                                                // $tax_tot = $order->tax_amount;
                                                $details = "";
                                                $order_detail = OrderDetails::Where('is_block', 1)->Where('order_id', $order->id)->get();
                                                $details="";
                                                if($order_detail) {
                                                    foreach ($order_detail as $key => $value) {
                                                        $stock = Products::Where('id', $value->product_id)->first();

                                                        if($stock && ($stock->onhand_qty != 0)) {
                                                            $stock_trans = new StockTransactions();
                                                            $stock_trans->order_code   = $order_code;
                                                            $stock_trans->product_id   = $value->product_id;
                                                            $stock_trans->att_name     = $value->att_name;
                                                            $stock_trans->att_value    = $value->att_value;
                                                            $stock_trans->previous_qty = $stock->onhand_qty;
                                                            $stock_trans->current_qty  = $stock->onhand_qty - $value->order_qty;
                                                            $stock_trans->date         = date('Y-m-d');
                                                            $stock_trans->remarks      = $value->product_title.' is ordered.';

                                                            $stock->onhand_qty = $stock->onhand_qty - $value->order_qty;
                                                            
                                                            $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                                            if($p_atts) {
                                                                $stock_trans->att_previous_qty = $p_atts->att_qty;
                                                                $stock_trans->att_current_qty  = $p_atts->att_qty - $value->order_qty;
                                                                
                                                                $p_atts->att_qty = $p_atts->att_qty - $value->order_qty;
                                                                $p_atts->save();
                                                            }

                                                            if($stock->save() && $stock_trans->save()) {
                                                                $sck = 1;
                                                            }

                                                        }

                                                        if($stock && $stock->created_user != 1) {
                                                            if($stock->Creatier->user_type == 2 || $stock->Creatier->user_type == 3) {
                                                                $com_per = $stock->Creatier->commission;
                                                                $t_pce = $value->totalprice;
                                                                $admin_com = round($t_pce * ($com_per / 100), 2);
                                                                $mer_amt = round($t_pce - $admin_com, 2);

                                                                $comis = new AdminCommision();
                                                                $comis->order_code   = $order_code;
                                                                $comis->order_dets   = $value->id;
                                                                $comis->product_id   = $value->product_id;
                                                                $comis->att_name     = $value->att_name;
                                                                $comis->att_value    = $value->att_value;
                                                                $comis->merchant_id  = $stock->Creatier->id;
                                                                $comis->amount       = $admin_com;
                                                                $comis->merchant_amount = $mer_amt;
                                                                $comis->paid_status  = 0;
                                                                $comis->remarks      = $value->product_title.' product against Admin Commision is Rs. '.$admin_com.' set.';
                                                                $comis->save();

                                                                $net_comis   = $net_comis + $admin_com;
                                                                $net_mer_amt = $net_mer_amt + $mer_amt;
                                                            }
                                                        }

                                                        $att_tit = "";
                                                        if(isset($value->att_name) && $value->att_name != 0) {
                                                            if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                                                $att_tit = '<span>('.$value->AttName->att_name.' : '.$value->AttValue->att_value.')</span>';
                                                            }
                                                        }

                                                        $details.= '<tr>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;"> '.$value->product_title.' '. $att_tit .'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;"> '.$value->order_qty.'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: center;">Rs.  '.$value->unitprice.'</td>
                                                            <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs.  '.$value->totalprice.'</td>
                                                        </tr>';
                                                    }
                                                }

                                                if($order) {
                                                    $order->net_commision = $net_comis;
                                                    $order->net_merchant_amout = $net_mer_amt;
                                                    $order->save();
                                                }

                                                $ships = ShippingAddress::Where('user_id', $user->id)->Where('is_block', 1)->first();
                                                if(isset($data['shipping_address_flag']) && $data['shipping_address_flag'] == 1) {
                                                    if($ship) {
                                                        $customer_name = $ship->first_name.' '.$ship->last_name;
                                                        $address = $ship->address.','.$ship->City->city_name.','.$ship->pincode.','.$ship->State->state.','.$ship->Country->country_name;
                                                        $contact = $ship->contact_no;
                                                    } else if ($user) {
                                                        $customer_name = $user->first_name.' '.$user->last_name;
                                                        $address = $user->address1.','.$user->address2.','.$user->City->city_name.','.$user->pincode.','.$user->State->state.','.$user->Country->country_name;
                                                        $contact = $user->phone.','.$user->phone2;
                                                    }
                                                } else if ($user) {
                                                    $customer_name = $user->first_name.' '.$user->last_name;
                                                    $address = $user->address1.','.$user->address2.','.$user->City->city_name.','.$user->pincode.','.$user->State->state.','.$user->Country->country_name;
                                                    $contact = $user->phone.','.$user->phone2;
                                                }

                                                $name = $user->full_name;
                                                $email = $user->email;

                                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                                $headers.= "MIME-Version: 1.0\r\n";
                                                // $headers.= "From: $admin_email" . "\r\n";
                                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                                $to = $email;
                                                $to2 = $admin_email;
                                                $subject = "Orders Details";
                                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat;  background-size: 100% 102%;">
                                                    <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                                                    <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                                        <h2 style="color: #ff5c00;margin-top: 0px;">Orders Details</h2>
                                                        <table align="center" style=" text-align: center;">
                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$customer_name.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Contact No</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$contact.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Address</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$address.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Code</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$order_code.'</td>
                                                            </tr>

                                                            <tr>
                                                                <th style="text-align:center;text-transform:uppercase;padding-bottom:12px;color:#333;width:120px;font-size: 12px;font-weight: 900;">Order Date</th>
                                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;"> : '.$order_date.'</td>
                                                            </tr>
                                                        </table>

                                                        <table style="width: 100%;border: 1px solid black;">
                                                            <tr>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Product Title</th>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Quantity</th>
                                                                <th style="width:100px;text-align:center;text-transform:uppercase;padding-bottom: 5px;color:black;border:1px solid black;font-size: 13px;font-weight: 700;">Price</th>
                                                                <th style="width: 100px;text-align: right;text-transform: uppercase;padding-bottom: 5px;color: black;border: 1px solid black;font-size: 13px;font-weight: 700;">Total</th>
                                                            </tr>'.$details.'
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Sub Total</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->total_amount.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Shipping Charge</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->shipping_charge.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">COD Charge</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->cod_charge.'</td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">Net Total</th>
                                                                <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$net_tot.'</td>
                                                            </tr>
                                                        </table>

                                                        <p></p>
                                                        <p>Thank You.</p>
                                                         <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                                        <p>Thanks & Regards,</p>
                                                        <p><a href="'.route('home').'">'.$site_name.'</a></p>
                                                    </div>
                                                </div>';
                                
                                                // if(1==1) {
                                                if(mail($to,$subject,$txt,$headers)){
                                                    mail($to2,$subject,$txt,$headers);
                                                    if($user->phone) {
                                                        $text = "Replacement order successful - Order Reference Code  - ".$order_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Order Confirm Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Order placed & Email Send Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Order Placed & Mail Send Successfully!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                } else {
                                                    if($user->phone) {
                                                        $text = "Thanks for shopping with us.Plz note the Order Code - ".$order_code.", ecambiar.com";
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
                                                            Session::flash('message', 'Order Confirm Message and Email Send Successfully!');
                                                            Session::flash('alert-class', 'alert-success');
                                                        } else {
                                                            Session::flash('message', 'Order placed Successfully!'); 
                                                            Session::flash('alert-class', 'alert-success');
                                                        }
                                                        return redirect()->route('all_orders');
                                                    } else {
                                                        Session::flash('message', 'Order Placed Successfully!'); 
                                                        Session::flash('alert-class', 'alert-success');
                                                    }
                                                    return redirect()->route('all_orders');
                                                }
                                            } else {
                                                Orders::where('id', $order->id)->delete();
                                                Session::flash('message', 'Replace New Orders Placed Failed!'); 
                                                Session::flash('alert-class', 'alert-danger');
                                                return redirect()->route('new_orders');
                                            }
                                        } else {
                                            Session::flash('message', 'Replace New Orders Placed Failed!'); 
                                            Session::flash('alert-class', 'alert-danger');
                                            return redirect()->route('new_orders');
                                        }
                                    } else {
                                        Session::flash('message', 'New Order Created Not Possible!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('new_orders');      
                                    }
                                }
                            } else {
                                Session::flash('message', 'Please Enter All Details!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('new_orders');
                            }
                        } else {
                            Session::flash('message', 'Please Select Return Type!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->back();
                        }
                    } else {
                        Session::flash('message', 'Invalid Customer, Please Check Customer!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->back();
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

    public function GetGRV( Request $request) {   
        $id = 0;
        $error = 0;
        $r_type = 0;
        if($request->ajax() && isset($request->id)){
            $id = $request->id;
            $r_type = $request->r_type;
            if($id != 0) {
                $grv = GrvOrders::where('id',$id)->where('grv_status', 1)->first();
                if($grv) {
                    $re_orders = ReturnOrder::Where('id', $grv->return_order_id)->first();
                    $orders = Orders::Where('id', $grv->order_id)->first();
                    if($re_orders && $orders && ($re_orders->order_id == $orders->id)) {
                        $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                        $re_orders['details'] = ReturnOrderDetails::Where('return_order_id', $re_orders->id)->get();
                        $grv['details'] = GrvOrdersDetails::Where('grv_id', $grv->id)->Where('grv_issued', 'No')->get();
                        $dets = "";
                        $details = "";
                        if(sizeof($grv['details']) != 0) {
                            foreach ($grv['details'] as $key => $value) {
                                if($value->return_type == $r_type) {
                                    $attributes = "";
                                    if(isset($value->att_name) && $value->att_name != 0) {
                                        if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                            $attributes = '<span>('.$value->AttName->att_name.' : '.$value->AttValue->att_value.')</span>';
                                        }
                                    }

                                    $shiping = "";
                                    if ($value->Products->tax_type == 2 ) {
                                        $shiping = '<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="'.($value->product_id ? $value->Products->shiping_charge : 0).'">';
                                    } else {
                                        $shiping ='<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="0">';
                                    }

                                    $a_product = ProductsAttributes::Where('product_id', $value->product_id)->get();
                                    $a_product = $a_product->unique('attribute_name');
                                    $optz = "";
                                    if(sizeof($a_product) != 0) {
                                        foreach ($a_product as $apkey => $apvalue) {
                                            $optz.= '<option value="'.$apvalue->AttributeName->id.'">'.$apvalue->AttributeName->att_name.'</option>';
                                        }
                                    }

                                    $details.='<tr class="gj_tr_det" id="gj_tr_det_'.($key+1).'">
                                        <td>
                                            <input type="hidden" name="grv_det_id[]" class="grv_det_id" value="'.$value->id.'" placeholder="Enter GRV Details ID">

                                            <input type="hidden" name="det_product_id[]" class="det_product_id" value="'.$value->product_id.'" placeholder="Enter Product ID">

                                            <input type="hidden" name="det_att_name[]" class="det_att_name" value="'.$value->att_name.'" placeholder="Enter Attribute Name">

                                            <input type="hidden" name="det_att_value[]" class="det_att_value" value="'.$value->att_value.'" placeholder="Enter Attribute Value">

                                            <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Value">

                                            <input type="hidden" name="det_tax_type[]" class="det_tax_type" value="'.$value->tax_type.'" placeholder="Enter Tax Type">

                                            <input type="hidden" name="det_product_title[]" class="det_product_title" value="'.$value->product_title.'" placeholder="Enter Product Title" readonly>

                                            <span>
                                                '.$value->product_title.'
                                                '.$attributes.'
                                            </span>
                                        </td>

                                        <!-- <td>
                                            <select name="cge_atts[]" class="form-control cge_atts">
                                                <option value="">Change Attributes?</option>
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select> 
                                        </td>

                                        <td>
                                            <select name="cge_att_name[]" class="form-control cge_att_name">
                                                <option value="">Change Attribute Name</option>
                                                '.$optz.'
                                            </select> 
                                        </td>

                                        <td>
                                            <select name="cge_att_value[]" class="form-control cge_att_value">
                                                <option value="">Change Attribute Value</option>
                                            </select> 
                                        </td> -->

                                        <td>
                                            <input type="hidden" name="det_old_order_qty[]" class="det_old_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">

                                            <input type="number" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1" disabled>

                                            <input type="hidden" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">
                                        </td>

                                        <td>
                                            <input type="text" name="det_h_unitprice[]" class="det_h_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price" disabled>

                                            <input type="hidden" name="det_unitprice[]" class="det_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price">
                                        </td>

                                        <!--<td>
                                            <input type="text" name="det_h_tax_amount[]" class="det_h_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount" disabled>

                                            <input type="hidden" name="det_tax_amount[]" class="det_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount">
                                            <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Amount">
                                        </td>-->

                                        <td>
                                            <select name="det_return_type[]" class="form-control det_return_type">
                                                <option value="">Select Return Type</option>
                                                <option '.($value->return_type == 'Exchange' ? "selected" : "").' value="Exchange">Exchange</option>
                                                <option '.($value->return_type == 'Replacement' ? "selected" : "").' value="Replacement">Replacement</option>
                                                <option '.($value->return_type == 'Refund' ? "selected" : "").' value="Refund">Refund</option>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="hidden" name="det_old_return_qty[]" class="det_old_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                            <input type="hidden" name="assign_qty[]" class="assign_qty" value="'.$value->assign_qty.'" placeholder="Enter Quantity">

                                            <input type="number" name="det_return_qty[]" class="det_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                        </td>

                                        <td>
                                            <input type="text" name="det_h_return_amount[]" class="det_h_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price" disabled>

                                            <input type="hidden" name="det_return_amount[]" class="det_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price">
                                        </td>

                                        <!--<td>
                                            <input type="text" name="det_h_return_tax_amount[]" class="det_h_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax" disabled>

                                            <input type="hidden" name="det_return_tax_amount[]" class="det_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax">
                                        </td>-->

                                        <td>
                                            <input type="text" name="det_h_totalprice[]" class="det_h_totalprice" value="'.$value->return_amount.'" placeholder="Enter Total Price" disabled>

                                            <input type="hidden" name="det_totalprice[]" class="det_totalprice" value="'.$value->return_amount.'" placeholder="Enter Total Price">

                                            <input type="hidden" name="tot_service_charge[]" class="gj_det_sc" value="'.($value->product_id ? $value->Products->service_charge : 0).'">

                                            '.$shiping.'
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger gj_del_det" data-del-id="'.$value->id.'"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>';
                                }           
                            }
                        } else {
                            /*$details.='<tr id="gj_tr_det_1">
                                <td>
                                    <p class="gj_nodata">New Order Not Possible</p>
                                </td>
                            </tr>';*/
                            echo $error = 0;die();
                        }

                        $dets = '<div class="gj_odr_det_resp table-responsive">
                            <table class="table table-stripped table-bordered gj_tab_odr_det">
                                <thead>
                                    <tr>
                                        <th>Product Title</th>
                                        <!--<th>Change Attributes</th>-->
                                        <!--<th>Attribute Name</th>-->
                                        <!--<th>Attribute Value</th>-->
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <!--<th>Tax</th>-->
                                        <th>Return Type</th>
                                        <th>Return Qty</th>
                                        <th>Return Amount</th>
                                        <!--<th>Return Tax</th>-->
                                        <th>Total Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="gj_odr_det">
                                    '.$details.'
                                    <tr>
                                        <td colspan="6" class="text-right"> <b> Sub Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_sub_tot">0.00</span> </span> </b> </td>

                                        <input type="hidden" name="det_sub_tot" id="det_sub_tot">
                                        <input type="hidden" name="det_tax_total" id="det_tax_total">
                                        <input type="hidden" name="det_total_items" id="det_total_items">
                                        <input type="hidden" name="det_net_amount" id="det_net_amount">
                                        <input type="hidden" name="cut_off" id="cut_off">
                                        <input type="hidden" name="cod_charge" id="cod_charge">
                                        <input type="hidden" name="det_serv_charge" id="det_serv_charge">
                                        <input type="hidden" name="det_shipping_charge" id="det_shipping_charge">
                                    </tr>

                                    <!-- <tr>
                                        <td colspan="6" class="text-right"> <b> Service Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_sc_tot">'.($orders->shipping_charge ? $orders->shipping_charge : "0.00").'</span> </span> </b> </td>                                           
                                    </tr> -->

                                    <tr>
                                        <td colspan="6" class="text-right"> <b> Tax Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_tax_tot">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right"> <b> Shipping Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_shc_tot">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr class="gj_cod_set">
                                        <td colspan="6" class="text-right"> <b> COD Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_cod">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right"> <b> Grand Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_grand_tot">0.00</span> </span> </b> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';

                        $error ='';
                        $error.='<div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_mode">Payment Mode</label>

                                <div class="gj_py_ro_div">
                                    <span class="gj_py_ro">
                                        <input type="radio" '.($orders->payment_mode == 1 ? "checked" : "").' name="payment_mode" value="1"> Cash On Delivery
                                    </span>

                                    <span class="gj_py_ro">
                                        <input type="radio" '.($orders->payment_mode == 2 ? "checked" : "").' name="payment_mode" value="2"> Online
                                    </span>
                                </div>

                                <input class="form-control gj_order_id" placeholder="Order ID" name="order_id" type="hidden" value="'.$re_orders->order_id.'" id="order_id">

                                <input class="form-control gj_user_id" placeholder="User ID" name="user_id" type="hidden" value="'.$re_orders->user_id.'" id="user_id">
                            </div>

                            <div class="form-group">
                                <label for="delivery_date">Delivery Date</label>

                                <input class="form-control gj_delivery_date" placeholder="Delivery Date" name="delivery_date" type="date" id="delivery_date" autocomplete="new-password" value="'.date("Y-m-d", strtotime($orders->delivery_date)).'">
                            </div>

                            <div class="form-group">
                                <label for="order_status">Order Status</label>

                                <select id="order_status" name="order_status" class="form-control gj_edt_order_status">
                                    <option value="1" selected>Order Placed</option>
                                    <option value="2">Order Dispatched</option>
                                    <option value="3">Order Delivered </option>
                                    <option value="4">Order Complete</option>
                                    <option value="5">Order Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="h_contact_person" type="text" value="'.$orders->contact_person.'" id="h_contact_person" disabled>

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="contact_person" type="hidden" value="'.$orders->contact_person.'" id="contact_person">

                                <input class="form-control gj_contact_email" placeholder="Contact Person" name="contact_email" type="hidden" value="'.$orders->contact_email.'" id="contact_email">
                            </div>

                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="h_contact_no" type="text" value="'.$orders->contact_no.'" id="h_contact_no" disabled>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="contact_no" type="hidden" value="'.$orders->contact_no.'" id="contact_no">
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Shipping Address</label>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="h_shipping_address" type="text" value="'.$orders->shipping_address.'" id="h_shipping_address" disabled>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="shipping_address" type="hidden" value="'.$orders->shipping_address.'" id="shipping_address">

                                <input class="form-control gj_shipping_address_flag" placeholder="Shipping Address" name="shipping_address_flag" type="hidden" value="'.$orders->shipping_address_flag.'" id="shipping_address_flag">

                                <input class="form-control gj_city" placeholder="Shipping Address" name="city" type="hidden" value="'.$orders->city.'" id="city">

                                <input class="form-control gj_pincode" placeholder="Shipping Address" name="pincode" type="hidden" value="'.$orders->pincode.'" id="pincode">
                            </div>

                            <div class="form-group">
                                <label for="total_items">Total Items</label>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="h_total_items" type="text" value="'.$re_orders->total_items.'" id="h_total_items" disabled>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="total_items" type="hidden" value="'.$re_orders->total_items.'" id="total_items">
                            </div>

                            <div class="form-group">
                                <label for="discount_flag">Discount Flag</label>

                                <input class="form-control gj_discount_flag" placeholder="Discount Flag" name="discount_flag" type="number" id="discount_flag" autocomplete="new-password" value="'.$orders->discount_flag.'">
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>

                                <input class="form-control gj_discount" placeholder="Discount" name="discount" type="number" id="discount" autocomplete="new-password" value="'.$orders->discount.'">
                            </div>

                            <div class="form-group">
                                <label for="shipping_charge">Shipping Charge</label>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="h_shipping_charge" type="text" value="'.$orders->shipping_charge.'" id="h_shipping_charge" disabled>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="shipping_charge" type="hidden" value="'.$orders->shipping_charge.'" id="shipping_charge">
                            </div>

                            <!-- <div class="form-group">
                                <label for="tax_amount">Tax Amount</label>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="h_tax_amount" type="text" value="'.$orders->tax_amount.'" id="h_tax_amount" disabled>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="tax_amount" type="hidden" value="'.$orders->tax_amount.'" id="tax_amount">
                            </div>-->

                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="h_net_amount" type="text" value="'.$re_orders->net_amount.'" id="h_net_amount" disabled>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="net_amount" type="hidden" value="'.$re_orders->net_amount.'" id="net_amount">
                            </div>

                            <div class="form-group">
                                <label for="payment_status">Payment Status</label>

                                <select id="payment_status" name="payment_status" class="form-control gj_edt_payment_status">
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Success</option>
                                    <option value="2">Failed </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="delivery_status">Delivery Status</label>

                                <select id="delivery_status" name="delivery_status" class="form-control gj_edt_delivery_status">
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Success</option>
                                    <option value="2">Failed </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>

                                <textarea class="form-control gj_remarks" placeholder="Remarks" rows="5" name="remarks" cols="50" id="remarks">'.$orders->remarks.'</textarea>
                            </div>

                            <p class="error gj_note">Note : In New Order to exchange the product, the admin need to select "Change Attributes" to "YES" & Choose "Attribute Name"(ie Size or Color) and select their corresponding "Attribute Value"</p>

                            '.$dets.'

                            <input class="btn btn-primary" type="submit" value="Update" autocomplete="new-password">
                        </div>';

                    }
                } else {
                    $error = 0;
                }           
            } else {
                $error = 0;
            }

            echo $error;
        }
    }

    public function GetEXGRV( Request $request) {   
        $id = 0;
        $error = 0;
        $r_type = 0;
        if($request->ajax() && isset($request->id)){
            $id = $request->id;
            $r_type = $request->r_type;
            if($id != 0) {
                $grv = GrvOrders::where('id',$id)->where('grv_status', 1)->first();
                if($grv) {
                    $re_orders = ReturnOrder::Where('id', $grv->return_order_id)->first();
                    $orders = Orders::Where('id', $grv->order_id)->first();
                    if($re_orders && $orders && ($re_orders->order_id == $orders->id)) {
                        $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                        $re_orders['details'] = ReturnOrderDetails::Where('return_order_id', $re_orders->id)->get();
                        $grv['details'] = GrvOrdersDetails::Where('grv_id', $grv->id)->Where('grv_issued', 'No')->get();
                        $dets = "";
                        $details = "";
                        if(sizeof($grv['details']) != 0) {
                            foreach ($grv['details'] as $key => $value) {
                                if($value->return_type == $r_type) {
                                    $attributes = "";
                                    if(isset($value->att_name) && $value->att_name != 0) {
                                        if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                            $attributes = '<span>('.$value->AttName->att_name.' : '.$value->AttValue->att_value.')</span>';
                                        }
                                    }

                                    $shiping = "";
                                    if ($value->Products->tax_type == 2 ) {
                                        $shiping = '<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="'.($value->product_id ? $value->Products->shiping_charge : 0).'">';
                                    } else {
                                        $shiping ='<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="0">';
                                    }

                                    $a_product = ProductsAttributes::Where('product_id', $value->product_id)->get();
                                    $a_product = $a_product->unique('attribute_name');
                                    $optz = "";
                                    if(sizeof($a_product) != 0) {
                                        foreach ($a_product as $apkey => $apvalue) {
                                            $optz.= '<option value="'.$apvalue->AttributeName->id.'">'.$apvalue->AttributeName->att_name.'</option>';
                                        }
                                    }

                                    $details.='<tr class="gj_tr_det" id="gj_tr_det_'.($key+1).'">
                                        <td>
                                            <input type="hidden" name="grv_det_id[]" class="grv_det_id" value="'.$value->id.'" placeholder="Enter GRV Details ID">

                                            <input type="hidden" name="det_product_id[]" class="det_product_id" value="'.$value->product_id.'" placeholder="Enter Product ID">

                                            <input type="hidden" name="det_att_name[]" class="det_att_name" value="'.$value->att_name.'" placeholder="Enter Attribute Name">

                                            <input type="hidden" name="det_att_value[]" class="det_att_value" value="'.$value->att_value.'" placeholder="Enter Attribute Value">

                                            <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Value">

                                            <input type="hidden" name="det_tax_type[]" class="det_tax_type" value="'.$value->tax_type.'" placeholder="Enter Tax Type">

                                            <input type="hidden" name="det_product_title[]" class="det_product_title" value="'.$value->product_title.'" placeholder="Enter Product Title" readonly>

                                            <span>
                                                '.$value->product_title.'
                                                '.$attributes.'
                                            </span>
                                        </td>

                                        <td>
                                            <select name="cge_atts[]" class="form-control cge_atts">
                                                <option value="">Change Attributes?</option>
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select> 
                                        </td>

                                        <td>
                                            <select name="cge_att_name[]" class="form-control cge_att_name">
                                                <option value="">Change Attribute Name</option>
                                                '.$optz.'
                                            </select> 
                                        </td>

                                        <td>
                                            <select name="cge_att_value[]" class="form-control cge_att_value">
                                                <option value="">Change Attribute Value</option>
                                            </select> 
                                        </td>

                                        <td>
                                            <input type="hidden" name="det_old_order_qty[]" class="det_old_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">

                                            <input type="number" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1" disabled>

                                            <input type="hidden" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">
                                        </td>

                                        <td>
                                            <input type="text" name="det_h_unitprice[]" class="det_h_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price" disabled>

                                            <input type="hidden" name="det_unitprice[]" class="det_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price">
                                        </td>

                                        <!--<td>
                                            <input type="text" name="det_h_tax_amount[]" class="det_h_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount" disabled>

                                            <input type="hidden" name="det_tax_amount[]" class="det_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount">
                                            <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Amount">
                                        </td>-->

                                        <td>
                                            <select name="det_return_type[]" class="form-control det_return_type">
                                                <option value="">Select Return Type</option>
                                                <option '.($value->return_type == 'Exchange' ? "selected" : "").' value="Exchange">Exchange</option>
                                                <option '.($value->return_type == 'Replacement' ? "selected" : "").' value="Replacement">Replacement</option>
                                                <option '.($value->return_type == 'Refund' ? "selected" : "").' value="Refund">Refund</option>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="hidden" name="det_old_return_qty[]" class="det_old_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                            <input type="hidden" name="assign_qty[]" class="assign_qty" value="'.$value->assign_qty.'" placeholder="Enter Quantity">

                                            <input type="number" name="det_return_qty[]" class="det_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                        </td>

                                        <td>
                                            <input type="text" name="det_h_return_amount[]" class="det_h_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price" disabled>

                                            <input type="hidden" name="det_return_amount[]" class="det_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price">
                                        </td>

                                        <!--<td>
                                            <input type="text" name="det_h_return_tax_amount[]" class="det_h_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax" disabled>

                                            <input type="hidden" name="det_return_tax_amount[]" class="det_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax">
                                        </td>-->

                                        <td>
                                            <input type="text" name="det_h_totalprice[]" class="det_h_totalprice" value="'. $value->return_amount.'" placeholder="Enter Total Price" disabled>

                                            <input type="hidden" name="det_totalprice[]" class="det_totalprice" value="'.$value->return_amount.'" placeholder="Enter Total Price">

                                            <input type="hidden" name="tot_service_charge[]" class="gj_det_sc" value="'.($value->product_id ? $value->Products->service_charge : 0).'">

                                            '.$shiping.'
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger gj_del_det" data-del-id="'.$value->id.'"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>';
                                }           
                            }
                        } else {
                            /*$details.='<tr id="gj_tr_det_1">
                                <td>
                                    <p class="gj_nodata">New Order Not Possible</p>
                                </td>
                            </tr>';*/
                            echo $error = 0;die();
                        }

                        $dets = '<div class="gj_odr_det_resp table-responsive">
                            <table class="table table-stripped table-bordered gj_tab_odr_det">
                                <thead>
                                    <tr>
                                        <th>Product Title</th>
                                        <th>Change Attributes</th>
                                        <th>Attribute Name</th>
                                        <th>Attribute Value</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <!--<th>Tax</th>-->
                                        <th>Return Type</th>
                                        <th>Return Qty</th>
                                        <th>Return Amount</th>
                                        <!--<th>Return Tax</th>-->
                                        <th>Total Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="gj_odr_det">
                                    '.$details.'
                                    <tr>
                                        <td colspan="9" class="text-right"> <b> Sub Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_sub_tot">0.00</span> </span> </b> </td>

                                        <input type="hidden" name="det_sub_tot" id="det_sub_tot">
                                        <input type="hidden" name="det_tax_total" id="det_tax_total">
                                        <input type="hidden" name="det_total_items" id="det_total_items">
                                        <input type="hidden" name="det_net_amount" id="det_net_amount">
                                        <input type="hidden" name="cut_off" id="cut_off">
                                        <input type="hidden" name="cod_charge" id="cod_charge">
                                        <input type="hidden" name="det_serv_charge" id="det_serv_charge">
                                        <input type="hidden" name="det_shipping_charge" id="det_shipping_charge">
                                    </tr>

                                    <!-- <tr>
                                        <td colspan="9" class="text-right"> <b> Service Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_sc_tot">'.($orders->shipping_charge ? $orders->shipping_charge : "0.00").'</span> </span> </b> </td>                                           
                                    </tr> -->

                                    <tr>
                                        <td colspan="9" class="text-right"> <b> Tax Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_tax_tot">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr>
                                        <td colspan="9" class="text-right"> <b> Shipping Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_shc_tot">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr class="gj_cod_set">
                                        <td colspan="9" class="text-right"> <b> COD Charge </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_ch_cod">0.00</span> </span> </b> </td>
                                    </tr>

                                    <tr>
                                        <td colspan="9" class="text-right"> <b> Grand Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_grand_tot">0.00</span> </span> </b> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';

                        $error ='';
                        $error.='<div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_mode">Payment Mode</label>

                                <div class="gj_py_ro_div">
                                    <span class="gj_py_ro">
                                        <input type="radio" '.($orders->payment_mode == 1 ? "checked" : "").' name="payment_mode" value="1"> Cash On Delivery
                                    </span>

                                    <span class="gj_py_ro">
                                        <input type="radio" '.($orders->payment_mode == 2 ? "checked" : "").' name="payment_mode" value="2"> Online
                                    </span>
                                </div>

                                <input class="form-control gj_order_id" placeholder="Order ID" name="order_id" type="hidden" value="'.$re_orders->order_id.'" id="order_id">

                                <input class="form-control gj_user_id" placeholder="User ID" name="user_id" type="hidden" value="'.$re_orders->user_id.'" id="user_id">
                            </div>

                            <div class="form-group">
                                <label for="delivery_date">Delivery Date</label>

                                <input class="form-control gj_delivery_date" placeholder="Delivery Date" name="delivery_date" type="date" id="delivery_date" autocomplete="new-password" value="'.date("Y-m-d", strtotime($orders->delivery_date)).'">
                            </div>

                            <div class="form-group">
                                <label for="order_status">Order Status</label>

                                <select id="order_status" name="order_status" class="form-control gj_edt_order_status">
                                    <option value="1" selected>Order Placed</option>
                                    <option value="2">Order Dispatched</option>
                                    <option value="3">Order Delivered </option>
                                    <option value="4">Order Complete</option>
                                    <option value="5">Order Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="h_contact_person" type="text" value="'.$orders->contact_person.'" id="h_contact_person" disabled>

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="contact_person" type="hidden" value="'.$orders->contact_person.'" id="contact_person">

                                <input class="form-control gj_contact_email" placeholder="Contact Person" name="contact_email" type="hidden" value="'.$orders->contact_email.'" id="contact_email">
                            </div>

                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="h_contact_no" type="text" value="'.$orders->contact_no.'" id="h_contact_no" disabled>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="contact_no" type="hidden" value="'.$orders->contact_no.'" id="contact_no">
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Shipping Address</label>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="h_shipping_address" type="text" value="'.$orders->shipping_address.'" id="h_shipping_address" disabled>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="shipping_address" type="hidden" value="'.$orders->shipping_address.'" id="shipping_address">

                                <input class="form-control gj_shipping_address_flag" placeholder="Shipping Address" name="shipping_address_flag" type="hidden" value="'.$orders->shipping_address_flag.'" id="shipping_address_flag">

                                <input class="form-control gj_city" placeholder="Shipping Address" name="city" type="hidden" value="'.$orders->city.'" id="city">

                                <input class="form-control gj_pincode" placeholder="Shipping Address" name="pincode" type="hidden" value="'.$orders->pincode.'" id="pincode">
                            </div>

                            <div class="form-group">
                                <label for="total_items">Total Items</label>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="h_total_items" type="text" value="'.$re_orders->total_items.'" id="h_total_items" disabled>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="total_items" type="hidden" value="'.$re_orders->total_items.'" id="total_items">
                            </div>

                            <div class="form-group">
                                <label for="discount_flag">Discount Flag</label>

                                <input class="form-control gj_discount_flag" placeholder="Discount Flag" name="discount_flag" type="number" id="discount_flag" autocomplete="new-password" value="'.$orders->discount_flag.'">
                            </div>

                            <div class="form-group">
                                <label for="discount">Discount</label>

                                <input class="form-control gj_discount" placeholder="Discount" name="discount" type="number" id="discount" autocomplete="new-password" value="'.$orders->discount.'">
                            </div>

                            <div class="form-group">
                                <label for="shipping_charge">Shipping Charge</label>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="h_shipping_charge" type="text" value="'.$orders->shipping_charge.'" id="h_shipping_charge" disabled>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="shipping_charge" type="hidden" value="'.$orders->shipping_charge.'" id="shipping_charge">
                            </div>

                            <!-- <div class="form-group">
                                <label for="tax_amount">Tax Amount</label>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="h_tax_amount" type="text" value="'.$orders->tax_amount.'" id="h_tax_amount" disabled>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="tax_amount" type="hidden" value="'.$orders->tax_amount.'" id="tax_amount">
                            </div>-->

                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="h_net_amount" type="text" value="'.$re_orders->net_amount.'" id="h_net_amount" disabled>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="net_amount" type="hidden" value="'.$re_orders->net_amount.'" id="net_amount">
                            </div>

                            <div class="form-group">
                                <label for="payment_status">Payment Status</label>

                                <select id="payment_status" name="payment_status" class="form-control gj_edt_payment_status">
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Success</option>
                                    <option value="2">Failed </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="delivery_status">Delivery Status</label>

                                <select id="delivery_status" name="delivery_status" class="form-control gj_edt_delivery_status">
                                    <option value="0" selected>Pending</option>
                                    <option value="1">Success</option>
                                    <option value="2">Failed </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>

                                <textarea class="form-control gj_remarks" placeholder="Remarks" rows="5" name="remarks" cols="50" id="remarks">'.$orders->remarks.'</textarea>
                            </div>

                            <p class="error gj_note">Note : In New Order to exchange the product, the admin need to select "Change Attributes" to "YES" & Choose "Attribute Name"(ie Size or Color) and select their corresponding "Attribute Value"</p>

                            '.$dets.'

                            <input class="btn btn-primary" type="submit" value="Update" autocomplete="new-password">
                        </div>';

                    }
                } else {
                    $error = 0;
                }           
            } else {
                $error = 0;
            }

            echo $error;
        }
    }

    public function GetCNGRV( Request $request) {   
        $id = 0;
        $error = 0;
        if($request->ajax() && isset($request->id)){
            $id = $request->id;
            if($id != 0) {
                $grv = GrvOrders::where('id',$id)->where('grv_status', 1)->first();
                if($grv) {
                    $re_orders = ReturnOrder::Where('id', $grv->return_order_id)->first();
                    $orders = Orders::Where('id', $grv->order_id)->first();
                    if($re_orders && $orders && ($re_orders->order_id == $orders->id)) {
                        $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                        $re_orders['details'] = ReturnOrderDetails::Where('return_order_id', $re_orders->id)->get();
                        if($request->type == 'get_GRV_cn') {
                            $grv['details'] = GrvOrdersDetails::Where('grv_id', $grv->id)->Where('return_type', 'Refund')->Where('grv_issued', 'No')->get();
                        } else {
                            $grv['details'] = GrvOrdersDetails::Where('grv_id', $grv->id)->Where('return_type', '!=', 'Refund')->Where('grv_issued', 'No')->get();
                        }
                        $dets = "";
                        $details = "";
                        if(sizeof($grv['details']) != 0) {
                            foreach ($grv['details'] as $key => $value) {
                                $attributes = "";
                                if(isset($value->att_name) && $value->att_name != 0) {
                                    if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                        $attributes = '<span>('.$value->AttName->att_name.' : '.$value->AttValue->att_value.')</span>';
                                    }
                                }

                                $shiping = "";
                                if ($value->Products->tax_type == 2 ) {
                                    $shiping = '<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="'.($value->product_id ? $value->Products->shiping_charge : 0).'">';
                                } else {
                                    $shiping ='<input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="0">';
                                }

                                $details.='<tr class="gj_tr_det" id="gj_tr_det_'.($key+1).'">
                                    <td>
                                        <input type="hidden" name="grv_det_id[]" class="grv_det_id" value="'.$value->id.'" placeholder="Enter GRV Details ID">

                                        <input type="hidden" name="det_product_id[]" class="det_product_id" value="'.$value->product_id.'" placeholder="Enter Product ID">

                                        <input type="hidden" name="det_att_name[]" class="det_att_name" value="'.$value->att_name.'" placeholder="Enter Attribute Name">

                                        <input type="hidden" name="det_att_value[]" class="det_att_value" value="'.$value->att_value.'" placeholder="Enter Attribute Value">

                                        <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Value">

                                        <input type="hidden" name="det_tax_type[]" class="det_tax_type" value="'.$value->tax_type.'" placeholder="Enter Tax Type">

                                        <input type="hidden" name="det_product_title[]" class="det_product_title" value="'.$value->product_title.'" placeholder="Enter Product Title" readonly>

                                        <span>
                                            '.$value->product_title.'
                                            '.$attributes.'
                                        </span>
                                    </td>

                                    <td>
                                        <input type="hidden" name="det_old_order_qty[]" class="det_old_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">

                                        <input type="number" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1" disabled>

                                        <input type="hidden" name="det_order_qty[]" class="det_order_qty" value="'.$value->order_qty.'" placeholder="Enter Quantity" min="1">
                                    </td>

                                    <td>
                                        <input type="text" name="det_h_unitprice[]" class="det_h_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price" disabled>

                                        <input type="hidden" name="det_unitprice[]" class="det_unitprice" value="'.$value->unitprice.'" placeholder="Enter Price">
                                    </td>

                                    <!--<td>
                                        <input type="text" name="det_h_tax_amount[]" class="det_h_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount" disabled>

                                        <input type="hidden" name="det_tax_amount[]" class="det_tax_amount" value="'.$value->tax_amount.'" placeholder="Enter Tax Amount">
                                        <input type="hidden" name="det_tax[]" class="det_tax" value="'.$value->tax.'" placeholder="Enter Tax Amount">
                                    </td>-->

                                    <td>
                                        <select name="det_return_type[]" class="form-control det_return_type">
                                            <option value="">Select Return Type</option>
                                            <option '.($value->return_type == 'Exchange' ? "selected" : "").' value="Exchange">Exchange</option>
                                            <option '.($value->return_type == 'Replacement' ? "selected" : "").' value="Replacement">Replacement</option>
                                            <option '.($value->return_type == 'Refund' ? "selected" : "").' value="Refund">Refund</option>
                                        </select>
                                    </td>

                                    <td>
                                        <input type="hidden" name="det_old_return_qty[]" class="det_old_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                        <input type="hidden" name="assign_qty[]" class="assign_qty" value="'.$value->assign_qty.'" placeholder="Enter Quantity">

                                        <input type="number" name="det_return_qty[]" class="det_return_qty" value="'.$value->return_qty.'" placeholder="Enter Quantity" min="1">
                                    </td>

                                    <td>
                                        <input type="text" name="det_h_return_amount[]" class="det_h_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price" disabled>

                                        <input type="hidden" name="det_return_amount[]" class="det_return_amount" value="'.$value->return_amount.'" placeholder="Enter Price">
                                    </td>

                                    <!--<td>
                                        <input type="text" name="det_h_return_tax_amount[]" class="det_h_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax" disabled>

                                        <input type="hidden" name="det_return_tax_amount[]" class="det_return_tax_amount" value="'.$value->return_tax_amount.'" placeholder="Enter Tax">
                                    </td>-->

                                    <td>
                                        <input type="text" name="det_h_totalprice[]" class="det_h_totalprice" value="'.$value->return_amount.'" placeholder="Enter Total Price" disabled>

                                        <input type="hidden" name="det_totalprice[]" class="det_totalprice" value="'.$value->return_amount.'" placeholder="Enter Total Price">

                                        <input type="hidden" name="tot_service_charge[]" class="gj_det_sc" value="'.($value->product_id ? $value->Products->service_charge : 0).'">

                                        '.$shiping.'
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger gj_del_det" data-del-id="'.$value->id.'"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>';             
                            }
                        } else {
                            /*$details.='<tr id="gj_tr_det_1">
                                <td>
                                    <p class="gj_nodata">New Order Not Possible</p>
                                </td>
                            </tr>';*/
                            echo $error = 0;die();
                        }

                        $dets = '<div class="gj_odr_det_resp table-responsive">
                            <table class="table table-stripped table-bordered gj_tab_odr_det">
                                <thead>
                                    <tr>
                                        <th>Product Title</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <!--<th>Tax</th>-->
                                        <th>Return Type</th>
                                        <th>Return Qty</th>
                                        <th>Return Amount</th>
                                        <!--<th>Return Tax</th>-->
                                        <th>Total Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="gj_odr_det">
                                    '.$details.'
                                    <tr>
                                        <td colspan="6" class="text-right"> <b> Sub Total </b> </td>
                                        <td colspan="2" class="text-center">  <b> <span class="money"> ₹ <span class="gj_det_sub_tot">0.00</span> </span> </b> </td>

                                        <input type="hidden" name="det_sub_tot" id="det_sub_tot">
                                        <input type="hidden" name="det_tax_total" id="det_tax_total">
                                        <input type="hidden" name="det_total_items" id="det_total_items">
                                        <input type="hidden" name="det_net_amount" id="det_net_amount">
                                        <input type="hidden" name="cut_off" id="cut_off">
                                        <input type="hidden" name="cod_charge" id="cod_charge">
                                        <input type="hidden" name="det_serv_charge" id="det_serv_charge">
                                        <input type="hidden" name="det_shipping_charge" id="det_shipping_charge">
                                    </tr>
                                </tbody>
                            </table>
                        </div>';

                        $error ='';
                        $error.='<div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_person">Contact Person</label>
                                <input class="form-control gj_order_id" placeholder="Order ID" name="order_id" type="hidden" value="'.$re_orders->order_id.'" id="order_id">

                                <input class="form-control gj_user_id" placeholder="User ID" name="user_id" type="hidden" value="'.$re_orders->user_id.'" id="user_id">

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="h_contact_person" type="text" value="'.$orders->contact_person.'" id="h_contact_person" disabled>

                                <input class="form-control gj_contact_person" placeholder="Contact Person" name="contact_person" type="hidden" value="'.$orders->contact_person.'" id="contact_person">

                                <input class="form-control gj_contact_email" placeholder="Contact Person" name="contact_email" type="hidden" value="'.$orders->contact_email.'" id="contact_email">
                            </div>

                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="h_contact_no" type="text" value="'.$orders->contact_no.'" id="h_contact_no" disabled>

                                <input class="form-control gj_contact_no" placeholder="Contact Number" name="contact_no" type="hidden" value="'.$orders->contact_no.'" id="contact_no">
                            </div>

                            <div class="form-group">
                                <label for="shipping_address">Shipping Address</label>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="h_shipping_address" type="text" value="'.$orders->shipping_address.'" id="h_shipping_address" disabled>

                                <input class="form-control gj_shipping_address" placeholder="Shipping Address" name="shipping_address" type="hidden" value="'.$orders->shipping_address.'" id="shipping_address">

                                <input class="form-control gj_shipping_address_flag" placeholder="Shipping Address" name="shipping_address_flag" type="hidden" value="'.$orders->shipping_address_flag.'" id="shipping_address_flag">

                                <input class="form-control gj_city" placeholder="Shipping Address" name="city" type="hidden" value="'.$orders->city.'" id="city">

                                <input class="form-control gj_pincode" placeholder="Shipping Address" name="pincode" type="hidden" value="'.$orders->pincode.'" id="pincode">
                            </div>

                            <div class="form-group">
                                <label for="total_items">Total Items</label>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="h_total_items" type="text" value="'.$re_orders->total_items.'" id="h_total_items" disabled>

                                <input class="form-control gj_total_items" placeholder="Total Items" name="total_items" type="hidden" value="'.$re_orders->total_items.'" id="total_items">
                            </div>

                            <div class="form-group">
                                <label for="shipping_charge">Shipping Charge</label>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="h_shipping_charge" type="text" value="'.$orders->shipping_charge.'" id="h_shipping_charge" disabled>

                                <input class="form-control gj_shipping_charge" placeholder="Shipping Charge" name="shipping_charge" type="hidden" value="'.$orders->shipping_charge.'" id="shipping_charge">
                            </div>

                            <!-- <div class="form-group">
                                <label for="tax_amount">Tax Amount</label>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="h_tax_amount" type="text" value="'.$orders->tax_amount.'" id="h_tax_amount" disabled>

                                <input class="form-control gj_tax_amount" placeholder="Tax Amount" name="tax_amount" type="hidden" value="'.$orders->tax_amount.'" id="tax_amount">
                            </div>-->

                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="h_net_amount" type="text" value="'.$re_orders->net_amount.'" id="h_net_amount" disabled>

                                <input class="form-control gj_net_amount" placeholder="Net Amount" name="net_amount" type="hidden" value="'.$re_orders->net_amount.'" id="net_amount">
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks</label>

                                <textarea class="form-control gj_remarks" placeholder="Remarks" rows="5" name="remarks" cols="50" id="remarks"></textarea>
                            </div>

                            '.$dets.'

                            <input class="btn btn-primary" type="submit" value="Update" autocomplete="new-password">
                        </div>';

                    }
                } else {
                    $error = 0;
                }           
            } else {
                $error = 0;
            }

            echo $error;
        }
    }

    public function edit ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $orders = Orders::withTrashed()->where('id',$id)->first();
                if($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                }
                return View::make("transaction.orders.edit_orders")->with(array('orders'=>$orders, 'page'=>$page));
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
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Transaction";
                $id = $request->get('orders_id');
                $data = $request->all();
            	$orders = '';
                if($id != '') {
                	$orders = Orders::where('id',$id)->first();
                	if($orders) {
        				$orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
        				$orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
        				$orders['products'] = Products::Where('is_block', 1)->get();
        			}
                }

                if($orders) {
        			$rules = array(
        	            'payment_mode'           => 'nullable',
        	            'delivery_date'          => 'nullable',
        	            'order_status'           => 'required',
        	            'total_items'            => 'nullable',
        	           // 'discount_flag'          => 'nullable',
        	           // 'discount'               => 'nullable',
        	            'shipping_charge'        => 'nullable',
        	            'net_amount'             => 'nullable',
        	            'payment_status'         => 'nullable',
        	            'delivery_status'        => 'nullable',
        	            'remarks'                => 'nullable',
        	            'is_block'               => 'nullable',

        	            'det_order_id'           => 'nullable',
        	            'det_product_id'         => 'nullable',
        	            'det_product_title'      => 'required',
        	            'det_order_qty'          => 'required',
                        'det_att_name'           => 'required',
                        'det_att_value'          => 'required',
                        'det_tax'                => 'required',
                        'det_tax_type'           => 'required',
        	            'det_unitprice'          => 'nullable',
        	            'det_totalprice'         => 'nullable',
        	            'det_shipping_charge'    => 'nullable',
        	            'det_total_items'        => 'nullable',
        	            'det_net_amount'         => 'nullable',
        	            'tracking_id'  =>'nullable',
        	        );

        	        $messages=[
                        'det_product_title.required'=>'The Products Title field is required.',
                        'det_order_qty.required'=>'The Quantity field is required.',
                    ];
                    $validator = Validator::make($request->all(), $rules,$messages);

        	        if ($validator->fails()) {
        	    	   	return Redirect::to('/edit_orders/' . $id)->withErrors($validator)->with(array('orders'=>$orders, 'page'=>$page))->withInput();
        	        } else {
        	        	$sus2 = 0;
        	        	$sus3 = 0;

                        $orders = Orders::Where('id', $orders->id)->first();
        	            $orders->payment_mode     = $data['payment_mode'] ?? '';	            
        	            $orders->delivery_date    = $data['delivery_date'];	            
        	            $orders->order_status     = $data['order_status'];	 
        	            $orders->tracking_id   =$data['tracking_id'];
                        // $orders->discount_flag    = $data['discount_flag'];             
                        // $orders->discount         = $data['discount'];              
        	            $orders->total_items      = $data['det_total_items'];
                        // $orders->tax_amount       = $data['tax_total'];
                        $orders->total_amount     = $data['det_sub_tot'];
                        $orders->service_charge    = $data['det_serv_charge'];
                        $orders->shipping_charge  = $data['det_shipping_charge'];               
        	            $orders->net_amount       = $data['det_net_amount'];	            
        	            $orders->payment_status   = $data['payment_status'];	            
        	            $orders->delivery_status  = $data['delivery_status'];	            
        	            $orders->remarks          = $data['remarks'] ?? '';	            
        	            $orders->is_block         = 1;
                        
                        if($orders->save()) {
        	            	if (isset($data['order_det_id']) && count($data['order_det_id']) != 0) {
                                foreach ($data['order_det_id'] as $key => $value) {
            		                $order_details = OrderDetails::Where('id', $value)->first();
                                    if($order_details) {
                                        $order_details->order_id = $orders->id;
                                        
                                        if(isset($data['det_product_id'][$key])) {
                                            $order_details->product_id = $data['det_product_id'][$key];
                                        } else {
                                            $order_details->product_id = NULL;
                                        }

                                        if(isset($data['det_product_title'][$key])) {
                                            $order_details->product_title = $data['det_product_title'][$key];
                                        } else {
                                            $order_details->product_title = NULL;
                                        }

                                        if(isset($data['det_att_name'][$key])) {
                                            $order_details->att_name = $data['det_att_name'][$key];
                                        } else {
                                            $order_details->att_name = NULL;
                                        }

                                        if(isset($data['det_att_value'][$key])) {
                                            $order_details->att_value = $data['det_att_value'][$key];
                                        } else {
                                            $order_details->att_value = NULL;
                                        }

                                        if(isset($data['det_tax'][$key])) {
                                            $order_details->tax = $data['det_tax'][$key];
                                        } else {
                                            $order_details->tax = NULL;
                                        }

                                        if(isset($data['det_tax_type'][$key])) {
                                            $order_details->tax_type = $data['det_tax_type'][$key];
                                        } else {
                                            $order_details->tax_type = NULL;
                                        }
                                        
                                        if(isset($data['det_order_qty'][$key])) {
                                            $order_details->order_qty = $data['det_order_qty'][$key];
                                        } else {
                                            $order_details->order_qty = NULL;
                                        }

                                        if(isset($data['det_unitprice'][$key])) {
                                            $order_details->unitprice = $data['det_unitprice'][$key];
                                        } else {
                                            $order_details->unitprice = 0.00;
                                        }

                                        // if(isset($data['det_tax_amount[]'][$key])) {
                                        //     $order_details->tax_amount = $data['det_tax_amount[]'][$key];
                                        // } else {
                                        //     $order_details->tax_amount = 0.00;
                                        // }

                                        if(isset($data['det_totalprice'][$key])) {
                                            $order_details->totalprice = $data['det_totalprice'][$key];
                                        } else {
                                            $order_details->totalprice = 0.00;
                                        }
                                        
                                        $order_details->is_block = 1;

                                        if($order_details->save()) {
                                            $sus2 = 1;
                                        }    
                                    }
                                }                            
                            }

                            if (isset($data['payment_mode']) && in_array($data['payment_mode'], [1, 2, 3])) {
                            	$order_trans = OrdersTransactions::Where('order_id', $orders->id)->first();
                            	if($order_trans) {
                        			$order_trans->order_id = $orders->id;
        	                        $order_trans->net_amount = $orders->net_amount;
        	                        $order_trans->amountpaid = NULL;
        	                        $order_trans->paymentmode = $data['payment_mode'];
        	                        $order_trans->gatewaytransactionid = NULL;
        	                        $order_trans->trans_status = "Pending";
        	                        $order_trans->remarks = NULL;
        	                        $order_trans->is_block = 1;

        	                        if($order_trans->save()) {
        	                            $sus3 = 1;
        	                        }
                            	} else {
        	                        $order_trans = new OrdersTransactions();
        	                        $t_max = OrdersTransactions::max('trans_code');
        	                        $t_max_id = "00001";
        	                        $t_max_st = "Trans";
        	                        if($t_max) {
        	                            $t_max_no = substr($t_max, 5);
        	                            $t_increment = (int)$t_max_no + 1;
        	                            $data['trans_code'] = $t_max_st.sprintf("%05d", $t_increment);
        	                        } else {
        	                            $data['trans_code'] = $t_max_st.$t_max_id;
        	                        }

        	                        $order_trans->trans_code = $data['trans_code'];
        	                        $order_trans->trans_date = date('Y-m-d');
        	                        $order_trans->order_id = $orders->id;
        	                        $order_trans->net_amount = $orders->net_amount;
        	                        $order_trans->amountpaid = NULL;
        	                        $order_trans->paymentmode = $data['payment_mode'];
        	                        $order_trans->gatewaytransactionid = NULL;
        	                        $order_trans->trans_status = "Pending";
        	                        $order_trans->remarks = NULL;
        	                        $order_trans->is_block = 1;

        	                        if($order_trans->save()) {
        	                            $sus3 = 1;
        	                        }
                                }
                            }

                            if($sus2 == 1 || $sus3 == 1) {
                                $net_comis = 0.00;
                                $net_mer_amt = 0.00;
                                $customer_name = "";
                                $contact = "";
                                $address = "";
                                $order_code = $orders->order_code;
                                $order_date = date('d-m-Y', strtotime($orders->order_date));
                                $net_tot = $orders->net_amount;
                                $details = "";
                                $order_detail = OrderDetails::Where('is_block', 1)->Where('order_id', $orders->id)->get();
                                if($order_detail) {
                                    foreach ($order_detail as $key => $value) {
                                        $stock = Products::Where('id', $value->product_id)->first();

                                        if(isset($data['det_old_order_qty'][$key])) {
                                            $det_old_order_qty = $data['det_old_order_qty'][$key];
                                        } else {
                                            $det_old_order_qty = 0;
                                        }

                                        if($stock && ($stock->onhand_qty != 0)) {
                                            $stock_trans = new StockTransactions();
                                            $stock_trans->order_code   = $order_code;
                                            $stock_trans->product_id   = $value->product_id;
                                            $stock_trans->att_name     = $value->att_name;
                                            $stock_trans->att_value    = $value->att_value;
                                            $stock_trans->previous_qty = $stock->onhand_qty - $det_old_order_qty;
                                            $stock_trans->current_qty  = ($stock->onhand_qty - $det_old_order_qty) + $value->order_qty;
                                            $stock_trans->date         = date('Y-m-d');
                                            $stock_trans->remarks      = $value->product_title.' is reordered.';

                                            $stock->onhand_qty = ($stock->onhand_qty - $det_old_order_qty) + $value->order_qty;
                                            
                                            $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                            if($p_atts) {
                                                $stock_trans->att_previous_qty = $p_atts->att_qty - $det_old_order_qty;
                                                $stock_trans->att_current_qty  = ($p_atts->att_qty - $det_old_order_qty) + $value->order_qty;
                                                
                                                $p_atts->att_qty = ($p_atts->att_qty - $det_old_order_qty) + $value->order_qty;
                                                $p_atts->save();
                                            }

                                            if($stock->save() && $stock_trans->save()) {
                                                $sck = 1;
                                            }

                                        }

                                        if($stock && $stock->created_user != 1) {
                                            if($stock->Creatier->user_type == 2 || $stock->Creatier->user_type == 3) {
                                                $com_per = $stock->Creatier->commission;
                                                $t_pce = $value->totalprice;
                                                $admin_com = round($t_pce * ($com_per / 100), 2);
                                                $mer_amt = round($t_pce - $admin_com, 2);

                                                AdminCommision::Where('order_dets', $value->id)->delete();
                                                $comis = new AdminCommision();
                                                if($comis) {
                                                    $comis->order_code   = $order_code;
                                                    $comis->order_dets   = $value->id;
                                                    $comis->product_id   = $value->product_id;
                                                    $comis->att_name     = $value->att_name;
                                                    $comis->att_value    = $value->att_value;
                                                    $comis->merchant_id  = $stock->Creatier->id;
                                                    $comis->amount       = $admin_com;
                                                    $comis->merchant_amount = $mer_amt;
                                                    $comis->paid_status  = 0;
                                                    $comis->remarks      = $value->product_title.' product against Admin Commision is Rs. '.$admin_com.' set.';
                                                    $comis->save();
                                                }

                                                $net_comis   = $net_comis + $admin_com;
                                                $net_mer_amt = $net_mer_amt + $mer_amt;
                                            }
                                        }
                                    }
                                }

                                $order = Orders::Where('id', $orders->id)->first();
                                if($order) {
                                    $order->net_commision = $net_comis;
                                    $order->net_merchant_amout = $net_mer_amt;
                                    $order->save();
                                }        
                
                                Session::flash('message', 'Order Update Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                return redirect()->route('all_orders');
                            } else {
                                Session::flash('message', 'Order Update Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('all_orders');
                            }
                        } else {
                            Session::flash('message', 'Update Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('all_orders');
                        } 
        	        }
                } else{
                	Session::flash('message', 'Update Failed!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('all_orders');
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

    public function EditDelivery ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Delivery')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $orders = Orders::where('id',$id)->first();
                if($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                }
                return View::make("transaction.orders.delivery_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

    public function UpdateDelivery (Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Delivery')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $id = $request->get('orders_id');
                $orders = '';
                if($id != '') {
                    $orders = Orders::where('id',$id)->first();
                    $u_orders = Orders::where('id',$id)->first();
                    if($orders && $u_orders) {
                        $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                        $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                        $orders['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                if($orders && $u_orders) {
                    $rules = array(
                        'delivery_date'          => 'required',
                        'delivery_status'        => 'required',
                        'order_status'           => 'required',
                        'remarks'                => 'nullable',
                        'is_block'               => 'nullable',
                    );

                    $messages=[
                        'det_product_title.required'=>'The Products Title field is required.',
                        'det_order_qty.required'=>'The Quantity field is required.',
                    ];
                    $validator = Validator::make($request->all(), $rules,$messages);

                    if ($validator->fails()) {
                        return Redirect::to('/delivery_orders/' . $id)->withErrors($validator)->with(array('orders'=>$orders, 'page'=>$page));
                    } else {
                        $data = $request->all();
                        $u_orders->delivery_date    = $data['delivery_date'];             
                        $u_orders->delivery_status  = $data['delivery_status'];               
                        $u_orders->order_status     = $data['order_status'];              
                        $u_orders->remarks          = $data['remarks'];               
                        $u_orders->is_block         = 1;

                        if($u_orders->save()) {
                            Session::flash('message', 'Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('all_orders');
                        } else {
                            Session::flash('message', 'Update Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('all_orders');
                        } 
                    }
                } else{
                    Session::flash('message', 'Update Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('all_orders');
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
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.view', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
        		$orders = Orders::withTrashed()->where('id',$id)->first();
        		if($orders) {
        			$orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
        		}
        		return View::make("transaction.orders.view_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

public function viewCustomise($id){
     $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.view', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
        		$orders = CustomiseProduct::where('id',$id)->first();
        		return View::make("transaction.orders.view_customise_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

 public function editCustomise ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $orders = CustomiseProduct::where('id',$id)->first();
                
                return View::make("transaction.orders.edit_customise_orders")->with(array('orders'=>$orders, 'page'=>$page));
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

public function updateCustomise (Request $request) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Transaction";
                $id = $request->get('orders_id');
                $data =$request->all();
            	$orders = '';
                if($id != '') {
                	$orders = CustomiseProduct::where('id',$id)->first();
                
                }

                if($orders) {
        			$rules = array(
        	            'payment_mode'           => 'required',
        	           // 'delivery_date'          => 'nullable',
        	            'order_status'           => 'required',
        	            'box_quantity'            => 'nullable',
        	           // 'discount_flag'          => 'nullable',
        	           // 'discount'               => 'nullable',
        	           // 'shipping_charge'        => 'nullable',
        	           // 'net_amount'             => 'nullable',
        	            'payment_status'         => 'nullable',
        	           // 'delivery_status'        => 'nullable',
        	           // 'remarks'                => 'required',
        	           // 'is_block'               => 'nullable',
  
        	        );
                    $validator = Validator::make($request->all(), $rules);

        	        if ($validator->fails()) {
        	    	   	return Redirect::to('/edit_customise_orders/' . $id)->withErrors($validator)->with(array('orders'=>$orders, 'page'=>$page));
        	        } else {
        	        	$sus2 = 0;
        	        	$sus3 = 0;

                        $orders = CustomiseProduct::Where('id', $orders->id)->first();
        	            $orders->payment_mode     = $data['payment_mode'];	            
        	           // $orders->delivery_date    = $data['delivery_date'];	            
        	            $orders->order_status     = $data['order_status'];	            
                        // $orders->discount_flag    = $data['discount_flag'];             
                        // $orders->discount         = $data['discount'];              
        	            $orders->box_quantity      = $data['box_quantity'];
                        // $orders->tax_amount       = $data['tax_total'];
                    //     $orders->total_amount     = $data['det_sub_tot'];
                    //     $orders->service_charge    = $data['det_serv_charge'];
                    //     $orders->shipping_charge  = $data['det_shipping_charge'];               
        	           // $orders->net_amount       = $data['det_net_amount'];	            
        	            $orders->payment_status   = $data['payment_status'];	            
        	           // $orders->delivery_status  = $data['delivery_status'];	            
        	           // $orders->remarks          = $data['remarks'];	            
        	           // $orders->is_block         = 1;
                        
                        if($orders->save()) {
                             Session::flash('message', 'Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('custom_orders');
                        } else {
                            Session::flash('message', 'Update Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('custom_orders');
                        } 
        	        }
                } else{
                	Session::flash('message', 'Update Failed!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('custom_orders');
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
	
	 public function PaymentStatusOrdersCustomise( Request $request) { 
        $id = 0;
        $status = 0;
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id) && isset($request->status)){
                    $id = $request->id;
                    $status = $request->status;
                    if($id != 0) {
                        $orders = CustomiseProduct::where('id',$id)->first();
                        
                        if($orders) {
                            $orders->payment_status = $status;
                            if($orders->save()) {
                                $payment_status_text = '';
                                if ($orders->payment_status == 0) {
                                    $payment_status_text = 'Pending';
                                } elseif ($orders->payment_status == 1) {
                                    $payment_status_text = 'Success';
                                } elseif ($orders->payment_status == 2) {
                                    $payment_status_text = 'Failed';
                                } else {
                                    $payment_status_text = '------';
                                }
                                  $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@folkgems.com";
                                if($adm) {
                                    $admin_email = $adm->email;
                                }
                                $general = \DB::table('general_settings')->first();
                                $site_name = "Folkgems";
                                    if($general){
                                        $site_name = $general->site_name;
                                    } else {
                                        $site_name = "Folkgems";
                                    }
                                $logos = \DB::table('logo_settings')->latest()->first();
                                    $logo_path = 'images/logo';
                                    $logo = "";
                                    if($logos) {
                                        $logo = asset($logo_path.'/'.$logos->logo_image);
                                    } else {
                                        $logo = asset('images/logo.png');
                                    }
                                $name = $orders->name;
                                $email = $orders->email;
                                $contact =  $orders->phone_number;
                                $order_date =$orders->created_at;
                              $details= '<tr>
                                    <td style="font-size: 11px;font-weight: 600;color:black;border:1px solid black;text-align:center;"> '.$orders->product_name.'td>
                                    <td style="font-size: 11px;font-weight: 600;color:black;border:1px solid black;text-align:center;"> '.$orders->box_quantity.'</td>
                                </tr>';
            
                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to = $email;
                                $to2 = $admin_email;
                                $subject = "Orders Details";
                               $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat;  background-size: 100% 102%;">
                                    <div style="margin: 10px 20px; padding: 20px; border-bottom: 1px solid #ff5c00;">
                                       <a href="'.route('home').'"> <img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                    </div>
                                    <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                        <h2 style="color: #ff5c00;margin-top: 0px;">Order Payment Status Updated</h2>
                                        <table align="center" style=" text-align: center;width: 100%;">
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$name.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order_date.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Status</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : <strong>'.$payment_status_text.'</strong></td>
                                            </tr>
                                        </table>
                        
                                        <p style="font-size: 14px; color: #333;">Your order payment status has been updated to <strong>'.$payment_status_text.'</strong>. If you have any questions, please contact us.</p>
                                        <p style="font-size:13px;font-weight:600;">Thank You.</p>
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                        <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                        <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                    </div>
                                </div>';
                               $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                            if($mail){
                                Session::flash('message', 'Status Changed Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            }
                            } else {
                                Session::flash('message', 'Status Changed Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Status Changed Failed'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }           
                    } else {
                        Session::flash('message', 'Status Changed Failed, Invalid ID!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                // $error = 1;
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            // $error = 1;
            $error = 1;
        }

        echo $error;
    }
    
    	public function StatusCustomiseOrders( Request $request) {	
		$id = 0;
		$status = 0;
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id) && isset($request->status)){
        			$id = $request->id;
        			$status = $request->status;
        			if($id != 0) {
        				$orders = CustomiseProduct::where('id',$id)->first();
        				if($orders) {
                            if($status == 5) {
                                $orders->cancel_date = date('Y-m-d');
                            }
                            $orders->order_status = $status;

        					if($orders->save()) {
                                    $payment_status_text = '';
                                    if ($orders->order_status == 0) {
                                        $payment_status_text = '-------';
                                    } elseif ($orders->order_status == 1) {
                                        $payment_status_text = 'Order Placed';
                                    } elseif ($orders->order_status == 2) {
                                        $payment_status_text = 'Order Dispatched';
                                    } elseif ($orders->order_status == 3) {
                                        $payment_status_text = 'Order Delivered';
                                    } elseif ($orders->order_status == 4) {
                                        $payment_status_text = 'Order Complete';
                                    } elseif ($orders->order_status == 5) {
                                        $payment_status_text = 'Order Cancelled';
                                    } else {
                                        $payment_status_text = '------';
                                    }
                                      $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                    $admin_email = "info@folkgems.com";
                                    if($adm) {
                                        $admin_email = $adm->email;
                                    }
                                    $general = \DB::table('general_settings')->first();
                                    $site_name = "Folkgems";
                                        if($general){
                                            $site_name = $general->site_name;
                                        } else {
                                            $site_name = "Folkgems";
                                        }
                                    $logos = \DB::table('logo_settings')->latest()->first();
                                        $logo_path = 'images/logo';
                                        $logo = "";
                                        if($logos) {
                                            $logo = asset($logo_path.'/'.$logos->logo_image);
                                        } else {
                                            $logo = asset('images/logo.png');
                                        }
                                    $name = $orders->name;
                                    $email = $orders->email;
                                    $contact =  $orders->phone_number;
                                    $order_date =$orders->created_at;
                                  $details= '<tr>
                                        <td style="font-size: 11px;font-weight: 600;color:black;border:1px solid black;text-align:center;"> '.$orders->product_name.'td>
                                        <td style="font-size: 11px;font-weight: 600;color:black;border:1px solid black;text-align:center;"> '.$orders->box_quantity.'</td>
                                    </tr>';
                
                                    $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                    $headers.= "MIME-Version: 1.0\r\n";
                                    // $headers.= "From: $admin_email" . "\r\n";
                                    $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                    $to = $email;
                                    $to2 = $admin_email;
                                    $subject = "Orders Details";
                                   $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                                            <a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                        </div>
                                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                            <h2 style="color: #B73182;margin-top: 0px;">Order Payment Status Updated</h2>
                                            <table align="center" style=" text-align: center;width: 100%;">
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$name.'</td>
                                                </tr>
                            
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : '.$order_date.'</td>
                                                </tr>
                            
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Status</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : <strong>'.$payment_status_text.'</strong></td>
                                                </tr>
                                            </table>
                            
                                            <p style="font-size: 14px; color: #333;">Your order status has been updated to <strong>'.$payment_status_text.'</strong>. If you have any questions, please contact us.</p>
                                            <p style="font-size:13px;font-weight:600;">Thank You.</p>
                                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                            <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                            <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                        </div>
                                    </div>';
                                  $mail=  mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                                if($mail){
                                
        						Session::flash('message', 'Status Changed Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					} else {
        						Session::flash('message', 'Status Changed Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
        					Session::flash('message', 'Status Changed Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        					$error = 1;
        				}			
        			} else {
        				Session::flash('message', 'Status Changed Failed!'); 
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

	public function deleteCustomise( Request $request) {	
		$id = 0;
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$orders = CustomiseProduct::where('id',$id)->first();
        				if($orders){
        					if($orders->delete()) {
        						Session::flash('message', 'Deleted Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
        					} else {
        						Session::flash('message', 'Deleted Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
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

public function deleteCustomiseAll( Request $request) {	
		$ids = array();
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$orders = CustomiseProduct::where('id',$value)->first();
        					if($orders){
        						if($orders->delete()) {
        							Session::flash('message', 'Deleted Successfully!'); 
        							Session::flash('alert-class', 'alert-success');
        							$error = 0;
        						} else {
        							Session::flash('message', 'Deleted Failed!'); 
        							Session::flash('alert-class', 'alert-danger');

        						}
        					}	else {
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
                // $error = 1;
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            // $error = 1;
            $error = 1;
        }

		echo $error;
	}
	
	 public function addOrderProfit(Request $request)
    {
        $order = CustomiseProduct::find($request->order_id);
    
        if ($order) {
            $order->custom_order_profit = $request->custom_order_profit;
            $order->save();
    
            Session::flash('message', 'Custom Order Profit added successfully'); 
            Session::flash('alert-class', 'alert-success');
            
            return response()->json(0); // success
        }
    
        Session::flash('message', 'Failed to add Custom Order Profit'); 
        Session::flash('alert-class', 'alert-danger');
    
        return response()->json(1); // failure
    }


	public function CheckTax( Request $request) {	
		$id = 0;
		$price = 0;
		$error = 0;
		if($request->ajax() && isset($request->id) && isset($request->price) && isset($request->qty)){
			$id = $request->id;
			$price = $request->price;
            $qty = $request->qty;
			if($id != 0 && $price != 0 && $qty != 0) {
				$products = Products::where('id',$id)->first();
				if($products) {
					$tax = $products->tax;
					$tax_type = $products->tax_type;

                    $price = round(($price + (($price * $tax)/100)),2);

					/*if($tax_type == 2) {
			          $calc_tax = (($price * $tax)/100);
			          $price = $price + $calc_tax;
			        }*/
			        $error = $price;
				}	else {
					$error = 0;
				}			
			} else {
				$error = 0;
			}

			echo $error;
		}
	}

	public function DeleteOrderDetails( Request $request) {	
		$id = 0;
		$error = 0;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				if(OrderDetails::where('id',$id)->delete()) {
        					$error = 1;
        				}	else {
        					$error = 0;
        				}			
        			} else {
        				$error = 0;
        			}
        		}
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                $error = 0;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $error = 0;
        }

		echo $error;
	}

	public function SearchProducts( Request $request) {	
		$id = 0;
		$result = array();
		$table = "";
		if($request->ajax() && isset($request->id)){
			$id = $request->id;
			$error = 1;
			$product_path = 'images/featured_products';
			$noimage = NoimageSettings::first();
			$noimage_path = 'images/noimage';

			if($id != 0) {
				$products = Products::where('id',$id)->first();
				if($products) {
					if($products->featured_product_img){
						$image = '<img src="'.asset($product_path.'/'.$products->featured_product_img).'" alt="'.$products->product_title.'" class="img-responsive gj_cge_det_prod_img">'; 
					} else {
						$image = '<img src="'.asset($noimage_path.'/'.$noimage->product_no_image).'" alt="No Images" class="img-responsive gj_cge_det_prod_img">'; 
					}
					$table = '<table class="table table-hover gj_cge_det_tbl">
						<thead>
							<tr>
								<th>Product Title</th>
								<th>Images</th>
								<th>Apply</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>'.$products->product_title.'</td>
								<td>'.$image.'</td>
								<td><button type="button" class="btn btn-info gj_aly_det_btn" data-apply-id="'.$products->id.'">Apply</button></td>
							</tr>
						</tbody>
					</table>';
					$result = array('table' => $table, 'error' => '0');
				}	else {
					$result = array('table' => $table, 'error' => '1');
				}			
			} else {
				$result = array('table' => $table, 'error' => '1');
			}

			echo json_encode($result);
		}
	}

	public function ApplyProducts( Request $request) {	
		$id = 0;
		$result = array();
		$table = "";
		if($request->ajax() && isset($request->id)){
			$id = $request->id;
			$error = 1;
			$product_path = 'images/featured_products';
			$noimage = NoimageSettings::first();
			$noimage_path = 'images/noimage';

			if($id != 0) {
				$products = Products::where('id',$id)->first();
				if($products) {
					if($products->featured_product_img){
						$image = '<img src="'.asset($product_path.'/'.$products->featured_product_img).'" alt="'.$products->product_title.'" class="img-responsive gj_cge_det_prod_img">'; 
					} else {
						$image = '<img src="'.asset($noimage_path.'/'.$noimage->product_no_image).'" alt="No Images" class="img-responsive gj_cge_det_prod_img">'; 
					}

                    if ($products->tax_type == 2) {
                        $ships = $products->shiping_charge;
                    } else {
                        $ships = 0;
                    }

					$table = '<td>
                        <input type="hidden" name="det_product_id[]" class="det_product_id" value="'.$products->id.'" placeholder="Enter Product ID">

                        <input type="text" name="det_product_title[]" class="det_product_title" value="'.$products->product_title.'" placeholder="Enter Product Title">
                    </td>

                    <td>
                        <input type="number" name="det_order_qty[]" class="det_order_qty" value="1" placeholder="Enter Quantity" min="1">
                    </td>

                    <td>
                        <input type="text" name="det_h_unitprice[]" class="det_h_unitprice" value="'.$products->discounted_price.'" placeholder="Enter Price" disabled>

                        <input type="hidden" name="det_unitprice[]" class="det_unitprice" value="'.$products->discounted_price.'" placeholder="Enter Price">
                    </td>

                    <td>
                        <input type="text" name="det_h_totalprice[]" class="det_h_totalprice" value="'.round(1 * ($products->discounted_price + (($products->discounted_price * $products->tax)/100)),2).'" placeholder="Enter Total Price" disabled>

                        <input type="hidden" name="det_totalprice[]" class="det_totalprice" value="'.round(1 * ($products->discounted_price + (($products->discounted_price * $products->tax)/100)),2).'" placeholder="Enter Total Price">

                        <input type="hidden" name="tot_service_charge[]" class="gj_det_sc" value="'.$products->service_charge.'">

                        <input type="hidden" name="tot_shipping_charge[]" class="gj_det_spc" value="'.$ships.'">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger gj_del_det" data-del-id=""><i class="fa fa-trash"></i></button>
                    </td>';
					$result = array('table' => $table, 'error' => '0');
				}	else {
					$result = array('table' => $table, 'error' => '1');
				}			
			} else {
				$result = array('table' => $table, 'error' => '1');
			}

			echo json_encode($result);
		}
	}

	public function StatusOrders( Request $request) {	
		$id = 0;
		$status = 0;
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id) && isset($request->status)){
        			$id = $request->id;
        			$status = $request->status;
        			if($id != 0) {
        				$orders = Orders::where('id',$id)->first();
        				if($orders) {
                            if($status == 5) {
                                $orders->cancel_date = date('Y-m-d');
                            }elseif($status == 3){
                                $orders->delivery_date = date('Y-m-d');
                            }
                            
                            // if ($status == 2 && empty($orders->tracking_id)) {
                            //     Session::flash('message', 'Cannot mark as dispatched without a Tracking ID'); 
                            //     Session::flash('alert-class', 'alert-danger');
                            //     $error = 1;
                            //     return response()->json(['success' => false, 'message' => 'Tracking ID is required.']); // 🔁 STOP here
                            // }

                            $orders->order_status = $status;
                            
                            if($status == 4){
                                $orders->payment_status = 1;
                                $orders->delivery_status = 1;
                            }
                            

        					if($orders->save()) {
                                // if($orders->order_status == 3 || $orders->order_status == 5) {
                                //     // if($orders->order_status == 3) {
                                         
                                //     //     $text = "Your Order has been Delivered. Plz note the Order Code - ".$orders->order_code.",";
                                //     // } else {
                                //     //     $text = "Your Order has been Cancelled. Plz note the Order Code - ".$orders->order_code." ";
                                //     // }

                                        
                                //     $user = User::Where('id', $orders->user_id)->first();
                                //     if($user) {
                                //         $text = urlencode($text);
                     
                                //         $curl = curl_init();
                                     
                                //         // Send the POST request with cURL
                                //         curl_setopt_array($curl, array(
                                //         CURLOPT_RETURNTRANSFER => 1,
                                //         CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                //         CURLOPT_POST => 1,
                                //         CURLOPT_CUSTOMREQUEST => 'POST',
                                //         CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                //         CURLOPT_POSTFIELDS => array(
                                //             'mobile' => $user->phone,
                                //             'route' => 'TL',
                                //             'text' => $text,
                                //             'sender' => 'GJICAM')));
                                     
                                //         // Send the request & save response to $response
                                //         $response = curl_exec($curl);
                                     
                                //         // Close request to clear up some resources
                                //         curl_close($curl);
                                //         $response = json_decode($response);
                                //         // Print response
                                //         if(isset($response->data->status) && $response->data->status == "success") {
                                //             Session::flash('message', 'Order Status Changed Successfully and  Confirm Message Send Successfully!'); 
                                //             Session::flash('alert-class', 'alert-success');
                                //             echo $error = 0;die();
                                //         } else {
                                //             Session::flash('message', 'Order Status Changed Successfully!'); 
                                //             Session::flash('alert-class', 'alert-danger');
                                //             echo $error = 0;die();
                                //         }                                
                                //     }
                                // }
                                 $payment_status_text = '';
                                if ($orders->order_status == 0) {
                                        $payment_status_text = '-------';
                                    } elseif ($orders->order_status == 1) {
                                        $payment_status_text = 'Placed';
                                    } elseif ($orders->order_status == 2) {
                                        $payment_status_text = 'Dispatched';
                                    } elseif ($orders->order_status == 3) {
                                        $payment_status_text = 'Delivered';
                                    } elseif ($orders->order_status == 4) {
                                        $payment_status_text = 'Completed';
                                    } elseif ($orders->order_status == 5) {
                                        $payment_status_text = 'Cancelled';
                                    } else {
                                        $payment_status_text = '------';
                                    }
                                    
                                    if($orders->order_status == 3){
                                    //     $brand = "RANG BY BHAVANA"; 
                                    //     $validity = 5; 
                                    //     $mobile = '91' . $orders->contact_no; 
                                    //     $var3 = 'https://instagram.com/rang_by_bhavana';
                                    //     $var4 = 'www.rangjewelry.com';
                                    
                                    //     $message = "Dear $orders->contact_person, Your order $orders->order_code has been delivered. We hope you're enjoying your purchase from RANG BY BHAVANA $var3 $var4";
                                    //   $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                                    //     $senderId = "RANGBB";
                                    //     $route = "5";
                                    //     $templateId = "1007204259694796924";
                                    
                                    //   $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                                    //          . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                                    //          . "&number=$mobile&text=" . urlencode($message)
                                    //          . "&route=$route&DLTTemplateId=$templateId";
                                    
                                    //     $ch = curl_init();
                                    //     curl_setopt($ch, CURLOPT_URL, $url);
                                    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    //     $smsResponse = curl_exec($ch);
                                    //     $smsError = curl_error($ch);
                                    //     curl_close($ch);
                                    }
                                    elseif($orders->order_status == 4)
                                    {
                                //         $validity = 5; 
                                //     $mobile = '91' . $orders->contact_no; 
                                //     $var2 = 'RANG BY BHAVANA';
                                
                                //     $message = "Dear $orders->contact_person, Your order $orders->order_code status has been updated to $payment_status_text. If you have any questions, please contact us at $var2.";
                                //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                                //     $senderId = "RANGBB";
                                //     $route = "5";
                                //     $templateId = "1007006965462208823";
                                
                                //   $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                                //          . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                                //          . "&number=$mobile&text=" . urlencode($message)
                                //          . "&route=$route&DLTTemplateId=$templateId";
                                
                                //     $ch = curl_init();
                                //     curl_setopt($ch, CURLOPT_URL, $url);
                                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                                //     $smsResponse = curl_exec($ch);
                                //     $smsError = curl_error($ch);
                                //     curl_close($ch);
                                    }
                                    else{
                                   
                                //     $validity = 5; 
                                //     $mobile = '91' . $orders->contact_no; 
                                //     $var2 = 'www.rangjewelry.com';
                                
                                //     $message = "Dear $orders->contact_person, Your order $orders->order_code status has been updated to $payment_status_text. If you have any questions, please contact us at $var2.";
                                //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                                //     $senderId = "RANGBB";
                                //     $route = "5";
                                //     $templateId = "1007006965462208823";
                                
                                //   $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                                //          . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                                //          . "&number=$mobile&text=" . urlencode($message)
                                //          . "&route=$route&DLTTemplateId=$templateId";
                                
                                //     $ch = curl_init();
                                //     curl_setopt($ch, CURLOPT_URL, $url);
                                //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                //     $smsResponse = curl_exec($ch);
                                //     $smsError = curl_error($ch);
                                //     curl_close($ch);
                                    }
                                        
                                        
                                  $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@folkgems.com";
                                if($adm) {
                                    $admin_email = $adm->email;
                                }
                                $general = \DB::table('general_settings')->first();
                                $site_name = "Paris La Belle";
                                    if($general){
                                        $site_name = $general->site_name;
                                    } else {
                                        $site_name = "Paris La Belle";
                                    }
                                $logos = \DB::table('logo_settings')->latest()->first();
                                    $logo_path = 'images/logo';
                                    $logo = "";
                                    if($logos) {
                                        $logo = asset($logo_path.'/'.$logos->logo_image);
                                    } else {
                                        $logo = asset('images/logo.png');
                                    }
                                $net_tot = $orders->net_amount;
                                $name = $orders->contact_person;
                                $email = $orders->contact_email;
                                $contact =  $orders->contact_no;
                                $order_date =$orders->order_date;
                                $order_code =$orders->order_code;
                                $track=$orders->tracking_id;
                                $product_path= 'images/featured_products';
                                 $noimage = \DB::table('noimage_settings')->first();
                                $noimage_path = 'images/noimage';
                                $details = '';
                                $img = '';
                                 $color='';

                                foreach($orders->orderDetails as $orderDetail){
                                      if($orderDetail->color_name){
                                            $color='(' .$orderDetail->color_name .')';
                                        }           
                                    if ($orderDetail->Products->featured_product_img) {
                                            $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                        } else {
                                            $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                        }
                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                            <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                                 '.$img.'
                                            </a>
                                        </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.' '.$color.' </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                                    </tr>';
                                }
                                
                                $feedback_text = '';
                                $extratxt='';
                                $discount ='';
                                if($orders->order_status == 3){
                                    $feedback_text = '
                                    <p style="font-size:13px;font-weight:600;">We hope you are thrilled with your Rukmini Fashions purchase. </p>
                                    <p style="font-size:13px;font-weight:600;">
                                        Please provide feedback on Rukmini Fashions <a href="'.route('contact').'">here</a> and Product feedback by clicking on the product image above.
                                    </p>';
                                    $extratxt='';
                                }elseif($orders->order_status == 5){
                                    $feedback_text = ' 
                                    <p style="font-size:13px;font-weight:600;">We shall update you on the status of the cancellation request shortly.</p>
                                    <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>. </p>
                                    ';
                                    $extratxt='';
                                    
                                
                                }elseif($orders->order_status == 4){
                                    $feedback_text = ' 
                                    <p style="font-size:13px;font-weight:600;">We hope you are enjoying your order. Please provide feedback on Rukmini Fashions <a href="'.route('contact').'">here</a> and Product feedback by clicking on Review Order button <a href="'.url('my_account') . '?tab=completedOrders'.'">here </a>. </p>
                                    <p style="font-size:13px;font-weight:600;">Please <a href="'.route('contact').'">let us know</a> if there is anything else we can do for you.</p>
                                    ';
                                    $extratxt='';
                                    
                                }elseif($orders->order_status == 2){  
                                    $feedback_text = ' ';
                                     $extratxt='';
                                    //  $extratxt='<p style="font-size:12px;font-weight:600;">You can track it <a href="https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx" target="_blank">here</a> with tracking id #'.$track.'</p>';
                                    
                                }else{
                                    $feedback_text = ' 
                                    <p style="font-size:13px;font-weight:600;">We look forward to you receiving your Rukmini Fashions order soon.</p>
                                    <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>. </p>
                                    ';
                                    $extratxt='';
                                    
                                }
                                
                                if ($orders->coupon_code) {
                                        $discount = '
                                        <tr>
                                            <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                                Coupon Discount
                                            </th>
                                            <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                                - Rs. '.number_format($orders->coupon_discount, 2).'
                                            </td>
                                        </tr>';
                                    }
            
                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to = $email;
                                $to2 = $admin_email;
                                $subject = "Your Rukmini Fashions Order was $payment_status_text";
                               $txt = '<div class="gj_mail" style=" width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                    <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                                       <a href="'.route('home').'"> <img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                    </div>
                                    <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                        <h2 style="color: #B73182;margin-top: 0px;">Order Status Update</h2>
                                         <p style="font-size:15px;font-weight:600;">Dear '.$name.', </p>
                                           
                                           <p style="font-size:12px;font-weight:600;">We are pleased to inform you that your order #'.$order_code.' from Rukmini Fashions has been <b>'.$payment_status_text.'</b>.</p>
                                           '.$extratxt.'
                                           
                                        <table align="center" style=" text-align: center;width: 100%;">
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$name.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_date.'</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_code.'</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$orders->payment->name.'</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Status</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : <strong>'.$payment_status_text.'</strong></td>
                                            </tr>
                                            
                                            
                                        </table>
                                        
                                        <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                                <tr>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                                </tr>'.$details.'
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->total_amount.'</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->shipping_charge.'</td>
                                                </tr>
                                                
                                                '.$discount.'
                                               
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                                </tr>
                                            </table>
                        
                                        '.$feedback_text.'
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                        <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                        <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                            <div style="padding: 20px 0; text-align: center;">
                                                <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                                </a>
                                            </div>
                                    </div>
                                </div>';
                               $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                            if($mail){
        						Session::flash('message', 'Status Changed Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                            }
        					} else {
        						Session::flash('message', 'Status Changed Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
        					Session::flash('message', 'Status Changed Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        					$error = 1;
        				}			
        			} else {
        				Session::flash('message', 'Status Changed Failed!'); 
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
	
    public function updateTracking(Request $request)
    {
        $order = Orders::find($request->order_id);
    
        if ($order) {
            $order->tracking_id = $request->tracking_id;
            $order->save();
            
        //     $validity = 5; 
        //     $mobile = '91' . $order->contact_no; 
        //     $var2 = 'www.rangjewelry.com';
        //     $var3 = 'https://instagram.com/rang_by_bhavana';
            
        
        //     $message = "Dear $order->contact_person, Your order $order->order_code has been shipped! Track it using ID $order->tracking_id at $var2. Thank you for shopping with RANG BY BHAVANA. $var3 $var2 Thank you";
        //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
        //     $senderId = "RANGBB";
        //     $route = "5";
        //     $templateId = "1007463212643802688";
        
        //   $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
        //          . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
        //          . "&number=$mobile&text=" . urlencode($message)
        //          . "&route=$route&DLTTemplateId=$templateId";
        
        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $smsResponse = curl_exec($ch);
        //     $smsError = curl_error($ch);
        //     curl_close($ch);
            
    
            Session::flash('message', 'Tracking ID updated successfully'); 
            Session::flash('alert-class', 'alert-success');
            
            return response()->json(0); // success
        }
    
        Session::flash('message', 'Failed to update tracking ID'); 
        Session::flash('alert-class', 'alert-danger');
    
        return response()->json(1); // failure
    }
    
    public function addDiscount(Request $request)
    {
        $order = Orders::find($request->order_id);
    
        if ($order) {
            $order->additional_discount = $request->additional_discount;
            $order->save();
    
            Session::flash('message', 'Additional Discount added successfully'); 
            Session::flash('alert-class', 'alert-success');
            
            return response()->json(0); // success
        }
    
        Session::flash('message', 'Failed to add Additional Discount'); 
        Session::flash('alert-class', 'alert-danger');
    
        return response()->json(1); // failure
    }



    public function PaymentStatusOrders( Request $request) { 
        $id = 0;
        $status = 0;
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id) && isset($request->status)){
                    $id = $request->id;
                    $status = $request->status;
                    if($id != 0) {
                        $order = Orders::where('id',$id)->first();
                        $order_trans = OrdersTransactions::Where('order_id', $order->id)->first();
                        if(!$order_trans) {
                            $order_trans = OrdersTransactions::Where('order_id', $order->order_code)->first();
                        }
                        if($order && $order_trans) {
                            $order->payment_status = $status;
                            if($status == 0) {
                                $order_trans->amountpaid = 'Unpaid';
                                $order_trans->trans_status = 'PENDING';
                            } else if($status == 1) {
                                $order_trans->amountpaid = 'Paid';
                                $order_trans->trans_status = 'SUCCESS';
                            } else if($status == 2) {
                                $order_trans->amountpaid = 'Unpaid';
                                $order_trans->trans_status = 'FAILED';
                            } else {
                                $order_trans->amountpaid = 'Unpaid';
                                $order_trans->trans_status = 'FAILED';
                            }

                            if($order->save() && $order_trans->save()) {
                                
                                $payment_status_text = '';
                                $subj="";
                                $txt1='';
                                $txt2='';
                                if ($order->payment_status == 0) {
                                    $payment_status_text = 'Pending';
                                    $subj="";
                                    $txt1='';
                                    $txt2='';
                                } elseif ($order->payment_status == 1) {
                                    $payment_status_text = 'Successful'; 
                                    $subj="Your Payment for Rukmini Fashions Order was successful";
                                    $txt1=' 
                                    <p style="font-size:13px;font-weight:600;">We are pleased to inform you that payment for your order#'.$order->order_code.' from Rukmini Fashions has been processed Successfully</p>
                                    ';
                                    $txt2='
                                    <p style="font-size:13px;font-weight:600;">Your order is now being processed, and we will keep you updated on its status. </p>
                                    
                                    ';
                                } elseif ($order->payment_status == 2) {
                                    $payment_status_text = 'Unsuccessful';
                                    $subj="Your Payment for Rukmini Fashions Order was Unsuccessful.";
                                    $txt1='
                                    <p style="font-size:13px;font-weight:600;">We regret to inform you that payment for your order#'.$order->order_code.' from Rukmini Fashions has been processed Unsuccessful</p>
                                    
                                    ';
                                    $txt2='
                                    <p style="font-size:13px;font-weight:600;">Please review the payment details and try again. If you continue to experience issues, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>.</p>
                                    
                                    ';
                                } else {
                                    $payment_status_text = '------';
                                    $subj="";
                                    $txt1='';
                                    $txt2='';
                                }
                                  $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@folkgems.com";
                                if($adm) {
                                    $admin_email = $adm->email;
                                }
                                $general = \DB::table('general_settings')->first();
                                $site_name = "Folkgems";
                                    if($general){
                                        $site_name = $general->site_name;
                                    } else {
                                        $site_name = "Folkgems";
                                    }
                                $logos = \DB::table('logo_settings')->latest()->first();
                                    $logo_path = 'images/logo';
                                    $logo = "";
                                    if($logos) {
                                        $logo = asset($logo_path.'/'.$logos->logo_image);
                                    } else {
                                        $logo = asset('images/logo.png');
                                    }
                                $name = $order->contact_person;
                                $email = $order->contact_email;
                                $contact =  $order->contact_no;
                                $order_date =$order->order_date;
                                $order_code =$order->order_code;
                                $net_tot = $order->net_amount;
                              $product_path= 'images/featured_products';
                              $noimage = \DB::table('noimage_settings')->first();
                                $noimage_path = 'images/noimage';
                                $details = '';
                                $discount ='';
                                $img = '';
                                $color='';

                                foreach($order->orderDetails as $orderDetail){
                                     if($orderDetail->color_name){
                                            $color= '('.$orderDetail->color_name . ')';
                                        }      
                                    if ($orderDetail->Products->featured_product_img) {
                                        $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                    } else {
                                        $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                    }
                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                            <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                                 '.$img.'
                                            </a>
                                        </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.' '.$color.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                                    </tr>';
                                }
                                
                                if ($order->coupon_code) {
                                        $discount = '
                                        <tr>
                                            <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                                Coupon Discount
                                            </th>
                                            <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                                - Rs. '.number_format($order->coupon_discount, 2).'
                                            </td>
                                        </tr>';
                                    }
            
                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to = $email;
                                $to2 = $admin_email;
                                $subject = $subj;
                               $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                    <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                                        <a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                    </div>
                                    <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                        <h2 style="color: #B73182;margin-top: 0px;">Order Payment Status Updated</h2>
                                        '. $txt1.'
                                        <table align="center" style=" text-align: center;width: 100%;">
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$name.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_date.'</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_code.'</td>
                                            </tr>
                                            
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order->payment->name.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Status</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : <strong>'.$payment_status_text.'</strong></td>
                                            </tr>
                                        </table>
                                        
                                        <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                            <tr>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                            </tr>'.$details.'
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->total_amount.'</td>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$order->shipping_charge.'</td>
                                            </tr>
                                            
                                            '.$discount.'
                                           
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                            </tr>
                                        </table>
                                    
                                        '.$txt2.'
                                        <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="'.route('contact').'">customer support team</a>. </p>
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                        <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                        <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                        <div style="padding: 20px 0; text-align: center;">
                                            <a href="https://www.instagram.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                            </a>
                                            <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                            </a>
                                            <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                            </a>
                                        </div>
                                    </div>
                                </div>';
                              $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                              
                               if (
                                    $mail &&
                                    $order->payment_status == 1 &&
                                    in_array((int)$order->payment_mode, [1, 3]) &&
                                    empty($order->invoice_no)
                                ) {
                                
                                    \Log::info("Invoice condition passed for order #{$order->id}");
                                
                                    $invoice_no = 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                                    $invoice_date = now();
                                
                                    $order->invoice_no = $invoice_no;
                                    $order->invoice_date = $invoice_date;
                                    $order->save();
                                
                                    $user = User::find($order->user_id);
                                    $invoiceHtml = view('invoice_template', compact('order', 'user'))->render();
                                
                                    $invoiceHeaders  = "MIME-Version: 1.0\r\n";
                                    $invoiceHeaders .= "Content-type:text/html;charset=UTF-8\r\n";
                                    $invoiceHeaders .= "From: Rukmini Fashions <syjd250oi96g>\r\n";
                                
                                    $inv_subject = "Invoice - Order #{$order->invoice_no}";
                                
                                    mail($to, $inv_subject, $invoiceHtml, $invoiceHeaders);
                                }

                                
                            if($mail){
                                Session::flash('message', 'Status Changed Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                            }
                            } else {
                                Session::flash('message', 'Status Changed Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Status Changed Failed'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }           
                    } else {
                        Session::flash('message', 'Status Changed Failed, Invalid ID!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                // $error = 1;
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            // $error = 1;
            $error = 1;
        }

        echo $error;
    }

	public function delete( Request $request) {	
		$id = 0;
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$orders = Orders::where('id',$id)->first();
        				if($orders){
        					if($orders->delete()) {
        						Session::flash('message', 'Deleted Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
        					} else {
        						Session::flash('message', 'Deleted Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
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
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$orders = Orders::where('id',$value)->first();
        					if($orders){
        						if($orders->delete()) {
        							Session::flash('message', 'Deleted Successfully!'); 
        							Session::flash('alert-class', 'alert-success');
        							$error = 0;
        						} else {
        							Session::flash('message', 'Deleted Failed!'); 
        							Session::flash('alert-class', 'alert-danger');

        						}
        					}	else {
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
                // $error = 1;
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            // $error = 1;
            $error = 1;
        }

		echo $error;
	}

    public function ExportCSV( Request $request) {  
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.export', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax()){
                    $ids = $request->ids;
                    $table = array();
                    $filename = "Orders.csv";
                    $user = session()->get('user');

                    if(isset($ids) && $ids) {
                        if(sizeof($ids) != 0) {
                            if($user) {
                                $table = Orders::whereIn('id',$ids)->get();
                            } else {
                                echo $error = 1;die();
                            }
                            $filename = "Orders.csv";
                        }  else {
                            Session::flash('message', 'CSV Export Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            die();
                        }
                    } else if(isset($request->type) && $request->type == 'export_all') {
                        if($user) {
                            if ($user->user_type == 1) {
                                $table = Orders::all();
                            } else if ($user->user_type == 2 || $user->user_type == 3) {
                                $co_id=[];
                                $ords = DB::table('orders as A')
                                    ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                                    ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                                    ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                                    ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                                    ->OrderBy('A.id', 'DESC')
                                    ->where('C.created_user', '=', $user->id)
                                    ->where('D.id', '=', $user->id)
                                    ->whereIn('D.user_type', ['2','3'])
                                    ->GroupBy('B.order_id')
                                    ->get();

                                if (sizeof($ords) != 0) {
                                    foreach ($ords as $key => $value) {
                                        array_push($co_id, $value->id);
                                    }
                                }

                                if (sizeof($co_id) != 0) {
                                    $table = Orders::WhereIn('id', $co_id)->get();
                                    if(sizeof($table) != 0) {
                                        foreach ($table as $key => $value) {
                                            $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                            if(sizeof($det)) {
                                                $table[$key]->{'details'} = $det;
                                            } else {
                                                $table[$key]->{'details'} =  '';
                                            }
                                        }
                                    }
                                }
                            } else {
                                echo $error = 1;die();
                            }
                        } else {
                            echo $error = 1;die();
                        }
                        $filename = "All_Orders.csv";
                    } else {
                        Session::flash('message', 'CSV Export Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        die();
                    }

                    foreach ($table as $key => $value) {
                        $table_det = OrderDetails::where('order_id',$value->id)->get();

                        if($value->order_code) {
                            $table[$key]['order_code'] = $value->order_code;
                        } else {
                            $table[$key]['order_code'] = "---------";
                        }

                        if($value->order_date) {
                            $table[$key]['order_date'] = date('d-m-Y', strtotime($value->order_date));
                        } else {
                            $table[$key]['order_date'] = "---------";
                        }   

                        if($value->payment_mode == 0) {
                            $table[$key]['payment_mode'] = "---------";
                        } elseif ($value->payment_mode == 1) {
                            $table[$key]['payment_mode'] = "Cash On Delivery";
                        } elseif ($value->payment_mode == 2) {
                            $table[$key]['payment_mode'] = "Online";
                        } else {
                            $table[$key]['payment_mode'] = "---------";
                        }

                        if($value->delivery_date) {
                            $table[$key]['delivery_date'] = date('d-m-Y', strtotime($value->delivery_date));
                        } else {
                            $table[$key]['delivery_date'] = "---------";
                        }

                        if($value->order_status == 0) {
                            $table[$key]['order_status'] = "---------";
                        } elseif($value->order_status == 1) {
                            $table[$key]['order_status'] = "Order Placed";
                        } elseif ($value->order_status == 2) {
                            $table[$key]['order_status'] = "Order Dispatched";
                        } elseif ($value->order_status == 3) {
                            $table[$key]['order_status'] = "Order Delivered";
                        } elseif ($value->order_status == 4) {
                            $table[$key]['order_status'] = "Order Complete";
                        } elseif ($value->order_status == 5) {
                            $table[$key]['order_status'] = "Order Cancelled";
                        } else {
                            $table[$key]['order_status'] = "---------";
                        }

                        if($value->contact_person) {
                            $table[$key]['contact_person'] = $value->contact_person;
                        } else {
                            $table[$key]['contact_person'] = "---------";
                        }

                        if($value->contact_no) {
                            $table[$key]['contact_no'] = $value->contact_no;
                        } else {
                            $table[$key]['contact_no'] = "---------";
                        }

                        if($value->shipping_address) {
                            $table[$key]['shipping_address'] = $value->shipping_address;
                        } else {
                            $table[$key]['shipping_address'] = "---------";
                        }

                        if($value->total_items) {
                            $table[$key]['total_items'] = $value->total_items;
                        } else {
                            $table[$key]['total_items'] = "---------";
                        }

                        if($value->discount_flag) {
                            $table[$key]['discount_flag'] = $value->discount_flag;
                        } else {
                            $table[$key]['discount_flag'] = "---------";
                        }

                        if($value->discount) {
                            $table[$key]['discount'] = 'Rs '.$value->discount;
                        } else {
                            $table[$key]['discount'] = "---------";
                        }

                        if($value->shipping_charge) {
                            $table[$key]['shipping_charge'] = 'Rs '.$value->shipping_charge;
                        } else {
                            $table[$key]['shipping_charge'] = "---------";
                        }

                        if($value->net_amount) {
                            $table[$key]['net_amount'] = 'Rs '.$value->net_amount;
                        } else {
                            $table[$key]['net_amount'] = "---------";
                        }

                        if($value->payment_status == 0) {
                            $table[$key]['payment_status'] = "Pending";
                        } elseif($value->payment_status == 1) {
                            $table[$key]['payment_status'] = "Success";
                        } elseif ($value->payment_status == 2) {
                            $table[$key]['payment_status'] = "Failed";
                        } else {
                            $table[$key]['payment_status'] = "---------";
                        }

                        if($value->delivery_status == 0) {
                            $table[$key]['delivery_status'] = "Pending";
                        } elseif($value->delivery_status == 1) {
                            $table[$key]['delivery_status'] = "Success";
                        } elseif ($value->delivery_status == 2) {
                            $table[$key]['delivery_status'] = "Failed";
                        } else {
                            $table[$key]['delivery_status'] = "---------";
                        }

                        if($value->remarks) {
                            $table[$key]['remarks'] = $value->remarks;
                        } else {
                            $table[$key]['remarks'] = "---------";
                        }

                        $patt = "---------";
                        if($value->attributes_flag == 1) {
                            $PA = ProductsAttributes::where('product_id', $value->id)->get();
                            if(sizeof($PA) != 0) {
                                $patt="";
                                foreach ($PA as $pkey => $pvalue) {
                                    $patt.= 'Attributes : '.$pvalue->AttributeName->att_name.' - '.$pvalue->AttributeValue->att_value.', Price : Rs.'.$pvalue->att_price.', Qty : '.$pvalue->att_qty.', Description : '.$pvalue->description.', ';                              
                                }
                            }
                            $table[$key]['p_attributes'] = $patt;
                        } else {
                            $table[$key]['p_attributes'] = $patt;
                        }

                        $odr = "---------";
                        if(sizeof($table_det) != 0) {
                            $odr="";
                            foreach ($table_det as $keyz => $valuez) {
                                $odr.= 'Product Title : '.$valuez->product_title.', Price : Rs.'.$valuez->unitprice.', Qty : '.$valuez->order_qty.', Total Price : '.$valuez->totalprice.', ';                              
                            }
                            $table[$key]['odr'] = $odr;
                        } else {
                            $table[$key]['odr'] = $odr;
                        }
                    }
                    
                    $handle = fopen($filename, 'w+');
                    fputcsv($handle, array('Order Code', 'Order Date', 'Payment Mode', 'Delivery Date', 'Order Status', 'Contact Person', 'Contact Number', 'Shipping Address', 'Total Items', 'Discount', 'Discount Rate', 'Shipping Charge', 'Net Amount', 'Payment Status', 'Delivery Status', 'Remarks', 'Order Deatils'));

                    foreach($table as $row) {
                        fputcsv($handle, array($row['order_code'], $row['order_date'], $row['payment_mode'], $row['delivery_date'], $row['order_status'], $row['contact_person'], $row['contact_no'], $row['shipping_address'], $row['total_items'], $row['discount_flag'], $row['discount'], $row['shipping_charge'], $row['net_amount'], $row['payment_status'], $row['delivery_status'], $row['remarks'], $row['odr']));
                    }

                    fclose($handle);

                    $headers = array(
                        'Content-Type' => 'text/csv',
                    );

                    // Session::flash('message', 'CSV Export Successfully!'); 
                    // Session::flash('alert-class', 'alert-success');
                    $file_path = $filename;
                    return $file_path;
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
    
     public function ExportCSVCustom( Request $request) {  
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.export', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax()){
                    $ids = $request->ids;
                    $table = array();
                    $filename = "CustomOrders.csv";
                    $user = session()->get('user');

                    if(isset($ids) && $ids) {
                        if(sizeof($ids) != 0) {
                            if($user) {
                                $table = CustomiseProduct::whereIn('id',$ids)->get();
                            } else {
                                echo $error = 1;die();
                            }
                            $filename = "CustomOrders.csv";
                        }  else {
                            Session::flash('message', 'CSV Export Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            die();
                        }
                    } else if(isset($request->type) && $request->type == 'export_all') {
                        if($user) {
                            if ($user->user_type == 1 || $user->user_type == 2) {
                                $table = CustomiseProduct::all();
                            } else {
                                echo $error = 1;die();
                            }
                        } else {
                            echo $error = 1;die();
                        }
                        $filename = "All_CustomOrders.csv";
                    } else {
                        Session::flash('message', 'CSV Export Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        die();
                    }

                    foreach ($table as $key => $value) {

                        if($value->created_at) {
                            $table[$key]['order_date'] = date('d-m-Y', strtotime($value->created_at));
                        } else {
                            $table[$key]['order_date'] = "---------";
                        }   

                        if($value->name) {
                            $table[$key]['name'] = $value->name;
                        } else {
                            $table[$key]['name'] = "---------";
                        }

                        if($value->email) {
                            $table[$key]['email'] = $value->email;
                        } else {
                            $table[$key]['email'] = "---------";
                        }

                        if($value->phone_number) {
                            $table[$key]['phone_number'] = $value->phone_number;
                        } else {
                            $table[$key]['phone_number'] = "---------";
                        }

                        if($value->custom_order_profit) {
                            $table[$key]['custom_order_profit'] = $value->custom_order_profit;
                        } else {
                            $table[$key]['custom_order_profit'] = "---------";
                        }

                        if($value->message) {
                            $table[$key]['message'] = $value->message;
                        } else {
                            $table[$key]['message'] = "---------";
                        }

                    }
                    
                    $handle = fopen($filename, 'w+');
                    fputcsv($handle, array( 'Order Date', 'Contact Person', 'Contact Number', 'Custom Order Profit', 'Message')); 

                    foreach($table as $row) {
                        fputcsv($handle, array($row['order_date'], $row['name'], $row['phone_number'], $row['custom_order_profit'], $row['message']));
                    }

                    fclose($handle);

                    $headers = array(
                        'Content-Type' => 'text/csv',
                    );

                    // Session::flash('message', 'CSV Export Successfully!'); 
                    // Session::flash('alert-class', 'alert-success');
                    $file_path = $filename;
                    return $file_path;
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

    public function ExportCourierCSV( Request $request) {  
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.export', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    $exp = '<table id="gj_co_exp">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Customer Address</th>
                                <th>Customer City</th>
                                <th>Customer Pincode</th>
                                <th>Customer Contact Number</th>
                                <th>Shipment Date</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Pickup Address Name</th>
                                <th>Order Type</th>
                                <th>Total Value (Rs.)</th>
                                <th>Package Length (cm)</th>
                                <th>Package Width (cm)</th>
                                <th>Package Height (cm)</th>
                                <th>Package Weight (kg)</th>
                                <th>Mode Type</th>
                            </tr>
                        </thead>
                        <tbody>';
                    if(sizeof($ids) != 0) {
                        $table = Orders::whereIn('id',$ids)->get();

                        foreach ($table as $key => $value) {
                            $table_det = OrderDetails::where('order_id',$value->id)->get();

                            if($value->order_code) {
                                $table[$key]['order_id'] = $value->order_code;
                            } else {
                                $table[$key]['order_id'] = "";
                            }

                            if($value->contact_person) {
                                $table[$key]['cus_name'] = $value->contact_person;
                            } else {
                                $table[$key]['cus_name'] = "";
                            }

                            if($value->shipping_address) {
                                $table[$key]['cus_address'] = $value->shipping_address;
                            } else {
                                $table[$key]['cus_address'] = "";
                            }

                            if($value->city) {
                                $table[$key]['cus_city'] = $value->city;
                            } else {
                                $table[$key]['cus_city'] = "";
                            }

                            if($value->city) {
                                $table[$key]['cus_pincode'] = $value->pincode;
                            } else {
                                $table[$key]['cus_pincode'] = "";
                            }

                            if($value->contact_no) {
                                $table[$key]['cus_contact_no'] = $value->contact_no;
                            } else {
                                $table[$key]['cus_contact_no'] = "";
                            }

                            if($value->order_date) {
                                $table[$key]['shipment_date'] = date('d/m/Y', strtotime($value->order_date));
                            } else {
                                $table[$key]['shipment_date'] = "";
                            }

                            $table[$key]['category'] = "";

                            if(count($table_det) != 0) {
                                foreach ($table_det as $keyz => $valuez) {
                                    if($valuez->product_title) {
                                        $table[$key]['item_name'].= $valuez->product_title.',';
                                    } else {
                                        $table[$key]['item_name'] = "";
                                    }
                                }
                            }

                            if($value->total_items) {
                                $table[$key]['qty'] = $value->total_items;
                            } else {
                                $table[$key]['qty'] = "";
                            }

                            $table[$key]['pick_addrs'] = "INTERCAMBIAR";

                            $table[$key]['odr_type'] = "";

                            if($value->net_amount) {
                                $table[$key]['total_value'] = $value->net_amount;
                            } else {
                                $table[$key]['total_value'] = "";
                            }

                            $table[$key]['pack_len'] = "";

                            $table[$key]['pack_wid'] = "";

                            $table[$key]['pack_hgh'] = "";

                            $table[$key]['pack_wgt'] = "";

                            $table[$key]['mode_type'] = "";
                            
                            $exp.= '<tr>
                                <td>'.$table[$key]['order_id'].'</td>
                                <td>'.$table[$key]['cus_name'].'</td>
                                <td>'.$table[$key]['cus_address'].'</td>
                                <td>'.$table[$key]['cus_city'].'</td>
                                <td>'.$table[$key]['cus_pincode'].'</td>
                                <td>'.$table[$key]['cus_contact_no'].'</td>
                                <td>'.$table[$key]['shipment_date'].'</td>
                                <td>'.$table[$key]['category'].'</td>
                                <td>'.$table[$key]['item_name'].'</td>
                                <td>'.$table[$key]['qty'].'</td>
                                <td>'.$table[$key]['pick_addrs'].'</td>
                                <td>'.$table[$key]['odr_type'].'</td>
                                <td>'.$table[$key]['total_value'].'</td>
                                <td>'.$table[$key]['pack_len'].'</td>
                                <td>'.$table[$key]['pack_wid'].'</td>
                                <td>'.$table[$key]['pack_hgh'].'</td>
                                <td>'.$table[$key]['pack_wgt'].'</td>
                                <td>'.$table[$key]['mode_type'].'</td>
                            </tr>';
                        }
                        $exp.= '</tbody>
                        </table>';

                        return $exp;
                    } else {
                        Session::flash('message', 'CSV Export Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
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

    public function SearchOrder (Request $request) {
        $page = "Transaction";                                               
        $order_date = $request->get('gj_srh_odr_date');
        $order_code = $request->get('gj_srh_odr_code');
        $order_status = $request->get('gj_srh_odr_sts');
        // $coupon_code = $request->get('gj_srh_cpn_code');

        if($order_date && $order_code) {
            $orders = Orders::Where('order_date', $order_date)->Where('order_code', 'like', '%' . $order_code . '%')->get();
            if(count($orders) != 0) {
                // Session::flash('message', 'Search Items Founded!'); 
                // Session::flash('alert-class', 'alert-success');
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                $orders = Orders::paginate(10);
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            }
        } elseif($order_date) {
            $orders = Orders::Where('order_date', $order_date)->get();
            if(count($orders) != 0) {
                // Session::flash('message', 'Search Items Founded!'); 
                // Session::flash('alert-class', 'alert-success');
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                $orders = Orders::paginate(10);
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            }
        } elseif($order_code) {
            $orders = Orders::orWhere('order_code', 'like', '%' . $order_code . '%')->get();
            if(count($orders) != 0) {
                // Session::flash('message', 'Search Items Founded!'); 
                // Session::flash('alert-class', 'alert-success');
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                $orders = Orders::paginate(10);
                return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
            }
        } elseif($order_status) {
             if ($order_status == 'with_coupon') {
                $orders = Orders::whereNotNull('coupon_code')
                                ->where('coupon_code', '!=', '')
                                ->get();
            } else {
                $orders = Orders::orWhere('order_status', 'like', '%' . $order_status . '%')->get();
            }
                if(count($orders) != 0) {
                    // Session::flash('message', 'Search Items Founded!'); 
                    // Session::flash('alert-class', 'alert-success');
                    return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));  
                } else {
                    Session::flash('message', 'Search Items Not Found!'); 
                    Session::flash('alert-class', 'alert-danger');
                    $orders = Orders::paginate(10);
                    return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
                }
            
        }else {
            $orders = Orders::get();
            Session::flash('message', 'Search Items Not Found!'); 
            Session::flash('alert-class', 'alert-danger');
            return View::make("transaction.orders.all_orders")->with(array('orders'=>$orders, 'page'=>$page));
        }
    }

    public function AllCreditNotes () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Credit Notes')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $cn = array(); 
                $co_id = []; 
                $co_ids = []; 
                
                if($sess) {
                    if($sess->user_type == 1) {
                        $cn = CreditsNotes::OrderBy('id', 'DESC')->paginate(10);
                    } else if($sess->user_type == 2 || $sess->user_type == 3) {
                        $ords = DB::table('credits_notes as CN')
                            ->leftjoin('grv_orders as A', 'A.id', '=', 'CN.grv_id')
                            ->leftjoin('grv_orders_details as B', 'A.id', '=', 'B.grv_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('CN.id as cn_id','A.id as grv_id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.grv_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->cn_id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $cn = CreditsNotes::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                        }
                    }
                }

                return View::make("transaction.orders.manage_credit_notes")->with(array('cn'=>$cn, 'page'=>$page));
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

    public function ViewCreditNotes ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Credit Notes')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.view', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $cn = array(); 
                $co_id = []; 
                $co_ids = []; 
                $general = GeneralSettings::first();
                $logo = LogoSettings::first();
                $contact = EmailSettings::first();
                $grv = '';
                $grv_details = array();

                if($sess) {
                    $cn = CreditsNotes::Where('id', $id)->first();
                    if($cn) {
                        $grv = GrvOrders::Where('id', $cn->grv_id)->first();
                        if($grv) {
                            $o_grv_details = GrvOrdersDetails::Where('grv_id', $grv->id)->get();
                            if(sizeof($o_grv_details) != 0) {
                                foreach ($o_grv_details as $key => $value) {
                                    if($value->return_type == "Refund") {
                                        array_push($co_id, $value->id);
                                    }
                                }

                                if (sizeof($co_id) != 0) {
                                    $grv_details = GrvOrdersDetails::WhereIn('id', $co_id)->get();
                                    if(sizeof($grv_details) != 0) {
                                        return View::make("transaction.orders.view_credit_notes")->with(array('cn'=>$cn, 'general'=>$general, 'contact'=>$contact, 'logo'=>$logo, 'grv'=>$grv, 'grv_details'=>$grv_details, 'page'=>$page));
                                    } else {
                                        Session::flash('message', 'GRV Details Not Found!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('manage_credit_notes');
                                    }
                                } else {
                                    Session::flash('message', 'GRV Details Not Found!'); 
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('manage_credit_notes');
                                }
                            } else {
                                Session::flash('message', 'GRV Details Not Found!'); 
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('manage_credit_notes');
                            }
                        } else {
                            Session::flash('message', 'GRV Invalid!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_credit_notes');
                        }
                    } else {
                        Session::flash('message', 'View Not Possible!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_credit_notes');
                    }
                } else {
                    Session::flash('message', 'This User Cannot View This Module!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_credit_notes');
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

    public function StatusCreditNotes( Request $request) {  
        $id = 0;
        $status = 0;
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Credit Notes')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id) && isset($request->status)){
                    $id = $request->id;
                    $status = $request->status;
                    if($id != 0) {
                        $cn = CreditsNotes::where('id',$id)->first();
                        if($cn) {
                            $cn->is_paid = $status;
                            if($cn->save()) {
                                if($cn->is_paid == 'Paid') {
                                    $text = "Your Refund Order Amount is Paid. Plz note the Order Code - ".$cn->GRV->Orders->order_code.", ecambiar.com";
                                    $subject = "Refund Amount Paid";
                                /*} elseif ($cn->is_paid == 'Un Paid') {
                                    $text = "Your Refund Order Amount is Un Paid. Plz note the Order Code - ".$cn->GRV->Orders->order_code.", ecambiar.com";
                                    $subject = "Un Paid Refund";
                                }*/

                                    $text = urlencode($text);

                                    $curl = curl_init();
                                    $user = User::Where('id', $cn->GRV->Orders->user_id)->first();
                                    if($user) { 
                                        $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                        $admin_email = "info@ecambiar.com";
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
                                        $site_name = "ECambiar";
                                        if($general){
                                            $site_name = $general->site_name;
                                        } else {
                                            $site_name = "ECambiar";
                                        } 

                                        $name = $user->full_name;

                                        $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                        $headers.= "MIME-Version: 1.0\r\n";
                                        // $headers.= "From: $admin_email" . "\r\n";
                                        $headers.= "From: jgrrylvmgyxm" . "\r\n";
                                        $to1 = $user->email;
                                        $to2 = $admin_email;

                                        $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url('.asset('images/shadow.png').'); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                                                <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="'.$logo.'" style="width: 300px; margin: 0 auto;display: block;"></div>
                                                <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                                    <h2 style="color: #ff5c00;margin-top: 0px;">'.$subject.'</h2>
                                                    <table align="center" style=" text-align: center;">
                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">customer Name</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$user->first_name.' '.$user->last_name.'</td>
                                                        </tr>

                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Contact No</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$user->phone.'</td>
                                                        </tr>

                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Email</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$user->email.'</td>
                                                        </tr>

                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Order Code</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$cn->GRV->Orders->order_code.'</td>
                                                        </tr>

                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Request Replied Date</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.$cn->cn_code.'</td>
                                                        </tr>

                                                        <tr>
                                                            <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Issue Date</th>
                                                            <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : '.date('d-F-Y', Strtotime($cn->date)).'</td>
                                                        </tr>
                                                    </table>

                                                    <p>Your Refund Order Amount is Paid.</p>
                                                    <p>Thank You.</p>
                                                     <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                                    <p>Thanks & Regards,</p>
                                                    <p><a href="'.route('home').'">'.$site_name.'</a></p>
                                                </div>
                                            </div>';
                                            
                                            
                                        // if(1==1){
                                        if(mail($to1,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers)) {
                                            Session::flash('message', 'Status Changed Successfully!'); 
                                            Session::flash('alert-class', 'alert-success');
                                            $error = 0;
                                        }

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
                                            Session::flash('message', 'Status Changed Successfully!'); 
                                            Session::flash('alert-class', 'alert-success');
                                            $error = 0;
                                        } else {
                                            Session::flash('message', 'Status Changed Successfully!'); 
                                            Session::flash('alert-class', 'alert-success');
                                            $error = 0;
                                        }
                                    } else {
                                        Session::flash('message', 'Status Changed Successfully!'); 
                                        Session::flash('alert-class', 'alert-success');
                                        $error = 0;
                                    }
                                    Session::flash('message', 'Status Changed Successfully!'); 
                                    Session::flash('alert-class', 'alert-success');
                                    $error = 0;
                                } elseif ($cn->is_paid == 'Un Paid') {
                                    $text = "Your Refund Order Amount is Un Paid. Plz note the Order Code - ".$cn->GRV->Orders->order_code.", ecambiar.com";
                                    $subject = "Un Paid Refund";

                                    Session::flash('message', 'Status Changed Successfully!'); 
                                    Session::flash('alert-class', 'alert-success');
                                    $error = 0;
                                }
                            } else {
                                Session::flash('message', 'Status Changed Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Status Changed Not Possible!'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }           
                    } else {
                        Session::flash('message', 'Invalid ID!'); 
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

    public function TransactionSummary () {
        $loged = session()->get('user');
        if($loged) {
            $page = "Transaction";
            $sess = session()->get('user');
            $orders = ''; 
            $co_id = []; 
            $co_ids = []; 
            
            if($sess) {
                if($sess->user_type == 1) {
                    $orders = Orders::OrderBy('id', 'DESC')->paginate(10);
                    $vendors = User::WhereIn('user_type', ['2','3'])->get();
                    if(sizeof($orders) != 0) {
                        foreach ($orders as $key => $value) {
                            $det = OrderDetails::Where('order_id', $value->id)->get(); 
                            if(sizeof($det)) {
                                $orders[$key]->{'details'} = $det;
                            } else {
                                $orders[$key]->{'details'} =  '';
                            }
                        }
                    }
                } else if($sess->user_type == 2 || $sess->user_type == 3) {
                    $ords = DB::table('orders as A')
                        ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                        ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                        ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                        ->select('A.id', 'sum(B.unitprice) as sum', 'B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                        ->OrderBy('A.id', 'DESC')
                        ->where('C.created_user', '=', $sess->id)
                        ->where('D.id', '=', $sess->id)
                        ->whereIn('D.user_type', ['2','3'])
                        ->GroupBy('B.order_id')
                        ->get();

                    if (sizeof($ords) != 0) {
                        foreach ($ords as $key => $value) {
                            array_push($co_id, $value->id);
                        }
                    }

                    if (sizeof($co_id) != 0) {
                        $orders = Orders::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                        if(sizeof($orders) != 0) {
                            foreach ($orders as $key => $value) {
                                $det = OrderDetails::Where('order_id', $value->id)->get(); 
                                if(sizeof($det) != 0) {
                                    $orders[$key]->{'details'} = $det;
                                } else {
                                    $orders[$key]->{'details'} =  '';
                                }
                            }
                        }
                    }
                }
            }

            return View::make("transaction.orders.transaction_summary")->with(array('orders'=>$orders, 'vendors'=>$vendors, 'page'=>$page));
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function FilterTransactionSummary (Request $request) {
        $page = "Transaction"; 
        $vendors = User::WhereIn('user_type', ['2','3'])->Where('is_block', 1)->get();    
        $fo_id = [];                                         
        $fod_id = [];                                         
        $gj_srh_from_date = $request->get('gj_srh_from_date');
        $gj_srh_to_date = $request->get('gj_srh_to_date');
        $gj_srh_vendor = $request->get('gj_srh_vendor');
        $orders = array();

        if($gj_srh_from_date && $gj_srh_to_date && $gj_srh_vendor) {
            $gj_srh_from_date = date('Y-m-d', strtotime($gj_srh_from_date));
            $gj_srh_to_date = date('Y-m-d', strtotime($gj_srh_to_date));

            $ords = DB::table('orders as A')
                ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                ->select('A.id as o_id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                ->OrderBy('A.id', 'DESC')
                ->where('C.created_user', '=', $gj_srh_vendor)
                ->where(function($query) use ($gj_srh_from_date, $gj_srh_to_date) {
                    return $query->whereBetween('order_date', [$gj_srh_from_date, $gj_srh_to_date])
                    ->orWhereNull('order_date');
                })
                ->where('D.id', '=', $gj_srh_vendor)
                ->whereIn('D.user_type', ['2','3'])
                ->GroupBy('B.order_id')
                ->get();

            if (sizeof($ords) != 0) {
                foreach ($ords as $key => $value) {
                    array_push($fo_id, $value->o_id);
                }
            }

            if (sizeof($fo_id) != 0) {
                $orders = Orders::WhereIn('id', $fo_id)->OrderBy('id', 'DESC')->paginate(10);
                if(sizeof($orders) != 0) {
                    foreach ($orders as $key => $value) {
                        $det = OrderDetails::Where('order_id', $value->id)->get(); 
                        if(sizeof($det) != 0) {
                            $orders[$key]->{'details'} = $det;
                        } else {
                            $orders[$key]->{'details'} =  '';
                        }
                    }
                }
            }

            if (sizeof($orders) != 0) {
                return View::make("transaction.orders.transaction_summary")->with(array('orders'=>$orders, 'vendors'=>$vendors, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('transaction_summary');
            }
        } elseif($gj_srh_from_date && $gj_srh_vendor) {
            $gj_srh_from_date = date('Y-m-d', strtotime($gj_srh_from_date));

            $ords = DB::table('orders as A')
                ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                ->select('A.id as o_id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                ->OrderBy('A.id', 'DESC')
                ->where('C.created_user', '=', $gj_srh_vendor)
                ->where('A.order_date', '=', $gj_srh_from_date)
                ->where('D.id', '=', $gj_srh_vendor)
                ->whereIn('D.user_type', ['2','3'])
                ->GroupBy('B.order_id')
                ->get();

            if (sizeof($ords) != 0) {
                foreach ($ords as $key => $value) {
                    array_push($fo_id, $value->o_id);
                }
            }

            if (sizeof($fo_id) != 0) {
                $orders = Orders::WhereIn('id', $fo_id)->OrderBy('id', 'DESC')->paginate(10);
                if(sizeof($orders) != 0) {
                    foreach ($orders as $key => $value) {
                        $det = OrderDetails::Where('order_id', $value->id)->get(); 
                        if(sizeof($det) != 0) {
                            $orders[$key]->{'details'} = $det;
                        } else {
                            $orders[$key]->{'details'} =  '';
                        }
                    }
                }
            }

            if (sizeof($orders) != 0) {
                return View::make("transaction.orders.transaction_summary")->with(array('orders'=>$orders, 'vendors'=>$vendors, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('transaction_summary');
            }
        } elseif($gj_srh_vendor) {
            $ords = DB::table('orders as A')
                ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                ->select('A.id as o_id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                ->OrderBy('A.id', 'DESC')
                ->where('C.created_user', '=', $gj_srh_vendor)
                ->where('D.id', '=', $gj_srh_vendor)
                ->whereIn('D.user_type', ['2','3'])
                ->GroupBy('B.order_id')
                ->get();

            if (sizeof($ords) != 0) {
                foreach ($ords as $key => $value) {
                    array_push($fo_id, $value->o_id);
                }
            }

            if (sizeof($fo_id) != 0) {
                $orders = Orders::WhereIn('id', $fo_id)->OrderBy('id', 'DESC')->paginate(10);
                if(sizeof($orders) != 0) {
                    foreach ($orders as $key => $value) {
                        $det = OrderDetails::Where('order_id', $value->id)->get(); 
                        if(sizeof($det) != 0) {
                            $orders[$key]->{'details'} = $det;
                        } else {
                            $orders[$key]->{'details'} =  '';
                        }
                    }
                }
            }

            if (sizeof($orders) != 0) {
                return View::make("transaction.orders.transaction_summary")->with(array('orders'=>$orders, 'vendors'=>$vendors, 'page'=>$page));
            } else {
                Session::flash('message', 'Search Items Not Found!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('transaction_summary');
            }
        } else {
            Session::flash('message', 'Search Items Not Found!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('transaction_summary');
        }
    }
    
    public function CustomOrders () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Transaction";
                $sess = session()->get('user');
                $orders = ''; 
                $co_id = []; 
                $co_ids = []; 
                
                if($sess) {
                    if($sess->user_type == 1 || $sess->user_type == 2) {
                        $orders = CustomiseProduct::OrderBy('id', 'DESC')->get();
                    } else if( $sess->user_type == 3) {
                        $ords = DB::table('orders as A')
                            ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                            ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                            ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                            ->select('A.id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                            ->OrderBy('A.id', 'DESC')
                            ->where('C.created_user', '=', $sess->id)
                            ->where('D.id', '=', $sess->id)
                            ->whereIn('D.user_type', ['2','3'])
                            ->GroupBy('B.order_id')
                            ->get();

                        if (sizeof($ords) != 0) {
                            foreach ($ords as $key => $value) {
                                array_push($co_id, $value->id);
                            }
                        }

                        if (sizeof($co_id) != 0) {
                            $orders = CustomiseProduct::WhereIn('id', $co_id)->OrderBy('id', 'DESC')->paginate(10);
                        }
                    }
                }

            	return View::make("transaction.orders.custom_orders")->with(array('orders'=>$orders, 'page'=>$page));
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
    
     public function RefundStatusOrders( Request $request) { 
        $id = 0;
        $status = 0;
        $error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'All Orders') 
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->id) && isset($request->status)){
                    $id = $request->id;
                    $status = $request->status;
                    if($id != 0) {
                        $orders = Orders::where('id',$id)->first();
                        
                        if($orders ) {
                            $orders->refund_status = $status;
                            
                            if($orders->save()) {
                                
                                $payment_status_text = '';
                                    if ($orders->refund_status == 'pending') {
                                        $payment_status_text = 'Pending';
                                    } elseif ($orders->refund_status == 'complete') {
                                        $payment_status_text = 'Complete';
                                    } else {
                                        $payment_status_text = '------';
                                    }
                                
                                 $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@folkgems.com";
                                if($adm) {
                                    $admin_email = $adm->email;
                                }
                                $general = \DB::table('general_settings')->first();
                                $site_name = "Rang";
                                    if($general){
                                        $site_name = $general->site_name;
                                    } else {
                                        $site_name = "Rang";
                                    }
                                $logos = \DB::table('logo_settings')->latest()->first();
                                    $logo_path = 'images/logo';
                                    $logo = "";
                                    if($logos) {
                                        $logo = asset($logo_path.'/'.$logos->logo_image);
                                    } else {
                                        $logo = asset('images/logo.png');
                                    }
                                $net_tot = $orders->net_amount;
                                $name = $orders->contact_person;
                                $email = $orders->contact_email;
                                $contact =  $orders->contact_no;
                                $order_date =$orders->order_date;
                                $order_code =$orders->order_code;
                                
                                 $product_path= 'images/featured_products';
                                $noimage = \DB::table('noimage_settings')->first(); 
                                $noimage_path = 'images/noimage';
                                $details = '';
                                $img = '';
                                $discount = '';
                                $color='';

                                foreach($orders->orderDetails as $orderDetail){
                                    if($orderDetail->color_name){
                                            $color= '('.$orderDetail->color_name .')';
                                        }    
                                    if ($orderDetail->Products->featured_product_img) {
                                            $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                        } else {
                                            $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                        }
                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                            <a href="'.route('view_products', ['id' => $orderDetail->product_id]).'">
                                                 '.$img.'
                                            </a>
                                        </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->product_title.' '.$color.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">'.$orderDetail->order_qty.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->unitprice.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  '.$orderDetail->tax_amount.'</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. '.$orderDetail->totalprice.'</td>
                                    </tr>';
                                }
                                
                                if ($orders->coupon_code) {
                                        $discount = '
                                        <tr>
                                            <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                                Coupon Discount
                                            </th>
                                            <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                                - Rs. '.number_format($orders->coupon_discount, 2).'
                                            </td>
                                        </tr>';
                                    }
            
                                $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers.= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers.= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to = $email;
                                $to2 = $admin_email;
                                $subject = "Rukmini Fashions : Refund Status Update";
                               $txt = '<div class="gj_mail" style=" width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                    <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                                       <a href="'.route('home').'"> <img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a>
                                    </div>
                                    <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                        <h2 style="color: #B73182;margin-top: 0px;">Rukmini Fashions : Refund Status Update</h2>
                                        <table align="center" style=" text-align: center;width: 100%;">
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$name.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_date.'</td>
                                            </tr>
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : '.$order_code.'</td>
                                            </tr>
                        
                                            <tr>
                                                <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Refund Status</th>
                                                <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : <strong>'.$payment_status_text.'</strong></td>
                                            </tr>
                                        </table>
                                        
                                        <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                            <tr>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                            </tr>'.$details.'
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->total_amount.'</td>
                                            </tr>
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$orders->shipping_charge.'</td>
                                            </tr>
                                            
                                            '.$discount.'
                                           
                                            <tr>
                                                <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. '.$net_tot.'</td>
                                            </tr>
                                        </table>
                        
                                        <p style="font-size: 14px; color: #333;">Your refund status has been updated to <strong>'.$payment_status_text.'</strong>. If you have any questions, please contact us.</p>
                                        <p style="font-size:13px;font-weight:600;">Thank You.</p>
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                                        <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                        <p style="font-size:13px;font-weight:600;"><a href="'.route('home').'">'.$site_name.'</a></p>
                                         <div style="padding: 20px 0; text-align: center;">
                                                <a href="https://www.instagram.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                                </a>
                                            </div>
                                    </div>
                                </div>';
                               $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                                if($mail){
                                    Session::flash('message', 'Refund Status Changed Successfully!'); 
                                    Session::flash('alert-class', 'alert-success');
                                    $error = 0;
                                }
                            } else {
                                Session::flash('message', 'Refund Status Changed Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                                $error = 1;
                            }
                        }   else {
                            Session::flash('message', 'Refund Status Changed Failed'); 
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }           
                    } else {
                        Session::flash('message', 'Status Changed Failed, Invalid ID!'); 
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                // $error = 1;
                $error = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            // $error = 1;
            $error = 1;
        }

        echo $error;
    }
    
    
    
    
    
}