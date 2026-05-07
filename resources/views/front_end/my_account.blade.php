<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>

@extends('layouts.frontend')
@section('title', 'My Account')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>

.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: rgb(15 2 2 / 70%) !important;
}
    .country-code span select {
    width: 79px !important;
}
#flash-message-container {
    margin-top: 20px;
}

.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 16px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}

.cancel_order tr td {
    padding: 15px 7px !important;
}

  #orderCancelTable thead th {
    /*padding-right: 25px !important;*/
  }
  
  /*#onGoingTable thead th {*/
  /*  padding-right: 25px !important;*/
  /*}*/
  /*#completedTable thead th {*/
  /*  padding-right: 25px !important;*/
  /*}*/
  
  #orderTable thead th {
    /*padding-right: 25px !important;*/
  }
  
  .order-table tr th {
    padding: 15px 6px !important;
}
  
  .table-scroll-btn button#tbScrollBack {
    margin-left: -34px !important;
}
        ul.nav-menu li.nav-item a.nav-link {
    color: #222 !important;
}
div.click-search,div.search-items-top,.top-right ul li a.cart_rang{
    box-shadow:none;
        border: 1px solid #827e7e8f;
}
div.click-search i,div.search-items-top i,div.search-items-top input,div.search-items-top input::placeholder,.top-right ul li a.cart_rang{
    color:#222 !important;
}
header{
    border-bottom:1px solid #ccc;
}
</style>
<div class="cover-head"></div>
@section('content')
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--             @if (session('errors'))-->
<!--                <div class="gj_msg">-->
<!--                        @foreach (session('errors')->all() as $error)-->
<!--                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }} auto-dismiss">-->
<!--                                {{ $error }}-->
<!--                            </p>-->
<!--                        @endforeach-->
<!--                </div>-->
<!--            @endif-->
<!--            </div>-->
<!--    </div>-->
<!--</div>-->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="flash-message-container"></div>
            </div>
        </div>
    </div>

