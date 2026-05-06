<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryManagementSettings;
use App\SubCategoryManagementSettings;
use App\BannerImageSettings;
use App\GeneralAttributes;
use App\AttributesSettings;
use App\AttributesFields;
use App\ProductsAttributes;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class CategoryManagementSettingsController extends Controller
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $main = CategoryManagementSettings::all();
                if($main) {
                    foreach ($main as $key => $value) {
                        $sub = SubCategoryManagementSettings::where('main_cat_name',$value->id)->get();
                        $cnt_sub = count($sub);
                        $main[$key]['sub'] = $cnt_sub;     
                    }       
                }
                return View::make("settings.category_management.manage_category")->with(array('main'=>$main, 'page'=>$page));
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";  
                $attributes = AttributesFields::Where('is_block', 1)->get();

                return View::make('settings.category_management.add_category')->with(array('page'=>$page, 'attributes'=>$attributes));
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $rules = array(
                    'main_cat_name'    => 'required',
                    'main_cat_image'   => 'required',
                    // 'main_cat_icon'    => 'required',
                    'is_top_cat'       => 'required',
                    // 'priority'         => 'nullable',
                    'is_block'         => 'required',
                );

                $messages=[
                    'main_cat_name.required'=>'The main category name field is required.',
                    'main_cat_image.required'=>'The main category Image field is required.',
                    // 'main_cat_icon.required'=>'The main category Icon field is required.',
                ];
                $validator = Validator::make($request->all(), $rules,$messages);

                if ($validator->fails()) {
                    $attributes = AttributesFields::Where('is_block', 1)->get();
                    return View::make('settings.category_management.add_category')->withErrors($validator)->with(array('page'=>$page, 'attributes'=>$attributes));
                } else {
                    $data = $request->all();
                    
                    $main = new CategoryManagementSettings();

                    if($main) {
                        $main->main_cat_name    = $data['main_cat_name']; 
                        
                        $main->main_cat_desc    = $data['main_cat_desc'];  

                        $img_files = $request->file('main_cat_image');
                        if(isset($img_files)) {
                            $file_name = $img_files->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/main_cat_image/'.$date;
                            $file_path = 'images/main_cat_image/'.$date;
                            $img_files->move($file_path, $file_name);
                            $main->main_cat_image = $date.'/'.$file_name;
                        } else {
                            $main->main_cat_image = NULL;
                        }

                        // $main->main_cat_icon  = $data['main_cat_icon'];
                        $main->is_block       = $data['is_block'];
                        $main->is_top_cat     = $data['is_top_cat'];

                        // if(isset($data['priority']) && $data['priority']) {
                        //     $main->priority       = $data['priority'];
                        // } else {
                        //     $main->priority       = 0;
                        // }

                        $main->is_home        = 0;
                        
                        if($main->save()) {
                            // if($data['attribute_name'] && count($data['attribute_name']) != 0) {
                            //     foreach ($data['attribute_name'] as $key => $value) {
                            //         if(isset($data['att_value'][$key]) && $data['att_value'][$key] == "All") {
                            //             $attributes = AttributesSettings::where('att_name',$value)->Where('is_block' ,1)->get();
                            //             if(sizeof($attributes) != 0) {
                            //                 foreach ($attributes as $akey => $avalue) {
                            //                     $attr = new GeneralAttributes();

                            //                     $attr->category_id  = $main->id; 
                            //                     $attr->att_name  = $value;
                            //                     $attr->att_value  = $avalue->id; 
                            //                     $attr->save();
                            //                 }
                            //             } else {
                            //                 $attr = new GeneralAttributes();

                            //                 $attr->category_id        = $main->id; 
                            //                 $attr->att_name  = $value;
                            //                 $attr->att_value  = NULL; 
                            //                 $attr->save();
                            //             }                                            
                            //         } else if(isset($data['att_value'][$key]) && $data['att_value'][$key]) {
                            //             $attr = new GeneralAttributes();

                            //             $attr->category_id        = $main->id; 
                            //             $attr->att_name  = $value;
                            //             $attr->att_value  = $data['att_value'][$key];     
                            //             $attr->save();
                            //         } else {
                            //             $attr = new GeneralAttributes();

                            //             $attr->category_id        = $main->id; 
                            //             $attr->att_name  = $value;
                            //             $attr->att_value  = NULL; 
                            //             $attr->save();
                            //         }
                            //     }
                            // }

                            Session::flash('message', 'Added Category  Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_category');
                        } else{
                            Session::flash('message', 'Added Category  Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_category');
                        }
                    } else{
                        Session::flash('message', 'Added Category Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_category');
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $attributes = AttributesFields::Where('is_block', 1)->get();
                $main = CategoryManagementSettings::where('id',$id)->first();
                if($main) {
                    return View::make("settings.category_management.edit_category")->with(array('main'=>$main, 'page'=>$page, 'attributes'=>$attributes));
                } else {
                    Session::flash('message', 'Edit Not Possible!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_category'); 
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $id =$request->get('mc_id');
                $main = '';
                if($id != '') {
                    $main = CategoryManagementSettings::Where('id', $id)->first();
                }

                if($main) {
                    $rules = array(
                        'main_cat_name'    => 'required',
                        'main_cat_image'   => 'nullable',
                        // 'main_cat_icon'    => 'required',
                        'is_block'         => 'required',
                        'is_top_cat'       => 'required',
                        // 'priority'         => 'nullable',
                    );

                    $messages=[
                        'main_cat_name.required'=>'The main category name field is required.',
                        // 'main_cat_icon.required'=>'The main category icon field is required.',
                    ];
                    $validator = Validator::make($request->all(), $rules,$messages);

                    if ($validator->fails()) {
                        return Redirect::to('/edit_category/' . $id)->withErrors($validator)->withErrors($validator)->with(array('main'=>$main, 'page'=>$page));
                    } else {
                        $data =$request->all();
                        
                        $main->main_cat_name    = $data['main_cat_name'];  
                        $main->main_cat_desc    = $data['main_cat_desc'];  

                        $img_files = $request->file('main_cat_image');
                        $old_main_cat_image = $request->get('old_main_cat_image');
                        if(isset($img_files)) {
                            $file_name = $img_files->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/main_cat_image/'.$date;
                            $file_path = 'images/main_cat_image/'.$date;
                            $img_files->move($file_path, $file_name);
                            $main->main_cat_image = $date.'/'.$file_name;
                        } 
                        // else if(isset($old_main_cat_image) && $old_main_cat_image != '') {
                        //     $main->main_cat_image = $old_main_cat_image;
                        // }
                        else {
                            $main->main_cat_image = $old_main_cat_image;
                        }

                        // $main->main_cat_icon  = $data['main_cat_icon'];
                        $main->is_block       = $data['is_block'];

                         $main->is_top_cat     = $data['is_top_cat'];

                        // if(isset($data['priority']) && $data['priority']) {
                        //     $main->priority       = $data['priority'];
                        // } else {
                        //     $main->priority       = 0;
                        // }
                        
                        if($main->save()) {
                            // if($data['attribute_name'] && count($data['attribute_name']) != 0) {
                            //     GeneralAttributes::Where('category_id', $main->id)->delete();
                            //     foreach ($data['attribute_name'] as $key => $value) {
                            //         if(isset($data['att_value'][$key]) && $data['att_value'][$key] == "All") {
                            //             $attributes = AttributesSettings::where('att_name',$value)->Where('is_block' ,1)->get();
                            //             if(sizeof($attributes) != 0) {
                            //                 foreach ($attributes as $akey => $avalue) {
                            //                     $attr = new GeneralAttributes();

                            //                     $attr->category_id  = $main->id; 
                            //                     $attr->att_name  = $value;
                            //                     $attr->att_value  = $avalue->id; 
                            //                     $attr->save();
                            //                 }
                            //             } else {
                            //                 $attr = new GeneralAttributes();

                            //                 $attr->category_id        = $main->id; 
                            //                 $attr->att_name  = $value;
                            //                 $attr->att_value  = NULL; 
                            //                 $attr->save();
                            //             }                                            
                            //         } else if(isset($data['att_value'][$key]) && $data['att_value'][$key]) {
                            //             $attr = new GeneralAttributes();

                            //             $attr->category_id        = $main->id; 
                            //             $attr->att_name  = $value;
                            //             $attr->att_value  = $data['att_value'][$key];     
                            //             $attr->save();
                            //         } else {
                            //             $attr = new GeneralAttributes();

                            //             $attr->category_id        = $main->id; 
                            //             $attr->att_name  = $value;
                            //             $attr->att_value  = NULL; 
                            //             $attr->save();
                            //         }
                            //     }
                            // }

                            Session::flash('message', 'Updated Category Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_category');
                        } else{
                            Session::flash('message', 'Update Category Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_category');
                        }
                    }
                } else{
                    Session::flash('message', 'Update Category Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_category');
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

    public function StatusMainCategory ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                $main = '';
                $msg = '';
                if($id != '') {
                    $main = CategoryManagementSettings::Where('id', $id)->first();
                }

                if($main) {
                    if($main->is_block == 1) {
                        $main->is_block        = 0;
                        $msg = "Category Blocked Successfully";
                    } else {
                        $main->is_block        = 1;
                        $msg = "Category Unblocked Successfully";
                    }
                    
                    if($main->save()) {
                        Session::flash('message', $msg); 
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('manage_category');
                    } else{
                        Session::flash('message', 'Failed Block or Unblock!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_category');
                    }
                } else{
                    Session::flash('message', 'Failed Block or Unblock!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_category');
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

    public function MainCategoryBlock( Request $request) {  
        $ids = array();
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    if(sizeof($ids) != 0) {
                        foreach ($ids as $key => $value) {
                            $main = CategoryManagementSettings::where('id',$value)->first();
                            if($main){
                                 if ($main->is_block == 0) {
        					        Session::flash('message', 'Category Already Blocked'); 
            						Session::flash('alert-class', 'alert-danger');
            						$error = 0;
                                } else {
                                $main->is_block = 0;
                                $main->save();
                                Session::flash('message', 'Category Blocked Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                                }
                            }   else {
                                Session::flash('message', 'Category Blocked Failed!'); 
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

    public function MainCategoryUnblock( Request $request) {   
        $ids = array();
        $error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
                if($request->ajax() && isset($request->ids)){
                    $ids = $request->ids;
                    if(sizeof($ids) != 0) {
                        foreach ($ids as $key => $value) {
                            $main = CategoryManagementSettings::where('id',$value)->first();
                            if($main){
                                 if ($main->is_block == 1) {
        					        Session::flash('message', 'Category Already Unblocked'); 
            						Session::flash('alert-class', 'alert-danger');
            						$error = 0;
                                } else {
                                $main->is_block = 1;
                                $main->save();
                                Session::flash('message', 'Category Unblocked Successfully!'); 
                                Session::flash('alert-class', 'alert-success');
                                $error = 0;
                                }
                            }   else {
                                Session::flash('message', 'Category Unblocked Failed!'); 
                                Session::flash('alert-class', 'alert-danger');
                            }           
                        }
                    } else {
                        Session::flash('message', 'Category Unblocked Failed!'); 
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

    public function HomeView( Request $request) {   
        $id = 0;
        $is_home = 0;

        if($request->ajax() && isset($request->is_home) && isset($request->id)){
            $is_home = $request->is_home;
            $id = $request->id;
            $error = 1;
            
            $affected = DB::table('category_management_settings')->where('is_home', '=', $is_home)->update(array('is_home' => 0));

            $main = CategoryManagementSettings::where('id',$id)->first();
            if($main){
                $main->is_home = $is_home;
                $main->save();
                Session::flash('message', 'Home Page View Set Successfully!'); 
                Session::flash('alert-class', 'alert-success');
                $error = 0;
            }   else {
                Session::flash('message', 'Home Page View Set Failed!'); 
                Session::flash('alert-class', 'alert-danger');
            }

            echo $error;
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
                ->where('B.module_name', '=', 'Product Main Category')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$cat_bans = CategoryManagementSettings::where('id',$id)->first();
        				if($cat_bans){
        					if($cat_bans->delete()) {
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
                            $data = '<option value="">Select Attributes Value</option><option value="All">All</option>';
                            foreach ($attributes as $key => $value) {
                                if($old_id == $value->id) {
                                    $data.='<option value="'.$value->id.'" selected>'.$value->att_value.'</option>';
                                } else {
                                    $data.='<option value="'.$value->id.'">'.$value->att_value.'</option>';
                                }
                            }
                        } else {
                            $data = '<option value="">Select Attributes Value</option><option value="All">All</option>';
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
}
