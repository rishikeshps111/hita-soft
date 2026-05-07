<?php  
    $l_pages_opts='<option value="#">Select CMS Page</option>';
    if(isset($cms_pages) && sizeof($cms_pages) != 0) {
        foreach ($cms_pages as $cpkey => $cpvalue) {
            $l_pages_opts.= '<option value="'.route('pages', ['name' => $cpvalue->page_name]).'">'.$cpvalue->page_name.'</option>';
        }
    }
?>

@extends('layouts.master')
@section('title', 'Footer Settings')
@section('content')
<section class="gj_footer_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">
           

            <div class="gj_box dark">
                  @if(Session::has('message'))
                        <p class="alert  {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                <div class="col-md-12 px-0" >
                     <form action="{{ route('store_footer_setting') }}" method="POST" class="gj_footer_form " multipart="multipart/form-data" >
                     @csrf
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12 mb-3">
                             <h3 class="gj_heading"> Footer Settings  </h3>
                         </div>
                          <div class="form-group col-lg-4 mb-3">
                            <label for="heading1">First Footer Title</label>
                            <span class="error">* 
                                @if ($errors->has('heading1'))
                                    {{ $errors->first('heading1') }}
                                @endif
                            </span>
                            @if(isset($footer))
                                <input type="hidden" name="id" value="{{ $footer->id ? $footer->id : '' }}" class="form-control">
                                 <input type="text" name="heading1" value="{{ $footer->heading1 ? $footer->heading1 : '' }}" class="form-control">

                            @else
                                 <input type="hidden" name="id" value="{{ old('id') }}" class="form-control">
                                <input type="text" name="heading1" value="{{ old('heading1') }}" class="form-control">
    
                            @endif
                        </div>

                        <div class="form-group col-lg-4 mb-3">
                            <label for="heading2">Second Footer Title</label>
                            <span class="error">* 
                                @if ($errors->has('heading2'))
                                    {{ $errors->first('heading2') }}
                                @endif
                            </span>
                            @if(isset($footer))
                                 <input type="text" name="heading2" value="{{ $footer->heading2 ? $footer->heading2 : '' }}" class="form-control">
                            @else
                                <input type="text" name="heading2" value="{{ old('heading2') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group col-lg-4 mb-3">
                            <label for="heading3">Third Footer Title</label>
                            <span class="error">* 
                                @if ($errors->has('heading3'))
                                    {{ $errors->first('heading3') }}
                                @endif
                            </span>
                            @if(isset($footer))
                                 <input type="text" name="heading3" value="{{ $footer->heading3 ? $footer->heading3 : '' }}" class="form-control">
                            @else
                                <input type="text" name="heading3" value="{{ old('heading3') }}" class="form-control">
                            @endif
                        </div>
                        
                         <div class="form-group col-lg-12">
                            <label for="footer_desc"> Description</label>
                            <span class="error">* 
                                @if ($errors->has('footer_desc'))
                                    {{ $errors->first('footer_desc') }}
                                @endif
                            </span>

                            <textarea name="footer_desc" cols="20" rows="4" class="summernote form-control" >{{((isset($footer) && $footer->footer_desc) ? $footer->footer_desc : old('footer_desc'))}}</textarea>
                        </div>
                     </div>
                       

                        <!--<div class="form-group">-->
                        <!--    <label for="heading4">Fourth Footer Title</label>-->
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('heading4'))-->
                        <!--            {{ $errors->first('heading4') }}-->
                        <!--        @endif-->
                        <!--    </span>-->
                        <!--    @if(isset($footer))-->
                        <!--         <input type="text" name="heading4" value="{{ $footer->heading4 ? $footer->heading4 : '' }}" class="form-control">-->
                        <!--    @else-->
                        <!--        <input type="text" name="heading4" value="{{ old('heading4') }}" class="form-control">-->
                        <!--    @endif-->
                        <!--</div>-->
                       

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">FontAwesome Icons</h4>
                                    </div>
                                    <div class="modal-body icons-list">
                                        @include('layouts.icons')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                               <div class="col-lg-12 mb-3 ">
                                    <h3 class="gj_heading"> Footer Links  </h3>
                               </div>
                               <div class="col-md-12">
                                <div class="gj_f_lnk_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('l_title'))
                                            <p class="error"> 
                                                {{ $errors->first('l_title') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_f_lnk_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_f_lnk">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Title</th>
                                                    <th>URL</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_f_lnk_bdy">
                                                @if((isset($footer_lnk)) && (count($footer_lnk) != 0))
                                                    @foreach ($footer_lnk as $flkeys => $flvalues)
                                                        <tr id="gj_tr_f_lnk_{{$flkeys+1}}">
                                                            <td>
                                                                <select class="gj_l_type form-control" name="l_type[]">
                                                                    <option <?php if($flvalues->type == 1) { echo 'selected'; } ?> value="1">Quick Links</option>
                                                                    <option <?php if($flvalues->type == 2) { echo 'selected'; } ?> value="2">Others</option>
                                                                    {{-- <option <?php if($flvalues->type == 3) { echo 'selected'; } ?> value="3">Categories</option> --}}
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input class="form-control gj_l_title" placeholder="Enter Title" name="l_title[]" type="text" id="l_title_{{$flkeys+1}}" value="{{$flvalues->title}}">
                                                            </td>

                                                            <td>
                                                                <input class="form-control gj_l_url" placeholder="Enter URL" name="l_url[]" type="text" id="l_url_{{$flkeys+1}}" value="{{$flvalues->url}}">
                                                            </td>

                                                            <td>
                                                                <button type='button' id='f_lnk_bton_{{$flkeys+1}}' class="gj_f_lnk_rem td-dlt"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                      
                                    </div>
                                      <div class="btn-grp">
                                            <input type='button' value='Add Button' id='f_lnk_addbut' class="add_btn_cs">
                                        <input type='button' value='Add Pages to Footer' id='f_lnk_pages_addbut' class="add_btn_cs">
                                        </div>
                                </div>
                            </div>
                         </div>
                         
                           <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12 mb-3 title-between">
                                 <h3 class="gj_heading"> Contact Details  </h3>
                                 <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                             </div>
                             <div class="col-md-12">
                                <div class="gj_f_cnt_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('c_icon'))
                                            <p class="error"> 
                                                {{ $errors->first('c_icon') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_f_cnt_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_f_cnt">
                                            <thead>
                                                <tr>
                                                    <th>Icon</th>
                                                    <th>Title</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_f_cnt_bdy">
                                                @if((isset($footer_cnt)) && (count($footer_cnt) != 0))
                                                    @foreach ($footer_cnt as $fckeys => $fcvalues)
                                                        <tr id="gj_tr_f_cnt_{{$fckeys+1}}">
                                                            <td>
                                                                  
                                                                <input class="form-control gj_c_icon" placeholder="Enter Icon" name="c_icon[]" type="text" id="c_icon_{{$fckeys+1}}" value="{{$fcvalues->icon}}">

                                                              
                                                            </td>
                                                            <td>
                                                                <input class="form-control gj_c_title" placeholder="Enter Title" name="c_title[]" type="text" id="c_title_{{$fckeys+1}}" value="{{$fcvalues->title}}">
                                                            </td>
                                                            <td>
                                                                <button type='button' id='f_cnt_bton_{{$fckeys+1}}' class="gj_f_cnt_rem td-dlt"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                        <!--<input type='button' value='Add Button' id='f_cnt_addbut'>-->
                                    </div>
                                </div>
                            </div>
                         </div>
                          <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                               <div class="col-lg-12 mb-3 title-between">
                                      <h3 class="gj_heading"> Social Details  </h3>
                                        <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                               </div>
                                <div class="col-md-12">
                                <div class="gj_f_solk_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('s_icon'))
                                            <p class="error"> 
                                                {{ $errors->first('s_icon') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_f_solk_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_f_solk">
                                            <thead>
                                                <tr>
                                                    <th>Icon</th>
                                                    <th>URL</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_f_solk_bdy">
                                                @if((isset($footer_slnk)) && (count($footer_slnk) != 0))
                                                    @foreach ($footer_slnk as $fslkeys => $fslvalues)
                                                        <tr id="gj_tr_f_solk_{{$fslkeys+1}}">
                                                            <td>
                                                                <input class="form-control gj_s_icon" placeholder="Enter Icon" name="s_icon[]" type="text" value="{{$fslvalues->icon}}">

                                                              
                                                            </td>
                                                            <td>
                                                                <input class="form-control gj_s_url" placeholder="Enter URL" name="s_url[]" type="text" value="{{$fslvalues->url}}">
                                                            </td>
                                                            <td>
                                                                <button type='button' class="gj_f_solk_rem td-dlt"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                       

                                      
                                    </div>
                                     <div class="btn-grp">
                                              <input type='button' value='Add Button' id='f_solk_addbut' class="add_btn_cs">
                                        </div>
                                </div>
                            </div>
                          </div>

                       

                      

                       {{-- <div class="gj_box dark gj_inside_box">
                            <header>
                                <h5 class="gj_heading"> Payment Details  </h5>
                            </header>
                            
                            <div class="col-md-12">
                                <div class="gj_f_pay_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('p_url'))
                                            <p class="error"> 
                                                {{ $errors->first('p_url') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_f_pay_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_f_pay">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>URL</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_f_pay_bdy">
                                                @if((isset($footer_pay)) && (count($footer_pay) != 0))
                                                    @foreach ($footer_pay as $fpkeys => $fpvalues)
                                                        <tr id="gj_tr_f_pay_{{$fpkeys+1}}">
                                                            <td>
                                                                <input class="form-control gj_p_url" placeholder="Enter URL" name="p_url[]" type="text" value="{{$fpvalues->url}}">
                                                            </td>
                                                            <td>
                                                                @if($fpvalues->image)
                                                                    <div class="gj_aimg_div">
                                                                        <img src="{{ asset($fpvalues->image)}}" class="img-responsive gj_old_prod_img"> 
                                                                    </div>
                                                                    
                                                                    <input type="hidden" name="old_p_image[]" value="{{$fpvalues->image}}">
                                                                @endif
                                                                
                                                                <input type="file" name="p_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                                                            </td>
                                                            <td>
                                                                <button type='button' class="gj_f_pay_rem"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                        <input type='button' value='Add Button' id='f_pay_addbut' class="add_btn_cs">
                                    </div>
                                </div>
                            </div>
                        </div>--}}

                       <div class="update-btn-box">
                            <input type="submit" class="btn btn-primary mx_auto" value="Update">
                       </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700);
    });
</script>

<script type="text/javascript">
    $('p.gj_bk_alt').delay(7000).slideUp(700);
</script>

<script type="text/javascript">
    @if((isset($footer_cnt)) && (count($footer_cnt) != 0))
        var cnt = <?php echo count($footer_cnt) + 1;?>;
    @else
        var cnt = 1;
    @endif

    $("#f_cnt_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_f_cnt_' + cnt);
        newTextBoxDiv.after().html('<td><input class="form-control gj_c_icon" placeholder="Enter Icon" name="c_icon[]" type="text" id="c_icon_' + cnt + '" value=""><p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p></td><td><input class="form-control gj_c_title" placeholder="Enter Title" name="c_title[]" type="text" id="c_title_' + cnt + '" value=""></td><td><button type="button" id="f_cnt_bton_' + cnt + '" class="gj_f_cnt_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_f_cnt_bdy");
        cnt++;
    });

    $('body').on('click','.gj_f_cnt_rem',function() {
        if(cnt==1){
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
    
        cnt--;
        $(this).closest('tr').remove();
    });


    @if((isset($footer_lnk)) && (count($footer_lnk) != 0))
        var ctt = <?php echo count($footer_lnk) + 1;?>;
    @else
        var ctt = 1;
    @endif

    $("#f_lnk_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_f_lnk_' + ctt);
        newTextBoxDiv.after().html('<td><select class="gj_l_type form-control" name="l_type[]"><option value="1">Quick Links</option><option value="2">Others</option><option value="3">Categories</option></select></td><td><input class="form-control gj_l_title" placeholder="Enter Title" name="l_title[]" type="text" id="l_title_' + ctt + '" value=""></td><td><input class="form-control gj_l_url" placeholder="Enter URL" name="l_url[]" type="text" id="l_url_' + ctt + '" value="#"></td><td><button type="button" id="f_lnk_bton_' + ctt + '" class="gj_f_lnk_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_f_lnk_bdy");
        ctt++;
    });

    $('body').on('click','.gj_f_lnk_rem',function() {
        if(ctt==1){
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
    
        ctt--;
        $(this).closest('tr').remove();
    });
// <input class="form-control gj_l_title" placeholder="Enter Title" name="l_title[]" type="text" id="l_title_' + ctt + '" value="">
    $("#f_lnk_pages_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_f_lnk_' + ctt);
        newTextBoxDiv.after().html('<td><select class="gj_l_type form-control" name="l_type[]"><option value="1">Quick Links</option><option value="2">Others</option><option value="3">Categories</option></select></td><td><select class="gj_l_pages form-control" name="l_pages[]"><?php echo $l_pages_opts; ?></select></td><td><input class="form-control gj_l_url" placeholder="Enter URL" name="l_url[]" type="text" id="l_url_' + ctt + '" value="#"></td><td><button type="button" id="f_lnk_bton_' + ctt + '" class="gj_f_lnk_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_f_lnk_bdy");
        ctt++;

        // $('.gj_l_pages').closest("tr").find('.gj_l_url').val($('.gj_l_pages').val());
        // $('.gj_l_pages').closest("tr").find('.gj_l_title').val($("option:selected", '.gj_l_pages').text());
        // $('.gj_l_pages').closest("tr").find('.gj_l_pages').val($('.gj_l_pages').val());
    });

    $('body').on('change','.gj_l_pages',function() {
        $(this).closest("tr").find('.gj_l_url').val($(this).val());
        $(this).closest("tr").find('.gj_l_title').val($("option:selected", this).text());
    });

    @if((isset($footer_slnk)) && (count($footer_slnk) != 0))
        var fslct = <?php echo count($footer_slnk) + 1;?>;
    @else
        var fslct = 1;
    @endif

    $("#f_solk_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_f_solk_' + fslct);
        newTextBoxDiv.after().html('<td><input class="form-control gj_s_icon" placeholder="Enter Icon" name="s_icon[]" type="text" value=""><p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p></td><td><input class="form-control gj_s_url" placeholder="Enter URL" name="s_url[]" type="text" value="#"></td><td><button type="button" class="gj_f_solk_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_f_solk_bdy");
        fslct++;
    });

    $('body').on('click','.gj_f_solk_rem',function() {
        if(fslct==1){
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
    
        fslct--;
        $(this).closest('tr').remove();
    });

    @if((isset($footer_pay)) && (count($footer_pay) != 0))
        var fpay = <?php echo count($footer_pay) + 1;?>;
    @else
        var fpay = 1;
    @endif

    $("#f_pay_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_f_pay_' + fpay);
        newTextBoxDiv.after().html('<td><input class="form-control gj_p_url" placeholder="Enter URL" name="p_url[]" type="text" value="#"></td><td><input type="file" name="p_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control"></td><td><button type="button" class="gj_f_pay_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_f_pay_bdy");
        fpay++;
    });

    $('body').on('click','.gj_f_pay_rem',function() {
        if(fpay==1){
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
    
        fpay--;
        $(this).closest('tr').remove();
    });
</script>
@endsection