<section class="section-padding border-pt mt-3">
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0;">
                <div class="content">
                    <input type="radio" name="slider" checked id="myProfile" class="none-inp">
                    <input type="radio" name="slider" id="changePassword" class="none-inp">
                    <input type="radio" name="slider" id="myAddress" class="none-inp">
                    <input type="radio" name="slider" id="myWishlist" class="none-inp">
                    <input type="radio" name="slider" id="myOrders" class="none-inp">
                    <input type="radio" name="slider" id="completedOrders" class="none-inp">
                    <input type="radio" name="slider" id="cancelOrders" class="none-inp">
                    <input type="radio" name="slider" id="customiseOrders" class="none-inp"> 
                    <input type="radio" name="slider" id="notifications" class="none-inp">
                    <input type="radio" name="slider" id="deactivate" class="none-inp">
                    <input type="radio" name="slider" id="feedBack" class="none-inp">
                     <div class="account-side-mob">
                         <button type="button" onclick="openNav()" class="account-sidebar-open"><i class="fa-solid fa-bars-staggered"></i></button>
                     </div>

                    <div class="list filtersidenav" id="myFilterSidebar">
                        <div class="account-side-mob account-side-mob2">
                             <button type="button" class="account-sidebar-close"  onclick="openNav()"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </div>
                        
                        <label for="myProfile" class="myProfile" onclick="openNav()">
                            <i class="fa-regular fa-user"></i>
                            <span>Your Profile</span>
                        </label>
                        <label for="changePassword" class="changePassword" onclick="openNav()">
                            <i class="fa-solid fa-lock-open"></i>
                            <span>Change Password</span>
                        </label>
                        <label for="myAddress" class="myAddress" onclick="openNav()">
                            
                            <i class="fa-solid fa-location-dot"></i>
                            <span>My Address</span>
                        </label>
                        <label for="myWishlist" class="myWishlist" onclick="openNav()">
                            <i class="fa-solid fa-heart"></i>
                            <span>My Wishlist</span>
                        </label>
                       <label for="myOrders" class="myOrders" onclick="openNav()">
                        <i class="fa-solid fa-clipboard-list"></i>
                            <span>My Ongoing Orders</span>
                        </label>
                        <label for="completedOrders" class="completedOrders" onclick="openNav()">
                            <i class="fa-regular fa-circle-check"></i>
                            <span>My Completed Orders</span>
                        </label>
                         <label for="cancelOrders" class="cancelOrders" onclick="openNav()">
                            <i class="fa-regular fa-circle-xmark"></i>
                            <span>My Cancelled Orders</span>
                        </label>
                        <!-- <label for="customiseOrders" class="customiseOrders" onclick="openNav()">-->
                        <!--    <i class="fa-regular fa-circle-xmark"></i>-->
                        <!--    <span>My Customise Orders</span>-->
                        <!--</label>-->
                        <!-- <label for="notifications" class="notifications" onclick="openNav()">-->
                        <!--    <i class="fa-regular fa-bell"></i>-->
                        <!--    <span>Notification Preference Settings</span>-->
                        <!--</label>-->
                         <label for="deactivate" class="deactivate" onclick="openNav()">
                            <i class="fa-regular fa-trash-can"></i>
                            <span>Deactivate Account</span>
                        </label>
                        <!-- <label for="feedBack" class="feedBack">
                            <span>Feedback</span>
                        </label> -->
                        <label>
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
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
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-6">
                                            <div class="profile-preview">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-preview-img">
                                                           
                                                            <?php 
                                                             @$user = session()->get('user');
                                                            $file_path = 'images/profile_img';
                                                            ?>
                                                            @if(isset($user))
                                                                @if(@$user->profile_img != '')
                                                                    <img src="{{ asset($file_path.'/'.$user->profile_img)}}" alt="">
                                                                    @else
                                                                      <img src="{{ asset($noimage_path.'/'.$noimage->profile_no_img)}}" alt="">
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="profile-preview-info">
                                                            <ul>
                                                                <li>Name : <span>
                                                                    @php
                                                                        $fullName = trim($user->first_name . ' ' . $user->last_name);
                                                                    @endphp
                                                                
                                                                    {{ $fullName ?: $user->full_name }}
                                                                    </span></li>
                                                                <li>Email : <span>{{$user->email}}</span></li>
                                                                <li>Phone : <span>{{$user->phone}}</span></li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                     @if($user)
                                        @if(@$user->user_type == 4)
                                         <form action="{{route('update_profile')}}" class="gj_user_form" method="POST" enctype="multipart/form-data">
                                             @csrf
                                                @if($user)
                                                     <input type="hidden" name="user_id" class="form-control gj_user_id" value="{{ @$user->id }}" >
                                                @endif
                                        <div class="row">
                                            <div class="col-lg-6 mb-1">
                                                <div class=" profile-field">
                                                    @php
                                                        $name = trim(($user_data->first_name ?? '') . ' ' . ($user_data->last_name ?? ''));
                                                        $fullNameValue = $name ?: ($user_data->full_name ?? old('full_name'));
                                                    @endphp
                                                    <label for="name">Full Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control shadow-none" name="full_name" value="{{ $fullNameValue }}" placeholder="Enter Your Name">
                                                    <span class="error"> *
                                                        @if ($errors->has('full_name'))
                                                            {{ $errors->first('full_name') }}
                                                        @endif
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-6  mb-1">
                                                <div class=" profile-field">
                                                    <label for="Email">E-mail <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" class="form-control shadow-none gj_email" name="email" value="{{$user->email ? $user->email : old('email')}}" placeholder="Enter Your Email">
                                                    
                                                    <input type="hidden" class="form-control shadow-none" name="bussiness_name" value="{{$user->bussiness_name ? $user->bussiness_name : old('bussiness_name')}}" placeholder="Enter Name">
                                                    
                                                    <input type="hidden" class="form-control shadow-none" name="buss_reg_no" value="{{$user->buss_reg_no ? $user->buss_reg_no : old('buss_reg_no')}}" placeholder="Enter Name">
                                                     <span class="error">* 
                                                        @if ($errors->has('email'))
                                                            {{ $errors->first('email') }}
                                                        @endif
                                                    </span>
                                                       
                                                </div>
                                            </div>
                                            <div class="col-lg-6  mb-3">
                                                <div class=" profile-field">
                                                    <label for="Phone">Phone <span
                                                            class="text-danger">*</span></label>
                                                  <div class="country-code">
                                                    <span>
                                                        <select name="country_code" class="form-select shadow-none" id="countryCodeSelect">
                                                            <!--<option value="">Select Country Code</option>-->
                                                        </select>
                                                    </span>
                                                    <input type="number" class="form-control shadow-none gj_phone" name="phone" value="{{@$user->phone ? $user->phone : old('phone')}}"
                                                    placeholder="Enter Your Phone">
                                                    
                                                  </div>
                                                  <span class="error">
                                                        @if ($errors->has('phone'))
                                                            {{ $errors->first('phone') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  mb-3">
                                                <div class=" profile-field">
                                                    <label for="">Date of Birth </label>
                                                       <div class="choose-date-bookings">
                               
                                                        <input type="date" id="datepicker" name="dob" value="{{@$user_data->dob ? $user_data->dob : old('dob')}}" autocomplete="off" class="form-control shadow-none" placeholder="dd-mm-yy">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12   mb-1">
                                                <div class="profile-field">
                                                    <label for="Address">Address <span
                                                            class="text-danger">*</span></label>
                                                    <textarea placeholder="(House No, Building, Street, Area)" name="address1"
                                                        class="form-control shadow-none">{{@$user_data->address1 ? $user_data->address1 : old('address1')}}</textarea>
                                                        <span class="error">* 
                                                        @if ($errors->has('address1'))
                                                            {{ $errors->first('address1') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  mb-1">
                                                <div class=" profile-field">
                                                    <label for="City">City <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control shadow-none" name="address2" value="{{@$user_data->address2 ? $user_data->address2 : old('address2')}}"
                                                        placeholder="Enter Your City">
                                                        <span class="error">* 
                                                            @if ($errors->has('address2'))
                                                                {{ $errors->first('address2') }}
                                                            @endif
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  mb-1">
                                                <div class=" profile-field">
                                                    <label for="Pincode">Pincode <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control shadow-none" name="pincode" value="{{@$user_data->pincode ? $user_data->pincode : old('pincode')}}"
                                                        placeholder="Enter Your Pincode">
                                                        
                                                    <input type="hidden" class="form-control shadow-none" name="user_type" value="{{@$user_data->user_type ? $user_data->user_type : old('user_type')}}"
                                                        placeholder="Enter User user_type">
                                                        <span class="error">* 
                                                        @if ($errors->has('pincode'))
                                                            {{ $errors->first('pincode') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                         
                                            <div class="col-lg-12  mb-3">
                                                <div class=" profile-field">
                                                    <label for="Answer">Upload Profile image    <span
                                                            class="text-danger">*</span> <span
                                                            class="text-danger">image size must be 250 x 200
                                                            pixels</span></label>
                                                    <input type="file" name="profile_img" id="profile_img" class="form-control shadow-none p_0">
                                                     <span class="error"> 
                                                        @if ($errors->has('profile_img'))
                                                            {{ $errors->first('profile_img') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12  mb-3">
                                                <button type="submit" class="profile-sub-btn">Submit</button>
                                            </div>
                                        </div>
                                    </form>
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
                                    <form action="{{route('check_forgot')}}" method="POST" class="login100-form" enctype="multipart/form-data">
                                        @csrf
                                         <input type="hidden" name="user_id" value="{{ @$user->id }}" >
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class=" profile-field">
                                                    <label for="currentPassword">Current Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="current_password" class="form-control shadow-none"
                                                        placeholder="Enter Current Password">
                                                          @if ($errors->has('current_password'))
                                                                {{ $errors->first('current_password') }}
                                                            @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class=" profile-field">
                                                    <label for="newPas">New Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="new_password" class="form-control shadow-none"
                                                        placeholder="Enter New Password">
                                                         @if ($errors->has('new_password'))
                                                                {{ $errors->first('new_password') }}
                                                            @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <div class=" profile-field">
                                                    <label for="cPas">Confirm Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="confirm_password" class="form-control shadow-none"
                                                        placeholder="Enter Confirm Password">
                                                        @if ($errors->has('confirm_password'))
                                                            {{ $errors->first('confirm_password') }}
                                                        @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <button type="submit" class="profile-sub-btn">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="myAddress text">
                            <div class="tab-service">
                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3>My Address</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="#!" data-bs-toggle="modal" data-bs-target="#Addresmodal" class="add-address-btn">Add new address</a>
                                        </div>
                                        @foreach($address as $key => $value)
                                        <div class="col-lg-12 mb-3">
                                            <div class="address-container">
                                                <div class="address-icon">
                                                    <i class="fa-solid fa-house"></i>
                                                </div>
                                                <div class="address-dt">
                                                    <h3>{{$value->address_type}}  @if($value->is_default)
                                                            <a href="#!" class="active">Default</a>
                                                            @else
                                                            <a  href="javascript:void(0);" class="make-default" data-id="{{$value->id}}">Make Default</a>
                                                        @endif
                                                        </h3>
                                                    <p>{{ $value->address2 }} {{ $value->address3 }}<br> {{ $value->locality }}, {{ $value->pincode }} </p>
                                                    <div class="addres-dt-icons">
                                                        <a href="#!" data-bs-toggle="modal" data-bs-target="#Addresmodal" data-id="{{ $value->id }}"  class="edit-address-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        <a href="{{ route('address.delete', $value->id) }}"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="myWishlist text">
                            <div class="tab-service">
                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3>My Wishlist</h3>
                                            </div>
                                        </div>
                                    </div>
                                     @if (isset($wishlist) && count($wishlist) != 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="wishlist-container account-wishlist-table">
                                                <div class="over-scrol">
                                                 <table class="table wishlist-table table-borderless ">
                                                     <thead>
                                                      <tr>
                                                          <th>
                                                             <input type="checkbox" id="select_all" class="select-all-checkbox">
                                                          </th>
                                                          <th></th>
                                                          <th>Product Name</th>
                                                          <th>Price</th>
                                                          <th>Stock Status</th>
                                                          <!--<th>Actions</th>-->
                                                      </tr>
                                                     </thead>
                                                     <tbody>
                                                    @foreach ($wishlist as $key =>$value)
                                                        <tr>
                                                            <td>
                                                                 <input type="checkbox" class="select-item-checkbox" data-product-id="{{ $value->product_id }}">
                                                                <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">
                                                                <input type="hidden" name="w_id[]" id="wishlist_{{$value->id}}" class="gj_w_id" value="{{$value->id}}">
                                                                {{--<form method="post" action="{{route('delete_wishlist')}}" id="removeWishlist" accept-charset="UTF-8">
                                                                    <input name="utf8" type="hidden" value="✓">
                                                                    <input type="hidden" name="id" value="{{$value->id}}">
                                                                    <button type="submit" class="gj_btn_wish_rem wishlist-delete"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button>
                                                                  </form>--}}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('view_products', ['id' => $value->product_id]) }}"><img src="{{ asset($product_path.'/'.$value->image) }}" alt="" class="wishlist-product-img">  </a>
                                                                 <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_w_img" value="{{$value->image}}">
                                                                   <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_w_name" value="{{$value->name}}">
                                                                <input type="hidden" name="discounted_price[]" id="dp_{{$value->product_id}}" class="gj_w_dp" value="{{$value->original_price}}">
                                                                <input type="hidden" name="name[]" id="op_{{$value->product_id}}" class="gj_w_op" value="{{$value->original_price}}">
                                                            </td>
                                                            <td> {{$value->name}}</td>
                                                            <td class="td-price">₹ {{$value->discounted_price}}</td>
                                                            <td>
                                                             @if(isset($value->Products->onhand_qty) && $value->Products->onhand_qty != 0)
                                                                 In-stock
                                                              @else
                                                                  Out of stock
                                                              @endif
                                                            </td>
                                                            <!--<td>-->
                                                            <!--  <button type="button" class="wishlist-cart-btn gj_add2cart" data-cart-id="{{$value->product_id}}">Add to Cart</button>-->
                                                            <!--</td>-->
                                                        </tr>
                                                    @endforeach
                                                       </tbody>
                          
                                                  </table>
                                                    <div class="wishlist-actions add-cart-wishlist-btns">
                                                        <button type="button" id="add_to_cart_selected" class="wishlist-cart-btn btn" style="background-color:#198723;color: #fff;border-radius: 5px;">Add To Cart</button>
                                                        <button type="button" id="delete_selected" class="btn btn-danger">Delete Selected</button>
                                                    </div>
                                                </div>
                                             </div>
                                        </div>
                                    </div>
                                    @else
                                        <p class="text-danger text-center">Wishlist is Empty</p>
                                    @endif
                                </div>
                            </div>
                         </div>
                        <div class="myOrders text">
                            <div class="tab-service">
                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3>My Ongoing Orders</h3>
                                            </div>
                                        </div>
                                    </div>
                                     @if(isset($orders) && count($orders) != 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="over-scrol scroll-data-table on-table">
                                                <table class="table order-table table-striped" id="onGoingTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="odr-min-width-130">Order ID</th>
                                                            <th class="odr-min-width-130">Order Date</th>
                                                            <th>Order Status</th>
                                                            <!--<th>Estimated <br>Delivery Date </th>-->
                                                            <th>Quantity</th>
                                                            <th>Total Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         @foreach ($orders as $key => $value)
                                                        <tr>
                                                            <td >{{$value->order_code}}</td>
                                                            <td class="nowrap" data-order="{{ $value->order_date ? date('Y-m-d', strtotime($value->order_date)) : '' }}">{{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}} </td>
                                                            <td>
                                                                 @if($value->order_status == 1)
                                                                    {{'Order Placed'}}
                                                                @elseif($value->order_status == 2)
                                                                    Order Dispatched
                                                                @elseif($value->order_status == 3)
                                                                    Order Delivered
                                                                @elseif($value->order_status == 4)
                                                                    Order Completed
                                                                @elseif($value->order_status == 5)
                                                                    Order Cancelled
                                                                @else
                                                                    {{'------'}}
                                                                @endif
                                                            </td>
                                                            <!--<td class="nowrap">-</td>-->
                                                            <td>{{$value->total_items}}</td>
                                                            <td>₹ {{$value->net_amount}}</td>
                                                            <td>
                                                                <div class="td-actions">
                                                                    <a href="{{ route('my_track_orders', ['id' => $value->id, 'return_url' => 'myOrders']) }}">Track Order</a>
                                                                    <a href="{{ route('my_view_orders', ['id' => $value->id, 'return_url' => 'myOrders']) }}" >View Order</a>
                                                                    <!--<a href="#" data-bs-toggle="modal" data-bs-target="#myModal{{$value->id}}" @if($value->order_status != 1) style="pointer-events: none;     background-color: #6c757d !important; color:#fff !important;" title="Order Cancel Not Possible" @endif @if($value->cancel_approved == 2) style="pointer-events: none;     background-color: #7c1111 !important;" title="Order Cancel Request Rejected" @endif @if($value->cancel_approved == 3) style="pointer-events: none;     background-color: #FA8072 !important;" title="Order Cancel Request Processed" @endif class="gj_my_codr_req" data-id="{{$value->id}}">Cancel Order</a>-->
                                                                <a href="#"
                                                                   class="gj_my_codr_req"
                                                                   data-id="{{$value->id}}"
                                                                   data-order_status="{{$value->order_status}}"
                                                                   data-cancel_approved="{{$value->cancel_approved}}"
                                                                   data-created_at="{{ \Carbon\Carbon::parse($value->created_at)->timestamp }}" {{-- UNIX timestamp --}}
                                                                   style="@if($value->order_status != 1 || $value->cancel_approved == 2 || $value->cancel_approved == 3 || \Carbon\Carbon::parse($value->created_at)->diffInHours(now()) > 24)
                                                                             pointer-events: auto; background-color: #6c757d !important; color:#fff !important;
                                                                          @endif"
                                                                   title="@if($value->order_status != 1) Order Cancel Not Possible
                                                                          @elseif($value->cancel_approved == 2) Order Cancel Request Rejected
                                                                          @elseif($value->cancel_approved == 3) Order Cancel Request Processed
                                                                          @elseif(\Carbon\Carbon::parse($value->created_at)->diffInHours(now()) > 24) Order placed more than 24 hours ago
                                                                          @endif">
                                                                   Cancel Order
                                                                </a>

                                                                </div>
                                                                <div class="modal fade " id="myModal{{$value->id}}" role="dialog">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content modal-terms-pop">
                                                                            <div class="modal-header">
                                                                                <h3>Term & Condition For Cancel Order</h3>
                                                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            
                                                                            <div class="modal-footer acpt-tn">
                                                                                <a  href="#" @if($value->order_status != 1) style="pointer-events: none;     background-color: #ffae42 !important;" title="Order Cancel Not Possible" @endif @if($value->cancel_approved == 2) style="pointer-events: none;     background-color: #7c1111 !important;" title="Order Cancel Request Rejected" @endif @if($value->cancel_approved == 3) style="pointer-events: none;     background-color: #FA8072 !important;" title="Order Cancel Request Processed" @endif class="gj_my_codr" data-id="{{$value->id}}"> Accept </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                         @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <p class="text-danger text-center">Orders is Empty</p>
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
                                                <h3>My Completed Orders</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($past_orders) && count($past_orders) != 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="over-scrol scroll-data-table on-table">
                                                <table class="table order-table table-striped" id="completedTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="odr-min-width-130">Order ID</th>
                                                            <th class="odr-min-width-130">Order Date</th>
                                                            <th>Order Status</th>
                                                            <th>Quantity</th>
                                                            <th>Total Amount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($past_orders as $key => $value)
                                                        <tr>
                                                            <td> {{$value->order_code}} </td>
                                                            <td data-order="{{ $value->order_date ? date('Y-m-d', strtotime($value->order_date)) : '' }}"> {{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}} </td>
                                                            <td> 
                                                                @if($value->order_status == 1)
                                                                    {{'Order Placed'}}
                                                                @elseif($value->order_status == 2)
                                                                    Order Dispatched
                                                                @elseif($value->order_status == 3)
                                                                    Order Delivered
                                                                @elseif($value->order_status == 4)
                                                                    Order Completed
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
                                                                     <a href="{{ route('my_track_orders', ['id' => $value->id, 'return_url' => 'completedOrders']) }}" class="gj_my_todr btn-info"> Track Order </a>
                                                                    <a href="{{ route('my_review_orders', ['id' => $value->id]) }}" class="gj_my_rodr"> Review Order</a>
                                                                    <a href="{{ route('my_view_orders', ['id' => $value->id, 'return_url' => 'completedOrders']) }}" class="gj_my_vodr btn-warning"> View Order </a>                   
                                                                </td>
                                                            </div>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                     
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                        <p class="text-danger text-center">Orders is Empty</p>
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
                                                <h3>My Cancelled Orders</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($cancel_orders) && count($cancel_orders) != 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="scroll-tb-pos">
                                                <div class="over-scrol scroll-data-table on-table"  id="scrollTB">
                                                <table class="table order-table table-striped cancel_order" id="orderCancelTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="odr-min-width-130">Order ID</th>
                                                            <th class="odr-min-width-130" >Order Date</th>
                                                            <!--<th>Cancel Date</th>-->
                                                            <!--<th>Remarks</th>-->
                                                            <th>Order Status</th>
                                                            <!--<th>Approval Status</th>-->
                                                            <th>Refund Status</th>
                                                            <!--<th>Quantity</th>-->
                                                            <!--<th>Total Amount</th>-->
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cancel_orders as $key => $value)
                                                        <tr>
                                                            <td>{{$value->order_code}}</td>
                                                            <td data-order="{{ $value->order_date ? date('Y-m-d', strtotime($value->order_date)) : '' }}">{{$value->order_date ? date('d-m-Y', strtotime($value->order_date)) : '------'}}</td>
                                                            {{--<td>{{$value->cancel_date ? date('d-m-Y', strtotime($value->cancel_date)) : '------'}}</td>
                                                            <td>{{ \Illuminate\Support\Str::ucfirst($value->cancel_remarks) }}</td> --}}
                                                            <td>
                                                               {{-- @if($value->order_status == 1)
                                                                    {{'Order Placed'}}
                                                                @elseif($value->order_status == 2)
                                                                    Order Dispatched
                                                                @elseif($value->order_status == 3)
                                                                    Order Delivered
                                                                @elseif($value->order_status == 4)
                                                                    Order Completed
                                                                @elseif($value->order_status == 5)
                                                                    Order Cancelled
                                                                @else
                                                                    {{'------'}}
                                                                @endif --}}
                                                                
                                                                 {{ $value->order_status_text ?? '------' }}
                                                            </td>
                                                           {{-- <td>
                                                                 @if($value->cancel_approved == 1)
                                                                    {{'Approved'}}
                                                                @elseif($value->cancel_approved == 2)
                                                                    Rejected
                                                                @elseif($value->cancel_approved == 3)
                                                                    Pending Approval
                                                                @else
                                                                    {{'------'}}
                                                                @endif
                                                            </td> --}}
                                                            <td>
                                                                 @if($value->refund_status == 'pending')
                                                                    {{'Pending'}}
                                                                @elseif($value->refund_status == 'complete')
                                                                    Complete
                                                                @else
                                                                    {{'------'}}
                                                                @endif
                                                            </td>
                                                           {{-- <td>{{$value->total_items}} </td>
                                                            <td>₹ {{$value->net_amount}} </td> --}}
                                                            <td class="stat"> 
                                                                <div class="td-actions">
                                                                     <!--<a href="{{ route('my_track_orders', ['id' => $value->id, 'return_url' => 'cancelOrders']) }}" class="gj_my_todr btn-info"> Track Order </a>-->
                                                                     <a href="{{ route('my_view_orders', ['id' => $value->id, 'return_url' => 'cancelOrders']) }}" class="gj_my_vodr btn-warning"> View Order </a>                   
                                                                </td>
                                                            </div>
                                                            
                                                        </tr>
                                                      @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="table-scroll-btn">
                                                     <button id="tbScrollBack" type="button"><i class="fa-solid fa-angle-left"></i></button>
                                             <button id="tbScrollNext" type="button"><i class="fa-solid fa-chevron-right"></i></button>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                     @else
                                       <p class="text-danger text-center">Orders is Empty</p>
                                    @endif
                                   
                                </div>
                            </div>
                        </div>
                        <div class="customiseOrders text">
                            <div class="tab-service">

                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3>My Customise Orders</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!--middle-table-data-->
                                    @if(isset($cust_orders) && count($cust_orders) != 0)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="scroll-tb-pos">
                                                <div class="over-scrol scroll-data-table"  id="scrollTB">
                                                <table class="table order-table table-striped  table-sm img-table-cs" id="orderTable">
                                                    <thead>
                                                        <tr>
                                                            <th class="odr-min-width-130">Order ID</th>
                                                            <th class="odr-min-width-130">Order Date</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th> Image</th>
                                                            <th>Phone No</th>
                                                            <th style="width: 100px;">Message</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($cust_orders as $key => $value)
                                                        <tr>
                                                            <td> {{$value->order_code}} </td>
                                                            <td data-order="{{ $value->created_at ? date('Y-m-d', strtotime($value->created_at)) : '' }}"> {{$value->created_at ? date('d-m-Y', strtotime($value->created_at)) : '------'}} </td>
                                                            <td>{{$value->name }}</td>
                                                            <td>{{$value->email}}</td>
                                                            <td>
                                                                @if(!empty($value->uploaded_image))
                                                                    <img src="{{ asset($value->uploaded_image) }}" alt="Uploaded Image" width="80">
                                                                @else
                                                                    <span>No Image</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                 {{$value->phone_number }}
                                                            </td>
                                                            <td> 
                                                            <div class="td-actions">
                                                                <button type="button" class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#messageModal{{ $value->id }}">View</button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="messageModal{{ $value->id }}" tabindex="-1" aria-labelledby="messageModalLabel{{ $value->id }}" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="messageModalLabel{{ $value->id }}"> Message</h5>
                                                                                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body content-modal">
                                                                                    {{ $value->message }}
                                                                                </div>
                                                                                <div class="modal-footer justify-content-center">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                                </td>
                                                        </tr>
                                                      @endforeach
                                                    </tbody>
                                                </table>
                                                 
                                            </div>
                                            <div class="table-scroll-btn">
                                                     <button id="tbScrollBack" type="button"><i class="fa-solid fa-angle-left"></i></button>
                                             <button id="tbScrollNext" type="button"><i class="fa-solid fa-chevron-right"></i></button>
                                                 </div>
                                            </div>
                                            
                                            <div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                     @else
                                       <p class="text-danger text-center">Orders is Empty</p>
                                    @endif
                                   
                                </div>
                            </div>
                        </div>
                        <div class="notifications text">
                            <div class="tab-service">
                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3> Notification Preference Settings</h3>
                                            </div>
                                        </div>
                                    </div>
                                   @php
                                        $user = session()->get('user');
                                        $prefs = null;
                                        if ($user) {
                                            $user_data = \App\User::find($user->id);
                                            $prefs = $user_data?->notificationPreference;
                                        }
                                    @endphp
                                    <form method="POST" action="{{ route('notification.preferences.update') }}">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <div class="notification-prefer">
                                                <p>Email Notifications</p>
                                                <ul>
                                                    <li>
                                                        
                                                        <input type="checkbox" class="form-check shadow-none" id="Orderrelated" name="order_related"  {{ $prefs && $prefs->order_related ? 'checked' : '' }}>
                                                        <label for="Orderrelated">Order Related <span><i class="fa-solid fa-clipboard-list"></i></span></label>
                                                    </li>
                                                    <!-- <li>
                                                        
                                                        <input type="checkbox" class="form-check shadow-none" id="CancelledOrder">
                                                        <label for="CancelledOrder">Order Cancelled</label>
                                                    </li>
                                                    <li>
                                                        
                                                        <input type="checkbox" class="form-check shadow-none" id="Refund Order">
                                                        <label for="Refund Order">Order Refund </label>
                                                    </li> -->
                                                    <li>
                                                        
                                                        <input type="checkbox" class="form-check shadow-none" id="newsletterupdates" name="newsletter_updates" {{ $prefs && $prefs->newsletter_updates ? 'checked' : '' }}>
                                                        <label for="newsletterupdates">Newsletter Updates <span><i class="fa-solid fa-envelope-open-text"></i></span></label>
                                                    </li>
                                                    <li>
                                                        
                                                        <input type="checkbox" class="form-check shadow-none" id="newsItems" name="news_items" {{ $prefs && $prefs->news_items ? 'checked' : '' }}>
                                                        <label for="newsItems"> New arrivals <span><i class="fa-solid fa-cart-plus"></i></span></label>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-3 pt-4">
                                            <button type="submit" class="profile-sub-btn">Save</button>
                                        </div>
                                        <!-- <div class="col-lg-3">
                                           <div class="notification-prefer">
                                            <label for="emailNot">Email</label>
                                            <input type="checkbox" class="toggle-btn" id="emailNot">
                                           </div>

                                        </div>
                                        <div class="col-lg-3">
                                           <div class="notification-prefer">
                                            <label for="SMS">SMS</label>
                                            <input type="checkbox" class="toggle-btn" id="SMS" checked>
                                           </div>

                                        </div> -->
                                    </div>
                                    </form>
                                </div>
                            </div>
                         </div>
                        <div class="deactivate text">
                            <div class="tab-service">
                                
                                <div class="profile-container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="account-top-title">
                                                <h3>Deactivate Account</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="deactivateForm" method="POST" action="{{ route('account.deactivate') }}">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <div class=" profile-field">
                                                    <label for="enterPassword">Enter Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="password" id="enterPassword" class="form-control shadow-none"
                                                        placeholder="Enter Current Password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <div class=" profile-field">
                                                    <label for="newPas">Select Reason<span
                                                            class="text-danger">*</span></label>
                                                   <select name="reason" id="reasonSelect" class="form-select shadow-none">
                                                        <option value="">Select Reason</option>
                                                        <option value="1">Privacy concerns</option>
                                                        <option value="2">Not satisfied with service</option>
                                                        <option value="3">Account security issues</option>
                                                        <option value="4">Other</option>
                                                   </select>
                                                </div>
                                            </div>
                                             <div class="col-lg-12 mb-3 d-none" id="customReasonDiv">
                                                <div class="profile-field">
                                                    <label for="customReason">Please specify your reason <span class="text-danger">*</span></label>
                                                    <input type="text" name="custom_reason" id="customReason" class="form-control shadow-none" placeholder="Enter your reason">
                                                </div>
                                            </div>
                                           

                                            <div class="col-lg-12 mb-3">
                                                <button type="submit" class="profile-sub-btn">Deactivate</button>
                                            </div>
                                        </div>
                                    </form>
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
                                    <form action="">
                                        <div class="row">
                                            <div class="col-lg-12 mb-2">
                                                <div class=" profile-field">
                                                    <label for="Subject">Subject <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control shadow-none"
                                                        placeholder="Subject">
                                                </div>
                                            </div>
                                           
                                            <div class="col-lg-12  mb-2">
                                                <div class="profile-field">
                                                    <label for="Message">Message  <span
                                                            class="text-danger">*</span></label>
                                                    <textarea placeholder="Message"  class="form-control shadow-none"></textarea>
                                                </div>
                                            </div>
                                           
                                            <div class="col-lg-12 mb-2">
                                                <button type="submit" class="profile-sub-btn">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
   </section>


  <!-- Modal -->
  <div class="modal fade" id="Addresmodal" tabindex="-1" aria-labelledby="AddresmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="AddresmodalLabel">My Address</h1>
          <button type="button" id="modalCloseBtn" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{route('address.store')}}" id="addressForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="address_id" id="address_id" value="">
                 @if($user)
                     <input type="hidden" name="user_id" class="form-control gj_user_id" value="{{ @$user->id }}" >
                @endif
                <div class="row">
                    <div class="checkout-radio">
                        <ul class="checkout-now">
                            <li> 
                                <input type="radio" id="ad1" name="address1" value="Home" >
                                <label for="ad1">Home</label>
                            </li>
                            <li>
                                <input type="radio" id="ad2" name="address1" value="Office" >
                                <label for="ad2">Office</label>
                            </li>
                            <li>
                                <input type="radio" id="ad3" name="address1" value="New" >
                                <label for="ad3">New</label>
                            </li>
                        </ul>
                    </div>
                    <!--<div class="col-lg-12  mb-3">-->
                    <!--    <div class="profile-field">-->
                    <!--        <label for="label_name">Label Name (e.g., Home, Office)</label>-->
                    <!--        <input type="text" name="label_name" id="label_name" class="form-control shadow-none" placeholder="Enter label " value="{{ old('label_name') }}">-->
                    <!--        @if ($errors->has('label_name'))-->
                    <!--            <div class="text-danger">{{ $errors->first('label_name') }}</div>-->
                    <!--        @endif-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-lg-12  mb-3">
                        <div class=" profile-field">
                            <label for="Title">Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control shadow-none"
                                placeholder="Enter Title" value="{{old('title')}}">
                               <span class="text-danger"> 
                               @if ($errors->has('title'))
                                    {{ $errors->first('title') }}
                                @endif
                                </span>
                            </div>
                    </div>
                    <div class="col-lg-12   mb-3">
                        <div class="profile-field">
                            <label for="Address">Address <span
                                    class="text-danger">*</span></label>
                            <textarea placeholder="(House No, Building, Street, Area)"
                                class="form-control shadow-none" id="address2" name="address2">{{old('address2')}}</textarea>
                                <span class="text-danger">
                                    @if ($errors->has('address2'))
                                    {{ $errors->first('address2') }}
                                @endif
                                </span>
                        </div>
                    </div>
                    <div class="col-lg-12  mb-3">
                        <div class=" profile-field">
                            <label for="City">Street / Society / Office Name* <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-none"
                                placeholder="Street address" id="address3" name="address3" value="{{old('address3')}}">
                                <span class="text-danger">
                                    @if ($errors->has('address3'))
                                    {{ $errors->first('address3') }}
                                @endif
                                </span>
                        </div>
                    </div>
                    <div class="col-lg-6  mb-3">
                        <div class=" profile-field">
                            <label for="City">Locality / Town <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-none"
                                placeholder="Enter Your City" id="locality" name="locality" value="{{old('locality')}}">
                                <span class="text-danger">
                                    @if ($errors->has('locality'))
                                    {{ $errors->first('locality') }}
                                @endif
                                </span>
                        </div>
                    </div>
                    <div class="col-lg-6  mb-3">
                        <div class=" profile-field">
                            <label for="Pincode">Pincode <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control shadow-none"
                                placeholder="Enter Your Pincode" id="pincode" name="pincode" value="{{old('pincode')}}">
                                <span class="text-danger">
                                    @if ($errors->has('pincode'))
                                    {{ $errors->first('pincode') }}
                                @endif
                                </span>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-1">
                        <div class="shiping-form-field check-field">
                            <input type="checkbox" class="form-check shadow-none" id="defaultAddress" name="default">
                            <label for="defaultAddress"> Do you make this address as default address?</label>
                        </div>

                    </div>
                    <div class="col-lg-12  mb-3">
                        <input type="submit" class="profile-sub-btn" value="Submit">
                    </div>
                </div>
            </form>
        </div>
       
      </div>
    </div>
  </div>

@endsection

@section('before_scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  document.querySelectorAll('.filtersidenav label').forEach(label => {
  label.addEventListener('click', () => {
    const forAttr = label.getAttribute('for');
    if (forAttr) {
      const url = new URL(window.location.href);
      url.searchParams.set('tab', forAttr);
      window.location.href = url.toString();
    }
  });
});

window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const tab = urlParams.get('tab');
  if (tab) {
    const radio = document.getElementById(tab);
    if (radio) {
      radio.checked = true;
    }
  }
});

</script>


<script>
$(document).ready(function() {
    $('#orderTable').DataTable({
        paging: true,
        searching: false,
        info: false,
        lengthChange: false,
        ordering: true,
        order: [ [1, 'desc']], 
        columnDefs: [
            { orderable: false, targets: [2, 3, 4, 5, 6] },
            { orderable: true, targets: [0, 1] }           
        ]
    });
});
</script>

<script>
$(document).ready(function() {
    $('#orderCancelTable').DataTable({
        paging: true,
        searching: false,
        info: false,
        lengthChange: false,
        ordering: true,
        order: [[1, 'desc']], 
        columnDefs: [
            { orderable: true, targets: [0, 1] }, 
            { orderable: false, targets: [2, 3, 4] } 
        ]
    });
});
</script>

<script>
$(document).ready(function() {
    $('#onGoingTable').DataTable({
        paging: true,
        searching: false,
        info: false,
        lengthChange: false,
        ordering: true,
       order: [[1, 'desc']], // Default sort by 2nd column (Order Date), descending
        columnDefs: [
            { orderable: true, targets: [0, 1] },
            { orderable: false, targets: [2, 3, 4, 5] }
        ]
    });
});
</script>
<script>
$(document).ready(function() {
    $('#completedTable').DataTable({
        paging: true,
        searching: false,
        info: false,
        lengthChange: false,
        ordering: true,
        order: [[1, 'desc']], // Default sort by 2nd column (Order Date), descending
        columnDefs: [
            { orderable: true, targets: [0, 1] },
            { orderable: false, targets: [2, 3, 4, 5] }
        ]
    });
});
</script>



<script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');

        if (tab) {
            const tabRadio = document.getElementById(tab);
            if (tabRadio) {
                tabRadio.checked = true;
            }
        }
    });
</script>
<script>
    document.querySelectorAll('input[name="address1"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('label_name').value = this.value;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reasonSelect = document.getElementById('reasonSelect');
        const customReasonDiv = document.getElementById('customReasonDiv');

        reasonSelect.addEventListener('change', function () {
            if (this.value === '4') {
                customReasonDiv.classList.remove('d-none');
            } else {
                customReasonDiv.classList.add('d-none');
            }
        });
    });
