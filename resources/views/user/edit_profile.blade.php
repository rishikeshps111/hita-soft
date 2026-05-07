@extends('layouts.master')
@section('title', 'Edit Profile')
@section('content')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px !important;
}
</style>
<section class="gj_email_setting">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.user_sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                
               

                <div class="col-md-12">
                      <form action="{{ route('update_profile') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                        @if($user)
                            
                             <input type="hidden" name="user_id" value="{{ $user->id }}" class="form-control gj_user_id">
                        @endif
                        <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                            <div class="col-lg-12 back-container">
                                <h3 class="gj_heading"> Edit Admin Profile  </h3>
                                <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="gj_box dark gj_inside_box">
                          
                            
                            <div class="row row_mx_0">
                                @if($user->user_type== 1)
                                <div class="form-group col-lg-6">
                                      <label for="first_name">First Name</label>
                                    <span class="error">* 
                                        @if ($errors->has('first_name'))
                                            {{ $errors->first('first_name') }}
                                        @endif
                                    </span>
                                    <input type="text" name="first_name" class="form-control gj_first_name" placeholder="Enter user First Name"  value="{{ $user->first_name ? $user->first_name : old('first_name') }}" >

                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="last_name">Last Name</label>
                                    <span class="error"> 
                                        @if ($errors->has('last_name'))
                                            {{ $errors->first('last_name') }}
                                        @endif
                                    </span>
                                    <input type="text" name="last_name" class="form-control gj_last_name" placeholder="Enter user Last Name"  value="{{ $user->last_name ? $user->last_name : old('last_name') }}" >

                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="bussiness_name">Bussiness Name</label>
                                    <span class="error"> 
                                        @if ($errors->has('bussiness_name'))
                                            {{ $errors->first('bussiness_name') }}
                                        @endif
                                    </span>
                                    <input type="text" name="bussiness_name" class="form-control gj_bussiness_name" placeholder="Enter Merchant Bussiness Name"  value="{{ $user->bussiness_name ? $user->bussiness_name : old('bussiness_name') }}" >

                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="buss_reg_no">Bussiness Register Number</label>
                                    <span class="error"> 
                                        @if ($errors->has('buss_reg_no'))
                                            {{ $errors->first('buss_reg_no') }}
                                        @endif
                                    </span>
                                    <input type="text" name="buss_reg_no" class="form-control gj_buss_reg_no" placeholder="Enter Merchant Bussiness Register Number"  value="{{ $user->buss_reg_no ? $user->buss_reg_no : old('buss_reg_no') }}" >

                                </div>
                                @else
                                <div class="form-group col-lg-6">
                                      <label for="first_name">Full Name</label>
                                    <span class="error">* 
                                        @if ($errors->has('full_name'))
                                            {{ $errors->first('full_name') }}
                                        @endif
                                    </span>
                                    <input type="text" name="full_name" class="form-control gj_first_name" placeholder="Enter user Full Name"  value="{{ $user->full_name ? $user->full_name : old('full_name') }}" >

                                </div>
                                
                                @endif

                                <div class="form-group col-lg-6">
                                    <label for="email">E-mail Id</label>
                                    <span class="error">* 
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @endif
                                    </span>
                                    <input type="email" name="email" class="form-control gj_email" placeholder="Enter user E-mail Id"  value="{{ $user->email ? $user->email : old('email') }}" >

                                </div>

                                <div class="form-group col-lg-12 select-cs-cont">
                                     <label for="country">Select Country</label>
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

                                <div class="form-group col-lg-12 select-cs-cont">
                                    <label for="state">Select State</label>
                                    <span class="error">* 
                                        @if ($errors->has('state'))
                                            {{ $errors->first('state') }}
                                        @endif
                                    </span>

                                    <select id="state" name="state" disabled class="form-control">
                                        <option value="0" selected disabled>Select State</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-12 select-cs-cont">
                                    <label for="city">Select District</label>
                                    <span class="error">* 
                                        @if ($errors->has('city'))
                                            {{ $errors->first('city') }}
                                        @endif
                                    </span>

                                    <select id="city" name="city" disabled class="form-control">
                                        <option value="0" selected disabled>Select District</option>
                                    </select>
                                </div>

                                <div class="form-group col-lg-6">
                                     <label for="phone">Phone-1</label>
                                    <span class="error">* 
                                        @if ($errors->has('phone'))
                                            {{ $errors->first('phone') }}
                                        @endif
                                    </span>
                                <input type="number" name="phone" class="form-control gj_phone" placeholder="Enter user Phone Number"  value="{{ $user->phone ? $user->phone : old('phone') }}" >
                                
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="phone2">Phone-2</label>
                                    <span class="error">
                                        @if ($errors->has('phone2'))
                                            {{ $errors->first('phone2') }}
                                        @endif
                                    </span>
                                    <input type="number" name="phone2" class="form-control gj_phone2" placeholder="Enter user Optional Phone Number"  value="{{ $user->phone2 ? $user->phone2 : old('phone2') }}" >
                                
                                </div>

                                <div class="form-group col-lg-12">
                                     <label for="gender">Gender</label>
                                    <span class="error">* 
                                        @if ($errors->has('gender'))
                                            {{ $errors->first('gender') }}
                                        @endif
                                    </span>

                                    <div class="gj_py_ro_div df-gap">
                                        <span class="gj_py_ro">
                                            <input type="radio" <?php if($user->gender == "Male"){ echo "checked"; } ?> name="gender" value="Male"> Male
                                        </span>
                                        <span class="gj_py_ro">
                                            <input type="radio" <?php if($user->gender == "Female"){ echo "checked"; } ?> name="gender" value="Female"> Female
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="address1">Address</label>
                                    <span class="error">* 
                                        @if ($errors->has('address1'))
                                            {{ $errors->first('address1') }}
                                        @endif
                                    </span>
                                    <input type="text" name="address1" class="form-control gj_address1" placeholder="Enter user Address"  value="{{ $user->address1 ? $user->address1 : old('address1') }}" >

                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="address2">City</label>
                                    <span class="error">* 
                                        @if ($errors->has('address2'))
                                            {{ $errors->first('address2') }}
                                        @endif
                                    </span>
                                    <input type="text" name="address2" class="form-control gj_address2" placeholder="Enter user City"  value="{{ $user->address2 ? $user->address2 : old('address2') }}" >

                                </div>

                                <div class="form-group col-lg-4">
                                     <label for="pincode">Pincode</label>
                                    <span class="error">* 
                                        @if ($errors->has('pincode'))
                                            {{ $errors->first('pincode') }}
                                        @endif
                                    </span>
                                    <input type="number" name="pincode" class="form-control gj_pincode" placeholder="Enter user Pincode"  value="{{ $user->pincode ? $user->pincode : old('pincode') }}" >

                                </div>

                                <div class="form-group col-lg-12">
                                    {{-- {{ Form::label('user_type', 'user_type') }} --}}
                                    <span class="error"> 
                                        @if ($errors->has('user_type'))
                                            {{ $errors->first('user_type') }}
                                        @endif
                                    </span>
                                        <input type="hidden" name="user_type" class="form-control gj_user_type" placeholder="Enter Admin user_type"  value="{{ $user->user_type ? $user->user_type : old('user_type') }}" >

                                </div>

                                <div class="col-lg-12">
                                    <div class="gj_ban_img_whole pf-img-box">
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
                                            <input type="hidden" name="old_profile_img" class="form-control "   value="{{ $user->profile_img ? $user->profile_img : '' }}" >

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

                                {{--<div class="form-group">
                                     <label for="payment_account_details">Payment Account Details</label>
                                    <span class="error"> 
                                        @if ($errors->has('payment_account_details'))
                                            {{ $errors->first('payment_account_details') }}
                                        @endif
                                    </span>
                                    <input type="text" name="payment_account_details" class="form-control gj_p_acc_d" plaseholder="Paypal  EMail-ID  Payment Bank Details"  value="{{ $user->payment_account_details ? $user->payment_account_details : old('payment_account_details') }}" >

                                </div>

                                <div class="form-group col-lg-12">
                                     <label for="document">Documents </label>

                                    <div class="gj_m_doc_div">
                                        <div class="gj_tot_err">
                                            @if ($errors->has('d_name'))
                                                <p class="error"> 
                                                    {{ $errors->first('d_name') }}
                                                </p>
                                            @endif

                                            @if ($errors->has('d_image'))
                                                <p class="error"> 
                                                    {{ $errors->first('d_image') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="gj_m_doc_resp table-responsive">
                                            <table class="table table-stripped table-bordered gj_tab_m_doc">
                                                <thead>
                                                    <tr>
                                                        <th>Document Name</th>
                                                        <th>Document File</th>
                                                        <th>#</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="gj_m_doc_bdy">
                                                    @if($user)
                                                        @if($user['docs'] && (count($user['docs']) != 0))
                                                            @foreach($user['docs'] as $key => $value)
                                                                <tr id="gj_tr_m_doc_{{$key+1}}">
                                                                    <td>
                                                                        <input class="form-control gj_d_name" placeholder="Enter Product Name" name="d_name[]" type="text" id="d_name_{{$key+1}}" value="{{$value->d_name}}">
                                                                    </td>
                                                                    <td>
                                                                        <?php  
                                                                            $doc_file_path = 'documents';
                                                                        ?>
                                                                        @if($value->image)
                                                                            <!-- <img src="{{ asset($doc_file_path.'/'.$value->image)}}" class="img-responsive gj_old_doc_img">  -->
                                                                            <a href="{{ asset($doc_file_path.'/'.$value->image)}}" target="_blank" class="gj_old_doc"><embed src="{{ asset($doc_file_path.'/'.$value->image)}}"/></a>
                                                                            {{ Form::hidden('old_d_image[]', $value->image, array('class' => 'form-control')) }}
                                                                        @endif
                                                                        <input type="file" name="d_image[]" id="d_image_{{$key+1}}" accept="image/*" class="gj_d_image gj_edit_d_image form-control">
                                                                    </td>
                                                                    <td>
                                                                        <button type='button' id='img_removeButton_{{$key+1}}' class="gj_m_doc_rem td-dlt"><i class="fa fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr id="gj_tr_m_doc_1">
                                                                <td>
                                                                    <input class="form-control gj_d_name" placeholder="Enter Document Name" name="d_name[]" type="text" id="d_name_1">
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="d_image[]" id="d_image_1" class="gj_d_image form-control">
                                                                </td>
                                                                <td>
                                                                    <button type='button' id='img_removeButton_1' class="gj_m_doc_rem  td-dlt"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @else
                                                        <tr id="gj_tr_m_doc_1">
                                                            <td>
                                                                <input class="form-control gj_d_name" placeholder="Enter Product Name" name="d_name[]" type="text" id="d_name_1">
                                                            </td>
                                                            <td>
                                                                <input type="file" name="d_image[]" id="d_image_1" class="gj_d_image form-control">
                                                            </td>
                                                            <td>
                                                                <button type='button' id='img_removeButton_1' class="gj_m_doc_rem td-dlt"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <input type='button' value='Add New' id='img_addButton' class="add_new_btn">
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                        </div>

                        

                        <input type="submit" class="btn btn-primary mx_auto" value="Update">


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#country").select2();
        $("#state").select2();
        $("#city").select2();

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
                            // $.confirm({
                            //     title: '',
                            //     content: 'Please Select State!',
                            //     icon: 'fa fa-exclamation',
                            //     theme: 'modern',
                            //     closeIcon: true,
                            //     animation: 'scale',
                            //     type: 'blue',
                            //     buttons: {
                            //         Ok: function(){
                            //         }
                            //     }
                            // });
                        }
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select Country!',
                            icon: 'fa fa-exclamation',
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
            // $.confirm({
            //     title: '',
            //     content: 'Please Select Country!',
            //     icon: 'fa fa-exclamation',
            //     theme: 'modern',
            //     closeIcon: true,
            //     animation: 'scale',
            //     type: 'blue',
            //     buttons: {
            //         Ok: function(){
            //         }
            //     }
            // });
        }

        @if(count($user['docs']) != 0)
            var cnt = <?php echo count($user['docs']) + 1;?>;
        @else
            var cnt = 2;
        @endif

        $("#img_addButton").click(function () {
            var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_m_doc_' + cnt);
            newTextBoxDiv.after().html('<td><input class="form-control gj_d_name" placeholder="Enter Product Name" name="d_name[]" type="text" id="d_name_' + cnt + '"></td><td><input type="file" name="d_image[]" id="d_image_' + cnt + '" class="gj_d_image form-control"></td><td><button type="button" id="img_removeButton_' + cnt + '" class="gj_m_doc_rem td-dlt"><i class="fa fa-trash"></i></button></td>');
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
                            icon: 'fa fa-exclamation',
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
                icon: 'fa fa-exclamation',
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
                            icon: 'fa fa-exclamation',
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
                icon: 'fa fa-exclamation',
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
@endsection