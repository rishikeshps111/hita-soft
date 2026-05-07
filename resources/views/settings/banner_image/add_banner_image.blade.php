@extends('layouts.master')
@section('title', 'Add Banner Image')
@section('content')
    <section class="gj_email_setting">
        <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
        <div class="row gj_row ">

            <div class="col-lg-2 adminLeftSide" id="adminSideNav">
                <button type="button" class="Mob-side-close" onclick="openadminSide()"><i
                        class="fa-solid fa-xmark"></i></button>
                @include('layouts.sidebar')
            </div>

            <div class="col-lg-10 ">


                <div class="gj_box dark">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif


                    <div class="col-md-12">
                        <form action="{{ route('store_banner_image') }}" method="POST" class="gj_geneal_form"
                            enctype="multipart/form-data">
                            <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                                <div class="col-lg-12 mb-3">
                                    <h3 class="gj_heading"> Add Banner Image </h3>
                                </div>
                                <div class="col-lg-4 mt__3">
                                    @csrf
                                    <div class="form-group">

                                        <label for="image_title">Banner Caption</label>
                                        <span class="error">
                                            @if ($errors->has('image_title'))
                                                {{ $errors->first('image_title') }}
                                            @endif
                                        </span>
                                        <input type="text" name="image_title" class="form-control gj_image_title"
                                            placeholder="Banner Title in English">

                                    </div>
                                </div>
                                <div class="col-lg-8 mt__3">

                                    <div class="form-group">
                                        <label for="redirect_url">Banner Subcaption</label>
                                        <span class="error">*
                                            @if ($errors->has('button_title'))
                                                {{ $errors->first('button_title') }}
                                            @endif
                                        </span>
                                        <input type="text" name="button_title" value="{{ old('button_title') }}"
                                            class="form-control gj_redirect_url" placeholder="Button Subcaption">
                                    </div>

                                </div>
                                {{-- <div class="col-lg-4 mt__3">

                                    <div class="form-group">
                                        <label for="redirect_url">Redirect URL</label>
                                        <span class="error">*
                                            @if ($errors->has('redirect_url'))
                                                {{ $errors->first('redirect_url') }}
                                            @endif
                                        </span>
                                        <input type="text" name="redirect_url" value="{{ old('redirect_url') }}"
                                            class="form-control gj_redirect_url" placeholder="Redirect URL">

                                        <p class="gj_ru_ex">Example : <b>http://www.google.com</b> or <b>#</b></p>
                                    </div>

                                </div> --}}
                                <div class="col-lg-12 ">
                                    <div class="form-group">
                                        <label for="banner_image">Upload Banner Image</label>
                                        <span class="error">*
                                            @if ($errors->has('banner_image'))
                                                {{ $errors->first('banner_image') }}
                                            @endif
                                        </span>
                                        <p class="gj_not" style="color:red"><em>image size must be 1090 x 450 pixels</em>
                                        </p>

                                        <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                            class="gj_banner_image">
                                    </div>
                                </div>
                            </div>


                            <!-- <div class="form-group">
                            <label for="slider_speed">Image Slider Speed</label>
                                <span class="error">* 
                                    @if ($errors->has('slider_speed'))
                                        {{ $errors->first('slider_speed') }}
                                    @endif
                                </span>

                                    <input type="number" name="slider_speed"  class="form-control gj_slider_speed" placeholder="Banner Slider Speed in Number">


                                <p class="gj_note">1000 = 1second. You have put the value for 1000,2000 like us.</p>
                            </div> -->

                            <div class="update-btn-box mx_auto">
                                <input type="submit" class="btn btn-primary mx_auto" value="Update">
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('p.alert').delay(1000).slideUp(300);
        });
    </script>
@endsection