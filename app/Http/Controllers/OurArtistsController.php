<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OurArtist;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class OurArtistsController extends Controller
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
                ->where('B.module_name', '=', 'Artists')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";                          
                $artist = OurArtist::all();

                if (sizeof($artist) != 0) {
                    return response()->json(array('status_code'=>'1','response_msg'=>'Artists Deatils','response_data'=>array('data'=>$artist,'page'=>$page)), 200);
                } else {
                    return response()->json(array('status_code'=>'0','response_msg'=>'No Artists Deatils'), 200);
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
                ->where('B.module_name', '=', 'Artists')
                ->where('A.role', '=', $loged->user_type)
                // ->where('A.edit', '=', 1)
                // ->orwhere('A.add', '=', 1)
                ->where(function ($query) {
                    $query->where('A.edit', '=', 1)
                          ->orWhere('A.add', '=', 1);
                })
                ->first();
                
                // print_r($privil);die();

            if($privil) {
                $page = "Settings";                           
                $artist = OurArtist::first();
                if($artist) {
                    return View::make("settings.artist_setting")->with(array('artist'=>$artist,'page'=>$page));
                } else {
                    return View::make('settings.artist_setting');
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
                ->where('B.module_name', '=', 'Artists')
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
                $artist = OurArtist::first();
                if($artist) {
                    $rules = array(
                        'main_heading'         => 'required',
                        'first_link_text'       => 'nullable',
                        'first_link'       => 'required',
                        'first_caption1'          => 'nullable',
                        'first_caption2'          => 'nullable',
                        'second_link_text'        => 'required',
                        'second_link'        => 'required',
                        'second_caption1'        => 'nullable',
                        'second_caption2'        => 'nullable',
                        'third_link_text'        => 'nullable',
                        'third_link'        => 'required',
                        'third_caption1'        => 'nullable',
                        'third_caption2'        => 'nullable',
                        'first_bg'        => 'nullable',
                        'first_poster'        => 'nullable',
                        'second_bg'        => 'nullable',
                        'second_poster'        => 'nullable',
                        'third_bg'        => 'nullable',
                        'third_poster'        => 'nullable',
                    );
                } else {
                    $rules = array(
                        'main_heading'         => 'required',
                        'first_link_text'       => 'nullable',
                        'first_link'       => 'required',
                        'first_caption1'          => 'nullable',
                        'first_caption2'          => 'nullable',
                        'second_link_text'        => 'required',
                        'second_link'        => 'required',
                        'second_caption1'        => 'nullable',
                        'second_caption2'        => 'nullable',
                        'third_link_text'        => 'nullable',
                        'third_link'        => 'required',
                        'third_caption1'        => 'nullable',
                        'third_caption2'        => 'nullable',
                        'first_bg'        => 'required',
                        'first_poster'        => 'nullable',
                        'second_bg'        => 'required',
                        'second_poster'        => 'nullable',
                        'third_bg'        => 'required',
                        'third_poster'        => 'nullable',
                    );
                }
                $validator = Validator::make(Input::all(), $rules);

                if ($validator->fails()) {
                    if($artist) {
                        return View::make("settings.artist_setting")->withErrors($validator)->with(array('artist'=>$artist,'page'=>$page));
                    } else {
                       return View::make('settings.artist_setting')->withErrors($validator);
                    }
                } else {
                    $id = Input::get('id');
                    $artist = '';
                    if($id != '') {
                        $artist = OurArtist::Where('id', $id)->first();
                    } else {
                        $artist = new OurArtist();
                    }

                    if($artist) {
                        $artist->main_heading    = $data['main_heading'];
                        $artist->first_link_text      = $data['first_link_text'];
                        $artist->first_link      = $data['first_link'];
                        $artist->first_caption1      = $data['first_caption1'];
                        $artist->first_caption2      = $data['first_caption2'];
                        $artist->second_link_text      = $data['second_link_text'];
                        $artist->second_link      = $data['second_link'];
                        $artist->second_caption1      = $data['second_caption1'];
                        $artist->second_caption2      = $data['second_caption2'];
                        $artist->third_link_text      = $data['third_link_text'];
                        $artist->third_link      = $data['third_link'];
                        $artist->third_caption1      = $data['third_caption1'];
                        $artist->third_caption2      = $data['third_caption2'];

                        if(isset($data['first_bg'])) {
                            $file_name = $data['first_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['first_bg']->move($file_path, $file_name);
                            $artist->first_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_first_bg'])) {
                            $artist->first_bg       = $data['old_first_bg'];
                        } else {
                            $artist->first_bg       = NULL;
                        }

                        if(isset($data['first_poster'])) {
                            $file_name = $data['first_poster']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['first_poster']->move($file_path, $file_name);
                            $artist->first_poster       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_first_poster'])) {
                            $artist->first_poster       = $data['old_first_poster'];
                        } else {
                            $artist->first_poster       = NULL;
                        }

                        if(isset($data['second_bg'])) {
                            $file_name = $data['second_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['second_bg']->move($file_path, $file_name);
                            $artist->second_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_second_bg'])) {
                            $artist->second_bg       = $data['old_second_bg'];
                        } else {
                            $artist->second_bg       = NULL;
                        }

                        if(isset($data['second_poster'])) {
                            $file_name = $data['second_poster']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['second_poster']->move($file_path, $file_name);
                            $artist->second_poster       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_second_poster'])) {
                            $artist->second_poster       = $data['old_second_poster'];
                        } else {
                            $artist->second_poster       = NULL;
                        }

                        if(isset($data['third_bg'])) {
                            $file_name = $data['third_bg']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['third_bg']->move($file_path, $file_name);
                            $artist->third_bg       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_third_bg'])) {
                            $artist->third_bg       = $data['old_third_bg'];
                        } else {
                            $artist->third_bg       = NULL;
                        }

                        if(isset($data['third_poster'])) {
                            $file_name = $data['third_poster']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/artist/'.$date;
                            $data['third_poster']->move($file_path, $file_name);
                            $artist->third_poster       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_third_poster'])) {
                            $artist->third_poster       = $data['old_third_poster'];
                        } else {
                            $artist->third_poster       = NULL;
                        }

                        if($artist->save()) {
                            Session::flash('message', 'Update Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            // return View::make("settings.artist_setting")->with(array('artist'=>$artist,'artist_cnt'=>$artist_cnt,'artist_lnk'=>$artist_lnk,'artist_slnk'=>$artist_slnk,'artist_pay'=>$artist_pay,'page'=>$page));
                            return redirect()->route('artist_setting');
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