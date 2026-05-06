<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellOnFolkgemsPage;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class SellOnFolkgemsPagesController extends Controller
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
                ->where('B.module_name', '=', 'Sell On Folkgems Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $sofp = SellOnFolkgemsPage::all();

                if (sizeof($sofp) != 0) {
                	return response()->json(array('status_code'=>'1','response_msg'=>'Sell On Folkgems Page Deatils','response_data'=>array('data'=>$sofp,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No Sell On Folkgems Page Deatils'), 200);
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
                ->where('B.module_name', '=', 'Sell On Folkgems Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                           
            	$sofp = SellOnFolkgemsPage::first();
            	if($sofp) {
                	return View::make("settings.sofp_setting")->with(array('sofp'=>$sofp,'page'=>$page));
            	} else {
                	return View::make('settings.sofp_setting');
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
                ->where('B.module_name', '=', 'Sell On Folkgems Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->orwhere('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$sofp = SellOnFolkgemsPage::first();
            	if($sofp) {
        	        $rules = array(
        	            'banner_caption'         => 'nullable',
                        'title'       => 'required',
                        'desc'       => 'required',
                        'sell_content1'          => 'required',
                        'sell_content2'          => 'required',
                        'button_text'        => 'required',
                        'button_url'        => 'required',
                        'next_main_hd'        => 'required',
                        'banner_image'        => 'nullable',
                        'sell_bg'        => 'nullable',

                        'why_sell_hd'        => 'required',
                        'why_sell_desc'        => 'required',
                        'why_img_1'        => 'nullable',
                        'why_title_1'        => 'required',
                        'why_content_1'        => 'required',
                        'why_link_text_1'        => 'required',
                        'why_link_1'        => 'required',
                        'why_img_2'        => 'nullable',
                        'why_title_2'        => 'required',
                        'why_content_2'        => 'required',
                        'why_link_text_2'        => 'required',
                        'why_link_2'        => 'required',
                        'why_img_3'        => 'nullable',
                        'why_title_3'        => 'required',
                        'why_content_3'        => 'required',
                        'why_link_text_3'        => 'required',
                        'why_link_3'        => 'required',
                        'how_it_hd'        => 'required',
                        'how_it_desc'        => 'required',
                        'how_title_1'        => 'required',
                        'how_content_1'        => 'required',
                        'how_img_1'        => 'nullable',
                        'how_title_2'        => 'required',
                        'how_content_2'        => 'required',
                        'how_img_2'        => 'nullable',
                        'how_title_3'        => 'required',
                        'how_content_3'        => 'required',
                        'how_img_3'        => 'nullable',
                        'how_title_4'        => 'required',
                        'how_content_4'        => 'required',
                        'how_img_4'        => 'nullable',
                        'start_sell_bg'        => 'nullable',
                        'start_sell_content'        => 'required',
                        'start_sell_link_text'        => 'required',
                        'start_sell_link'        => 'required',
        	        );
                } else {
                	$rules = array(
        	            'banner_caption'         => 'nullable',
        	            'title'       => 'required',
                        'desc'       => 'required',
        	            'sell_content1'          => 'required',
                        'sell_content2'          => 'required',
        	            'button_text'        => 'required',
                        'button_url'        => 'required',
                        'next_main_hd'        => 'required',
                        'banner_image'        => 'required',
                        'sell_bg'        => 'required',

                        'why_sell_hd'        => 'required',
                        'why_sell_desc'        => 'required',
                        'why_img_1'        => 'required',
                        'why_title_1'        => 'required',
                        'why_content_1'        => 'required',
                        'why_link_text_1'        => 'required',
                        'why_link_1'        => 'required',
                        'why_img_2'        => 'required',
                        'why_title_2'        => 'required',
                        'why_content_2'        => 'required',
                        'why_link_text_2'        => 'required',
                        'why_link_2'        => 'required',
                        'why_img_3'        => 'required',
                        'why_title_3'        => 'required',
                        'why_content_3'        => 'required',
                        'why_link_text_3'        => 'required',
                        'why_link_3'        => 'required',
                        'how_it_hd'        => 'required',
                        'how_it_desc'        => 'required',
                        'how_title_1'        => 'required',
                        'how_content_1'        => 'required',
                        'how_img_1'        => 'required',
                        'how_title_2'        => 'required',
                        'how_content_2'        => 'required',
                        'how_img_2'        => 'required',
                        'how_title_3'        => 'required',
                        'how_content_3'        => 'required',
                        'how_img_3'        => 'required',
                        'how_title_4'        => 'required',
                        'how_content_4'        => 'required',
                        'how_img_4'        => 'required',
                        'start_sell_bg'        => 'required',
                        'start_sell_content'        => 'required',
                        'start_sell_link_text'        => 'required',
                        'start_sell_link'        => 'required',
        	        );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($sofp) {
                        return View::make("settings.sofp_setting")->withErrors($validator)->with(array('sofp'=>$sofp,'page'=>$page));
                    } else {
                	   return View::make('settings.sofp_setting')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('id');
                    $sofp = '';
                    if($id != '') {
                    	$sofp = SellOnFolkgemsPage::Where('id', $id)->first();
                    } else {
                    	$sofp = new SellOnFolkgemsPage();
                    }

                    if($sofp) {
        	            $sofp->banner_caption    = $data['banner_caption'];
        	            $sofp->title      = $data['title'];
                        $sofp->desc      = $data['desc'];
        	            $sofp->sell_content1      = $data['sell_content1'];
                        $sofp->sell_content2      = $data['sell_content2'];
        	            $sofp->button_text      = $data['button_text'];
                        $sofp->button_url      = $data['button_url'];
                        $sofp->next_main_hd      = $data['next_main_hd'];

                        $sofp->why_sell_hd      = $data['why_sell_hd'];
                        $sofp->why_sell_desc      = $data['why_sell_desc'];
                        $sofp->why_title_1      = $data['why_title_1'];
                        $sofp->why_content_1      = $data['why_content_1'];
                        $sofp->why_link_text_1      = $data['why_link_text_1'];
                        $sofp->why_link_1      = $data['why_link_1'];
                        $sofp->why_title_2      = $data['why_title_2'];
                        $sofp->why_content_2      = $data['why_content_2'];
                        $sofp->why_link_text_2      = $data['why_link_text_2'];
                        $sofp->why_link_2      = $data['why_link_2'];
                        $sofp->why_title_3      = $data['why_title_3'];
                        $sofp->why_content_3      = $data['why_content_3'];
                        $sofp->why_link_text_3      = $data['why_link_text_3'];
                        $sofp->why_link_3      = $data['why_link_3'];
                        $sofp->how_it_hd      = $data['how_it_hd'];
                        $sofp->how_it_desc      = $data['how_it_desc'];
                        $sofp->how_title_1      = $data['how_title_1'];
                        $sofp->how_content_1      = $data['how_content_1'];
                        $sofp->how_title_2      = $data['how_title_2'];
                        $sofp->how_content_2      = $data['how_content_2'];
                        $sofp->how_title_3      = $data['how_title_3'];
                        $sofp->how_content_3      = $data['how_content_3'];
                        $sofp->how_title_4      = $data['how_title_4'];
                        $sofp->how_content_4      = $data['how_content_4'];
                        $sofp->start_sell_content      = $data['start_sell_content'];
                        $sofp->start_sell_link_text      = $data['start_sell_link_text'];
                        $sofp->start_sell_link      = $data['start_sell_link'];

                        if(isset($data['sell_bg'])) {
                            $file_name = $data['sell_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['sell_bg']->move($file_path, $file_name);
                            $sofp->sell_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_sell_bg'])) {
                            $sofp->sell_bg       = $data['old_sell_bg'];
                        } else {
                            $sofp->sell_bg       = NULL;
                        }

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $sofp->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $sofp->banner_image       = $data['old_banner_image'];
                        } else {
                            $sofp->banner_image       = NULL;
                        }

                        if(isset($data['why_img_1'])) {
                            $file_name = $data['why_img_1']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['why_img_1']->move($file_path, $file_name);
                            $sofp->why_img_1       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_why_img_1'])) {
                            $sofp->why_img_1       = $data['old_why_img_1'];
                        } else {
                            $sofp->why_img_1       = NULL;
                        }

                        if(isset($data['why_img_2'])) {
                            $file_name = $data['why_img_2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['why_img_2']->move($file_path, $file_name);
                            $sofp->why_img_2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_why_img_2'])) {
                            $sofp->why_img_2       = $data['old_why_img_2'];
                        } else {
                            $sofp->why_img_2       = NULL;
                        }

                        if(isset($data['why_img_3'])) {
                            $file_name = $data['why_img_3']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['why_img_3']->move($file_path, $file_name);
                            $sofp->why_img_3       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_why_img_3'])) {
                            $sofp->why_img_3       = $data['old_why_img_3'];
                        } else {
                            $sofp->why_img_3       = NULL;
                        }

                        if(isset($data['how_img_1'])) {
                            $file_name = $data['how_img_1']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['how_img_1']->move($file_path, $file_name);
                            $sofp->how_img_1       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_how_img_1'])) {
                            $sofp->how_img_1       = $data['old_how_img_1'];
                        } else {
                            $sofp->how_img_1       = NULL;
                        }

                        if(isset($data['how_img_2'])) {
                            $file_name = $data['how_img_2']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['how_img_2']->move($file_path, $file_name);
                            $sofp->how_img_2       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_how_img_2'])) {
                            $sofp->how_img_2       = $data['old_how_img_2'];
                        } else {
                            $sofp->how_img_2       = NULL;
                        }

                        if(isset($data['how_img_3'])) {
                            $file_name = $data['how_img_3']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['how_img_3']->move($file_path, $file_name);
                            $sofp->how_img_3       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_how_img_3'])) {
                            $sofp->how_img_3       = $data['old_how_img_3'];
                        } else {
                            $sofp->how_img_3       = NULL;
                        }

                        if(isset($data['how_img_4'])) {
                            $file_name = $data['how_img_4']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['how_img_4']->move($file_path, $file_name);
                            $sofp->how_img_4       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_how_img_4'])) {
                            $sofp->how_img_4       = $data['old_how_img_4'];
                        } else {
                            $sofp->how_img_4       = NULL;
                        }

                        if(isset($data['start_sell_bg'])) {
                            $file_name = $data['start_sell_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/sofp/'.$date;
                            $data['start_sell_bg']->move($file_path, $file_name);
                            $sofp->start_sell_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_start_sell_bg'])) {
                            $sofp->start_sell_bg       = $data['old_start_sell_bg'];
                        } else {
                            $sofp->start_sell_bg       = NULL;
                        }

                        if($sofp->save()) {
                        	Session::flash('message', 'Update Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
                        	// return View::make("settings.sofp_setting")->with(array('sofp'=>$sofp,'sofp_cnt'=>$sofp_cnt,'sofp_lnk'=>$sofp_lnk,'sofp_slnk'=>$sofp_slnk,'sofp_pay'=>$sofp_pay,'page'=>$page));
                            return redirect()->route('sofp_setting');
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