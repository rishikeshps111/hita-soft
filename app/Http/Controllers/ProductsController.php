<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\ProductsAttributes;
use App\AttributesSettings;
use App\AttributesFields;
use App\ProductsImages;
use App\StockManagement;
use App\SubStock;
use App\User;
use App\CityManagement;
use App\CountriesManagement;
use App\CategoryManagementSettings;
use App\SubCategoryManagementSettings;
use App\SubSubCategoryManagementSettings;
use App\MeasurementUnits;
use App\TaxManagement;
use App\Tags;
use App\Store;

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

class ProductsController extends Controller
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
            	$page = "Products";
            	$log = session()->get('user');
            	if($log) {
            	    $category=CategoryManagementSettings::Where('is_block', 1)->get();
            	     $categoryId = request()->get('category_id');
        	    	 $query = Products::query();

                            if ( $log->user_type == 3) {
                                $query->where('created_user', $log->id);
                            }
                
                            if (!empty($categoryId) && $categoryId != '8') {
                                $query->where('main_cat_name', $categoryId); 
                            }
                
                            $product = $query->orderBy('id', 'desc')->get();
                
                            return View::make("products.product.manage_product")->with([
                                'product' => $product,
                                'category' => $category,
                                'page' => $page,
                                'selectedCategory' => $categoryId, // Pass selected category to view
                            ]);
            	} else {
            		Session::flash('message', 'You Are Not Login!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('admin');
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $store = Store::Where('is_block', 1)->get();
            	$page = "Products";
            	$attributes = AttributesFields::Where('is_block', 1)->get();

                if($loged->user_type == 1) {
                    $store = Store::Where('is_block', 1)->get();
                } elseif ($loged->user_type == 2 || $loged->user_type == 3) {
                    $store = Store::Where('is_block', 1)->Where('merchant', $loged->id)->get();
                }

            	return View::make('products.product.add_product')->with(array('attributes'=>$attributes, 'store'=>$store, 'page'=>$page));
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Products";
            	$log = session()->get('user');
            	$rules = array(
                    'product_code'         => 'nullable',
                    'product_title'        => 'required',
                    'product_desc'         => 'required',
                    'product_weight'       => 'nullable|numeric',
                    'product_length'       => 'nullable|numeric',
                    'product_width'        => 'nullable|numeric',
                    'product_height'       => 'nullable|numeric',
                    'brand'                => 'nullable',
                    'model_no'             => 'nullable',
                    'varient'              => 'nullable',
                    'vendor_code'          => 'nullable',
                    'main_cat_name'        => 'required',
                    // 'sub_cat_name'         => 'nullable',
                    // 'sub_sub_cat_name'     => 'required',
                    'manufacturer'         => 'nullable',
                    'tags'                 => 'nullable',
                    // 'rang_price'       => 'required|numeric',
                    'original_price'       => 'nullable|numeric',
                    // 'h_tax'                  => 'nullable|numeric',
                    // 'product_cost'         => 'nullable|numeric',
                    // 'tax_amount'           => 'nullable|numeric',
                    'discounted_price'     => 'required|numeric',
                    'service_charge'       => 'nullable|numeric',
                    'tax_type'             => 'nullable',
                    // 'shiping_charge'       => 'nullable|numeric',
                    // 'inter_shiping_charge'       => 'nullable|numeric',
                    'onhand_qty'           => 'required|integer',
                    'measurement_unit'     => 'nullable',
                    // 'features'             => 'required',
                    'shiping_policy'       => 'nullable',
                    'attributes_flag'      => 'required',
                    // 'offers_flag'          => 'required',
                    'featuredproduct_flag' => 'nullable',
                    // 'toprated_flag'        => 'required',
                    // 'best_seller_flag'     => 'required',
                    'new_arrival'          => 'required',
                    'delivery'             => 'nullable|integer',
                    // 'store_name'           => 'nullable',
                    'created_user'         => 'nullable',
                    'modified_user'        => 'nullable',
                    'is_block'             => 'nullable',
                    'featured_product_img' => 'required',

                    // 'v_att_default'        => 'required_if:attributes_flag,==,1',
                    // 'attribute_name'       => 'required_if:attributes_flag,==,1',
                    // 'att_value'            => 'required_if:attributes_flag,==,1',
                    // 'att_description'      => 'required_if:attributes_flag,==,1',
                    // 'att_cost'             => 'required_if:attributes_flag,==,1',
                    // 'att_tax_amount'       => 'required_if:attributes_flag,==,1',
                    // 'att_colors' => 'required_if:attributes_flag,==,1',
                        
                    // 'att_qty'              => 'required_if:attributes_flag,==,1',
                    // 'att_image'            => 'required_if:attributes_flag,==,1',

                    // 'p_name'               => 'required',
                    'p_image'              => 'nullable',
                );
             
                $messages=[
                    'onhand_qty.required'=>'The onhand quantity field is required.',
                    // 'att_image.required_if'=>'Adding Attribute Image is required if setting Attributes to Active',
                    //     'att_colors.required_if' => 'Adding Color Code is required if setting Attributes to Active',
                    'p_image.required'=>'Product Image field is required.',
                    'main_cat_name.required' => 'The main category name field is required.',
                ];
                $validator = Validator::make($request->all(), $rules,$messages);

        	   	$attributes = AttributesFields::Where('is_block', 1)->get();
                $store = Store::Where('is_block', 1)->get();

                if($loged->user_type == 1) {
                    $store = Store::Where('is_block', 1)->get();
                } elseif ($loged->user_type == 2 || $loged->user_type == 3) {
                    $store = Store::Where('is_block', 1)->Where('merchant', $loged->id)->get();
                }

                if ($validator->fails()) {
            		return Redirect::back()->withErrors($validator)->with(array('attributes'=>$attributes, 'store'=>$store, 'page'=>$page))->withInput();
                } else {
                    $data = $request->all();
                    $max = Products::max('product_code');
                    $max_id = "0001";
                	$max_st = "pr";
                    if(($max)) {
                    	$max_no = substr($max, 2);
                    	$increment = (int)$max_no + 1;
                    	$data['product_code'] = $max_st.sprintf("%04d", $increment);
                    } else {
                    	$data['product_code'] = $max_st.$max_id;
                    }

                	$product = new Products();

                // 	if($data['attributes_flag'] == 1 && isset($data['att_qty'])) {
                // 		$data['onhand_qty'] = array_sum($data['att_qty']);
                // 	}

                    if($product) {
        	            $product->product_code           = $data['product_code'];	 
        	            $product->product_title          = $data['product_title'];	 
        	            $product->product_desc           = $data['product_desc'];	 
        	           // $product->product_weight         = $data['product_weight'];	 
        	           // $product->product_length         = $data['product_length'];	 
        	           // $product->product_width          = $data['product_width'];	 
        	           // $product->product_height         = $data['product_height'];	 
        	            // $product->vendor_code            = $data['vendor_code'];	
        	            $product->brand                  = $data['brand'] ?? '0';	 
        	            $product->model_no               = $data['model_no'] ?? '0';	 
        	            $product->varient                = $data['varient'] ?? '0';	 
        	            
        	            if(isset($data['main_cat_name']) && $data['main_cat_name']) {
        	               $product->main_cat_name       = $data['main_cat_name'];	 
                        } else {
                           $product->main_cat_name       = NULL;    
                        }

                        if(isset($data['sub_cat_name']) && $data['sub_cat_name']) {
                           $product->sub_cat_name       = $data['sub_cat_name'];   
                        } else {
                           $product->sub_cat_name       = NULL;    
                        }

                        // if(isset($data['sub_sub_cat_name']) && $data['sub_sub_cat_name']) {
                        //   $product->sub_sub_cat_name       = $data['sub_sub_cat_name'];   
                        // } else {
                        //   $product->sub_sub_cat_name       = NULL;    
                        // }
        	            	 
        	            $product->manufacturer           = $data['manufacturer'] ?? '0';	 

                        if(isset($data['tags'])) {
                           $product->tags                = json_encode($data['tags']);
                        } else {
                           $product->tags                = NULL;
                        }   
                        $product->rang_price         = $data['rang_price'] ?? '0';	 
        	            $product->original_price         = $data['original_price'];	 
        	            $product->tax                    = $data['h_tax'] ?? '0'; 
        	            $product->product_cost           = $data['product_cost'] ?? '0';	 
                        $product->tax_amount             = $data['tax_amount'] ?? '0';    
                        $product->discounted_price       = $data['discounted_price'] ?? '0';    
        	            $product->service_charge         = $data['service_charge'] ?? '0';	 
        	            $product->tax_type               = $data['tax_type'] ?? '0';	 
        	           // $product->shiping_charge         = $data['shiping_charge'] ?? '0';	
        	           // $product->inter_shiping_charge = $data['inter_shiping_charge'] ?? '0';	
        	            $product->onhand_qty             = $data['onhand_qty'];	 
        	            $product->measurement_unit       = $data['measurement_unit'] ?? '0';	 
        	            $product->features               = $data['features'] ?? null;	 
        	            $product->delivery_text               = $data['delivery_text'] ?? '';	 
        	            $product->instructions               = $data['instructions'] ?? '';	 
        	            $product->disclaimer               = $data['disclaimer'] ?? '';	 
        	            $product->note               = $data['note'] ?? '';	 
        	            $product->shiping_policy         = $data['shiping_policy'] ?? '0';	 
        	            $product->attributes_flag        = $data['attributes_flag'];	 
        	           // $product->offers_flag            = $data['offers_flag'];	 
        	            $product->featuredproduct_flag   = $data['featuredproduct_flag'];	 
        	           // $product->toprated_flag          = $data['toprated_flag'];	 
        	           // $product->best_seller_flag       = $data['best_seller_flag'];	 
                        $product->new_arrival            = $data['new_arrival'];    
        	            $product->delivery               = $data['delivery'] ?? '0';
        	            $product->product_notes   =$data['product_notes'] ?? '';
        	           // if($data['store_name']) {
        	           // 	$product->store              = $data['store_name'] ?? '0';	
        	           // } else {
        	           // 	$product->store              = 0;	
        	           // }

        	            if($log) {
        	            	$product->created_user       = $log->id;	            
        	            } else {
        	            	$product->created_user       = 1;	            
        	            }
        	            $product->is_block               = 1;

        	            $img_files = $request->file('featured_product_img');
                        if(isset($img_files)) {
                            $file_name = $img_files->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/featured_products/'.$date;
                            $file_path = 'images/featured_products/'.$date;
                            $img_files->move($file_path, $file_name);
                            $product->featured_product_img = $date.'/'.$file_name;
                        } else {
                            $product->featured_product_img = NULL;
                        }	 
                        
                        if($product->save()) {
                        	$stock = new StockManagement();
                        	$stock->product_id    =  $product->id; 
                        	$stock->previous_qty  =  0;
                        	$stock->current_qty   =  $product->onhand_qty;
        		            $stock->addon_qty     =  0;
        		            $stock->date          =  date('Y-m-d');
        		            if($log) {
        		            	$stock->created_user = $log->id;	            
        		            } else {
        		            	$stock->created_user =  1;
        		            }
        		            $stock->is_block      =  1;
        		            $stock->save();

        		            if($product->attributes_flag == 1 && !empty($data['att_colors'])) {
        			            if($data['att_colors'] && count($data['att_colors']) != 0) {
        			            	foreach ($data['att_colors'] as $key => $value) {
        			            		$attr = new ProductsAttributes();

        			            		$attr->product_id        = $product->id; 
        			            	// 	$attr->attribute_name = 'color';

        			            	// 	if(isset($data['att_value'][$key])) {
        			            	// 		$attr->attribute_values  = $data['att_value'][$key];	 
        			            	// 	} else {
        			            	// 		$attr->attribute_values  = NULL;	 
        			            	// 	}
        			            		
        			            	

        			            		if(isset($data['v_att_default'][$key])) {
        			            			$attr->att_default  = $data['v_att_default'][$key];	 
        			            		} else {
        			            			$attr->att_default  = 0;	 
        			            		}


        			            		if(isset($data['att_colors'][$key])) {
        			            			$attr->colors = $data['att_colors'][$key];	 
        			            		} else {
        			            			$attr->colors = NULL;	 
        			            		}
        			            		
        			            		if(isset($data['att_colors_name'][$key])) {
        			            			$attr->color_name = $data['att_colors_name'][$key];	 
        			            		} else {
        			            			$attr->color_name = NULL;	 
        			            		}

        			            		if(isset($data['att_qty'][$key])) {
        			            			$attr->att_qty   = $data['att_qty'][$key];	 
        			            		} else {
        			            			$attr->att_qty   = $product->onhand_qty;	 
        			            		}

        			            		if(isset($data['att_image'][$key])) {
        		            				$file_name = $data['att_image'][$key]->getClientOriginalName();
        				                    $date = date('M-Y');
        				                    // $file_path = '../public/images/attributes/'.$date;
        				                    $file_path = 'images/attributes/'.$date;
        				                    $data['att_image'][$key]->move($file_path, $file_name);

        				                    $attr->image       = $date.'/'.$file_name;
        			            		} else {
        				                    $attr->image       = NULL;

        			            		}
        			            		
        			            		if ($product->attributes_flag == 1) {
        			            			$attr->is_block        = 1;
        			            		} else {
        			            			$attr->is_block        = 0;
        			            		}

        	            				$attr->save();

        	            				if($attr && $stock) {
        						            $sub_stock = new SubStock();
        				                	$sub_stock->product_id    =  $product->id; 
        				                	$sub_stock->attribute     =  $attr->id; 
        				                	$sub_stock->stock         =  $stock->id; 
        				                	$sub_stock->current_qty   =  $product->onhand_qty;
        				                	$sub_stock->date          =  date('Y-m-d');
        						            $sub_stock->save();
        					            }
        			            	}
        			            }
        		            }
        		            
        		            if ($product->attributes_flag == 1 && !empty($data['att_name'])) {

                                foreach ($data['att_name'] as $key => $attName) {
                            
                                    if (empty($attName)) {
                                        continue;
                                    }
                            
                                    $attr = new ProductsAttributes();
                                    $attr->product_id        = $product->id;
                                    $attr->attribute_name    = $attName;
                                    $attr->attribute_values  = $data['att_value'][$key] ?? null;
                                    $attr->is_block          = 1;
                                    $attr->save();
                            
                                }
                            }


        		            if(isset($data['p_image']) && count($data['p_image']) != 0) {
        		            	foreach ($data['p_image'] as $key => $file) {
        		            		$p_images = new ProductsImages();

        		            		if(isset($file)) {
        		            			$file_name = $file->getClientOriginalName();
        			                    $date = date('M-Y');
        			                    // $file_path = '../public/images/products/'.$date;
        			                    $file_path = 'images/products/'.$date;
        			                    $file->move($file_path, $file_name);
        			                    $p_images->image       = $date.'/'.$file_name;
        		                    } else {
        			                    $p_images->image       = NULL;
        		                    }

        		            		$p_images->product_id  = $product->id; 
	 
        		            		$p_images->is_block    = 1;

        		            		$p_images->save();
        		            	}
        		            }
        	                
        	                Session::flash('message', 'Product Added Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
        					return redirect()->route('manage_product');
        	            } else{
        	            	Session::flash('message', 'Product Added Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        	                return redirect()->route('manage_product');
        	            }  
                    } else{
                    	Session::flash('message', 'Product Added Failed!'); 
        				Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_product');
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

    public function view ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.view', '=', 1)
                ->first();

            if($privil) {
        		$page = "Products";
        		$product = Products::where('id',$id)->first();
        		return View::make("products.product.view_product")->with(array('product'=>$product, 'page'=>$page));
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Products";
        		$product = Products::where('id',$id)->first();
        		$attributes = AttributesFields::Where('is_block', 1)->get();
                $store = Store::Where('is_block', 1)->get();

                if($loged->user_type == 1) {
                    $store = Store::Where('is_block', 1)->get();
                } elseif ($loged->user_type == 2 || $loged->user_type == 3) {
                    $store = Store::Where('is_block', 1)->Where('merchant', $loged->id)->get();
                }

        		return View::make("products.product.edit_product")->with(array('product'=>$product, 'attributes'=>$attributes, 'store'=>$store, 'page'=>$page));
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Products";
        		$log = session()->get('user');
        		$id = $request->get('product_id');
                $product = '';
                if($id != '') {
                	$product = Products::Where('id', $id)->first();
                }

                if($product) {
        	        $rules = array(
        	            'product_code'         => 'nullable',
        	            'product_title'        => 'required',
        	            'product_desc'         => 'required',
        	            'product_weight'       => 'nullable|numeric',
        	            'product_length'       => 'nullable|numeric',
        	            'product_width'        => 'nullable|numeric',
        	            'product_height'       => 'nullable|numeric',
        	            'brand'                => 'nullable',
        	            'model_no'             => 'nullable',
        	            'varient'              => 'nullable',
        	            // 'vendor_code'          => 'nullable',
        	            'main_cat_name'        => 'required',
        	           // 'sub_cat_name'         => 'nullable',
        	           // 'sub_sub_cat_name'     => 'required',
        	            'manufacturer'         => 'nullable',
        	            'tags'                 => 'nullable',
        	           // 'rang_price'       => 'required|numeric',
                        'original_price'       => 'required|numeric',
                        // 'tax'                  => 'nullable|numeric',
                        // 'product_cost'         => 'nullable|numeric',
                    //     'tax_amount'           => 'nullable|numeric',
                    //     'discounted_price'     => 'required|numeric',
        	           // 'service_charge'       => 'nullable|numeric',
        	            'tax_type'             => 'nullable',
        	           // 'shiping_charge'       => 'nullable|numeric',
        	           // 'inter_shiping_charge'  => 'nullable|numeric',
        	            // 'onhand_qty'           => 'required|integer',
        	            'measurement_unit'     => 'nullable',
        	           // 'features'             => 'required',
        	            'shiping_policy'       => 'nullable',
        	            'attributes_flag'      => 'required',
        	           // 'offers_flag'          => 'required',
        	            'featuredproduct_flag' => 'nullable',
        	           // 'toprated_flag'        => 'required',
        	           // 'best_seller_flag'     => 'required',
                        'new_arrival'          => 'required',
        	            'delivery'             => 'nullable|integer',
        	           // 'store_name'           => 'nullable',
        	            'created_user'         => 'nullable',
        	            'modified_user'        => 'nullable',
        	            'is_block'             => 'nullable',
        	            'featured_product_img' => 'nullable',

        	           // 'attribute_name'       => 'required',
        	           // 'att_value'            => 'required',
        	           // 'att_description'      => 'required',
        	           // 'att_cost'             => 'required',
                    //     'att_tax_amount'       => 'required',
                    //     'att_price'            => 'required',
                        // 'att_colors' => 'required_if:attributes_flag,==,1',
                        
                    // 'att_qty'              => 'required_if:attributes_flag,==,1',
                    // 'att_image'            => 'required_if:attributes_flag,==,1',


        	            // 'v_att_default'        => 'required_if:attributes_flag,==,1',
        	            // 'attribute_name'       => 'required_if:attributes_flag,==,1',
        	            // 'att_value'            => 'required_if:attributes_flag,==,1',
        	            // 'colors'               => 'required_if:attributes_flag,==,1',
        	            // 'sizes'                => 'required_if:attributes_flag,==,1',
        	            // 'capacity'             => 'required_if:attributes_flag,==,1',
        	            // 'att_description'      => 'required_if:attributes_flag,==,1',
        	           // 'att_colors'            => 'required_if:attributes_flag,==,1',
        	           // 'att_image'            => 'required_if:attributes_flag,==,1',		

        	           // 'p_name'               => 'required',
        	            'p_image'              => 'nullable',
        	        );
        	        
        	        $messages = [
        	            'att_image.required_if'=>'Adding Attribute Image is required if setting Attributes to Active',
                        'att_colors.required_if' => 'Adding Color Code is required if setting Attributes to Active',
                        'main_cat_name.required' => 'The main category field is required.',
                    ];
        	        $validator = Validator::make($request->all(), $rules,$messages);

        	        if ($validator->fails()) {
        	        	$attributes = AttributesFields::Where('is_block', 1)->get();
        	        	return Redirect::to('/edit_product/' . $id)->withErrors($validator)->with(array('product'=>$product, 'attributes'=>$attributes, 'page'=>$page));
        	        } else {
        	            $data = $request->all();

// dd($data);
        	       //     if($data['attributes_flag'] == 1 && isset($data['att_qty'])) {
        	       // 		$data['onhand_qty'] = array_sum($data['att_qty']);
        	       // 	}

        	            $product->product_title          = $data['product_title'];	 
        	            $product->product_desc           = $data['product_desc'];
        	           // $product->product_weight         = $data['product_weight'];	 
        	           // $product->product_length         = $data['product_length'];	 
        	           // $product->product_width          = $data['product_width'];	 
        	           // $product->product_height         = $data['product_height'];	 
        	            $product->brand                  = $data['brand'] ?? '0';	 
        	            $product->model_no               = $data['model_no'] ?? '0';	 
        	            $product->varient                = $data['varient'] ?? '0';	
        	            
        	            if(isset($data['main_cat_name']) && $data['main_cat_name']) {
        	               $product->main_cat_name       = $data['main_cat_name'];	 
                        } else {
                           $product->main_cat_name       = NULL;    
                        }

                        if(isset($data['sub_cat_name']) && $data['sub_cat_name']) {
                           $product->sub_cat_name       = $data['sub_cat_name'];   
                        } else {
                           $product->sub_cat_name       = NULL;    
                        }

                        if(isset($data['sub_sub_cat_name']) && $data['sub_sub_cat_name']) {
                           $product->sub_sub_cat_name       = $data['sub_sub_cat_name'];   
                        } else {
                           $product->sub_sub_cat_name       = NULL;    
                        }
        	            	 
        	            $product->manufacturer           = $data['manufacturer'] ?? '0';
                        
                        if(isset($data['tags'])) {
        	               $product->tags                = json_encode($data['tags']);
                        } else {
                           $product->tags                = NULL;
                        }
                        $product->rang_price         = $data['rang_price']?? '0';	 
                        $product->original_price         = $data['original_price'] ?? '0';  
                        $product->tax                    = $data['h_tax'] ?? '0'; 
                        $product->product_cost           = $data['product_cost'] ?? '0';    
                        $product->tax_amount             = $data['tax_amount'] ?? '0';    
                        $product->discounted_price       = $data['discounted_price'] ?? '0';  
        	           // $product->service_charge         = $data['service_charge'] ?? '0';	 
        	            $product->tax_type               = $data['tax_type'] ?? '0';	 
        	           // $product->shiping_charge         = $data['shiping_charge'] ?? '0';
        	           // $product->inter_shiping_charge = $data['inter_shiping_charge'] ?? '0';
        	            $product->onhand_qty             = $data['onhand_qty'] ?? '0';	 
        	            $product->measurement_unit       = $data['measurement_unit'] ?? '0';	 
        	            $product->features               = $data['features'] ?? '0';
        	            $product->delivery_text               = $data['delivery_text'] ?? '';	 
        	            $product->instructions               = $data['instructions'] ?? '';	 
        	            $product->disclaimer               = $data['disclaimer'] ?? '';	 
        	            $product->note               = $data['note'] ?? '';	 
        	            $product->shiping_policy         = $data['shiping_policy'] ?? '0';	 
        	            $product->attributes_flag        = $data['attributes_flag'] ?? '0';	 
        	           // $product->offers_flag            = $data['offers_flag'] ?? '0';	 
        	            $product->featuredproduct_flag   = $data['featuredproduct_flag'] ?? '0';	 
        	           // $product->toprated_flag          = $data['toprated_flag'] ?? '0';	 
        	           // $product->best_seller_flag       = $data['best_seller_flag'] ?? '0';	 
                        $product->new_arrival            = $data['new_arrival'] ?? '0';    
        	            $product->delivery               = $data['delivery'] ?? '0';
        	            $product->product_notes   =$data['product_notes'] ?? '';
        	           // if($data['store_name']) {
        	           // 	$product->store              = $data['store_name'] ?? '0';	
        	           // } else {
        	           // 	$product->store              = 0;	
        	           // }

        	            if($log) {
        	            	$product->modified_user      = $log->id;	            
        	            } else {
        	            	$product->modified_user      = 1;	            
        	            }         
        	           // $product->is_block               = 1;

        	            $img_files = $request->file('featured_product_img');
                        if(isset($img_files)) {
                             $date = date('M-Y');
                            $file_path = 'images/featured_products/'.$date;
                        
                            $extension = $img_files->getClientOriginalExtension();
                            $file_name = uniqid('product_', true) . '.' . $extension;
                        
                            $img_files->move($file_path, $file_name); 
                        
                            $product->featured_product_img = $date.'/'.$file_name;
                        } else if (isset($data['old_featured_product_img'])) {
                            $product->featured_product_img = $data['old_featured_product_img'];
                        } else {
                            $product->featured_product_img = NULL;
                        }	  
                        
                        if($product->save()) {
                        	$stock = StockManagement::Where('product_id', $product->id)->first();
                            if($stock) {
                            	$stock->current_qty   =  $product->onhand_qty;
            		            $stock->save();
                            } else {
                                $stock = new StockManagement();
                                $stock->product_id   =  $product->id;
                                $stock->previous_qty =  0;
                                $stock->current_qty  =  $product->onhand_qty;
                                $stock->addon_qty    =  $product->onhand_qty;
                                $stock->date         =  date('Y-m-d');
                                $stock->created_user =  $log->id;
                                $stock->is_block     =  1;
                                $stock->save();
                            }
        								
                        	if($product->attributes_flag == 1) {
        			            if(!empty($data['att_colors']) && count($data['att_colors']) != 0) {
        			            	ProductsAttributes::where('product_id', $product->id)->delete();
        			            	foreach ($data['att_colors'] as $key => $value) {
        			            		$attr = new ProductsAttributes();

        			            		$attr->product_id        = $product->id; 
        			            	// 	$attr->attribute_name  = $data['att_name'][$key];

        			            	// 	if(isset($data['att_value'][$key])) {
        			            	// 		$attr->attribute_values  = $data['att_value'][$key];	 
        			            	// 	} else {
        			            	// 		$attr->attribute_values  = NULL;	 
        			            	// 	}

        			            		if(isset($data['v_att_default'][$key])) {
        			            			$attr->att_default  = $data['v_att_default'][$key];	 
        			            		} else {
        			            			$attr->att_default  = 2;	 
        			            		}

                                        if(isset($data['att_colors'][$key])) {
                                            $attr->colors = $data['att_colors'][$key];   
                                        } else {
                                            $attr->colors = NULL;  
                                        }
                                        
                                        if(isset($data['att_colors_name'][$key])) {
        			            			$attr->color_name = $data['att_colors_name'][$key];	 
        			            		} else {
        			            			$attr->color_name = NULL;	 
        			            		}

        			            		if(isset($data['att_qty'][$key])) {
        			            			$attr->att_qty  = $data['att_qty'][$key];	 
        			            		} else {
        			            			$attr->att_qty  = $product->onhand_qty;;	 
        			            		}

        			            		if(isset($data['att_image'][$key])) {
        		            				$file_name = $data['att_image'][$key]->getClientOriginalName();
        				                    $date = date('M-Y');
        				                    // $file_path = '../public/images/attributes/'.$date;
        				                    $file_path = 'images/attributes/'.$date;
        				                    $data['att_image'][$key]->move($file_path, $file_name);

        				                    $attr->image       = $date.'/'.$file_name;
        			            		} else if (isset($data['old_att_image'][$key])) {
        				                    $attr->image       = $data['old_att_image'][$key];

        			            		} else {
        				                    $attr->image       = NULL;

        			            		}

        			            		if ($product->attributes_flag == 1) {
        			            			$attr->is_block        = 1;
        			            		} else {
        			            			$attr->is_block        = 0;
        			            		}

        	            				$attr->save();

        	            				if($attr && $stock) {
        	            					// SubStock::where('product_id', $product->id)->delete();
        						            $sub_stock = new SubStock();
        				                	$sub_stock->product_id    =  $product->id; 
        				                	$sub_stock->attribute     =  $attr->id; 
        				                	$sub_stock->stock         =  $stock->id; 
        				                	$sub_stock->current_qty   =  $product->onhand_qty;
        				                	$sub_stock->date          =  date('Y-m-d');
        						            $sub_stock->save();
        					            }
        			            	}
        			            }
        			            
        			             if (!empty($data['att_name'])) {
                                    foreach ($data['att_name'] as $key => $name) {
                            
                                        if (!$name) continue;
                                         $attr = new ProductsAttributes();
                                        $attr->product_id        = $product->id;
                                        $attr->attribute_name    = $name;
                                        $attr->attribute_values  = $data['att_value'][$key] ?? null;
                                        $attr->is_block          = 1;
                                        $attr->save();
                            
                            
                                    }
                                }
                        	} else {
                        		ProductsAttributes::where('product_id', $product->id)->delete();
                        	}

        		            
        		            // If old images exist (edit existing)
                                 if (isset($data['old_p_image']) && count($data['old_p_image']) > 0) {
                                    ProductsImages::where('product_id', $product->id)->delete();
                                    foreach ($data['old_p_image'] as $key => $oldImage) {
                                        if ($oldImage) { 
                                            $p_images = new ProductsImages();
                                            $p_images->image = $oldImage;
                                            $p_images->product_id = $product->id;
                                            $p_images->is_block = 1;
                                            $p_images->save();
                                        }
                                    }
                                }else {
                                    ProductsImages::where('product_id', $product->id)->delete();
                                }
                                
                                // If new images are being added
                                if(isset($data['p_image']) && count($data['p_image']) != 0) {
                                    foreach ($data['p_image'] as $key => $image) {
                                        if ($image) { // Check file exists
                                            $p_images = new ProductsImages();
                                            $file_name = $image->getClientOriginalName();
                                            $date = date('M-Y');
                                            $file_path = 'images/products/'.$date;
                                
                                            // Move file to path
                                            $image->move($file_path, $file_name);
                                
                                            $p_images->image = $date.'/'.$file_name;
                                            $p_images->product_id = $product->id; 	 
                                            $p_images->is_block = 1;
                                            $p_images->save();
                                        }
                                    }
                                }

        	                
        	                Session::flash('message', 'Updated Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
        					return redirect()->route('manage_product');
        	            } else{
        	            	Session::flash('message', 'Updated Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        	                return redirect()->route('manage_product');
        	            }	            
        	        }
                } else {
                	Session::flash('message', 'Updated Failed!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_product');
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$product = Products::where('id',$id)->first();
        				if($product){
        					$p_id = $product->id;
        					if($product->delete()) {
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
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$product = Products::where('id',$value)->first();
        					if($product){
        						$p_id = $product->id;
        						if($product->delete()) {
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

	public function StatusProduct ($id) {
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
                	$product = Products::Where('id', $id)->first();
                }

                if($product) {
                	if($product->is_block == 1) {
                    	$product->is_block        = 0;
                    	$msg = "Blocked Successfully";
                	} else {
                		$product->is_block        = 1;
                    	$msg = "Unblocked Successfully";
                	}
        	        
        	        if($product->save()) {
        	        	Session::flash('message', $msg); 
        				Session::flash('alert-class', 'alert-success');
        				return redirect()->route('manage_product');
        	        } else{
        	        	Session::flash('message', 'Failed Block or Unblock!'); 
        				Session::flash('alert-class', 'alert-danger');
        	            return redirect()->route('manage_product');
        	        }
                } else{
                	Session::flash('message', 'Failed Block or Unblock!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_product');
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

	public function ProductBlock( Request $request) {	
		$ids = array();
		$error = 1;
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
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;

        			if(sizeof($ids) != 0) {
        			    $allAlreadyBlocked = true;
        				foreach ($ids as $key => $value) {
        					$product = Products::where('id',$value)->first();
        					
        					if($product){
        					    if ($product->is_block == 0) {
                                     Session::flash('message', 'Product Already Blocked!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                        // return redirect()->back();
                                } else {
            						$product->is_block = 0;
            						$product->save();
            			                Session::flash('message', 'Product Blocked successfully!');
                                        Session::flash('alert-class', 'alert-success');
                                        $error = 0;
            						
                                }
        					}	else {
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

	public function ProductUnblock( Request $request) {	
		$ids = array();
		$error = 1;

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
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$product = Products::where('id',$value)->first();
        					if($product){
        					     if ($product->is_block == 1) {
                                     Session::flash('message', 'Product Already Unblocked!'); 
                                        Session::flash('alert-class', 'alert-danger');
                                } else {
            						$product->is_block = 1;
            						$product->save();
            						Session::flash('message', 'Product Unblocked Successfully!'); 
            						Session::flash('alert-class', 'alert-success');
            						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'Product Unblocked Failed!'); 
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
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

		echo $error;

	}

	public function SelectSubCat (Request $request) {
		$main_cat = 0;
    	$sub_cat_val = 0;
		if($request->ajax() && isset($request->main_cat)){
			$main_cat = $request->main_cat;

			if(isset($request->sub_cat)) {
				$sub_cat_val = $request->sub_cat;
			}

			$data = "";
			if($main_cat != 0) {
				$sub_cat = SubCategoryManagementSettings::where('main_cat_name',$main_cat)->get();
				if(($sub_cat) && (sizeof($sub_cat) != 0)){
					if($sub_cat_val != 0) {
	                    foreach ($sub_cat as $key => $value) {
	                    	if($sub_cat_val == $value->sub_cat_id) {
	                        	$data.='<option selected value="'.$value->sub_cat_id.'">'.$value->sub_cat_name.'</option>';
	                    	} else {
	                        	$data.='<option value="'.$value->sub_cat_id.'">'.$value->sub_cat_name.'</option>';
	                    	}
	                    }
					} else {
						$data = '<option value="" selected>Select Sub Category Name</option>';
	                    foreach ($sub_cat as $key => $value) {
	                        $data.='<option value="'.$value->sub_cat_id.'">'.$value->sub_cat_name.'</option>';
	                    }
					}
                } 			
			}
			echo $data;
		}
    }

    public function SelectSubSubCat (Request $request) {
		$sub_cat = 0;
    	$sub_sub_cat_val = 0;
		if($request->ajax() && isset($request->sub_cat)){
			$sub_cat = $request->sub_cat;

			if(isset($request->sub_sub_cat)) {
				$sub_sub_cat_val = $request->sub_sub_cat;
			}

			$data = "";
			if($sub_cat != 0) {
				$sub_sub_cat = SubSubCategoryManagementSettings::where('sub_cat_name',$sub_cat)->get();
				if(($sub_sub_cat) && (sizeof($sub_sub_cat) != 0)){
					if($sub_sub_cat_val != 0) {
	                    foreach ($sub_sub_cat as $key => $value) {
	                    	if($sub_sub_cat_val == $value->sub_sub_cat_id) {
	                        	$data.='<option selected value="'.$value->sub_sub_cat_id.'">'.$value->sub_sub_cat_name.'</option>';
	                    	} else {
	                        	$data.='<option value="'.$value->sub_sub_cat_id.'">'.$value->sub_sub_cat_name.'</option>';
	                    	}
	                    }
					} else {
						$data = '<option value="" selected>Select Sub Category Name</option>';
	                    foreach ($sub_sub_cat as $key => $value) {
	                        $data.='<option value="'.$value->sub_sub_cat_id.'">'.$value->sub_sub_cat_name.'</option>';
	                    }
					}
                } 			
			}
			echo $data;
		}
    }

    public function SelectAttVals (Request $request) {
		$id = 0;
		$old_id = 0;
		$product_id = 0;
		if($request->ajax() && isset($request->id)){
			$id = $request->id;
			if(isset($request->old_id) && ($request->old_id)) {
				$old_id = $request->old_id;
			}

			if(isset($request->product_id) && ($request->product_id)) {
				$product_id = $request->product_id;
			}

			$data = 0;
			$att_id = [];
			if($id != 0) {
				if($product_id) {
					$pro_att = ProductsAttributes::where('product_id', $product_id)->where('attribute_name', $id)->Where('is_block', 1)->get();
					if(sizeof($pro_att) != 0) {
		                foreach ($pro_att as $key => $value) {
		                    array_push($att_id, $value->attribute_values);                   
		                }
		            }

		            if(sizeof($att_id) != 0) {
		                $attributes = AttributesSettings::WhereIn('id', $att_id)->Where('is_block' ,1)->get();
		                if(isset($attributes) && (sizeof($attributes) != 0)){
		                	if($old_id != 0) {
								$data = '<option value="">Select Attributes Value</option>';
			                    foreach ($attributes as $key => $value) {
			                    	if($old_id == $value->id) {
			                        	$data.='<option value="'.$value->id.'" selected>'.$value->att_value.'</option>';
			                    	} else {
			                        	$data.='<option value="'.$value->id.'">'.$value->att_value.'</option>';
			                    	}
			                    }
							} else {
								$data = '<option value="" selected>Select Attributes Value</option>';
			                    foreach ($attributes as $key => $value) {
			                        $data.='<option value="'.$value->id.'">'.$value->att_value.'</option>';
			                    }
							}
		                } 
		            }
				} else {
					$attributes = AttributesSettings::where('att_name',$id)->Where('is_block' ,1)->get();
					if(isset($attributes) && (sizeof($attributes) != 0)){
						if($old_id != 0) {
							$data = '<option value="">Select Attributes Value</option>';
		                    foreach ($attributes as $key => $value) {
		                    	if($old_id == $value->id) {
		                        	$data.='<option value="'.$value->id.'" selected>'.$value->att_value.'</option>';
		                    	} else {
		                        	$data.='<option value="'.$value->id.'">'.$value->att_value.'</option>';
		                    	}
		                    }
						} else {
							$data = '<option value="" selected>Select Attributes Value</option>';
		                    foreach ($attributes as $key => $value) {
		                        $data.='<option value="'.$value->id.'">'.$value->att_value.'</option>';
		                    }
						}
	                } 			
				}
			}
			echo $data;
		}
    }

	public function GetTax( Request $request) {	
		$main_cat = "";

		if($request->ajax() && isset($request->main_cat)){
			$main_cat = $request->main_cat;
			$error = 'error';
			$tax = TaxManagement::Where('main_cat_name', $main_cat)->Where('is_block', 1)->first();
			if($tax) {
				$error = $tax->tax;
				Session::flash('message', 'Get Tax Successfully!'); 
				Session::flash('alert-class', 'alert-success');
			} else {
				Session::flash('message', 'Get Tax Failed!'); 
				Session::flash('alert-class', 'alert-danger');
				$error = 'error';
			}
		}
		echo $error;
	}	

    public function SearchProducts (Request $request) {
        $page = "Products";                                               
        $gj_srh_pdts = $request->get('gj_srh_pdts');

        if($gj_srh_pdts) {
            $page = "Products";
            $log = session()->get('user');
            if($log) {
                if($log->user_type == 1 || $log->user_type == 2 ) {
                    $category=CategoryManagementSettings::Where('is_block', 1)->get();
                    $product = Products::Orderby('id', 'desc')->orWhere('product_title', 'like', '%' . $gj_srh_pdts . '%')->get();
                    if(sizeof($product) == 0) {
                        Session::flash('message', 'Search Items Not Found!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_product');
                    } else {
                        Session::flash('message', 'Search Items Founded!'); 
                        Session::flash('alert-class', 'alert-success');
                        return View::make("products.product.manage_product")->with(array('product'=>$product, 'page'=>$page,'category'=>$category));
                    }
                } elseif ($log->user_type == 3) {
                    $category=CategoryManagementSettings::Where('is_block', 1)->all();
                    $product = Products::Where('created_user',$log->id)->orWhere('product_title', 'like', '%' . $gj_srh_pdts . '%')->paginate(10);
                    if(sizeof($product) == 0) {
                        Session::flash('message', 'Search Items Not Found!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_product');
                    } else {
                        Session::flash('message', 'Search Items Founded!'); 
                        Session::flash('alert-class', 'alert-success');
                        return View::make("products.product.manage_product")->with(array('product'=>$product, 'page'=>$page,'category'=>$category));
                    }
                }
            } else {
                Session::flash('message', 'You Are Not Login!'); 
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('admin');
            }
        } else {
            Session::flash('message', 'Search Items Not Found!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('manage_product');
        }
    }
	
	public function ExportCSV( Request $request) {
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Products')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.export', '=', 1)
                ->first();

            if($privil) {	
        		if($request->ajax()) {
        		    $selectedColumns = $request->columns ?? [];
        		    $columnMap = [
                        0 => ['label' => 'S.No', 'value' => function ($row, $i) { return $i + 1; }],
                        1 => ['label' => '#', 'value' => function ($row) { return $row->id; }],
                        2 => ['label' => 'Product Code', 'value' => function ($row) { return $row->product_code; }],
                        3 => ['label' => 'Product Title', 'value' => function ($row) { return $row->product_title; }],
                        4 => ['label' => 'Main Category', 'value' => function ($row) { return $row['main_cat_name'] ?? '---------'; }],
                        5 => ['label' => 'Stock Quantity', 'value' => function ($row) { return $row->onhand_qty; }],
                        6 => ['label' => 'Rang Price', 'value' => function ($row) { return "Rs. " . $row->rang_price; }],
                        7 => ['label' => 'Selling Price', 'value' => function ($row) { return "Rs. " . $row->original_price; }],
                        8 => ['label' => 'Discount Selling Price', 'value' => function ($row) { return "Rs. " . $row->discounted_price; }],
                        9 => ['label' => 'Tax Amount', 'value' => function ($row) { return $row->tax_amount; }],
                        10 => ['label' => 'Final Selling Price', 'value' => function ($row) { return $row->product_cost ?? '0'; }],
                      
                        11 => ['label' => 'Product Image', 'value' => function ($row) { return $row->image ?? 'N/A'; }],
                       
                    ];

        			$ids = $request->ids;
        			$table = array();
        			$filename = "products.csv";
        			if(isset($ids) && $ids) {
        				if(sizeof($ids) != 0) {
        				     if (!empty($request->category_id)) {
                                $table = Products::whereIn('id',$ids)->where('main_cat_name', $request->category_id)->get();
                                $filename = "products.csv";
                            } else {
                                $table = Products::whereIn('id',$ids)->get();
                               $filename = "products.csv";
                            }
                            // $table = Products::whereIn('id',$ids)->get();
                            // $filename = "products.csv";
                        }  else {
                            Session::flash('message', 'CSV Export Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            die();
                        }
        			} else if(isset($request->type) && $request->type == 'export_all') {
        			    if (!empty($request->category_id)) {
                            $table = Products::where('main_cat_name', $request->category_id)->get();
                            $filename = "all_products.csv";
                        } else {
                            $table = Products::all();
                            $filename = "all_products.csv";
                        }
        				// $table = Products::all();
        				// $filename = "all_products.csv";
        			} else {
        				Session::flash('message', 'CSV Export Failed!'); 
        				Session::flash('alert-class', 'alert-danger');
        				die();
        			}

        			foreach ($table as $key => $value) {
        				if($value->main_cat_name) {
        					$table[$key]['main_cat_name'] = $value->MainCat->main_cat_name;
        				} else {
        					$table[$key]['main_cat_name'] = "---------";
        				}

        				if($value->sub_cat_name) {
        					$table[$key]['sub_cat_name'] = $value->SubCat->sub_cat_name;
        				} else {
        					$table[$key]['sub_cat_name'] = "---------";
        				}	

        				if($value->sub_sub_cat_name) {
        					$table[$key]['sub_sub_cat_name'] = $value->SubSubCat->sub_sub_cat_name;
        				} else {
        					$table[$key]['sub_sub_cat_name'] = "---------";
        				}

        				if($value->offers_flag == 1) {
        					$table[$key]['offers_flag'] = "Yes";
        				} else {
        					$table[$key]['offers_flag'] = "No";
        				}

        				if($value->featuredproduct_flag == 1) {
        					$table[$key]['featuredproduct_flag'] = "Yes";
        				} else {
        					$table[$key]['featuredproduct_flag'] = "No";
        				}

        				if($value->toprated_flag == 1) {
        					$table[$key]['toprated_flag'] = "Yes";
        				} else {
        					$table[$key]['toprated_flag'] = "No";
        				}	

        				if($value->delivery) {
        					$table[$key]['delivery'] = $value->delivery." Days";
        				} else {
        					$table[$key]['delivery'] = "---------";
        				}

        				if($value->store) {
        					$table[$key]['store'] = $value->Store->store_name;
        				} else {
        					$table[$key]['store'] = "---------";
        				}

        				if($value->created_user) {
        					$table[$key]['created_user'] = $value->Creatier->first_name.' '.$value->Creatier->last_name;
        				} else {
        					$table[$key]['created_user'] = "---------";
        				}

        				if($value->modified_user) {
        					$table[$key]['modified_user'] = $value->Modifier->first_name.' '.$value->Modifier->last_name;
        				} else {
        					$table[$key]['modified_user'] = "---------";
        				}

        				if($value->is_block == 1) {
        					$table[$key]['is_block'] = "Active";
        				} else {
        					$table[$key]['is_block'] = "---------";
        				}	 	
        			}
        	    	
        		    $handle = fopen($filename, 'w+');
        		    $csvHeader = [];
                    foreach ($selectedColumns as $colIndex) {
                        if (isset($columnMap[$colIndex])) {
                            $csvHeader[] = $columnMap[$colIndex]['label'];
                        }
                    }
                    fputcsv($handle, $csvHeader);
                    
        		    foreach ($table as $i => $row) {
                        $csvRow = [];
                        foreach ($selectedColumns as $colIndex) {
                            if (isset($columnMap[$colIndex])) {
                                $csvRow[] = $columnMap[$colIndex]['value']($row, $i);
                            }
                        }
                        fputcsv($handle, $csvRow);
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
	
	public function showBulkUploadForm()
    {
        return view('products.product.bulk_upload');
    }
    
    public function downloadTemplate()
    {
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=product_template.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];
    
        $columns = [
            'product_title',
            'product_desc',
            'main_cat_name',
            'sub_cat_name',
            'product_notes',
            'rang_price',
            'original_price',
            'h_tax',
            'product_cost',
            'tax_amount',
            'discounted_price',
            'onhand_qty',
            'features',
            'featuredproduct_flag',
            'new_arrival',
            'delivery_text',
            'instructions',
            'disclaimer',
            'note'
        ];
        $friendlyNames = [
            'Product Title',
            'Product Description',
            'Main Category Name',
            'Sub Category Name',
            'Product Notes',
            'Rang Price',
            'Selling Price',
            'Tax Percentage',
            'Final Selling Price',
            'Tax Amount',
            'Discount Selling Price',
            'On-Hand Quantity',
            'Features',
            'Featured Product (Yes/No)',
            'New Arrival (Yes/No)',
            'Delivery',
            'Care Instructions',
            'Disclaimer',
            'Note'
        ];
    
        $callback = function () use ($columns, $friendlyNames) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);       // Row 1 - technical names
        fputcsv($file, $friendlyNames); // Row 2 - friendly display names
        fclose($file);
    };
    
        return Response::stream($callback, 200, $headers);
    }

	public function handleBulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
    
        try {
        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        $header = array_map('trim', $csvData[0]);
       $csvData = array_slice($csvData, 2);
    
        foreach ($csvData as $row) {
            $rowData = array_combine($header, $row);
    
            $category = CategoryManagementSettings::where('main_cat_name', trim($rowData['main_cat_name']))->first();
            $category_id = $category ? $category->id : null;
            
            // Lookup subcategory ID from name
            $subcategory = SubCategoryManagementSettings::where('sub_cat_name', trim($rowData['sub_cat_name']))->first();
            $subcategory_id = $subcategory ? $subcategory->id : null;
    
    
            $max = Products::max('product_code');
            $max_id = "0001";
            $max_st = "pr";
            if ($max) {
                $max_no = substr($max, 2);
                $increment = (int)$max_no + 1;
                $product_code = $max_st . sprintf("%04d", $increment);
            } else {
                $product_code = $max_st . $max_id;
            }
    
            $product = new Products();
            $product->product_code = $product_code;
            $product->product_title = $rowData['product_title'] ?? '';
            $product->product_desc = $rowData['product_desc'] ?? '';
            $product->brand = $rowData['brand'] ?? '0';
            $product->model_no = $rowData['model_no'] ?? '0';
            $product->varient = $rowData['varient'] ?? '0';
            $product->main_cat_name = $rowData['main_cat_name'] ?? null;
            $product->sub_cat_name = $rowData['sub_cat_name'] ?? null;
            $product->product_notes = $rowData['product_notes'] ?? null;
            $product->manufacturer = $rowData['manufacturer'] ?? '0';
            $product->tags = isset($rowData['tags']) ? json_encode(explode('|', $rowData['tags'])) : null;
            $product->rang_price = $rowData['rang_price'] ?? '0';
            $product->original_price = $rowData['original_price'] ?? '0';
            $product->tax = $rowData['h_tax'] ?? '0';
            $product->product_cost = $rowData['product_cost'] ?? '0';
            $product->tax_amount = $rowData['tax_amount'] ?? '0';
            $product->discounted_price = $rowData['discounted_price'] ?? '0';
            $product->service_charge = $rowData['service_charge'] ?? '0';
            $product->tax_type = $rowData['tax_type'] ?? '0';
            $product->shiping_charge = $rowData['shiping_charge'] ?? '0';
            $product->onhand_qty = $rowData['onhand_qty'] ?? 0;
            $product->measurement_unit = $rowData['measurement_unit'] ?? '0';
            $product->features = $rowData['features'] ?? '';
            $product->shiping_policy = $rowData['shiping_policy'] ?? '0';
            $product->attributes_flag = $rowData['attributes_flag'] ?? 0;
            $product->featuredproduct_flag = $rowData['featuredproduct_flag'] ?? 0;
            $product->new_arrival = $rowData['new_arrival'] ?? 0;
            $product->delivery = $rowData['delivery'] ?? '0';
            $product->delivery_text = $rowData['delivery_text'] ?? '';
            $product->disclaimer = $rowData['disclaimer'] ?? '';
            $product->note = $rowData['note'] ?? '';
            $product->instructions = $rowData['instructions'] ?? '';
            $product->created_user = auth()->id() ?? 1;
            $product->is_block = 0;
    
            $product->save();
    
            // Stock Management
            $stock = new StockManagement();
            $stock->product_id = $product->id;
            $stock->previous_qty = 0;
            $stock->current_qty = $product->onhand_qty;
            $stock->addon_qty = 0;
            $stock->date = now();
            $stock->created_user = auth()->id() ?? 1;
            $stock->is_block = 1;
            $stock->save();
        }
        
     Session::flash('message', 'Product uploaded Successfully!'); 
		Session::flash('alert-class', 'alert-success');
		return redirect()->route('manage_product');
		
        } catch (\Exception $e) {
        // Catch any other errors
        Session::flash('message', 'Upload failed: '.$e->getMessage());
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
    }
    
    }

	
}