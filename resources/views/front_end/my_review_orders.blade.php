@extends('layouts.frontend')
@section('title', 'Review Orders')
<!--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">-->
<!--<link rel="stylesheet" href="{{ asset('frontend/css/theme-config.css')}}">-->
<!--<link rel="stylesheet" href="{{ asset('frontend/css/styles.css')}}">-->
@section('content')
<style>
 .rating-cs {
        display: inline-flex;
        flex-direction: row-reverse; /* Labels in reverse so stars appear left-to-right */
    }

    .rating-cs input {
        display: none;
    }

    .rating-cs label {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
    }

    .rating-cs input:checked ~ label {
        color: #ffc107; /* Highlight checked + previous */
    }

    .rating-cs label:hover,
    .rating-cs label:hover ~ label {
        color: #ffc107; /* Highlight on hover */
    }
</style>

<section class="accountz section-padding bg-section">
    <div class="container mb_5">
        <div class="row">
            <div class="col-md-12">
                <div class="vertical-tab" role="tabpanel">
                    <!-- Nav tabs -->
                    {{--<ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">My Profile</a></li>

                        <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Edit Profile</a></li>

                        <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"> Change Password</a></li>

                        <li role="presentation"><a href="#Section4" aria-controls="orders" role="tab" data-toggle="tab">My Orders</a></li>

                        <li role="presentation"><a href="#Section5" aria-controls="past_orders" role="tab" data-toggle="tab">Complete Orders</a></li>

                        <li role="presentation"><a href="#Section6" aria-controls="cancel_orders" role="tab" data-toggle="tab">Cancel Orders</a></li>

                        <li role="presentation"><a href="#rtn_odr" aria-controls="cancel_orders" role="tab" data-toggle="tab">Return Orders</a></li>

                        <li role="presentation"><a href="#Section7" aria-controls="feed_back" role="tab" data-toggle="tab">Feed Back</a></li>

                        <li role="presentation" id="logout"><a href="{{ route('logout') }}" aria-controls="logout" role="tab" data-toggle="tab">Logout</a></li>
                    </ul> --}}
                    <!-- Tab panes -->
                    <div class="tab-content tabs">
                        <div role="tabpanel" class="tab-pane fade" id="Section1">
                            <h3>My Profile</h3>
                            <div class="prof">
                                <?php 
                                    $value = session()->get('user');
                                ?>
                                @if($value)
                                    @if($value->user_type == 4)
                                        <h4>Name  
                                            <span>
                                                @if($value->first_name)
                                                    {{$value->first_name}} {{$value->last_name}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4>Mobile  
                                            <span>
                                                @if($value->phone)
                                                    <gjspan>{{$value->phone}}</gjspan>
                                                    @if($value->mobile_verify == 1)
                                                        <gjspan class="gj_verify"><i class="fa fa-check-circle"></i><b>Verified</b></gjspan>
                                                    @else
                                                        <a href="{{ route('verify', ['on' => 'mobile', 'id' => $value->id]) }}" class="gj_verf_but1"><button type="button" class="btn btn-info gj_verf_but2">Verify Now</button></a>
                                                        <gjspan class="gj_unverify"><i class="fa fa-times"></i><b>Unverified</b></gjspan>
                                                    @endif  
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4>Email Id  
                                            <span>
                                                @if($value->email)
                                                    <gjspan>{{$value->email}}</gjspan>
                                                    @if($value->email_verify == 1)
                                                        <gjspan class="gj_verify"><i class="fa fa-check-circle"></i><b>Verified</b></gjspan>
                                                    @else
                                                        <a href="{{ route('verify', ['on' => 'email', 'id' => $value->id]) }}" class="gj_verf_but1"><button type="button" class="btn btn-info gj_verf_but2">Verify Now</button></a>
                                                        <gjspan class="gj_unverify"><i class="fa fa-times"></i><b>Unverified</b></gjspan>
                                                    @endif
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4>Gender  
                                            <span>
                                                @if($value->gender)
                                                    {{$value->gender}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4> State 
                                            <span> 
                                                @if($value->state)
                                                    {{$value->State->state}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4> District 
                                            <span> 
                                                @if($value->city)
                                                    {{$value->City->city_name}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4> Address - 1
                                            <span> 
                                                @if($value->address1)
                                                    {{$value->address1}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4> Address - 2
                                            <span> 
                                                @if($value->address2)
                                                    {{$value->address2}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>
                                        <h4> Pincode 
                                            <span> 
                                                @if($value->pincode)
                                                    {{$value->pincode}}
                                                @else
                                                    {{'------'}}
                                                @endif  
                                            </span> 
                                        </h4>

                                        <?php 
                                            $file_path = 'images/profile_img';
                                        ?>
                                        @if($value->profile_img)
                                            <h4> Profile Image 
                                                <span> 
                                                    <img src="{{ asset($file_path.'/'.$value->profile_img)}}" class="img-responsive">  
                                                </span> 
                                            </h4>
                                        @endif
                                    @else
                                        <p class="gj_no_data">No More Details to Edit!</p>
                                    @endif
                                @else
                                    <p class="gj_no_data">No More Details to Edit!</p>
                                @endif
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="Section2">
                            <h3> Edit Profile</h3>
                            <?php
                                $user = session()->get('user');
                            ?>
                            @if($user)
                                @if($user->user_type == 4)
                                <form action="{{route('update_profile')}}" class="gj_user_form" method="POST" enctype="multipart/form-data">
                                             @csrf
                                        @if($user)
                                        <input type="hidden" name="user_id" class="form-control gj_user_id" value="{{ $user->id }}" >
                                        @endif

                                        <div class="gj_box dark editprofixz gj_inside_box">
                                            <header>
                                                <h5 class="gj_heading"> users Account  </h5>
                                            </header>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="first_name">First Name<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('first_name'))
                                                            {{ $errors->first('first_name') }}
                                                        @endif
                                                    </span>
                                                    <input type="text" class="form-control shadow-none gj_first_name" name="first_name" value="{{ $user->first_name ? $user->first_name : old('first_name') }}" placeholder="Enter user First Name">
                                                    
                                                    </div>

                                                <div class="form-group">
                                                    <label for="last_name">Last Name<label>
                                                    <span class="error"> 
                                                        @if ($errors->has('last_name'))
                                                            {{ $errors->first('last_name') }}
                                                        @endif
                                                    </span>
                                                    <input type="text" class="form-control shadow-none gj_last_name" name="last_name" value="{{ $user->last_name ? $user->last_name : old('last_name') }}" placeholder="Enter user Last Name">
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <label for="email">E-mail Id<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('email'))
                                                            {{ $errors->first('email') }}
                                                        @endif
                                                    </span>
                                                    <input type="email" class="form-control shadow-none gj_email" name="email" value="{{$user->email ? $user->email : old('email')}}" placeholder="Enter Your Email">
                                                    
                                                    <input type="hidden" class="form-control shadow-none" name="bussiness_name" value="{{$user->bussiness_name ? $user->bussiness_name : old('bussiness_name')}}" placeholder="Enter Name">
                                                    
                                                    <input type="hidden" class="form-control shadow-none" name="buss_reg_no" value="{{$user->buss_reg_no ? $user->buss_reg_no : old('buss_reg_no')}}" placeholder="Enter Name">
                                                    
                                                     </div>

                                                <div class="form-group">
                                                    <label for="country">Select Country<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('country'))
                                                            {{ $errors->first('country') }}
                                                        @endif
                                                    </span>

                                                    <?php 
                                                        $opt = '';
                                                        $ctys = \DB::table('countries_managements')->where('is_block',1)->get();
                                                        if(($ctys) && (count($ctys) != 0)){
                                                            foreach ($ctys as $key => $value) {
                                                                if ($value->id == $user->country) {
                                                                    $opt.='<option selected value="'.$value->id.'">'.$value->country_name.'</option>';
                                                                } else {
                                                                    $opt.='<option value="'.$value->id.'">'.$value->country_name.'</option>';
                                                                }
                                                            }
                                                        } 
                                                    ?>
                                                    <select id="country" name="country" class="form-control">
                                                        <option value="0" selected disabled>Select Country</option>
                                                        <?php echo $opt; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="state">Select State<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('state'))
                                                            {{ $errors->first('state') }}
                                                        @endif
                                                    </span>

                                                    <select id="state" name="state" disabled class="form-control">
                                                        <option value="0" selected disabled>Select State</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="city">Select District<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('city'))
                                                            {{ $errors->first('city') }}
                                                        @endif
                                                    </span>

                                                    <select id="city" name="city" disabled class="form-control">
                                                        <option value="0" selected disabled>Select District</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="phone">Phone<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('phone'))
                                                            {{ $errors->first('phone') }}
                                                        @endif
                                                    </span>
                                                    <input type="number" class="form-control shadow-none gj_phone" name="phone" value="{{$user->phone ? $user->phone : old('phone')}}"
                                                    placeholder="Enter Your Phone">
                                                    
                                                    </div>

                                                <div class="form-group">
                                                    <label for="phone2">Alternate Phone No<label>
                                                    <span class="error"> 
                                                        @if ($errors->has('phone2'))
                                                            {{ $errors->first('phone2') }}
                                                        @endif
                                                    </span>
                                                    <input type="number" class="form-control shadow-none gj_phone2" name="phone2" value="{{$user->phone2 ? $user->phone2 : old('phone2')}}"
                                                    placeholder="Enter Your Phone">
                                                   </div>

                                                <div class="form-group">
                                                    <label for="gender">Gender<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('gender'))
                                                            {{ $errors->first('gender') }}
                                                        @endif
                                                    </span>

                                                    <div class="gj_py_ro_div">
                                                        <span class="gj_py_ro">
                                                            <input type="radio" <?php if($user->gender == "Male"){ echo "checked"; } ?> name="gender" value="Male"> Male
                                                        </span>
                                                        <span class="gj_py_ro">
                                                            <input type="radio" <?php if($user->gender == "Female"){ echo "checked"; } ?> name="gender" value="Female"> Female
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address1">Address<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('address1'))
                                                            {{ $errors->first('address1') }}
                                                        @endif
                                                    </span>
                                                    <input type="text" class="form-control shadow-none gj_address1" name="address1" value="{{$user->address1 ? $user->address1 : old('address1')}}"
                                                        placeholder="Enter Your Address">
                                                        
                                                    </div>

                                                <div class="form-group">
                                                    <label for="address2">City<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('address2'))
                                                            {{ $errors->first('address2') }}
                                                        @endif
                                                    </span>
                                                    <input type="text" class="form-control shadow-none gj_address2" name="address2" value="{{$user->address2 ? $user->address2 : old('address2')}}"
                                                        placeholder="Enter Your City">
                                                        
                                                </div>

                                                <div class="form-group">
                                                    <label for="pincode">Pincode<label>
                                                    <span class="error">* 
                                                        @if ($errors->has('pincode'))
                                                            {{ $errors->first('pincode') }}
                                                        @endif
                                                    </span>
                                                    <input type="number" class="form-control shadow-none" name="pincode" value="{{$user->pincode ? $user->pincode : old('pincode')}}"
                                                        placeholder="Enter Your Pincode">
                                                        
                                                    <input type="hidden" class="form-control shadow-none" name="user_type" value="{{$user->user_type ? $user->user_type : old('user_type')}}"
                                                        placeholder="Enter User user_type">
                                                       
                                                     </div>

                                                <div class="form-group">
                                                    <label for="question">Select Your Security Question</label>
                                                    <span class="error">* 
                                                        @if ($errors->has('question'))
                                                            {{ $errors->first('question') }}
                                                        @endif
                                                    </span>

                                                    @php ($opt = '<option value=""> Select Your Security Question </option>')
                                                    @if(isset($secure) && sizeof($secure) != 0)
                                                        @foreach($secure as $skey => $sval)
                                                            @if($sval->id == $user->question) 
                                                                <?php
                                                                    $opt.= '<option selected value="'.$sval->id.'"> '.$sval->question.' </option>';    
                                                                ?>
                                                            @else 
                                                                <?php
                                                                    $opt.= '<option value="'.$sval->id.'"> '.$sval->question.' </option>';    
                                                                ?>
                                                            @endif 
                                                        @endforeach
                                                    @endif
                                                    <select name="question" id="question" class="form-control gj_s_question">
                                                        <?php echo $opt; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="answer">Security Answer</label>
                                                    <span class="error">* 
                                                        @if ($errors->has('answer'))
                                                            {{ $errors->first('answer') }}
                                                        @endif
                                                    </span>
                                                     <input type="text" class="form-control shadow-none gj_s_answer" name="answer" value="{{$user->answer ? $user->answer : old('answer')}}"
                                                        placeholder="Enter Your Security Answer">
                                                    
                                                    </div>

                                                <div class="gj_ban_img_whole">
                                                    <?php 
                                                    $file_path = 'images/profile_img';
                                                    ?>
                                                    @if(isset($user))
                                                        @if($user->profile_img != '')
                                                        <div class="form-group">
                                                            <label for="current_profile_img">Current Profile Image</label>
                                                            <div class="gj_mc_div">
                                                               <img src="{{ asset($file_path.'/'.$user->profile_img)}}" class="img-responsive"> 
                                                            </div>
                                                             <input type="hidden" name="old_profile_img" id="profile_img" class="form-control " value="{{$user->profile_img ? $user->profile_img : ''}}">
                                                     
                                                        </div>
                                                        @endif
                                                    @endif

                                                    <div class="form-group">
                                                        <label for="profile_img">Upload Profile Image</label>
                                                        <span class="error"> 
                                                            @if ($errors->has('profile_img'))
                                                                {{ $errors->first('profile_img') }}
                                                            @endif
                                                        </span>
                                                        <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                                                        <input type="file" name="profile_img" id="profile_img" accept="image/*" class="gj_profile_img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>

                                    </form>
                                @else
                                    <p class="gj_no_data">No More Details to Edit!</p>
                                @endif
                            @else
                                <p class="gj_no_data">No More Details to Edit!</p>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="Section3">
                            <h3> Change Password </h3>
                            <form action="{{route('check_forgot')}}" method="POST" class="login100-form validate-form gj_ui_fp" enctype="multipart/form-data">
                                        @csrf
                                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                                    <input class="input100" type="text" name="email_id" placeholder="Email">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <p class="error gj_l_err"> 
                                    @if ($errors->has('email_id'))
                                        {{ $errors->first('email_id') }}
                                    @endif
                                </p>
                                
                                <div class="container-login100-form-btn">
                                    <button class="login100-form-btn" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fadein active gj_rw_tab" id="Section4">
                             <div class="account_review-box">
                                 <div class="sec-title">
                                    <h3>Review Orders  </h3>
                                </div>
                               

                            @if(isset($orders))
                                @if(!empty($orders))
                                    <p class="error"> 
                                        @if ($errors->has('product_id'))
                                            {{ $errors->first('product_id') }}
                                        @elseif ($errors->has('order_id'))
                                            {{ $errors->first('order_id') }}
                                        @elseif ($errors->has('user_id'))
                                            {{ $errors->first('user_id') }}
                                        @endif
                                    </p>

                                    <p class="error"> 
                                        @if ($errors->has('rating'))
                                            {{ $errors->first('rating') }}
                                        @endif
                                    </p>
                                    
                                    <p class="error"> 
                                        @if ($errors->has('description'))
                                            {{ $errors->first('description') }}
                                        @endif
                                    </p>

                                    <div class="flex-xs review-item-select">
                                        <select class=" form-select shadow-none select-cs" name="gj_rw_odr" id="gj_rw_odr">
                                           <option value="0">-- Select Reviewed Item --</option>
                                            @foreach ($orders['details'] as $key => $value)
                                                <option value="{{$value->product_id}}">{{$value->product_title}}</option>
                                            @endforeach
                                        </select>
                                      <div class="gj_back_div text-right mt-2">
                                          <div class="back-to-order">
                                                <a href='{{  route("my_account", ["tab" => "completedOrders"])}}' class="order-back-btn"><i class="fa-solid fa-arrow-left"></i></a>
                                                
                                            </div>
                                <!--<a href="{{ route('my_account', ['tab' => 'completedOrders'])}}" ><button type="button" class="gj_bck_btn order-back-btn"><i class="fa-solid fa-arrow-left"></i></button></a>-->
                            </div>
                                    </div>
                                @else
                                    <p class="gj_no_data">You're Not Reviewed This Time!</p>
                                @endif

                                <div class="gj_p_rw_div view-container review-rationg-cs">
                                    <form action="{{route('submit_review')}}" method="POST" class="gj_rw_form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="product_id" id="gj_rw_product_id">
                                        @if(isset($orders) && $orders->id)
                                            <input type="hidden" name="order_id" id="gj_rw_order_id" value="{{$orders->id}}">
                                        @else
                                            <input type="hidden" name="order_id" id="gj_rw_order_id" value="0">
                                        @endif

                                        <?php 
                                        $value = session()->get('user');
                                        ?>
                                        @if($value)
                                            @if($value->user_type == 4)
                                                <input type="hidden" name="user_id" id="gj_rw_user_id" value="{{$value->id}}">
                                            @else
                                                <input type="hidden" name="user_id" id="gj_rw_user_id" value="0">
                                            @endif
                                        @else
                                            <input type="hidden" name="user_id" id="gj_rw_user_id" value="0">
                                        @endif

                                        <div class="form-group">
                                            <label class="gj_sr_rw_hd">Star Ratings
                                                <span class="error">*</span>
                                            </label>
                                             <div class="rating rating-cs">
                                                 @for($i = 5; $i >= 1; $i--)
                                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" />
                                                    <label for="star{{ $i }}">
                                                        <i class="fa fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                           

                                        </div>

                                        <div class="form-group">
                                            <label>Review</label>
                                            <textarea rows="5" class="form-control gj_rw_desc shadow-none" id="gj_rw_desc" name="description" placeholder="Enter Your Review"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="submit" class="gj_submit_rw profile-sub-btn" value="Submit">
                                        </div>
                                    </form>
                                </div>
                            @else
                                <p class="gj_no_data">You're Not Reviewed This Time!</p>
                            @endif
                             </div>

                           
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="Section5">
                            <h3> Complete Orders   </h3>

                            @if(isset($past_orders) && count($past_orders) != 0)
                                <div class= "table-responsive">
                                    <table class="table text-center">
                                        <tr>
                                            <th> Order ID </th>
                                            <th> Order Date </th>
                                            <th> Order Status </th>
                                            <th> Quantity </th>
                                            <th> Total Amount </th>
                                            <th> Action </th>
                                        </tr>
                                        
                                        @foreach ($past_orders as $key => $value)
                                            <tr>
                                                <td> {{$value->order_code}} </td>
                                                <td> {{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}} </td>
                                                <td> 
                                                    @if($value->order_status == 1)
                                                        {{'Order Placed'}}
                                                    @elseif($value->order_status == 2)
                                                        Order Dispatched
                                                    @elseif($value->order_status == 3)
                                                        Order Delivered
                                                    @elseif($value->order_status == 4)
                                                        Order Complete
                                                    @elseif($value->order_status == 5)
                                                        Order Cancelled
                                                    @else
                                                        {{'------'}}
                                                    @endif
                                                </td>
                                                <td> {{$value->total_items}} </td>
                                                <td> INR {{$value->net_amount}} </td>
                                                <td class="stat"> 
                                                    <a href="{{ route('my_track_orders', ['id' => $value->id]) }}" class="gj_my_todr"> Track Order </a>
                                                    <a href="{{ route('my_review_orders', ['id' => $value->id]) }}" class="gj_my_rodr"> Review Order</a>
                                                    <a href="{{ route('my_view_orders', ['id' => $value->id]) }}" class="gj_my_vodr"> View Order </a>                   
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="gj_myacc_pge">
                                        {{$past_orders->links()}}
                                    </div>
                                </div>
                            @else
                                <p class="gj_no_data">Orders is Empty</p>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="Section6">
                            <h3> Cancel Orders   </h3>

                            @if(isset($cancel_orders) && count($cancel_orders) != 0)
                                <div class= "table-responsive">
                                    <table class="table text-center">
                                        <tr>
                                            <th> Order ID </th>
                                            <th> Order Date </th>
                                            <th> Cancel Date </th>
                                            <th> Remarks </th>
                                            <th> Order Status </th>
                                            <th> Status </th>
                                            <th> Quantity </th>
                                            <th> Total Amount </th>
                                        </tr>
                                        
                                        @foreach ($cancel_orders as $key => $value)
                                            <tr>
                                                <td> {{$value->order_code}} </td>
                                                <td> {{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}} </td>
                                                <td> {{$value->cancel_date ? date('d-m-Y', strtotime($value->cancel_date)) : '------'}} </td>
                                                <td> {{$value->cancel_remarks}} </td>
                                                <td> 
                                                    @if($value->order_status == 1)
                                                        {{'Order Placed'}}
                                                    @elseif($value->order_status == 2)
                                                        Order Dispatched
                                                    @elseif($value->order_status == 3)
                                                        Order Delivered
                                                    @elseif($value->order_status == 4)
                                                        Order Complete
                                                    @elseif($value->order_status == 5)
                                                        Order Cancelled
                                                    @else
                                                        {{'------'}}
                                                    @endif
                                                </td>
                                                <td> 
                                                    @if($value->cancel_approved == 1)
                                                        {{'Accept'}}
                                                    @elseif($value->cancel_approved == 2)
                                                        Reject
                                                    @elseif($value->cancel_approved == 3)
                                                        Process
                                                    @else
                                                        {{'------'}}
                                                    @endif
                                                </td>
                                                <td> {{$value->total_items}} </td>
                                                <td> <i class="fa fa-inr"></i> {{$value->net_amount}} </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="gj_myacc_pge">
                                        {{$cancel_orders->links()}}
                                    </div>
                                </div>
                            @else
                                <p class="gj_no_data">Orders is Empty</p>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="rtn_odr">
                            <h3> Return Orders   </h3>

                            @if(isset($re_orders) && count($re_orders) != 0)
                                <div class= "table-responsive">
                                    <table class="table text-center">
                                        <tr>
                                            <th> Order ID </th>
                                            <th> Order Date </th>
                                            <th> Return Date </th>
                                            <th> Status </th>
                                            <th> Quantity </th>
                                            <th> Total Amount </th>
                                            <th> Action </th>
                                        </tr>
                                        
                                        @foreach ($re_orders as $key => $value)
                                            <tr>
                                                <td> {{$value->order_code}} </td>
                                                <td> {{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}} </td>
                                                <td> {{$value->return_date ? date('d-m-Y', strtotime($value->return_date)) : '------'}} </td>
                                                <td> 
                                                    @if($value->Orders->return_order_status == 1)
                                                        {{'Order Return Initialized'}}
                                                    @elseif($value->Orders->return_order_status == 2)
                                                        Order Return Confirmed
                                                    @elseif($value->Orders->return_order_status == 3)
                                                        Order Return Cancelled
                                                    @else
                                                        {{'------'}}
                                                    @endif
                                                </td>
                                                <td> {{$value->total_items}} </td>
                                                <td> <i class="fa fa-inr"></i> {{$value->net_amount}} </td>
                                                <td class="stat"> 
                                                    <a href="{{ route('my_view_return_order', ['id' => $value->id]) }}" class="gj_my_vodr"> View Order </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="gj_myacc_pge">
                                        {{$re_orders->links()}}
                                    </div>
                                </div>
                            @else
                                <p class="gj_no_data">Orders is Empty</p>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="Section7">
                            <h3> Feed Back</h3>
                            <?php
                                $u_log = session()->get('user');
                            ?>
                            @if($u_log)
                                @if($u_log->user_type == 4)
                                <form action="{{route('send_feedback')}}" method="POST" class="gj_fuser_form" enctype="multipart/form-data">
                                        @csrf
                                        @if($u_log)
                                        <input type="hidden" name="user_id" value="{{ $u_log->id }}" class="form-control gj_fuser_id">
                                        @endif

                                        <div class="gj_box dark gj_inside_box">
                                            <header>
                                                <h5 class="gj_heading"> User Feed Back  </h5>
                                            </header>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subject">Subject </label>
                                                    <span class="error">* 
                                                        @if ($errors->has('subject'))
                                                            {{ $errors->first('subject') }}
                                                        @endif
                                                    </span>
                                                    <input type="text" name="subject" class="form-control shadow-none gj_subject" value="{{$user->subject ? $user->subject : old('subject')}}" placeholder="Enter Subject in English">
                                                </div>

                                                <div class="form-group">
                                                    <label for="message">Message </label>
                                                    <span class="error">* 
                                                        @if ($errors->has('message'))
                                                            {{ $errors->first('message') }}
                                                        @endif
                                                    </span>

                                                   <textarea placeholder="Enter Message in English" name="message" rows="5" class="form-control shadow-none gj_message">{{$user->message ? $user->message : old('message')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send</button>

                                    </form>
                                @else
                                    <p class="gj_no_data">Sorry!, You can not send the Feed Back!</p>
                                @endif
                            @else
                                <p class="gj_no_data">Sorry!, You can not send the Feed Back!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('before_scripts')
<script>     
    $(document).ready(function(){
        $('.vertical-tab .nav-tabs li a[href="#Section4"]').tab('show');
        $('.vertical-tab .nav-tabs li').removeClass('active'); 
        $('.vertical-tab .nav-tabs li a[href="#Section4"]').parent().addClass('active');

        $('.vertical-tab .nav-tabs li').click(function(){ 
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $(this).addClass('active'); 
        });

        $('#logout').click(function(){ 
            window.location.href = "{{ route('logout') }}";
        });

        $('.buzin').click(function(){ 
            $(".buzzacc").toggle(); 
        })
    });
</script>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
        $("#gj_rw_odr").select2();
    });
