<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CMSPageManagement;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class CMSPageManagementController extends Controller
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
                $cms_page = CMSPageManagement::all();
            	return View::make("settings.cms_page.manage_cms_page")->with(array('cms_page'=>$cms_page, 'page'=>$page));
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	return View::make('settings.cms_page.add_cms_page')->with(array('page'=>$page));
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $rules = array(
                    'page_name'    => 'required',
                    'page_description'   => 'required',
                    'banner_caption'   => 'nullable',
                    'meta_tags'   => 'nullable',
                    'video_url'   => 'nullable',
                    'banner_image'   => 'nullable',
                    'is_block'       => 'nullable',
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with(array('page'=>$page))->withInput();
                } else {
                    $data = $request->all();
                    
                    $cms_page = new CMSPageManagement();

                    if($cms_page) {
                        $cms_page->page_name    = $data['page_name'];               
                        $cms_page->page_description      = $data['page_description'];
                        // $cms_page->banner_caption      = $data['banner_caption'];
                        $cms_page->meta_tags      = $data['meta_tags'];
                        // $cms_page->video_url          = $data['video_url'];
                        $cms_page->is_block   = 1;

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/cms_banner/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $cms_page->banner_image       = $file_path.'/'.$file_name;
                        } else {
                            $cms_page->banner_image       = NULL;
                        }
                        
                        if($cms_page->save()) {
                            Session::flash('message', 'Added Page Successfully !'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_cms_page');
                        } else{
                            Session::flash('message', 'Added Page Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_cms_page');
                        }
                    } else{
                        Session::flash('message', 'Added Page Failed!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_cms_page');
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Settings";
        		$cms_page = CMSPageManagement::where('id',$id)->first();
        		return View::make("settings.cms_page.edit_cms_page")->with(array('cms_page'=>$cms_page, 'page'=>$page));
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $id = $request->get('cms_page_id');
                $cms_page = '';
                if($id != '') {
                    $cms_page = CMSPageManagement::Where('id', $id)->first();
                }

                if($cms_page) {
                    $rules = array(
                        'page_name'    => 'required',
                        'page_description'   => 'required',
                        'banner_caption'   => 'nullable',
                        'meta_tags'   => 'nullable',
                        'video_url'   => 'nullable',
                        'banner_image'   => 'nullable',
                        'is_block'       => 'nullable',
                    );
                    $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return Redirect::to('/edit_cms_page/' . $id)->withErrors($validator)->with(array('cms_page'=>$cms_page, 'page'=>$page));
                    } else {
                        $data = $request->all();
                        
                        $cms_page->page_name    = $data['page_name'];               
                        $cms_page->page_description      = $data['page_description'];
                        // $cms_page->banner_caption      = $data['banner_caption'];
                        $cms_page->meta_tags      = $data['meta_tags'];
                        // $cms_page->video_url          = $data['video_url'];
                        $cms_page->is_block   = 1;

                        if(isset($data['banner_image'])) {
                            $file_name = $data['banner_image']->getClientOriginalName();
                            $date = date('M-Y');
                            // $file_path = '../public/images/products/'.$date;
                            $file_path = 'images/cms_banner/'.$date;
                            $data['banner_image']->move($file_path, $file_name);
                            $cms_page->banner_image       = $file_path.'/'.$file_name;
                        } else if (isset($data['old_banner_image'])) {
                            $cms_page->banner_image       = $data['old_banner_image'];
                        } else {
                            $cms_page->banner_image       = NULL;
                        }
                        
                        if($cms_page->save()) {
                            Session::flash('message', 'Updated Page Successfully!'); 
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->route('manage_cms_page');
                        } else{
                            Session::flash('message', 'Updated Page Failed!'); 
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('manage_cms_page');
                        }               
                    }
                } else{
                    Session::flash('message', 'Updated Page Failed!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_cms_page');
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$cms_page = CMSPageManagement::where('id',$id)->first();
        				if($cms_page){
        					if($cms_page->delete()) {
        						Session::flash('message', 'Deleted Page Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
        					} else {
        						Session::flash('message', 'Deleted Page Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
        					Session::flash('message', 'Deleted Page Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        					$error = 1;
        				}			
        			} else {
        				Session::flash('message', 'Deleted Page Failed!'); 
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
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$cms_page = CMSPageManagement::where('id',$value)->first();
        					if($cms_page){
        						if($cms_page->delete()) {
        							Session::flash('message', 'Deleted Page Successfully!'); 
        							Session::flash('alert-class', 'alert-success');
        							$error = 0;
        						} else {
        							Session::flash('message', 'Deleted Page Failed!'); 
        							Session::flash('alert-class', 'alert-danger');
        						}
        					}	else {
        						Session::flash('message', 'Deleted Page Failed!'); 
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

	public function StatusCMSPage ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		$cms_page = '';
        		$msg = '';
            	if($id != '') {
                	$cms_page = CMSPageManagement::Where('id', $id)->first();
                }

                if($cms_page) {
                	if($cms_page->is_block == 1) {
                    	$cms_page->is_block        = 0;
                    	$msg = "Blocked Successfully";
                	} else {
                		$cms_page->is_block        = 1;
                    	$msg = "Unblocked Successfully";
                	}
        	        
        	        if($cms_page->save()) {
        	        	Session::flash('message', $msg); 
        				Session::flash('alert-class', 'alert-success');
        				return redirect()->route('manage_cms_page');
        	        } else{
        	        	Session::flash('message', 'Failed Block or Unblock!'); 
        				Session::flash('alert-class', 'alert-danger');
        	            return redirect()->route('manage_cms_page');
        	        }
                } else{
                	Session::flash('message', 'Failed Block or Unblock!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_cms_page');
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

	public function CMSPageBlock( Request $request) {	
		$ids = array();
		$error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$cms_page = CMSPageManagement::where('id',$value)->first();
        					if($cms_page){
        					      if ($cms_page->is_block == 0) {
        					        Session::flash('message', 'CMS Page Already Blocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {
        						$cms_page->is_block = 0;
        						$cms_page->save();
        						Session::flash('message', 'CMS Page  Blocked Successfully!'); 
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

	public function CMSPageUnblock( Request $request) {	
		$ids = array();

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'CMS Page')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			$error = 1;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$cms_page = CMSPageManagement::where('id',$value)->first();
        					if($cms_page){
        					      if ($cms_page->is_block == 1) {
        					        Session::flash('message', 'CMS Page Already Unblocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {
        						$cms_page->is_block = 1;
        						$cms_page->save();
        						Session::flash('message', 'CMS Page Unblocked Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'CMS Page Unblocked Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        					}			
        				}
        			} else {
        				Session::flash('message', 'CMS Page Unblocked Failed!'); 
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
}
