@extends('layouts.master')
@section('title', 'Edit Color')
@section('content')
<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Edit Color  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <div class="col-md-12">
                    <form action="{{ route('update_color') }}" method="POST" class="gj_color_form" enctype="multipart/form-data">
                     @csrf

                    @if($colour)
                     <input type="hidden" name="colour_id" class="form-control gj_colour_id" value="{{ $colour->id }}" >

                    @endif
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                              <h3 class="gj_heading"> Edit Color</h3>
                          </div>
                    <div class="col-lg-12 mt__1">

                    <div class="gj_ban_img_whole row">
                        <div class="form-group">
                            <label for="colour">Colour</label>
                            <span class="error">* 
                                @if ($errors->has('color_code'))
                                    {{ $errors->first('color_code') }}
                                @endif
                                @if ($errors->has('color_name'))
                                    {{ $errors->first('color_name') }}
                                @endif
                            </span>

                            <div id="ntc" class="gj_color_picker">
                                <div id="picker"></div>
                                <div id="colortag">
                                    <h2 id="colorname"></h2>
                                    <div id="colorpick"></div>
                                    <div id="colorbox">
                                        <div id="colorsolid"></div>
                                    </div>
                                    <div id="colorpanel">
                                        <div id="colorhex">Your Color:</div>
                                        <input type="text" name="color_code" id="colorinp" class="inputbox" maxlength="10">
                                        <div id="colorrgb"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                     <div class="col-lg-12 mt__1">
                         <div class="update-btn-box ">
                            <input type="submit" class="btn btn-primary mx_auto" id="update" value="Update">
                        </div>
                    </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="{{ asset('color/farbtastic.js')}}"></script>
<script type="text/javascript" src="{{ asset('color/ntc.js')}}"></script>
<script type="text/javascript" src="{{ asset('color/ntc_main.js')}}"></script>
<link type="text/css" rel="stylesheet" href="{{ asset('color/farbtastic.css')}}">
<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
        // $("#colorop").select2();
    });

    $('#update').on('click',function(){
        var id = 0;
        var cn = 0;
        var cc = 0;
        var avoid1 ="<sup>approx.</sup>";
        var avoid2 ='<sup id="solid">solid</sup>';
        if($('#colorname').html()) {
            cn = $('#colorname').html();
            cn = cn.replace(avoid1,'');
            cn = cn.replace(avoid2,'');
        }

        if($('#colorinp').val()) {
            cc = $('#colorinp').val();
        }

        if($('.gj_colour_id').val()) {
            id = $('.gj_colour_id').val();
        }
        // alert(cn+" "+cc);
        if((cn == 0) && (cc == 0) && (id == 0)) {
            $.confirm({
                title: '',
                content: 'Please Select Correct Colour!',
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
        } else {
            $.ajax({
                type: 'post',
                url: '{{url('/edit_color')}}',
                data: {cn: cn, cc: cc, id: id, type: 'edit'},
                success: function(data){
                    if(data == 0){
                        window.location.href = "{{route('manage_color')}}";
                    } else {
                        $.confirm({
                            title: '',
                            content: 'No Action Performed!',
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
        }
    });
</script>
@endsection