</script>
<script>
    document.getElementById('deactivateForm').addEventListener('submit', function(e) {
       
        e.preventDefault();

        let password = document.getElementById('enterPassword').value;
        let reason = document.getElementById('reasonSelect').value;

        if (password === "" || reason === "") {
            alert("Please fill all fields.");
            return;
        }

        this.submit();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('countryCodeSelect');

    let selectedCode = {!! json_encode(old('country_code', @$user->country) ?: '+91') !!};
    selectedCode = selectedCode.toString(); // Convert to string
    console.log("Selected Code:", selectedCode);

    fetch('https://restcountries.com/v3.1/all?fields=name,idd')
        .then(response => response.json())
        .then(data => {
            const codes = [];

            data.forEach(country => {
                if (country.idd && country.idd.root) {
                    let root = country.idd.root;
                    let suffixes = country.idd.suffixes || [''];
                    suffixes.forEach(suffix => {
                        const dialCode = root + suffix;
                        const name = country.name.common;
                        codes.push({ code: dialCode, name });
                    });
                }
            });

            const uniqueCodes = Array.from(new Map(codes.map(item => [item.code, item])).values());
            uniqueCodes.sort((a, b) => a.name.localeCompare(b.name));

            uniqueCodes.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.code;
                opt.textContent = item.code;

                if (item.code === ('+' + selectedCode.replace('+', ''))) {
                    opt.selected = true;
                }

                select.appendChild(opt);
            });
        })
        .catch(err => {
            console.error("Error loading country codes:", err);
        });
});

