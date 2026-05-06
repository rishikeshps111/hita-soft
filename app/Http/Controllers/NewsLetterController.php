<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsLetter;
use App\Contacts;
use App\User;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;

class NewsLetterController extends Controller
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
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
            	$page = "Messages";
                $news_letters = NewsLetter::all();
            	return View::make("message.news_letters.manage_news_letters")->with(array('news_letters'=>$news_letters, 'page'=>$page));
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

    public function SendNewsLetters () {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Send News Letters')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
            	$page = "Messages";
            	$subcribers = NewsLetter::Where('is_block', 1)->get();
                $contacts = Contacts::Where('is_block', 1)->get();
                return View::make("message.news_letters.send_news_letters")->with(array('subcribers'=>$subcribers, 'contacts'=>$contacts, 'page'=>$page));
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

    public function MailedNewsLetters(Request $request) {
    	$error = 1;
    	$err = 1;
        $loged = session()->get('user');
        
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'Send News Letters')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.list', '=', 1)
                ->first();

            if($privil) {
            // 	if($request->ajax() && isset($request->subject) && isset($request->message) && isset($request->email_to)) {
        	    	$subject = $request->subject;
        	   // 	$message = $request->message;
        	   $htmlMessage = $request->message;
        	    	
        	    $dom = new \DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($htmlMessage, 'HTML-ENTITIES', 'UTF-8'));
                
                $images = $dom->getElementsByTagName('img');
                
                foreach ($images as $img) {
                    $src = $img->getAttribute('src');
                
                    if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                        $data = substr($src, strpos($src, ',') + 1);
                        $data = base64_decode($data);
                        $ext = strtolower($type[1]);
                
                        $filename = uniqid() . '.' . $ext;
                        $folder = public_path('uploads/newsletter_images');
                
                        if (!file_exists($folder)) {
                            mkdir($folder, 0755, true);
                        }
                
                        $path = $folder . '/' . $filename;
                        file_put_contents($path, $data);
                
                        $img->setAttribute('src', url('public/uploads/newsletter_images/' . $filename));
                          $img->setAttribute('width', '300');   // Change as needed
                        $img->setAttribute('height', '200');  // Change as needed
                
                        // ✅ Optional: Add inline style (some email clients respect this more)
                        $img->setAttribute('style', 'display:block;margin:auto;border-radius:6px;max-width:100%;height:auto;');
                    
                    }
                }
                
                $message = $dom->saveHTML() ?: $htmlMessage;

                        
        	    	$email_to = $request->email_to;
        	    	$part_subs = 0;
                    $part_enqs = 0;

        	    	if(isset($request->part_subs)) {
        	    		$part_subs = $request->part_subs;
        	    	} else {
        	    		$part_subs = 0;
        	    	}

                    if(isset($request->part_enqs)) {
                        $part_enqs = $request->part_enqs;
                    } else {
                        $part_enqs = 0;
                    }

                // dd($message);
        	    	$subcriber = 0;

        	    	if($email_to == 1) {
        	    		$subcriber = NewsLetter::Where('is_block', 1)->get();
        	    	} else if($email_to == 2) {
        	    		$subcriber = NewsLetter::Where('is_block', 1)->WhereIn('id', $part_subs)->get();
        	    	} else if($email_to == 3) {
                        $subcriber = Contacts::Where('is_block', 1)->get();
                    } else if($email_to == 4) {
                        $subcriber = Contacts::Where('is_block', 1)->WhereIn('id', $part_enqs)->get();
                    }
                    
                    // dd($subcriber);

            		if (count($subcriber) != 0) {
        				$adm = User::where('user_type', 1)->where('is_block', 1)->first();
                        $admin_email = "teamadsdev5@gmail.com";
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
                        $site_name = "Paris La Belle";
                        if($general){
                            $site_name = $general->site_name;
                        } else {
                            $site_name = "Paris La Belle";
                        }

        	    		foreach ($subcriber as $key => $value) {
                            $headers="Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers.= "MIME-Version: 1.0\r\n";
                            // $headers.= "From: $admin_email" . "\r\n";
                            $headers.= "From:  Rukmini Fashions <syjd250oi96g>" . "\r\n";
                            $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                            if($email_to == 1) {
                                $to = $value->email;
                            } else if($email_to == 2) {
                                $to = $value->email;
                            } else if($email_to == 3) {
                                $to = $value->contact_email;
                            } else if($email_to == 4) {
                                $to = $value->contact_email;
                            }

                            $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="'.route('home').'"><img src="'.$logo.'" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                        <h2 style="color: #B73182;margin-top: 0px;">'.$subject.'</h2>
                                        <p style="font-size:15px;font-weight:600;">'.$message.'</p>
                                        <p></p>
                                        <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                        <p style="color: #777;font-size: 10px;">We hope you enjoy receiving news and special offer emails from '.$site_name.'. If you would prefer not receiving our emails, please <a href="'.route('unsubcribe', ['id' => $value->id]).'" style="white-space: nowrap;color: #777;text-decoration: underline;cursor: pointer;font-size: 10px;">click here </a> to unsubscribe.</p>
                                        <p></p>
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
                                
                                // $mail=mail($to,$subject,$txt,$headers);
                                //  Session::put('news_data', [
                                //     'to' => $to,
                                //     'subject' => $subject,
                                //     'body' => $txt,
                                //     'headers' => $headers,
                                // ]);
                                $allMails = Session::get('news_data', []);
                                $allMails[] = [
                                    'to' => $to,
                                    'subject' => $subject,
                                    'body' => $txt,
                                    'headers' => $headers,
                                ];
                                Session::put('news_data', $allMails);
                                			
        	    		}
        	    	}

        	 
                         return response()->json([
                            'success' => true,
                            'message' => 'Newsletter sent successfully!'
                        ]);
                 
            } else {
                Session::flash('message', 'You Are Not Access This Module!'); 
                Session::flash('alert-class', 'alert-danger');
                // return redirect()->back();
                $err = 1;
            }
        } else {
            Session::flash('message', 'Please Login Properly!'); 
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->back();
            $err = 1;
        }

        // echo $err;
    }
    
     public function sendLettersEmail(Request $request)
        {
            $allMails = session()->pull('news_data', []); 

            if ($allMails) {
                foreach ($allMails as $data) {
                    @mail($data['to'], $data['subject'], $data['body'], $data['headers']);
                }
                return response()->json(['status' => 'sent', 'count' => count($allMails)]);
            }
        
            return response()->json(['status' => 'no_data']);
        }

	public function delete( Request $request) {	
		$id = 0;
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->id)){
        			$id = $request->id;
        			if($id != 0) {
        				$news_letters = NewsLetter::where('id',$id)->first();
        				if($news_letters){
        					if($news_letters->delete()) {
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
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.delete', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$news_letters = NewsLetter::where('id',$value)->first();
        					if($news_letters){
        						if($news_letters->delete()) {
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

	public function StatusNewsLetters ($id) {
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		$news_letters = '';
        		$msg = '';
            	if($id != '') {
                	$news_letters = NewsLetter::Where('id', $id)->first();
                }

                if($news_letters) {
                	if($news_letters->is_block == 1) {
                    	$news_letters->is_block        = 0;
                    	$msg = "Blocked Successfully";
                	} else {
                		$news_letters->is_block        = 1;
                    	$msg = "Unblocked Successfully";
                	}
        	        
        	        if($news_letters->save()) {
        	        	Session::flash('message', $msg); 
        				Session::flash('alert-class', 'alert-success');
        				return redirect()->route('manage_news_letters');
        	        } else{
        	        	Session::flash('message', 'Failed Block or Unblock!'); 
        				Session::flash('alert-class', 'alert-danger');
        	            return redirect()->route('manage_news_letters');
        	        }
                } else{
                	Session::flash('message', 'Failed Block or Unblock!'); 
        			Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('manage_news_letters');
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

	public function NewsLettersBlock( Request $request) {	
		$ids = array();
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$news_letters = NewsLetter::where('id',$value)->first();
        					if($news_letters){
        					     if ($news_letters->is_block == 0) {
        					        Session::flash('message', 'NewsLetter Already Blocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {

        						$news_letters->is_block = 0;
        						$news_letters->save();
        						Session::flash('message', 'NewsLetter Blocked Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'NewsLetter Blocked Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        					}			
        				}
        			} else {
        				Session::flash('message', 'NewsLetter Blocked Failed!'); 
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

	public function NewsLettersUnblock( Request $request) {	
		$ids = array();
		$error = 1;
        $loged = session()->get('user');
        if($loged) {
            $privil = DB::table('previlages as A')
                ->leftjoin('modules as B', 'A.module', '=', 'B.id')
                ->select('A.id as pid','A.*','B.id as mid','B.*')
                ->where('B.module_name', '=', 'News Letter')
                ->where('A.role', '=', $loged->user_type)
                ->where('A.status', '=', 1)
                ->first();

            if($privil) {
        		if($request->ajax() && isset($request->ids)){
        			$ids = $request->ids;
        			if(sizeof($ids) != 0) {
        				foreach ($ids as $key => $value) {
        					$news_letters = NewsLetter::where('id',$value)->first();
        					if($news_letters){
        					      if ($news_letters->is_block == 1) {
        					        Session::flash('message', 'NewsLetter Already Unblocked'); 
            						Session::flash('alert-class', 'alert-danger');
                                } else {

        						$news_letters->is_block = 1;
        						$news_letters->save();
        						Session::flash('message', 'NewsLetter Unblocked Successfully!'); 
        						Session::flash('alert-class', 'alert-success');
        						$error = 0;
                                }
        					}	else {
        						Session::flash('message', 'NewsLetter Unblocked Failed!'); 
        						Session::flash('alert-class', 'alert-danger');
        					}			
        				}
        			} else {
        				Session::flash('message', 'NewsLetter Unblocked Failed!'); 
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
