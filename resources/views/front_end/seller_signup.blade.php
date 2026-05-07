@extends('layouts.frontend')
@section('title', 'Bussiness Signup')
@section('content')
<div class="gj_seller_reg_sec">
    <!-- Seller Banner Section Start -->
    <section class="gj_cus_signup_ban_sec">
        <div class="inban inban9" style="background-image:url('{{asset('images/site_img/inban9.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                         <h4> Become a Seller </h4> 
                    </div>
                </div>
            </div>    
        </div>  
    </section>
    <!-- Seller Banner Section End -->
    
    <!-- Seller Form Section Start -->
    <section class="ps-section--account">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    
                </div>
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        {{ Form::open(array('url' => 'seller_register','class'=>'ps-form--account-setting gj_user_seller_register', 'id' => 'seller_register', 'files' => true)) }}                           
                            <div class="ps-form__content selregz">
                                <p class="reqfilzd"> * Required Fields </p>
                                <div class="row">
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> First Name * </label>

                                            <span class="error">
                                                @if ($errors->has('first_name'))
                                                    {{ $errors->first('first_name') }}
                                                @endif
                                            </span> 

                                            <input class="form-control" type="text" placeholder=" " name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Last Name</label>

                                            <span class="error">
                                                @if ($errors->has('last_name'))
                                                    {{ $errors->first('last_name') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="last_name">
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email *</label>

                                            <span class="error">
                                                @if ($errors->has('email'))
                                                    {{ $errors->first('email') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="email" placeholder=" " name="email">
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone Number *</label>

                                            <span class="error">
                                                @if ($errors->has('phone'))
                                                    {{ $errors->first('phone') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="phone">
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Password *</label>

                                            <span class="error">
                                                @if ($errors->has('password'))
                                                    {{ $errors->first('password') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="password" placeholder=" " name="password">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Confirm Password *</label>

                                            <span class="error">
                                                @if ($errors->has('c_password'))
                                                    {{ $errors->first('c_password') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="password" placeholder=" " name="c_password">
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Company Name *</label>

                                            <span class="error">
                                                @if ($errors->has('bussiness_name'))
                                                    {{ $errors->first('bussiness_name') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="bussiness_name">
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Select Security Question *</label>

                                            <span class="error">
                                                @if ($errors->has('question'))
                                                    {{ $errors->first('question') }}
                                                @endif
                                            </span> 

                                            <?php 
                                                $opt = '';
                                                $secure = \DB::table('login_securities')->where('is_block',1)->get();
                                                if(($secure) && (count($secure) != 0)){
                                                    foreach ($secure as $srkey => $srvalue) {
                                                        $opt.='<option value="'.$srvalue->id.'">'.$srvalue->question.'</option>';
                                                    }
                                                } 
                                            ?>
                                            <select id="question" name="question" class="form-control">
                                                <option value="" >Select Question</option>
                                                <?php echo $opt; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Security Answer *</label>

                                            <span class="error">
                                                @if ($errors->has('answer'))
                                                    {{ $errors->first('answer') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="answer">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Select Country *</label>

                                            <span class="error">
                                                @if ($errors->has('country'))
                                                    {{ $errors->first('country') }}
                                                @endif
                                            </span> 

                                            <?php 
                                                $opt = '';
                                                $ctys = \DB::table('countries_managements')->where('is_block',1)->get();
                                                if(($ctys) && (count($ctys) != 0)){
                                                    foreach ($ctys as $key => $value) {
                                                        $opt.='<option value="'.$value->id.'">'.$value->country_name.'</option>';
                                                    }
                                                } 
                                            ?>
                                            <select id="country" name="country" class="form-control">
                                                <option value="" >Select Country</option>
                                                <?php echo $opt; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Select State *</label>

                                            <span class="error">
                                                @if ($errors->has('state'))
                                                    {{ $errors->first('state') }}
                                                @endif
                                            </span> 

                                            <select id="state" name="state" disabled class="form-control">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Location</label>

                                            <span class="error">
                                                @if ($errors->has('address2'))
                                                    {{ $errors->first('address2') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="address2">
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-12">
                                        <div class="form-group">
                                            <label> Address *</label>

                                            <span class="error">
                                                @if ($errors->has('address1'))
                                                    {{ $errors->first('address1') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="address1">
                                        </div>
                                    </div>
                                    
                                    
                                     
                                    
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>  Pincode</label>

                                            <span class="error">
                                                @if ($errors->has('pincode'))
                                                    {{ $errors->first('pincode') }}
                                                @endif
                                            </span> 
                                            <input class="form-control" type="text" placeholder=" " name="pincode">
                                        </div>
                                    </div>
                                    
                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Upload your Picture</label>

                                            <span class="error">
                                                @if ($errors->has('profile_img'))
                                                    {{ $errors->first('profile_img') }}
                                                @endif
                                            </span> 

                                            <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                                            <input class="form-control" type="file" placeholder="" accept="image/*" name="profile_img">
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="form-group submit">
                                <button type="submit" class="ps-btn">Save</button>
                                <button type="reset" class="ps-btn gj_reset_but">Reset</button>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
                
                  <div class="col-lg-2">
                    
                </div>
                
                
            </div>
        </div>
    </section>
    <!-- Seller Form Section End -->
</div>
@endsection

@section('before_scripts')
<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700); 
    });
</script>

<script>
    $(document).ready(function() { 
        $("#country").select2();
        $("#state").select2();
        $("#question").select2();
    });

    $('.gj_reset_but').on('click',function() {
        /*$("#country").select2({
            placeholder: "Select Country",
            allowClear: true
        });

        $("#state").select2({
            placeholder: "Select State",
            allowClear: true
        });

        $("#question").select2({
            placeholder: "Select Security Question",
            allowClear: true
        });
        $("#state").prop("disabled", true);*/
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
</script>
@endsection