<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FAQS;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class FAQSController extends Controller
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
                $page = "Settings";
                $faqz = FAQS::all();

            	return View::make("settings.faq.manage_faq")->with(array('faqz'=>$faqz,'page'=>$page));
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	return View::make('settings.faq.add_faq')->with(array('page'=>$page));
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.add', '=', 1)
                ->first();

            if($privil) {
            	$page = "Settings";
            	$rules = array(
                    // 'faq_cat'    => 'required',
                    'title'   => 'required',
                    'content'   => 'required',
                    'is_block'       => 'nullable',
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
            	   	return View::make('settings.faq.add_faq')->withErrors($validator);
                } else {
                    $data = $request->all();
                    
                	$faqz = new FAQS();

                    if($faqz) {
        	           // $faqz->faq_cat    = $data['faq_cat'];	            
                        $faqz->title      = $data['title'];
                    	$faqz->content    = $data['content'];
        	            $faqz->is_block   = 1;
        	            
        	            if($faqz->save()) {
        	            	Session::flash('message', 'Added FAQ Successfully'); 
        					Session::flash('alert-class', 'alert-success');
        					return redirect()->route('manage_faq');
        	            } else{
        	            	Session::flash('message', 'Added FAQ Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        	                return redirect()->route('manage_faq');
        	            }
                    } else{
                    	Session::flash('message', 'Added FAQ Failed!'); 
        				Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('manage_faq');
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Settings";
        		$faqz = FAQS::where('id',$id)->first();
        		if($faqz) {
        			return View::make("settings.faq.edit_faq")->with(array('faqz'=>$faqz,'page'=>$page));
        		} else {
        			Session::flash('message', 'Edit Not Possible!'); 
        			Session::flash('alert-class', 'alert-danger');
        			return redirect()->route('manage_faq'); 
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.edit', '=', 1)
                ->first();

            if($privil) {
        		$page = "Settings";
        		$id = $request->get('b_id');
                $faqz = '';
                if($id != '') {
                	$faqz = FAQS::Where('id', $id)->first();
                }

                if($faqz) {
        			$rules = array(
        	           // 'faq_cat'    => 'required',
                        'title'      => 'required',
        	            'content'    => 'required',
        	            'is_block'   => 'nullable',
        	        );
        	        $validator = Validator::make($request->all(), $rules);

        	        if ($validator->fails()) {
        	        	return Redirect::to('/edit_faq/' . $id)->withErrors($validator)->with(array('faqz'=>$faqz, 'page'=>$page));
        	        } else {
        	            $data = $request->all();
        	            
        	           // $faqz->faq_cat    = $data['faq_cat'];              
                        $faqz->title      = $data['title'];
                        $faqz->content    = $data['content'];
        	            
        	            if($faqz->save()) {
        	            	Session::flash('message', 'Updated FAQ Successfully!'); 
        					Session::flash('alert-class', 'alert-success');
        					return redirect()->route('manage_faq');
        	            } else{
        	            	Session::flash('message', 'Updated FAQ Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        	                return redirect()->route('manage_faq');
        	            }	            
        	        }
                } else{
                	Session::flash('message', 'Updated FAQ Failed!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_faq');
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
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$faqz = FAQS::where('id',$id)->first();
        				if($faqz){
        					if($faqz->delete()) {
        						Session::flash('message', 'Deleted FAQ Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
        					} else {
        						Session::flash('message', 'Deleted FAQ Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        						$error = 1;
        					}
        				}	else {
        					Session::flash('message', 'Deleted FAQ Failed!'); 
        					Session::flash('alert-class', 'alert-danger');
        					$error = 1;
        				}			
        			} else {
        				Session::flash('message', 'Deleted FAQ Failed!'); 
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

	public function DeleteAll( Request $request) {	
		$ids = array();
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$faqz = FAQS::where('id',$value)->first();
        					if($faqz){
        						if($faqz->delete()) {
        							Session::flash('message', 'Deleted FAQ Successfully!'); 
        							Session::flash('alert-class', 'alert-success');
        							$error = 0;
        						} else {
        							Session::flash('message', 'Deleted FAQ Failed!'); 
        							Session::flash('alert-class', 'alert-danger');

        						}
        					}	else {
        						Session::flash('message', 'Deleted FAQ Failed!'); 
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
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

		echo $error;
	}

	public function StatusFAQ ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		$page = "Settings";
        		$faqz = '';
        		$msg = '';
            	if($id != '') {
                	$faqz = FAQS::Where('id', $id)->first();
                }

                if($faqz) {
                	if($faqz->is_block == 1) {
                    	$faqz->is_block        = 0;
                    	$msg = "Blocked Successfully";
                	} else {
                		$faqz->is_block        = 1;
                    	$msg = "Unblocked Successfully";
                	}
        	        
        	        if($faqz->save()) {
        	        	Session::flash('message', $msg); 
        				Session::flash('alert-class', 'alert-success');
        				return redirect()->route('manage_faq');
        	        } else{
        	        	Session::flash('message', 'Failed Block or Unblock!'); 
        				Session::flash('alert-class', 'alert-danger');
        	            return redirect()->route('manage_faq');
        	        }
                } else{
                	Session::flash('message', 'Failed Block or Unblock!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_faq');
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

	public function FAQBlock( Request $request) {	
		$ids = array();
		$error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$faqz = FAQS::where('id',$value)->first();
        					if($faqz){
        					     if ($faqz->is_block == 0) {
        					        Session::flash('message', 'FAQ Already Blocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {

        						$faqz->is_block = 0;
        						$faqz->save();
        						Session::flash('message', 'FAQ Blocked Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'FAQ Blocked Failed!'); 
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
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }

		echo $error;
	}

	public function FAQUnblock( Request $request) {	
		$ids = array();
		$error = 1;

        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'FAQS Settings')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$faqz = FAQS::where('id',$value)->first();
        					if($faqz){
        					     if ($faqz->is_block == 1) {
        					        Session::flash('message', 'FAQ Already Unblocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {

        						$faqz->is_block = 1;
        						$faqz->save();
        						Session::flash('message', 'FAQ Unblocked Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'FAQ Unblocked Failed!'); 
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
}
