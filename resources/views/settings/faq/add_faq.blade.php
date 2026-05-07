@extends('layouts.master')
@section('title', 'Add FAQs')
@section('content')
<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">


            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-edit"></i></div>-->
                <!--    <h5 class="gj_heading">   </h5>-->
                <!--</header>-->

                <div class="col-md-12">
                     <form action="{{ route('store_faq') }}" method="POST" class="gj_faq_form" enctype="multipart/form-data">
                     @csrf
                        <!--<div class="form-group">-->
                        <!--    <label for="faq_cat"> Select Category</label>-->
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('faq_cat'))-->
                        <!--            {{ $errors->first('faq_cat') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        <!--    <select class="form-control" name="faq_cat">-->
                        <!--        <option value="">Select Category...</option>-->
                        <!--        <option value="1">General</option>-->
                        <!--        <option value="2">Sell on Fokgems</option>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                            <div class="col-lg-12 mb-3">
                                 <h3 class="gj_heading"> Add FAQs  </h3>
                            </div>
                             <div class="form-group col-lg-12">
                            <label for="title"> Title</label>
                            <span class="error">* 
                                @if ($errors->has('title'))
                                    {{ $errors->first('title') }}
                                @endif
                            </span>

                                <input type="text" name="title" class="form-control gj_title" value="{{ old('title') }}" placeholder="Title in English">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="content"> Content</label>
                            <span class="error">* 
                                @if ($errors->has('content'))
                                    {{ $errors->first('content') }}
                                @endif
                            </span>

                            <textarea name="content" cols="20" rows="4" class="summernote" required=""></textarea>
                        </div>
                        </div>

                       <div class="update-btn-box mx_auto">
                           <input type="submit" class="btn btn-primary mx_auto" value="Save">
                       </div>

                         
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(1000).slideUp(300); 
    });

    $('.summernote').summernote({
        placeholder: 'Enter Content',
        tabsize: 2,
        height: 100
    });
</script>
@endsection
