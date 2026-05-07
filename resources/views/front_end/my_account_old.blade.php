@extends('layouts.frontend1')
@section('title', 'My Account')

@section('content')
{{-- @if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif --}}
        @if (session('errors'))
            <div class="alert alert-danger">
                <ul>
                    @foreach (session('errors')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <section class="pad-sec">
            <div class="container">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0;">
                        <div class="content">
                            <input type="radio" name="slider" checked id="myProfile" class="none-inp">
                            <input type="radio" name="slider" id="changePassword" class="none-inp">
                            <input type="radio" name="slider" id="myOrders" class="none-inp">
                            <input type="radio" name="slider" id="completedOrders" class="none-inp">
                            <input type="radio" name="slider" id="cancelOrders" class="none-inp">
                            <input type="radio" name="slider" id="feedBack" class="none-inp">

                            <div class="list">
                                <label for="myProfile" class="myProfile">
                                    <span>Profile</span>
                                </label>
                                <label for="changePassword" class="changePassword">
                                    <span>Change Password</span>
                                </label>
                                <label for="myOrders" class="myOrders">
                                    <span>My Orders</span>
                                </label>
                                <label for="completedOrders" class="completedOrders">
                                    <span>Completed Orders</span>
                                </label>
                                <label for="cancelOrders" class="cancelOrders">
                                    <span>Cancel Orders</span>
                                </label>
                                <!-- <label for="feedBack" class="feedBack">
                                    <span>Feedback</span>
                                </label> -->
                                <label>
                                    <a href="{{ route('logout') }}" id="logout">Log Out</a>
                                </label>
                                <div class="slider"></div>
                            </div>

                            <div class="text-content">
                                <div class="myProfile text">
                                    <div class="tab-service">
                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>Profile</h3>
                                                    </div>
                                                </div>
                                            </div>
                                             <?php
                                                @$user = session()->get('user');
                                            ?>
                                            @if($user)
                                                @if(@$user->user_type == 4)
                                                    {{ Form::open(array('url' => 'edit_profile','class'=>'gj_user_form','files' => true)) }}
                                                        @if($user)
                                                            {{ Form::hidden('user_id', @$user->id, array('class' => 'form-control gj_user_id')) }}
                                                        @endif
                                            
                                                <div class="row">
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="name">Full Name <span
                                                                    class="text-danger">*</span></label>
                                                            <span class="error"> *
                                                                @if ($errors->has('full_name'))
                                                                    {{ $errors->first('full_name') }}
                                                                @endif
                                                            </span>
                                                           {{ Form::text('full_name', ($user_data->full_name ? $user_data->full_name : Input::old('full_name')), array('class' => 'form-control gj_last_name','placeholder' => 'Enter user Full Name')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Email">E-mail <span
                                                                    class="text-danger">*</span></label>
                                                             <span class="error">* 
                                                        @if ($errors->has('email'))
                                                            {{ $errors->first('email') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::email('email', ($user->email ? $user->email : Input::old('email')), ['class' => 'form-control gj_email', 'placeholder' => 'Enter user E-mail Id', 'readonly' => 'readonly']) }}

                                                    {{ Form::hidden('bussiness_name', ($user->bussiness_name ? $user->bussiness_name : Input::old('bussiness_name')), array('class' => 'form-control gj_bussiness_name','placeholder' => 'Enter Name')) }}

                                                    {{ Form::hidden('buss_reg_no', ($user->buss_reg_no ? $user->buss_reg_no : Input::old('buss_reg_no')), array('class' => 'form-control gj_buss_reg_no','placeholder' => 'Enter Name')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Phone">Phone <span
                                                                    class="text-danger">*</span></label>
                                                              <span class="error">* 
                                                        @if ($errors->has('phone'))
                                                            {{ $errors->first('phone') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::number('phone', (@$user->phone ? $user->phone : Input::old('phone')), array('class' => 'form-control gj_phone','placeholder' => 'Enter user Phone Number')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12  mb_20">
                                                        <div class="profile-field">
                                                            <label for="Address">Address <span
                                                                    class="text-danger">*</span></label>
                                                    <span class="error">* 
                                                        @if ($errors->has('address1'))
                                                            {{ $errors->first('address1') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::text('address1', (@$user_data->address1 ? $user_data->address1 : Input::old('address1')), array('class' => 'form-control gj_address1','placeholder' => 'Enter user Address')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="City">City <span
                                                                    class="text-danger">*</span></label>
                                                            <span class="error">* 
                                                        @if ($errors->has('address2'))
                                                            {{ $errors->first('address2') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::text('address2', (@$user_data->address2 ? $user_data->address2 : Input::old('address2')), array('class' => 'form-control gj_address2','placeholder' => 'Enter User City')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Pincode">Pincode <span
                                                                    class="text-danger">*</span></label>
                                                            <span class="error">* 
                                                        @if ($errors->has('pincode'))
                                                            {{ $errors->first('pincode') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::number('pincode', (@$user_data->pincode ? $user_data->pincode : Input::old('pincode')), array('class' => 'form-control gj_pincode','placeholder' => 'Enter User Pincode')) }}
                                                    
                                                    {{ Form::hidden('user_type', (@$user->user_type ? $user->user_type : Input::old('user_type')), array('class' => 'form-control gj_user_type','placeholder' => 'Enter User user_type')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Question">Select Your Security Question <span
                                                                    class="text-danger">*</span></label>
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
                                                     <select name="question" id="question" class="form-control gj_s_question shadow-none">
                                                        <?php echo $opt; ?>
                                                    </select>
                                                         
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Answer">Security Answer <span
                                                                    class="text-danger">*</span></label>
                                                            <span class="error">* 
                                                                @if ($errors->has('answer'))
                                                                    {{ $errors->first('answer') }}
                                                                @endif
                                                            </span>
        
                                                            {{ Form::text('answer', ($user_data->answer ? $user_data->answer : Input::old('answer')), array('class' => 'form-control gj_s_answer','placeholder' => 'Enter Your Security Answer')) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                             <?php 
                                                            $file_path = 'images/profile_img';
                                                            ?>
                                                            @if(isset($user))
                                                                @if(@$user->profile_img != '')
                                                                <div class="form-group">
                                                                    {{ Form::label('current_profile_img', 'Current Profile Image') }}
                                                                    <div class="gj_mc_div">
                                                                       <img src="{{ asset($file_path.'/'.$user->profile_img)}}" class="" height="100px"> 
                                                                    </div>
                                                                    {{ Form::hidden('old_profile_img', ($user->profile_img ? $user->profile_img : ''), array('class' => 'form-control')) }}
                                                                </div>
                                                                @endif
                                                            @endif
                                                            <label for="Answer">Upload image <span
                                                                    class="text-danger">image size must be 250 x 200
                                                                    pixels</span></label>
                                                        <span class="error"> 
                                                            @if ($errors->has('profile_img'))
                                                                {{ $errors->first('profile_img') }}
                                                            @endif
                                                        </span>
                                                            <input type="file" name="profile_img" id="profile_img" accept="image/*" class="form-control shadow-none p_0">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb_20">
                                                        <button type="submit" class="profile-sub-btn">Submit</button>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
                                                @else
                                                    <p class="gj_no_data">No More Details to Edit!</p>
                                                @endif
                                            @else
                                                <p class="gj_no_data">No More Details to Edit!</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="changePassword text">
                                    <div class="tab-service">

                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>Change Password</h3>
                                                    </div>
                                                </div>
                                            </div>
                                             {{ Form::open(array('url' => 'forgot','class'=>'login100-form validate-form gj_ui_fp', 'files' => true)) }}
                                             <input type="hidden" name="user_id" value="{{ @$user->id }}" >
                                                <div class="row">
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="current_password">Current Password <span
                                                                    class="text-danger">*</span></label>
                                                            @if ($errors->has('current_password'))
                                                                {{ $errors->first('current_password') }}
                                                            @endif
                                                            <input type="text" name="current_password" class="form-control shadow-none"
                                                                placeholder="Enter Current Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="new_password">New Password <span
                                                                    class="text-danger">*</span></label>
                                                            @if ($errors->has('new_password'))
                                                                {{ $errors->first('new_password') }}
                                                            @endif
                                                            <input type="text" name="new_password" class="form-control shadow-none"
                                                                placeholder="Enter New Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="confirm_password">Confirm Password <span
                                                                    class="text-danger">*</span></label>
                                                            @if ($errors->has('confirm_password'))
                                                                {{ $errors->first('confirm_password') }}
                                                            @endif
                                                            <input type="text" name="confirm_password" class="form-control shadow-none"
                                                                placeholder="Enter Confirm Password">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 mb_20">
                                                        <button type="submit" class="profile-sub-btn">Submit</button>
                                                    </div>
                                                </div>
                                             {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="myOrders text">
                                    <div class="tab-service">
                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>My Orders</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($orders) && count($orders) != 0)
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="over-scrol">
                                                        <table class="table order-table table-striped">
                                                            <thead>
                                                                <tr>
                                                                   <th> Order ID </th>
                                                                    <th> Order Date </th>
                                                                    <th> Order Status </th>
                                                                    <th> Quantity </th>
                                                                    <th> Total Amount </th>
                                                                    <th> Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                 @foreach ($orders as $key => $value)
                                                                <tr>
                                                                     <td> 
                                                                        {{$value->order_code}}
                                                                        @if($value->ref_order_id)
                                                                            @if($value->Reference->order_code)
                                                                                <p class="gj_fd_ref_odr">Reference Order : {{$value->Reference->order_code}}</p>
                                                                            @endif
                                                                        @endif
                                                                    </td>
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
                                                                    <td> <i class="fa fa-inr"></i> {{$value->net_amount}} </td>
                                                                    <td class="stat"> 
                                                                        <div class="td-actions">
                                                                            <a href="{{ route('my_track_orders', ['id' => $value->id]) }}" class="gj_my_todr btn-info"> Track Order </a>
                    
                                                                        <a href="{{ route('my_view_orders', ['id' => $value->id]) }}" class="gj_my_vodr btn-warning"> View Order </a>
                    
                                                                        <a href="#" data-toggle="modal" data-target="#myModal{{$value->id}}" @if($value->order_status != 1) style="pointer-events: none;     background-color: #d43f3a !important; color:#fff !important;" title="Order Cancel Not Possible" @endif @if($value->cancel_approved == 2) style="pointer-events: none;     background-color: #7c1111 !important;" title="Order Cancel Request Rejected" @endif @if($value->cancel_approved == 3) style="pointer-events: none;     background-color: #FA8072 !important;" title="Order Cancel Request Processed" @endif class="gj_my_codr_req" data-id="{{$value->id}}"> Cancel Order </a>
                                                                        </div>
                    
                                                                        <div class="modal fade" id="myModal{{$value->id}}" role="dialog">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title">Term & Condition For Cancel Order</h4>
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        @if($general)
                                                                                            @if($general->cancel_terms)
                                                                                                <div class="gj_can_trm"><?php echo $general->cancel_terms; ?></div>
                                                                                            @else
                                                                                                <p>Please Click Accept Button</p>
                                                                                            @endif
                                                                                        @else
                                                                                            <p>Please Click Accept Button</p>
                                                                                        @endif
                                                                                    </div>
                    
                                                                                    <div class="modal-footer">
                                                                                        <a href="#" @if($value->order_status != 1) style="pointer-events: none;     background-color: #ffae42 !important;" title="Order Cancel Not Possible" @endif @if($value->cancel_approved == 2) style="pointer-events: none;     background-color: #7c1111 !important;" title="Order Cancel Request Rejected" @endif @if($value->cancel_approved == 3) style="pointer-events: none;     background-color: #FA8072 !important;" title="Order Cancel Request Processed" @endif class="gj_my_codr" data-id="{{$value->id}}"> Accept </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                    
                                                                        <?php  
                                                                            $n_date = date('Y-m-d');
                                                                            $r_date = date('Y-m-d', strtotime($value->delivery_date. ' + 14 days'));
                                                                        ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                 @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <p class="gj_no_data">Orders is Empty</p>
                                            @endif
                                           
                                        </div>

                                    </div>
                                </div>
                                <div class="completedOrders text">
                                    <div class="tab-service">
                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>Completed Orders</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($past_orders) && count($past_orders) != 0)
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <!--<p class="text-danger">Orders is Empty</p>-->
                                                    <div class="over-scrol ">
                                                        <table class="table order-table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th> Order ID </th>
                                                                    <th> Order Date </th>
                                                                    <th> Order Status </th>
                                                                    <th> Quantity </th>
                                                                    <th> Total Amount </th>
                                                                    <th> Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
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
                                                                    <td> <i class="fa fa-inr"></i> {{$value->net_amount}} </td>
                                                                    <td class="stat"> 
                                                                    <div class="td-actions">
                                                                         <a href="{{ route('my_track_orders', ['id' => $value->id]) }}" class="gj_my_todr btn-info"> Track Order </a>
                                                                        <a href="{{ route('my_review_orders', ['id' => $value->id]) }}" class="gj_my_rodr"> Review Order</a>
                                                                        <a href="{{ route('my_view_orders', ['id' => $value->id]) }}" class="gj_my_vodr btn-warning"> View Order </a>                   
                                                                    </td>
                                                                    </div>
                                                                       
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            
                                                        </table>
                                                         <div class="gj_myacc_pge">
                                                            {{$past_orders->links()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <p class="gj_no_data">Orders is Empty</p>
                                            @endif
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="cancelOrders text">
                                    <div class="tab-service">

                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>My Cancel Orders</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($cancel_orders) && count($cancel_orders) != 0)
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="over-scrol">
                                                        <table class="table order-table table-striped">
                                                            <thead>
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
                                                            </thead>
                                                            <tbody>
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
                                                            </tbody>
                                                        </table>
                                                          <div class="gj_myacc_pge">
                                                                {{$cancel_orders->links()}}
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                             @else
                                                <p class="gj_no_data">Orders is Empty</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="feedBack text">
                                    <div class="tab-service">
                                        <div class="profile-container">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="account-top-title">
                                                        <h3>Feedback</h3>
                                                    </div>
                                                </div>
                                            </div>
                                             <?php
                                                $u_log = session()->get('user');
                                            ?>
                                            @if($u_log)
                                                @if($u_log->user_type == 4)
                                                    {{ Form::open(array('url' => 'send_feedback','class'=>'gj_fuser_form','files' => true)) }}
                                                        @if($u_log)
                                                            {{ Form::hidden('user_id', $u_log->id, array('class' => 'form-control gj_fuser_id')) }}
                                                        @endif
                                                <div class="row">
                                                    <div class="col-lg-12 mb_20">
                                                        <div class=" profile-field">
                                                            <label for="Subject">Subject <span
                                                                    class="text-danger">*</span></label>
                                                            <span class="error">* 
                                                                @if ($errors->has('subject'))
                                                                    {{ $errors->first('subject') }}
                                                                @endif
                                                            </span>
        
                                                            {{ Form::text('subject', ($user->subject ? $user->subject : Input::old('subject')), array('class' => 'form-control gj_subject','placeholder' => 'Enter Subject in English')) }}
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-lg-12  mb_20">
                                                        <div class="profile-field">
                                                            <label for="Message">Message  <span
                                                                    class="text-danger">*</span></label>
                                                             <span class="error">* 
                                                        @if ($errors->has('message'))
                                                            {{ $errors->first('message') }}
                                                        @endif
                                                    </span>

                                                    {{ Form::textarea('message', ($user->message ? $user->message : Input::old('message')), array('class' => 'form-control gj_message', 'rows' => '5','placeholder' => 'Enter Message in English')) }}
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-lg-12 mb_20">
                                                        <button type="submit" class="profile-sub-btn">Submit</button>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
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
                </div>
            </div>
        </section>

@endsection

@section('before_scripts')
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
        $('p.alert').delay(5000).slideUp(500); 
        $("#country").select2();
        $("#state").select2();
        $("#city").select2();
        $("#question").select2();

        var trgr = false;
        var url = document.location.href;
        var res = url.toString().split('#');
        var resu = url.toString().split('my_account');

        if(res[1]) {
            var trgr = res[1];
        }

        if(trgr) {
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').tab('show');
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').parent().addClass('active');
        }

        /*@if(isset($orders) && count($orders) != 0)
            if(resu[1]) {
                if(resu[1] == '?page=<?php echo $orders->currentPage(); ?>') {
                    $('.vertical-tab .nav-tabs li a[href="#Section4"]').tab('show');
                    $('.vertical-tab .nav-tabs li').removeClass('active'); 
                    $('.vertical-tab .nav-tabs li a[href="#Section4"]').parent().addClass('active');
                }
            }
        @endif*/

        var country = $('#country').select2('val');
        @if(@$user->state)
            var state = <?php echo $user->state; ?>;
        @else
            var state = 0;
        @endif

        @if(@$user->city)
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
                                            icon: 'fa fa-ban',
                                            theme: 'modern',
                                            closeIcon: true,
                                            animation: 'scale',
                                            type: 'blue',
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
                                type: 'blue',
                                buttons: {
                                    Ok: function(){
                                    }
                                }
                            });
                        }
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select Country!',
                            icon: 'fa fa-ban',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'blue',
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
            /*$.confirm({
                title: '',
                content: 'Please Select Country!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    Ok: function(){
                    }
                }
            });*/
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
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        Ok: function(){
                            window.location.reload();
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
                            type: 'blue',
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
                type: 'blue',
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
                            type: 'blue',
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
                type: 'blue',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });
</script>

<!-- Cancel Order Script Start -->
<script type="text/javascript">
  $('body').on('click', '.gj_my_codr', function () {
    var id = $(this).attr('data-id') || 0;
    var th = $(this);

    if (id != 0) {
        $.confirm({
            title: '',
            content: 'Are You Sure to Cancel this Order?',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'purple',
            buttons: {
                Ok: function () {
                    $('#myModal' + id).modal('hide');
                    $('.modal-backdrop').remove();
                    $.ajax({
                        type: 'post',
                        url: '{{url('/customer_cancel_order')}}',
                        data: {id: id, type: 'cancel'},
                        success: function (data) {
                            if (data == 1) {
                                $.confirm({
                                    title: '',
                                    content: 'Your Order Cancel Request Sent Successfully!!',
                                    icon: 'fa fa-check',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'green',
                                    buttons: {
                                        Ok: function () {
                                            // $('#myModal' + id).modal('hide'); // Close modal properly
                                            // $('.modal-backdrop').remove(); // Remove modal backdrop
                                            window.location.href = "{{ route('my_account') }}";
                                        }
                                    }
                                });
                            } else if (data == 5) {
                                $.confirm({
                                    title: '',
                                    content: 'You can only send a cancel request 24 hours after ordering!',
                                    icon: 'fa fa-exclamation',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'red',
                                    buttons: {
                                        Ok: function () {
                                            $('#myModal' + id).modal('hide');
                                            $('.modal-backdrop').remove();
                                            window.location.href = "{{ route('my_account') }}#Section4";
                                        }
                                    }
                                });
                            } else {
                                $.confirm({
                                    title: '',
                                    content: 'No Way to Cancel This Order!',
                                    icon: 'fa fa-ban',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'red',
                                    buttons: {
                                        Ok: function () {
                                            $('#myModal' + id).modal('hide');
                                            $('.modal-backdrop').remove();
                                            window.location.href = "{{ route('my_account') }}#Section4";
                                        }
                                    }
                                });
                                th.css("pointer-events", "none");
                            }
                        }
                    });
                },
                Cancel: function () {
                    $('#myModal' + id).modal('hide');
                    $('.modal-backdrop').remove();
                }
            }
        });
    } else {
        $.confirm({
            title: '',
            content: 'You cannot cancel this order!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                Ok: function () {
                    $('#myModal' + id).modal('hide');
                    $('.modal-backdrop').remove();
                    window.location.href = "{{ route('my_account') }}#Section4";
                }
            }
        });
    }
});

</script>
<!-- Cancel Order Script End -->

<!-- Return Order Script Start -->
<!-- <script type="text/javascript">
    $('body').on('click','.gj_my_rodr_req',function() {
        var id = 0;                                                       
        var th = $(this);                                                       
        if($(this).attr('data-id')){
            id = $(this).attr('data-id');
        }   
    
        if(id != 0) {
            $.confirm({
                title: '',
                content: 'Are You Sure to Return / Replace this Order?',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                        $.ajax({
                            type: 'post',
                            url: '{{url('/customer_cancel_order')}}',
                            data: {id: id, type: 'cancel'},
                            success: function(data) {
                                if(data == 1) {
                                    $.confirm({
                                        title: '',
                                        content: 'Your Order Cancel Request Send Successfully!!',
                                        icon: 'fa fa-check',
                                        theme: 'modern',
                                        closeIcon: true,
                                        animation: 'scale',
                                        type: 'green',
                                        buttons: {
                                            Ok: function(){
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                                window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
                                            },
                                            Cancel:function() {
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                            }
                                        }
                                    });
                                } else if(data == 5){
                                    $.confirm({
                                        title: '',
                                        content: 'You can cancel order request send after two days of ordering!',
                                        icon: 'fa fa-exclamation',
                                        theme: 'modern',
                                        closeIcon: true,
                                        animation: 'scale',
                                        type: 'red',
                                        buttons: {
                                            Ok: function(){
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                                window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
                                            },
                                            Cancel:function() {
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                            }
                                        }
                                    });
                                    window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
                                } else {
                                    $.confirm({
                                        title: '',
                                        content: 'No Way to Cancel This Order!',
                                        icon: 'fa fa-ban',
                                        theme: 'modern',
                                        closeIcon: true,
                                        animation: 'scale',
                                        type: 'red',
                                        buttons: {
                                            Ok: function(){
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                                window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
                                            },
                                            Cancel:function() {
                                                $('.modal').removeClass('show');
                                                $('.modal-backdrop').removeClass('show');
                                            }
                                        }
                                    });
                                    th.css("pointer-events", "none");
                                }
                            }
                        });
                    },
                    Cancel:function() {
                        $('.modal').removeClass('show');
                        $('.modal-backdrop').removeClass('show');
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'You Are Not Cancelled this Order!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                        $('.modal').removeClass('show');
                        $('.modal-backdrop').removeClass('show');
                        window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
                    },
                    Cancel:function() {
                        $('.modal').removeClass('show');
                        $('.modal-backdrop').removeClass('show');
                    }
                }
            });

            window.location.href = "<?php echo route('my_account').'#Section4'; ?>";
        }
    });
</script> -->
<!-- Return Order Script End -->    
@endsection