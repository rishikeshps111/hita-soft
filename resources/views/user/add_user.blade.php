@extends('layouts.master')
@section('title', 'Add User')
@section('content')
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
                @if ($errors->any())
                    <div class="alert alert-danger" id="error-alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif

             

                <div class="col-md-12">
                    <form action="{{ route('store_user') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                             <h3 class="gj_heading"> Add User / Admin Staff </h3>
                         </div>
                         
                         <div class="form-group col-lg-6">
                          <label for="full_name">Role</label>
                            <span class="error">* 
                                @if ($errors->has('role'))
                                    {{ $errors->first('role') }}
                                @endif
                            </span>
                            <select class="form-control" name="role">
                                <option value="4">Customer</option>
                                <option value="2">Admin Staff</option>
                            </select>
                        </div>
                        
                         <div class="form-group col-lg-6">
                          <label for="full_name">Full Name</label>
                            <span class="error">* 
                                @if ($errors->has('full_name'))
                                    {{ $errors->first('full_name') }}
                                @endif
                            </span>
                            <input type="text" name="full_name" class="form-control gj_first_name" placeholder="Enter user Full Name"  value="{{  old('full_name') }}" >

                        </div>
                        
                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('first_name', 'First Name') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('first_name'))-->
                        <!--            {{ $errors->first('first_name') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        {{--    {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control gj_first_name','placeholder' => 'Enter User First Name')) }}--}}
                        <!--</div>-->

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('last_name', 'Last Name') }}--}}
                        <!--    <span class="error"> -->
                        <!--        @if ($errors->has('last_name'))-->
                        <!--            {{ $errors->first('last_name') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        {{--    {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control gj_last_name','placeholder' => 'Enter User Last Name')) }}--}}
                        <!--</div>-->

                        <div class="form-group col-lg-6">
                            <label for="email">E-mail Id</label>
                            <span class="error">* 
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </span>
                            <input type="text" name="email" class="form-control gj_email" placeholder="Enter user E-mail Id"  value="{{  old('email') }}" >

                        </div>

                        <div class="form-group col-lg-6">
                            <label for="password">Password</label>
                            <span class="error">* 
                                @if ($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </span>

                            <div style="position: relative;">
                                <input class="form-control gj_password" placeholder="Enter User Password" name="password" type="password" id="password" value="{{ old('password') }}">
                                <span class="toggle-password" toggle="#password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa fa-eye fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                             <label for="password_salt">Confirm Password</label>
                            <span class="error">* 
                                @if ($errors->has('password_salt'))
                                    {{ $errors->first('password_salt') }}
                                @endif
                            </span>

                             <div style="position: relative;">
                                <input class="form-control gj_password_salt" placeholder="Enter User Confirm Password" name="password_salt" type="password" id="password_salt" value="{{ old('password_salt') }}">
                                <span class="toggle-password" toggle="#password_salt" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa fa-eye fa-eye-slash"></i>
                                </span>
                            </div>
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
                                    <select name="country_code" class="form-select shadow-none" id="countryCodeSelect"  style="width:100%; background-color:#f7f7f7;">
                                        <!-- <option value="">Code</option> -->
                                    </select>
                                </div>
                        
                                <div class="col-lg-8 w-100-cs" style="padding:0;width: 80%;">
                                    <input class="form-control gj_phone"  placeholder="Enter User Phone Number"
                                        name="phone" type="tel" style="width:100%; border-radius:0;" value="{{ old('phone') }}"
                                        pattern="^\d*$"
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
                                    <input type="date" name="dob" class="form-control gj_dob" placeholder="Enter user DOB"  value="{{old('dob') }}" min="1900-01-01" max="{{ date('Y-m-d') }}" >
                                   

                                </div>
                                 <div class="form-group col-lg-12">
                                    <label for="dob">Address</label>
                                    <span class="error">* 
                                        @if ($errors->has('address1'))
                                            {{ $errors->first('address1') }}
                                        @endif
                                    </span>
                                     <textarea placeholder="(House No, Building, Street, Area)" name="address1"
                                                        class="form-control shadow-none">{{ old('address1') }}</textarea>

                                </div>
                                 <div class="form-group col-lg-6">
                                    <label for="address2">City</label>
                                    <span class="error">* 
                                        @if ($errors->has('address2'))
                                            {{ $errors->first('address2') }}
                                        @endif
                                    </span>
                                    <input type="text" name="address2" class="form-control gj_city" placeholder="Enter user City"  value="{{old('address2') }}" >

                                </div>
                                 <div class="form-group col-lg-6">
                                    <label for="pincode">Pincode</label>
                                    <span class="error">* 
                                        @if ($errors->has('pincode'))
                                            {{ $errors->first('pincode') }}
                                        @endif
                                    </span>
                                    <input type="text" name="pincode" class="form-control gj_pincode" placeholder="Enter user Pincode"  value="{{old('pincode') }}"
           oninput="this.value=this.value.replace(/[^0-9]/g,'');" >

                                </div>

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('phone2', 'Phone-2') }}--}}
                        <!--    <span class="error"> -->
                        <!--        @if ($errors->has('phone2'))-->
                        <!--            {{ $errors->first('phone2') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        {{--    {{ Form::number('phone2', Input::old('phone2'), array('class' => 'form-control gj_phone2','placeholder' => 'Enter User Optional Phone Number')) }}--}}
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
                        <!--            <input type="radio" name="gender" value="Male"> Male-->
                        <!--        </span>-->
                        <!--        <span class="gj_py_ro">-->
                        <!--            <input type="radio" name="gender" value="Female"> Female-->
                        <!--        </span>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <div class="form-group col-lg-12">
                             <label for="profile_img">Upload Profile Image</label>
                            <span class="error"> 
                                @if ($errors->has('profile_img'))
                                    {{ $errors->first('profile_img') }}
                                @endif
                            </span>
                            <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                            <input type="file" name="profile_img" id="profile_img" accept="image/*" class="gj_profile_img">
                        </div>

                                <input type="hidden" name="is_approved" value="1">

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('is_approved', 'Approved') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('is_approved'))-->
                        <!--            {{ $errors->first('is_approved') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        <!--    <div class="gj_py_ro_div">-->
                        <!--        <span class="gj_py_ro">-->
                        <!--            <input type="radio" name="is_approved" value="1"> Active-->
                        <!--        </span>-->
                        <!--        <span class="gj_py_ro">-->
                        <!--            <input type="radio" checked name="is_approved" value="0"> Deactive-->
                        <!--        </span>-->
                        <!--    </div>-->
                        <!--</div>-->
                     </div>
                      
                        
                        <input type="submit" class="btn btn-primary mx_auto" value="Add User">


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    setTimeout(function () {
        let alert = document.getElementById('error-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500); // Fully remove after fade-out
        }
    }, 5000); // 5 seconds
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('countryCodeSelect');

    let selectedCode = {!! json_encode( '+91') !!};
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
        $(".toggle-password").click(function() {
            var input = $($(this).attr("toggle"));
            var icon = $(this).find("i");

            if (input.attr("type") == "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                input.attr("type", "password");
                
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
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

        var cnt = 2;
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