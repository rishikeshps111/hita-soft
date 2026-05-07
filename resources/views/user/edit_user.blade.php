@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<style>
    .w-100-cs{
        width:100% !important;
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
               

                <div class="col-md-12">
                     <form action="{{ route('update_user') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                        @if($user)
                            <input type="hidden" name="user_id" value="{{ $user->id }}" class="form-control gj_user_id">
                              <input type="hidden" name="role" value="{{ $user->user_type }}" class="form-control gj_user_id">
                        @endif
                        <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                            <div class="col-lg-12 back-container">
                                  <h3 class="gj_heading">@if($user->user_type == 1) Edit Admin Profile
                                  @elseif($user->user_type == 2)
                                  Edit Admin Staff
                                  @else
                                  Edit Customer
                                  @endif
                                  </h3>
                                  <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                            </div>
                             <div class="gj_box dark gj_inside_box">
                           
                            <div class="row row_mx_0">
                                
                                 @php
                                     $name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                                    $fullNameValue = !empty($name) ? $name : ($user->full_name ?? old('full_name'));
                                @endphp
                                 <div class="form-group col-lg-6">
                                    <label for="full_name">Full Name</label>
                                    <span class="error">* 
                                        @if ($errors->has('full_name'))
                                            {{ $errors->first('full_name') }}  
                                        @endif
                                    </span>
                                    <input type="text" name="full_name" class="form-control gj_first_name" placeholder="Enter user Full Name"  value="{{ $fullNameValue }}" >

                                </div>
                                
                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('first_name', 'First Name') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('first_name'))-->
                                <!--            {{ $errors->first('first_name') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                {{--    {{ Form::text('first_name', ($user->first_name ? $user->first_name : Input::old('first_name')), array('class' => 'form-control gj_first_name','placeholder' => 'Enter user First Name')) }}--}}
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('last_name', 'Last Name') }}--}}
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('last_name'))-->
                                <!--            {{ $errors->first('last_name') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                {{--    {{ Form::text('last_name', ($user->last_name ? $user->last_name : Input::old('last_name')), array('class' => 'form-control gj_last_name','placeholder' => 'Enter user Last Name')) }}--}}
                                <!--</div>-->

                                <div class="form-group col-lg-6">
                                    <label for="email">E-mail Id</label>
                                    <span class="error">* 
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @endif
                                    </span>
                                    <input type="text" name="email" class="form-control gj_email" placeholder="Enter user E-mail Id"  value="{{ $user->email ? $user->email : old('email') }}" >

                                </div>
                               

                                <div class="form-group col-lg-6">
                                    <label for="phone">Phone</label>
                                    <span class="error">* 
                                        @if ($errors->has('phone'))
                                            {{ $errors->first('phone') }}
                                        @endif
                                    </span>
                                    <div class="row gx-2" style="display:flex; margin:0">
                                    <div class="col-lg-4" style="padding:0;">
                                        <select name="country_code" class="form-select shadow-none" id="countryCodeSelect" style="width:100%; background-color:#f7f7f7;">
                                        </select>
                                    </div>
                        
                                    <div class="col-lg-8 w-100-cs" style="padding:0;width: 80%;">
                                    <input type="tel" style="width:100%; border-radius:0;" name="phone" class="form-control gj_phone" placeholder="Enter user Phone Number"  value="{{ $user->phone ? $user->phone : old('phone') }}" pattern="^\d*$" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                                     </div>
                                </div>
                                </div>
                                 <div class="form-group col-lg-6">
                                    <label for="dob">Date Of Birth</label>
                                    <span class="error">* 
                                        @if ($errors->has('dob'))
                                            {{ $errors->first('dob') }}
                                        @endif
                                    </span>
                                    <input type="date" name="dob" class="form-control gj_dob" placeholder="Enter user DOB"  value="{{ $user->dob ? $user->dob : old('dob') }}"   max="{{ date('Y-m-d') }}">
                                   

                                </div>
                                 <div class="form-group col-lg-12">
                                    <label for="dob">Address</label>
                                    <span class="address1">* 
                                        @if ($errors->has('address1'))
                                            {{ $errors->first('address1') }}
                                        @endif
                                    </span>
                                     <textarea placeholder="(House No, Building, Street, Area)" name="address1"
                                                        class="form-control shadow-none">{{ $user->address1 ? $user->address1 : old('address1') }}</textarea>

                                </div>
                                 <div class="form-group col-lg-6">
                                    <label for="address2">City</label>
                                    <span class="error">* 
                                        @if ($errors->has('address2'))
                                            {{ $errors->first('address2') }}
                                        @endif
                                    </span>
                                    <input type="text" name="address2" class="form-control gj_city" placeholder="Enter user City"  value="{{ $user->address2 ? $user->address2 : old('address2') }}" >

                                </div>
                                 <div class="form-group col-lg-6">
                                    <label for="pincode">Pincode</label>
                                    <span class="error">* 
                                        @if ($errors->has('pincode'))
                                            {{ $errors->first('pincode') }}
                                        @endif
                                    </span>
                                    <input type="text" name="pincode" class="form-control gj_pincode" placeholder="Enter user Pincode"  value="{{ $user->pincode ? $user->pincode : old('pincode') }}"pattern="^\d{6}$" 
           oninput="this.value=this.value.replace(/[^0-9]/g,'');"  >

                                </div>

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('phone2', 'Phone-2') }}--}}
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('phone2'))-->
                                <!--            {{ $errors->first('phone2') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                {{--    {{ Form::number('phone2', ($user->phone2 ? $user->phone2 : Input::old('phone2')), array('class' => 'form-control gj_phone2','placeholder' => 'Enter user Optinal Phone Number')) }}--}}
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('gender', 'Gender') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('gender'))-->
                                <!--            {{ $errors->first('gender') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                <!--    <div class="gj_py_ro_div">-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio"> name="gender" value="Male"> Male-->
                                <!--        </span>-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio"> name="gender" value="Female"> Female-->
                                <!--        </span>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="col-lg-12">
                                    <div class="gj_ban_img_whole pf-img-box">
                                    <?php 
                                    $file_path = 'images/profile_img';
                                    ?>
                                    @if(isset($user))
                                        @if($user->profile_img != '')
                                        <div class="form-group">
                                             <label for="current_profile_img">Current Profile Featured Image</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($file_path.'/'.$user->profile_img)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_profile_img" class="form-control"   value="{{ $user->profile_img ? $user->profile_img : '' }}" >

                                        </div>
                                        @endif
                                    @endif

                                    <div class="form-group">
                                        <label for="profile_img">Upload Featured Profile Image</label>
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

                                

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('is_approved', 'Approved') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('is_approved'))-->
                                <!--            {{ $errors->first('is_approved') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                <input type="hidden" name="is_approved" value="1">

                                    <!--<div class="gj_py_ro_div">-->
                                    <!--    <span class="gj_py_ro">-->
                                    <!--        <input type="radio" name="is_approved" value="1"> Active-->
                                    <!--    </span>-->
                                    <!--    <span class="gj_py_ro">-->
                                    <!--        <input type="radio" name="is_approved" value="0"> Deactive-->
                                    <!--    </span>-->
                                    <!--</div>-->
                                <!--</div>-->
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
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('countryCodeSelect');

    let selectedCode = {!! json_encode(old('country_code', $user->country) ?: '+91') !!};
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
                opt.textContent = `(${item.code}) ${item.name}`;

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
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#country").select2();
        $("#state").select2();
        $("#city").select2();
        $("#user_type").select2();

        @if(count($user['docs']) != 0)
            var cnt = <?php echo count($user['docs']) + 1;?>;
        @else
            var cnt = 2;
        @endif

        $("#img_addButton").click(function () {
            var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_m_doc_' + cnt);
            newTextBoxDiv.after().html('<td><input class="form-control gj_d_name" placeholder="Enter Document Name" name="d_name[]" type="text" id="d_name_' + cnt + '"></td><td><input type="file" name="d_image[]" id="d_image_' + cnt + '" class="gj_d_image form-control"></td><td><button type="button" id="img_removeButton_' + cnt + '" class="gj_m_doc_rem"><i class="fa fa-trash"></i></button></td>');
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
</script>
@endsection