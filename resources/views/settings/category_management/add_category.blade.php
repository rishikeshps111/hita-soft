@extends('layouts.master')
@section('title', 'Add Main Category')
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
                
               

                <div class="col-md-12"> 
                <form action="{{ route('store_category') }}" method="POST" class="gj_geneal_form" enctype="multipart/form-data">
                     @csrf
                      <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                          <div class="col-lg-12">
                              <h3 class="gj_heading"> Add Main Category  </h3>
                          </div>
                          <div class="col-lg-6 mt__1">
                              <div class="form-group">
                            
                            <label for="main_cat_name">Main Category Name</label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_name'))
                                    {{ $errors->first('main_cat_name') }}
                                @endif
                            </span>
                            <input type="text" name="main_cat_name" class="form-control gj_main_cat_name" placeholder="Enter Category Name In English"  value="{{ old('main_cat_name') }}" >

                        </div>
                          </div>
                          <div class="col-lg-6 mt__1">
                                 <div class="form-group">
                            <label for="main_cat_name"> Category Description</label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_desc'))
                                    {{ $errors->first('main_cat_desc') }}
                                @endif
                            </span>
                            <input type="text" name="main_cat_desc" class="form-control gj_main_cat_name" placeholder="Enter Category Description"  value="{{ old('main_cat_desc') }}" >

                        </div>
                          </div>
                          <div class="col-lg-6 mt__1">
                              <div class="form-group">
                            <label for="is_top_cat">Top Category</label>
                            <span class="error">* 
                                @if ($errors->has('is_top_cat'))
                                    {{ $errors->first('is_top_cat') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" name="is_top_cat" value="1"> Yes
                                </span>
                                <span class="gj_py_ro mt__1">
                                    <input type="radio" checked name="is_top_cat" value="0"> No
                                </span>
                            </div>
                        </div>
                          </div>
                          <div class="col-lg-6 mt__1">
                                <div class="form-group">
                            <label for="is_block">Category Staus</label>
                            <span class="error">* 
                                @if ($errors->has('is_block'))
                                    {{ $errors->first('is_block') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" checked name="is_block" value="1"> Active
                                </span>
                                <span class="gj_py_ro mt__1">
                                    <input type="radio" name="is_block" value="0"> Deactive
                                </span>
                            </div>
                        </div>
                          </div>
                           <div class="col-lg-12 mt__1">
                               <div class="form-group">
                            <label for="main_cat_image">Upload Main Category Image</label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_image'))
                                    {{ $errors->first('main_cat_image') }}
                                @endif
                            </span>
                            <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                            <input type="file" name="main_cat_image" id="main_cat_image" accept="image/*" class="gj_main_cat_image">
                        </div>
                           </div>
                            <div class="col-lg-12 mt__1">
                                 <div class="update-btn-box ">
                            <input type="submit" class="btn btn-primary mx_auto" value="Update">
                        </div>
                            </div>
                      </div>

                        
                     

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('main_cat_icon', 'Main Category Icon') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('main_cat_icon'))-->
                        <!--            {{ $errors->first('main_cat_icon') }}-->
                        <!--        @endif-->
                        <!--    </span>-->
                        <!--    <p class="gj_ex_ph">Example: fa-user </p>-->

                        {{--    {{ Form::text('main_cat_icon', Input::old('main_cat_icon'), array('class' => 'form-control gj_main_cat_icon','placeholder' => 'Enter Category Icon In Under the List')) }}--}}
                        <!--    <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>-->

                            <!-- Modal -->
                        <!--    <div class="modal fade" id="myModal" role="dialog">-->
                        <!--        <div class="modal-dialog">-->
                                    <!-- Modal content-->
                        <!--            <div class="modal-content">-->
                        <!--                <div class="modal-header">-->
                        <!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                        <!--                    <h4 class="modal-title">FontAwesome Icons</h4>-->
                        <!--                </div>-->
                        <!--                <div class="modal-body">-->
                        <!--                    @include('layouts.icons')-->
                        <!--                </div>-->
                        <!--                <div class="modal-footer">-->
                        <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('priority', 'Priority') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('priority'))-->
                        <!--            {{ $errors->first('priority') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        {{--    {{ Form::number('priority', Input::old('priority'), array('class' => 'form-control gj_priority','placeholder' => 'Enter Priority In Number')) }}--}}
                        <!--</div>-->

                        

                      

                       

                         

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $("#country_name").select2();
        $('p.alert').delay(7000).slideUp(700); 
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
                            }
                        }
                    });
                }
            }
        });
    });

  
    $('body').on('click','.gj_att_rem',function() {
        if(counter==1){
            $.confirm({
                title: '',
                content: 'No more textbox to remove!',
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
            return false;
        }   
    
        counter--;
        $(this).closest('tr').remove();
    });

    $('body').on('change','.gj_att_name',function() {
        var att_n = 0;
        if ($(this).val()) {
            att_n = $(this).val();
        }
        var ths = $(this);

        $.ajax({
            type: 'post',
            url: '{{url('/cat_select_att_vals')}}',
            data: {id: att_n, type: 'select_att_vals'},
            success: function(data){
                if(data != 0){
                    ths.closest('tr').find('.gj_attr_values').html(data);
                } else {
                    $.confirm({
                        title: '',
                        content: 'Select Another Attributes!',
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
                    // window.location.reload();
                }
            }
        });
    });
</script>
@endsection