</script>

<script>
    $(document).ready(function () {
        // $('.gj_p_rw_div').hide(); // Hide form by default

        let userId = $('#gj_rw_user_id').val();
        let orderId = $('#gj_rw_order_id').val();

        $('#gj_rw_odr').on('change', function () {
            let productId = $(this).val();
            $('#gj_rw_product_id').val(productId);

            if (productId && productId != 0) {
                // $('.gj_p_rw_div').show();

                // Fetch review via AJAX
                $.ajax({
                    url: "{{ route('get_review') }}",
                    type: 'GET',
                    data: {
                        product_id: productId,
                        user_id: userId
                    },
                    success: function (res) {
                        let review = res.review;

                        // Reset first
                        $(".rating input").prop("checked", false);
                        $('#gj_rw_desc').val('');

                        if (review) {
                            // Pre-fill rating
                            if (review.rating) {
                                $(`.rating input[value="${review.rating}"]`).prop("checked", true);
                            }

                            // Pre-fill description
                            $('#gj_rw_desc').val(review.description ?? '');
                        }
                    },
                    error: function () {
                        console.error("Could not fetch review.");
                        $('#gj_rw_desc').val('');
                        $(".rating input").prop("checked", false);
                    }
                });
            } else {
                $('.gj_p_rw_div').hide();
                $('#gj_rw_product_id').val('');
                $('#gj_rw_desc').val('');
                $(".rating input").prop("checked", false);
            }
        });

        // Form validation
        $(".gj_rw_form").on("submit", function (event) {
            let productID = $('#gj_rw_product_id').val();
            let ratingValue = $("input[name='rating']:checked").val();

            if (!productID) {
                alert("Please select a product before submitting your review.");
                event.preventDefault();
            } else if (!ratingValue) {
                alert("Please give a star rating before submitting.");
                event.preventDefault();
            }
        });
    });
