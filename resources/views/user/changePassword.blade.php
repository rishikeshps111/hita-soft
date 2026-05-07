@extends('layouts.master')
@section('title', 'Change Password')
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
                
              

                <div class="col-md-12">
                      <form action="{{ route('check_forgot') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                        @if($user)
                            
                             <input type="hidden" name="user_id" value="{{ $user->id }}" class="form-control gj_user_id">
                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12">
                                  <h3 class="gj_heading"> Change Admin Password  </h3>
                             </div>
                              <div class="gj_box dark gj_inside_box">
                           
                            
                            <div class="row row_mx_0">
                                <div class="form-group col-lg-4">
                                      <label for="current_password">Current Password</label>
                                    <span class="error">* 
                                        @if ($errors->has('current_password'))
                                            {{ $errors->first('current_password') }}
                                        @endif
                                    </span>
                                    <div style="position: relative;">
                                        <input type="password" name="current_password" id="current_password" class="form-control gj_first_name" placeholder="Enter Current Password">
                                        <span class="toggle-password" toggle="#current_password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fa fa-eye fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="new_password">New Password</label>
                                    <span class="error"> 
                                        @if ($errors->has('new_password'))
                                            {{ $errors->first('new_password') }}
                                        @endif
                                    </span>
                                    <div style="position: relative;">
                                        <input type="password" name="new_password" id="new_password" class="form-control gj_last_name" placeholder="Enter New Password">
                                        <span class="toggle-password" toggle="#new_password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fa fa-eye fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="confirm_password">Confirm Password</label>
                                    <span class="error"> 
                                        @if ($errors->has('confirm_password'))
                                            {{ $errors->first('confirm_password') }}
                                        @endif
                                    </span>
                                    <div style="position: relative;">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control gj_bussiness_name" placeholder="Enter Confirm Password">
                                        <span class="toggle-password" toggle="#confirm_password" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fa fa-eye fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>

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
        $(".toggle-password").click(function() {
            var input = $($(this).attr("toggle"));
            var icon = $(this).find("i");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
</script>
@endsection







