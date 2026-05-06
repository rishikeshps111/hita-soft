<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Store;
use App\CityManagement;
use App\CountriesManagement;
use App\CategoryManagementSettings;
use App\EmailSettings;
use App\Products;
use App\Contacts;
use App\Offers;
use App\Orders;
use App\CustomiseProduct;
use App\OrdersTransactions;
use App\CreditsManagement;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $response;
 
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function Dashboard () {
    	$page = "Dashboard";

		$customers = User::WhereIn('user_type',[4])->get();
		if($customers) {
			$customers['cnt'] = count($customers);
			$customers['web_cnt'] = count(User::WhereIn('user_type',[4])->Where('signup', 'Website SignUp')->get());
			$customers['fb_cnt'] = count(User::WhereIn('user_type',[4])->Where('signup', 'facebook')->get());
			$customers['gg_cnt'] = count(User::WhereIn('user_type',[4])->Where('signup', 'google')->get());


			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$customers['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_customers'] = User::WhereIn('user_type',[4])->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$customers['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_customers'] = count($customers['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_customers']);
			}
		}

		$active_products = Products::Where('is_block', 1)->get();
		if(sizeof($active_products) != 0) {
			$active_products['cnt'] = sizeof($active_products);
		} else {
			$active_products['cnt'] = 0;
		}

		$store = Store::all();
		if(sizeof($store) != 0) {
			$store['cnt'] = sizeof($store);
		} else {
			$store['cnt'] = 0;
		}

		$enquiries = Contacts::get();
		if(sizeof($enquiries) != 0) {
			$enquiries['cnt'] = sizeof($enquiries);
		} else {
			$enquiries['cnt'] = 0;
		}

		$offers = Offers::all();
		if(sizeof($offers) != 0) {
			$offers['cnt'] = sizeof($offers);
		} else {
			$offers['cnt'] = 0;
		}

		$place_odr = Orders::Where('order_status', 1)->get();
		if(sizeof($place_odr) != 0) {
			$place_odr['cnt'] = sizeof($place_odr);
		} else {
			$place_odr['cnt'] = 0;
		}
		
		$total_sales = Orders::where('order_status', 1)->get();
        if ($total_sales->isNotEmpty()) {
            $total_sales_sum = $total_sales->sum('net_amount'); 
        } else {
            $total_sales_sum = 0;
        }
		
			$transaction = OrdersTransactions::get();
		if(sizeof($transaction) != 0) {
			$transaction['cnt'] = sizeof($transaction);
		} else {
			$transaction['cnt'] = 0;
		}
		
			$total_odr = Orders::get();
		if(sizeof($total_odr) != 0) {
			$total_odr['cnt'] = sizeof($total_odr);
		} else {
			$total_odr['cnt'] = 0;
		}
		
			$custom_odr = CustomiseProduct::get();
		if(sizeof($custom_odr) != 0) {
			$custom_odr['cnt'] = sizeof($custom_odr);
		} else {
			$custom_odr['cnt'] = 0;
		}

		$complete_odr = Orders::Where('order_status', 4)->get();
		if(sizeof($complete_odr) != 0) {
			$complete_odr['cnt'] = sizeof($complete_odr);
		} else {
			$complete_odr['cnt'] = 0;
		}
		
		$cancel_odr = Orders::Where('order_status', 5)->get();
		if(sizeof($cancel_odr) != 0) {
			$cancel_odr['cnt'] = sizeof($cancel_odr);
		} else {
			$cancel_odr['cnt'] = 0;
		}
		
		$cancel_odr_req = Orders::Where('cancel_approved', 3)->get();
		if(sizeof($cancel_odr_req) != 0) {
			$cancel_odr_req['cnt'] = sizeof($cancel_odr_req);
		} else {
			$cancel_odr_req['cnt'] = 0;
		}

		$merchant = User::WhereIn('user_type',[2,3])->get();
		if($merchant) {
			$merchant['cnt'] = count($merchant);

			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$merchant['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_merchants'] = User::WhereIn('user_type',[2,3])->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$merchant['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_merchants'] = count($merchant['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_merchants']);
			}
		}

		$cod_trans = Orders::Where('payment_mode', 1)->get();
		if($cod_trans) {
			$cod_trans['cnt'] = count($cod_trans);

			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$cod_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans'] = Orders::Where('payment_mode', 1)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$cod_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans'] = count($cod_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans']);
			}
		}

		$online_trans = Orders::Where('payment_mode', 4)->get();
		if($online_trans) {
			$online_trans['cnt'] = count($online_trans);

			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$online_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans'] = Orders::Where('payment_mode', 4)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$online_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans'] = count($online_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans']);
			}
		}
		
		$phone_trans = Orders::Where('payment_mode', 2)->get();
		if($phone_trans) {
			$phone_trans['cnt'] = count($phone_trans);

			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$phone_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_phone_trans'] = Orders::Where('payment_mode', 2)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$phone_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_phone_trans'] = count($phone_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_phone_trans']);
			}
		}
		
		$cop_trans = Orders::Where('payment_mode', 3)->get();
		if($cop_trans) {
			$cop_trans['cnt'] = count($cop_trans);

			$year = date('Y');
			for ($i=1; $i <= 12; $i++) { 
				$cop_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cop_trans'] = Orders::Where('payment_mode', 3)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
				$cop_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cop_trans'] = count($cop_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cop_trans']);
			}
		}
		
		 $months = [];
            $year = date('Y');
        
            for ($i = 1; $i <= 12; $i++) {
                $months[] = date('F Y', mktime(0, 0, 0, $i, 1, $year));
            }
            
        $months = [];
        $cod_trans = [];
        $online_trans = [];
        $phone_trans = [];
        $cop_trans = [];
        
        $from = request('from') ? Carbon::createFromFormat('Y-m', request('from'))->startOfMonth() : Carbon::now()->subMonths(5)->startOfMonth();
        $to = request('to') ? Carbon::createFromFormat('Y-m', request('to'))->startOfMonth() : Carbon::now()->startOfMonth();
        
        if ($to->lt($from)) {
            [$from, $to] = [$to, $from];
        }
        
        $cursor = $from->copy();
        while ($cursor->lte($to)) {
            $label = $cursor->format('F_Y'); 
            $months[] = $label;
        
            $start = $cursor->copy()->startOfMonth()->toDateTimeString();
            $end   = $cursor->copy()->endOfMonth()->toDateTimeString();
        
            $cod_trans['cnt_last_' . $label . '_cod_trans'] =
                Orders::where('payment_mode', 1)->whereBetween('created_at', [$start, $end])->count();
        
            $online_trans['cnt_last_' . $label . '_online_trans'] =
                Orders::where('payment_mode', 4)->whereBetween('created_at', [$start, $end])->count();
        
            $phone_trans['cnt_last_' . $label . '_phone_trans'] =
               Orders::where('payment_mode', 2)->whereBetween('created_at', [$start, $end])->count();
        
            $cop_trans['cnt_last_' . $label . '_cop_trans'] =
                Orders::where('payment_mode', 3)->whereBetween('created_at', [$start, $end])->count();
        
            $cursor->addMonth();
        }


        $total_sales['cnt']=Orders::where('payment_status',1)->sum('net_amount');
		$products = Products::all();
		if($products) {
			$products['cnt'] = count($products);
			$products['act_cnt'] = count(Products::Where('is_block', 1)->get());
			$products['inact_cnt'] = count(Products::Where('is_block', '!=', 1)->get());
			$products['adm_cnt'] = count(Products::Where('created_user', 1)->get());
			$products['mer_cnt'] = count(Products::Where('created_user', '!=', 1)->get());
		}
		
		$categories = CategoryManagementSettings::all();
        $category_products = [];
    
        foreach ($categories as $category) {
            $count = Products::where('main_cat_name', $category->id)->count();
            $category_products[] = [
                'name' => $category->main_cat_name ?? ' ',
                'count' => $count
            ];
        }
        
         $categoryOrderCounts = DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->join('category_management_settings', 'products.main_cat_name', '=', 'category_management_settings.id')
        ->select('category_management_settings.main_cat_name', DB::raw('count(order_details.id) as order_count'))
        ->groupBy('category_management_settings.main_cat_name')
        ->get();
		
		$orders = Orders::with(['orderDetails.Products', 'Reference'])->get();

        $totalProfit = 0;
    
        foreach ($orders as $order) {
            $rangPrice = $order->orderDetails->sum(function($detail) {
               $productPrice = $detail->Products->rang_price ?? 0;
                $qty = $detail->order_qty ?? 1;
                return $productPrice * $qty;
            });
    
            $pricePaid = $order->net_amount ?? 0;
            $tax = $order->tax_amount ?? 0;
            $shipping = $order->shipping_charge ?? 0;
            $discount = $order->additional_discount ?? 0; 
    
            $profit = $pricePaid - $rangPrice - $tax - $shipping - $discount;
            $totalProfit += $profit;
        }
        
        $customOrderProfit =CustomiseProduct:: sum('custom_order_profit');

		return View::make("dashboard")->with(array('months'=>$months,'merchant'=>$merchant,'cancel_odr_req'=>$cancel_odr_req,'categoryOrderCounts'=>$categoryOrderCounts,'cancel_odr'=>$cancel_odr,'category_products'=>$category_products,'customOrderProfit'=>$customOrderProfit,'totalProfit'=>$totalProfit,'$total_sale'=>$total_sales,'total_sales_sum'=>$total_sales_sum, 'customers'=>$customers,'transaction'=>$transaction,'total_odr'=>$total_odr,'custom_odr'=>$custom_odr, 'page'=>$page, 'active_products'=>$active_products, 'store'=>$store, 'enquiries'=>$enquiries, 'offers'=>$offers, 'complete_odr'=>$complete_odr, 'place_odr'=>$place_odr, 'products'=>$products, 'cod_trans'=>$cod_trans,'cop_trans'=>$cop_trans, 'online_trans'=>$online_trans,'phone_trans'=>$phone_trans));
	}

	public function MerchantsDashboard () {
		$loged = session()->get('user');
		if($loged) {
			if($loged->id) {
				$page = "Dashboard";
				$active_products = Products::Where('is_block', 1)->Where('created_user', $loged->id)->get();
				if(sizeof($active_products) != 0) {
					$active_products['cnt'] = sizeof($active_products);
				} else {
					$active_products['cnt'] = 0;
				}

				$store = Store::Where('merchant', $loged->id)->get();
				if(sizeof($store) != 0) {
					$store['cnt'] = sizeof($store);
				} else {
					$store['cnt'] = 0;
				}

				$credits = CreditsManagement::Where('merchant_id', $loged->id)->max('current_credits');
				if(!$credits) {
					$credits = 0;
				}

				$co_id = [];
				$place_odr = []; 
				$complete_odr = []; 
				$cod_trans = []; 
				$online_trans = []; 
				$ords = DB::table('orders as A')
                    ->leftjoin('order_details as B', 'A.id', '=', 'B.order_id')
                    ->leftjoin('products as C', 'C.id', '=', 'B.product_id')
                    ->leftjoin('users as D', 'D.id', '=', 'C.created_user')
                    ->select('A.id as o_id','B.id as od_id', 'C.id as p_id', 'D.id as u_id')
                    ->OrderBy('A.id', 'DESC')
                    ->where('C.created_user', '=', $loged->id)
                    ->where('D.id', '=', $loged->id)
                    ->whereIn('D.user_type', ['2','3'])
                    ->GroupBy('B.order_id')
                    ->get();

                if (sizeof($ords) != 0) {
                    foreach ($ords as $key => $value) {
                        array_push($co_id, $value->o_id);
                    }
                }

                if (sizeof($co_id) != 0) {
                    $place_odr = Orders::Where('order_status', 1)->WhereIn('id', $co_id)->get();

                    $complete_odr = Orders::Where('order_status', 4)->WhereIn('id', $co_id)->get();
                    $cod_trans = Orders::Where('payment_mode', 1)->WhereIn('id', $co_id)->get();
                    $online_trans = Orders::Where('payment_mode', 2)->WhereIn('id', $co_id)->get();
                }				
                
                if(sizeof($place_odr) != 0) {
                    $place_odr['cnt'] = sizeof($place_odr);
                } else {
                	$place_odr['cnt'] = 0;
                }
				
				if(sizeof($complete_odr) != 0) {
					$complete_odr['cnt'] = sizeof($complete_odr);
				} else {
					$complete_odr['cnt'] = 0;
				}

				if(sizeof($cod_trans) != 0) {
					$cod_trans['cnt'] = count($cod_trans);

					$year = date('Y');
					for ($i=1; $i <= 12; $i++) { 
						$cod_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans'] = Orders::WhereIn('id', $co_id)->Where('payment_mode', 1)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
						$cod_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans'] = count($cod_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_cod_trans']);
					}
				}

				if(sizeof($online_trans) != 0) {
					$online_trans['cnt'] = count($online_trans);

					$year = date('Y');
					for ($i=1; $i <= 12; $i++) { 
						$online_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans'] = Orders::WhereIn('id', $co_id)->Where('payment_mode', 2)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', str_pad($i, 2, "0", STR_PAD_LEFT))->get();
						$online_trans['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans'] = count($online_trans['tot_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_online_trans']);
					}
				}

				$products = Products::all();
				if($products) {
					$products['cnt'] = count($products);
					$products['act_cnt'] = count(Products::Where('created_user', $loged->id)->Where('is_block', 1)->get());
					$products['inact_cnt'] = count(Products::Where('created_user', $loged->id)->Where('is_block', '!=', 1)->get());
					$products['pdt_cnt'] = count(Products::Where('created_user', $loged->id)->get());
				}

				return View::make("merchants_dashboard")->with(array('page'=>$page, 'active_products'=>$active_products, 'store'=>$store, 'complete_odr'=>$complete_odr, 'place_odr'=>$place_odr, 'credits'=>$credits, 'products'=>$products, 'cod_trans'=>$cod_trans, 'online_trans'=>$online_trans));
			} else {
				session()->forget('user');
				Session::flash('message', 'You Are Not Login!'); 
				Session::flash('alert-class', 'alert-danger');
	            return redirect()->route('admin');
			}
		} else {
			session()->forget('user');
			Session::flash('message', 'You Are Not Login!'); 
			Session::flash('alert-class', 'alert-danger');
            return redirect()->route('admin');
		}
	}
}