</script>
<script>
    $(document).ready(function () {
        @if(session('show_address_modal'))
            $('#Addresmodal').modal('show');
        @endif
    });
</script>
<script>
    $(document).ready(function () {
        $('#modalCloseBtn').on('click', function () {
            // Reset the form
            $('#addressForm')[0].reset();

            $('#address_id').val('');

            $('input[name="address1"]').prop('checked', false);
            $('#title').val('');
            $('#locality').val('');
            $('#address2').val('');
            $('#address3').val('');
            $('#pincode').val('');

            $('.text-danger').html('');
        });
    });
</script>




<script>
$(document).on('click', '.edit-address-btn', function () {
    var addressId = $(this).data('id');
     var url = "{{ route('address.edit', ':id') }}"; 
    url = url.replace(':id', addressId); // Replace the placeholder with the actual ID

    // Fetch the address data (you can use AJAX here or pass data directly)
    $.ajax({
        url: url,  // Adjust the URL if necessary
        method: 'GET',
        success: function (response) {
            if (response.success) {
                // Populate the form with the fetched address data
                $('#address_id').val(response.data.id);
                $('#title').val(response.data.title);
                $('#address2').val(response.data.address2);
                $('#address3').val(response.data.address3);
                $('#locality').val(response.data.locality);
                $('#pincode').val(response.data.pincode);
                if (response.data.is_default) {
                    $('#defaultAddress').prop('checked', true);
                } else {
                    $('#defaultAddress').prop('checked', false);
                }

                // Set the selected radio button for address type
                $("input[name='address1'][value='" + response.data.address_type + "']").prop('checked', true);
            }
        }
    });
});