</script>




<script>     
    $(document).ready(function() {
        <?php if(isset($_GET['tab_id']) && $_GET['tab_id'] == 'Section4') { ?>
            $('.vertical-tab .nav-tabs li a[href="#Section4"]').tab('show');
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $('.vertical-tab .nav-tabs li a[href="#Section4"]').parent().addClass('active');
        <?php } ?>

        $('.vertical-tab .nav-tabs li').click(function(){ 
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $(this).addClass('active'); 
        });

        $('#logout').click(function(){ 
            window.location.href = "{{ route('logout') }}";
        });

        $('.buzin').click(function(){ 
            $(".buzzacc").toggle(); 
        })

    });
</script>

<script>
    // $('body').on('click','.gj_myacc_pge ul.pagination li',function() {
    //     $('a[href="#Section4"]').trigger();                                                                      
    // });
    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(800); 
        $("#country").select2();
        $("#state").select2();
        $("#city").select2();

        var trgr = false;
        var url = document.location.href;
        var res = url.toString().split('#');

        if(res[1]) {
            var trgr = res[1];
        }

        if(trgr) {
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').tab('show');
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').parent().addClass('active');
        }

        var country = $('#country').select2('val');
        @if($user->state)
            var state = <?php echo $user->state; ?>;
        @else
            var state = 0;
        @endif

        @if($user->city)
            var city = <?php echo $user->city; ?>;
        @else
            var city = 0;
        @endif

        if(city) {
            city = city;          
        } else {
            city = 0;
        }

        if(country) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_state')}}',
                data: {country: country, state: state, type: 'state'},
                success: function(data){
                    if(data){
                        $("#state").html(data);
                        $("#state").removeAttr("disabled");

                        var st = $('#state').val();
                        if(st) {
                            $.ajax({
                                type: 'post',
                                url: '{{url('/select_city')}}',
                                data: {st: st, city: city, type: 'city'},
                                success: function(data){
                                    if(data){
                                        $("#city").html(data);
                                        $("#city").removeAttr("disabled");
                                    } else {
                                        $.confirm({
                                            title: '',
                                            content: 'Please Select State!',
                                            icon: 'fa fa-exclamation',
                                            theme: 'modern',
                                            closeIcon: true,
                                            animation: 'scale',
                                            type: 'purple',
                                            buttons: {
                                                Ok: function(){
                                                    // window.location.reload();
                                                }
                                            }
                                        });
                                        $("#city").prop("disabled", true);
                                    }
                                }
                            });
                        } else {
                            $.confirm({
                                title: '',
                                content: 'Please Select State!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function(){
                                        // window.location.reload();
                                    }
                                }
                            });
                        }
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select Country!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    // window.location.reload();
                                }
                            }
                        });
                        $("#state").prop("disabled", true);
                        $("#city").prop("disabled", true);
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select Country!',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function(){
                        // window.location.reload();
                    }
                }
            });
        }

        @if(isset($user['docs']))
            var cnt = <?php echo count($user['docs']) + 1;?>;
        @else
            var cnt = 2;
        @endif

        $("#img_addButton").click(function () {
            var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_m_doc_' + cnt);
            newTextBoxDiv.after().html('<td><input class="form-control gj_d_name" placeholder="Enter Product Name" name="d_name[]" type="text" id="d_name_' + cnt + '"></td><td><input type="file" name="d_image[]" id="d_image_' + cnt + '" class="gj_d_image form-control"></td><td><button type="button" id="img_removeButton_' + cnt + '" class="gj_m_doc_rem"><i class="fa fa-trash"></i></button></td>');
            newTextBoxDiv.appendTo("#gj_m_doc_bdy");
            cnt++;
        });

        $('body').on('click','.gj_m_doc_rem',function() {
            if(cnt==1){
                $.confirm({
                    title: '',
                    content: 'No more textbox to remove!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
                return false;
            }   
        
            cnt--;
            $(this).closest('tr').remove();
        });
    });

    $('#country').on('change',function() {
        var country = $(this).val();
        if(country) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_state')}}',
                data: {country: country, type: 'state'},
                success: function(data){
                    if(data){
                        $("#state").html(data);
                        $("#state").removeAttr("disabled");
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select Country!',
                            icon: 'fa fa-ban',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'red',
                            buttons: {
                                Ok: function(){
                                }
                            }
                        });
                        $("#state").prop("disabled", true);
                        $("#city").prop("disabled", true);
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select Country!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });

    $('#state').on('change',function() {
        var st = $(this).val();
        if(st) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_city')}}',
                data: {st: st, type: 'city'},
                success: function(data){
                    if(data){
                        $("#city").html(data);
                        $("#city").removeAttr("disabled");
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select State!',
                            icon: 'fa fa-ban',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'red',
                            buttons: {
                                Ok: function(){
                                }
                            }
                        });
                        $("#city").prop("disabled", true);
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select State!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });
</script>
@endsection