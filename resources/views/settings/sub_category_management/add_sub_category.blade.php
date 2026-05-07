@extends('layouts.master')
@section('title', 'Add Sub Category')
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
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add Sub Category  </h5>
                </header>

                <div class="col-md-12">
                    <form action="{{route('store_sub_category')}}" class="gj_geneal_form" method="POST" enctype="multipart/form-data">
                                             @csrf

                        <div class="form-group">
                              <label for="main_cat_name">Main Category Name </label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_name'))
                                    {{ $errors->first('main_cat_name') }}
                                @endif
                            </span>
                            <input type="text" class="form-control shadow-none gj_h_main_cat_name" name="h_main_cat_name" value="{{$cats->main_cat_name ? $cats->main_cat_name : old('main_cat_name')}}" placeholder="Enter Category Name In English" disabled>
                             <input type="hidden" class="form-control shadow-none gj_main_cat_name" name="main_cat_name" value="{{$cats->id ? $cats->id : 0 }}" placeholder="Enter Category Name In English" >
                             
                        </div>

                        <div class="form-group">
                             <label for="sub_cat_name">Sub Category Name</label>
                            <span class="error">* 
                                @if ($errors->has('sub_cat_name'))
                                    {{ $errors->first('sub_cat_name') }}
                                @endif
                            </span>
                            <input type="text" class="form-control shadow-none gj_sub_cat_name" name="sub_cat_name" value="{{old('sub_cat_name')}}" placeholder="Enter Sub Category Name In English" >
                           
                        </div>

                        <div class="form-group">
                           <label for="is_block">Sub Category Staus</label>
                            <span class="error">* 
                                @if ($errors->has('is_block'))
                                    {{ $errors->first('is_block') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" checked name="is_block" value="1"> Active
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" name="is_block" value="0"> Deactive
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sub_cat_image">Upload Sub Category Image</label>
                            <span class="error">* 
                                @if ($errors->has('sub_cat_image'))
                                    {{ $errors->first('sub_cat_image') }}
                                @endif
                            </span>
                            <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                            <input type="file" name="sub_cat_image" id="sub_cat_image" accept="image/*" class="gj_sub_cat_image">
                        </div>

                            <button type="submit" class="btn btn-primary">Update</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $("#country_name").select2();
        $('p.alert').delay(1000).slideUp(300); 
    });

    $('#country_name').on('change',function(){
        var c_id = $(this).select2('val');

        $.ajax({
            type: 'post',
            url: '{{url('/country_details')}}',
            data: {c_id: c_id, type: 'details'},
            success: function(data){
                if(data != ""){
                    var data = $.parseJSON(data);
                    $('.gj_h_country_name').val(data.name);
                    $('.gj_country_code').val(data.code);
                    $('.gj_currency_symbol').val(data.currency_symbol);
                    $('.gj_currency_code').val(data.currency_code);
                } else {
                    $.confirm({
                        title: '',
                        content: 'No More Data Here!',
                        icon: 'fa fa-exclamation',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'purple',
                        buttons: {
                            Ok: function(){
                                window.location.reload();
                            }
                        }
                    });
                }
            }
        });
    });
</script>
@endsection
