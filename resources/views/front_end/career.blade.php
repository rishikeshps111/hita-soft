<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'Career')

@section('content')
<!-- Pages SECTION START -->
<div class="gj_career_sec">
    <section class="gj_carrban_sec">
        <div class="inban inban9" style="background-image:url('{{asset($career->banner_image)}}')">
            @if(isset($career->banner_caption) && $career->banner_caption)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                           <h4> {{$career->banner_caption}}  </h4> 
                        </div>
                    </div>
                </div>  
            @endif    
        </div>  
    </section>
    
    <section class="caresDiv carerz" style="background: url('{{asset($career->career_bg)}}');">
        <div id="main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-7 col-lg-7 col-xs-12">
                        <div class="opez wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.002s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.002s; animation-name: fadeInLeft;">
                            <div class="gj_carr_desc">
                                <?php echo $career->career_desc; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-5 col-lg-5 col-xs-12 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.002s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.002s; animation-name: fadeInRight;">
                        <img class="careerimg" src="{{asset($career->career_img)}}">
                    </div>
                </div>
            </div>
        </div>
    </section>
 
    <section class="carform">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 ">
                    <div class="hirformz">
                        {{ Form::open(array('url' => 'career_form','class'=>'career_form form-horizontal gj_addcou_frm has-validation-callback','id'=>'career','accept-charset'=>'UTF-8','files' => true)) }}
                            <fieldset>
                                <h4 class="text-center">Upload your Resume <span class="short_explanation pull-right">* Required Fields</span></h4>
                           
                                <div><span class="error"></span></div>
                                
                                <div class="row">
                                
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <label for="first_name"> First Name * </label>
                                        <span class="contactus_name_errorloc error">
                                            @if ($errors->has('first_name'))
                                                {{ $errors->first('first_name') }}
                                            @endif
                                        </span>
                                        <br>
                                        <input class="gj_frmctrl" id="first_name" maxlength="50" placeholder="Enter First Name" autocomplete="off" name="first_name" type="text" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+)$">
                                        <br>                               
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <label for="last_name"> Last Name * </label>
                                        <span class="contactus_name_errorloc error">
                                            @if ($errors->has('last_name'))
                                                {{ $errors->first('last_name') }}
                                            @endif
                                        </span>
                                        <br>
                                        <input class="gj_frmctrl" id="last_name" maxlength="50" placeholder="Enter Last Name" autocomplete="off" name="last_name" type="text" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+)$">
                                        <br>
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <label for="email">Email Address *</label>
                                        <span class="contactus_name_errorloc error">
                                            @if ($errors->has('email'))
                                                {{ $errors->first('email') }}
                                            @endif
                                        </span>
                                        <br>
                                        <input class="gj_frmctrl" id="email" maxlength="50" placeholder="Enter Email Address" autocomplete="off" name="email" type="email" data-validation="email">
                                        <br>
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <label for="mobile"> Mobile *</label>
                                        <span class="contactus_name_errorloc error">
                                            @if ($errors->has('mobile'))
                                                {{ $errors->first('mobile') }}
                                            @endif
                                        </span>
                                        <br>
                                        <input class="gj_frmctrl" id="mobile" maxlength="50" placeholder="Enter Mobile Number" autocomplete="off" name="mobile" type="text" data-validation="required custom length" data-validation-regexp="^([0-9+]+)$" data-validation-error-msg-required="You must enter phone number (Eg:+919874563210 or 9874563210)" data-validation-error-msg-custom="You must enter valid phone number (Eg:+919874563210 or 9874563210)" data-validation-error-msg-length="The input value must be between 10-13 Digits (Eg:+919874563210 or 9874563210)" data-validation-length="10-13">
                                        <br>
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <label for="resume">Upload Your Resume *</label>
                                        <span class="contactus_name_errorloc error">
                                            @if ($errors->has('resume'))
                                                {{ $errors->first('resume') }}
                                            @endif
                                        </span>
                                        <br>
                                        <input type="file" name="resume" id="resume" data-validation="required extension" data-validation-allowing="pdf,docx"> 
                                    </div>

                                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                    <label for="job">Position You are applying for </label>
                                    <span class="contactus_name_errorloc error">
                                        @if ($errors->has('job'))
                                            {{ $errors->first('job') }}
                                        @endif
                                    </span>
                                    <br>
                                    <select name="job" id="job" class="gj_c_job" data-validation="required">
                                        <option value="">Select Job Position</option>
                                        @if(isset($jobs) && sizeof($jobs) != 0)
                                            @foreach($jobs as $jk => $jv)
                                                <option value="{{$jv->id}}">{{$jv->job_title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <label for="message">Message * </label>
                                    <span class="contactus_name_errorloc error">
                                        @if ($errors->has('message'))
                                            {{ $errors->first('message') }}
                                        @endif
                                    </span>
                                    <br>
                                    <textarea rows="5" cols="50" name="message" id="message" data-validation="required"></textarea>
                                </div> 
                                
                                
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div id="career_capcha"><div style="width: 304px; height: 78px;margin-bottom:15px;"><div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LdWA6cUAAAAAEcJihfUvZ7js5pBLmbL4zq6ZPE4&amp;co=aHR0cHM6Ly9uZXVyYWxwcnVuaW5nLmNvbTo0NDM.&amp;hl=en&amp;v=UFwvoDBMjc8LiYc1DKXiAomK&amp;size=normal&amp;cb=viopix27b6vu" width="304" height="78" role="presentation" name="a-sd7h3qzqo0i" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>
                                    <span class="contactus_name_errorloc error">
                                        @if ($errors->has('career_capcha'))
                                            {{ $errors->first('career_capcha') }}
                                        @endif
                                    </span>
                                </div>
                                 <br>
                                
                         

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <button type="submit" class="btn hirsubz popup-with-form "> Submit </button>
                                </div>
                                
                            </div> 
                        </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Pages SECTION END -->
@endsection