</script>
<script>
    $(document).on('click', '.make-default', function () {
    var addressId = $(this).data('id');
    
    $.ajax({
        url: '{{ route("address.make_default", ":id") }}'.replace(':id', addressId),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            // Reload the page to reflect changes without showing an alert
            // location.reload();
            window.location.href = '{{ route("my_account", ["tab" => "myAddress"]) }}';
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
document.getElementById('select_all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.select-item-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// ADD TO CART SELECTED ITEMS
document.getElementById('add_to_cart_selected').addEventListener('click', function() {
    let selectedItems = [];
    document.querySelectorAll('.select-item-checkbox:checked').forEach(checkbox => {
        selectedItems.push({
            product_id: checkbox.getAttribute('data-product-id'),
            quantity: 1
        });
    });

    let flashMessageContainer = document.getElementById('flash-message-container');

    if (selectedItems.length > 0) {
        fetch('{{ route("add_multiple_to_cart") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: selectedItems })
        })
        .then(response => response.json())
        .then(data => { 
            if (data.success) {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-success">
                        Items added to cart!
                    </div>
                `;
            } else {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to add items to cart. ${data.error || 'Please try again.'}
                    </div>
                `;
            }
            setTimeout(function() {
                window.location.href = '{{ route("my_account", ["tab" => "myWishlist"]) }}';
            }, 2000);
        })
        .catch(error => {
            console.error("Error during fetch:", error);
            flashMessageContainer.innerHTML = `
                <div class="alert alert-danger">
                    There was an error processing your request.
                </div>
            `;
        });
    } else {
        flashMessageContainer.innerHTML = `
            <div class="alert alert-warning">
                Please select at least one item.
            </div>
        `;
    }
});

// DELETE SELECTED ITEMS FROM WISHLIST
document.getElementById('delete_selected').addEventListener('click', function() {
    let selectedItems = [];
    document.querySelectorAll('.select-item-checkbox:checked').forEach(checkbox => {
        selectedItems.push(checkbox.getAttribute('data-product-id'));
    });

    let flashMessageContainer = document.getElementById('flash-message-container');

    if (selectedItems.length > 0) {
        fetch('{{ route("delete_multiple_from_wishlist") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: selectedItems })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-success">
                        Selected Items Remove From WishList !
                    </div>
                `;
            } else {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to delete items from wishlist. ${data.error || ''}
                    </div>
                `;
            }
            setTimeout(function() {
                window.location.href = '{{ route("my_account", ["tab" => "myWishlist"]) }}';
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            flashMessageContainer.innerHTML = `
                <div class="alert alert-danger">
                    There was an error processing your request.
                </div>
            `;
        });
    } else {
        flashMessageContainer.innerHTML = `
            <div class="alert alert-warning">
                Please select at least one item to delete.
            </div>
        `;
    }
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
                Yes: function () {
                    $('#myModal' + id).modal('hide');
                    $('.modal-backdrop').remove();
                    $.ajax({
                        type: 'post',
                        url: '{{url('/customer_cancel_order')}}',
                        data: {id: id, type: 'cancel'},
                        success: function (data) {
                          if (data == 1) {
                               fetch("{{ route('send.order_cancel.email') }}", {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({})
                            }).then(res => res.json())
                              .then(response => console.log('Email status:', response.status));

                                $.alert({
                                    title: '',
                                    content: 'Your Order Cancel Request Sent Successfully!!',
                                    icon: 'fa fa-check',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'green',
                                    backgroundDismiss: true,
                                    buttons: {
                                            // Override the default OK button with nothing
                                            ok: {
                                                isHidden: true, // hides the button completely
                                            }
                                        },
                                    onOpenBefore: function () {
                                        setTimeout(function () {
                                            window.location.href = "{{ route('my_account', ['tab' => 'myOrders']) }}";
                                        }, 3000); // 3 seconds
                                    }
                                });
                            }


                            // } else if (data == 5) {
                            //     $.confirm({
                            //         title: '',
                            //         content: 'You can only send a cancel request 24 hours after ordering!',
                            //         icon: 'fa fa-exclamation',
                            //         theme: 'modern',
                            //         closeIcon: true,
                            //         animation: 'scale',
                            //         type: 'red',
                            //         buttons: {
                            //             Yes: function () {
                            //                 $('#myModal' + id).modal('hide');
                            //                 $('.modal-backdrop').remove();
                            //                 window.location.href = "{{ route('my_account') }}#Section4";
                            //             }
                            //         }
                            //     });
                            // } on <a href="https://bioessenza.com/Rang/contact" target="_blank"></a>
                            else {
                                $.confirm({  
                                    title: '',
                                    content: 'Cancellation is not allowed post 24 hours / after the order is dispatched,<br/> Kindly Contact Paris La Belle on <a href="https://parislabelle.in/contact" target="_blank">Contact Us</a> for support on this order, Thank you',
                                    icon: 'fa fa-ban',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale', 
                                    type: 'red',
                                    buttons: {
                                        Ok: function () {
                                            $('#myModal' + id).modal('hide');
                                            $('.modal-backdrop').remove();
                                            window.location.href = "{{ route('my_account', ['tab' => 'myOrders']) }}";
                                        }
                                    }
                                });
                                th.css("pointer-events", "none");
                            }
                        }
                    });
                },
                No: function () {
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
<script>
  $('body').on('click', '.gj_my_codr_req', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var order_status = $(this).data('order_status');
    var cancel_approved = $(this).data('cancel_approved');
    var created_at = $(this).data('created_at');

    var now = Math.floor(Date.now() / 1000); // current UNIX time
    var hoursDiff = (now - created_at) / 3600;

    // Check if more than 24 hours passed or not allowed
    if (order_status != 1 || cancel_approved == 2 || cancel_approved == 3 || hoursDiff > 24) {
        $.confirm({
            title: '',
            content: 'Cancellation is not allowed post 24 hours / after the order is dispatched,<br/> Kindly Contact Paris La Belle on <a href="https://parislabelle.in/contact" target="_blank">Contact Us</a> for support on this order, Thank you',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                Ok: function () {
                    window.location.href = "{{ route('my_account', ['tab' => 'myOrders']) }}";
                }
            }
        });
        return;
    }

    // Else allow showing modal
    $('#myModal' + id).modal('show');
});

</script>
   
@endsection
