@extends('layouts.master')
@section('title', 'Manage Coupon')
@section('content')
<style>
    .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
</style>
<section class="gj_email_setting">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.coupon_sidebar')
        </div>

        <div class="col-lg-10 ">
             <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger" id="error-alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif
                
                <div class="col-md-12">
                    <form action="{{ route('store_coupons') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                             <h3 class="gj_heading"> Add Coupon</h3>
                         </div>
                         
                        <div class="form-group col-lg-6">
                          <label for="full_name">Coupon Code</label>
                            <span class="error">* 
                                @if ($errors->has('code'))
                                    {{ $errors->first('code') }}
                                @endif
                            </span>
                            <input type="text" name="code" class="form-control gj_first_name" placeholder="Enter Coupon Code"  value="{{  old('code') }}" >

                        </div>
                         
                         <div class="form-group col-lg-6">
                          <label for="type">Coupon Type</label>
                            <span class="error">* 
                                @if ($errors->has('type'))
                                    {{ $errors->first('type') }}
                                @endif
                            </span>
                            <select class="form-control" name="type">
                                <option value="fixed">Fixed amount</option>
                                <option value="percent">Percentage discount</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-6">
                          <label for="full_name">Discount Value</label>
                            <span class="error">* 
                                @if ($errors->has('value'))
                                    {{ $errors->first('value') }}
                                @endif
                            </span>
                            <input type="text" name="value" class="form-control gj_first_name" placeholder="Enter Discount Value"  value="{{  old('value') }}" >

                        </div>
                        
                        <div class="form-group col-lg-6">
                          <label for="full_name">Start Date</label>
                            <span class="error">* 
                                @if ($errors->has('start_date'))
                                    {{ $errors->first('start_date') }}
                                @endif
                            </span>
                            <input type="date" name="start_date" class="form-control gj_first_name" placeholder="Enter Start Date"  value="{{  old('start_date') }}" >

                        </div>
                        
                         <div class="form-group col-lg-6">
                          <label for="end_date">End Date</label>
                            <span class="error">* 
                                @if ($errors->has('end_date'))
                                    {{ $errors->first('end_date') }}
                                @endif
                            </span>
                            <input type="date" name="end_date" class="form-control gj_first_name" placeholder="Enter End Date"  value="{{  old('end_date') }}" >

                        </div>
                        
                        <div class="form-group col-lg-6">
                          <label for="end_date">Usage Limit</label>
                            <span class="error">* 
                                @if ($errors->has('usage_limit'))
                                    {{ $errors->first('usage_limit') }}
                                @endif
                            </span>
                            <input type="text" name="usage_limit" class="form-control gj_first_name" placeholder="Enter Usage Limit"  value="{{  old('usage_limit') }}" >

                        </div>
                        
                        <!--<div class="form-group col-lg-6">-->
                        <!--  <label for="end_date">Usage Limit Per User</label>-->
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('usage_limit_per_user'))-->
                        <!--            {{ $errors->first('usage_limit_per_user') }}-->
                        <!--        @endif-->
                        <!--    </span>-->
                        <!--    <input type="text" name="usage_limit_per_user" class="form-control gj_first_name" placeholder="Enter Usage Limit Per User"  value="{{  old('usage_limit_per_user') }}" >-->

                        <!--</div>-->
                        
                        <div class="form-group col-lg-6">
                          <label for="type">Status</label>
                            <span class="error">* 
                                @if ($errors->has('status'))
                                    {{ $errors->first('status') }}
                                @endif
                            </span>
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        
                        
                    </div>
                    <input type="submit" class="btn btn-primary mx_auto" value="Add Coupon">

                    </form>
                </div>
                 
            </div>
        </div>
    </div>
</section>


@endsection
