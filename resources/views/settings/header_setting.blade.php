<?php  
    $cat_opts ='';
    // $cat_opts ='<option value="">Select Category</option>';
    if(isset($all_cats) && sizeof($all_cats) != 0) {
        foreach ($all_cats as $ackey => $acvalue) {
            $cat_opts.='<option value="'.$acvalue->id.'">'.$acvalue->main_cat_name.'</option>';
        }
    }
?>

@extends('layouts.master')
@section('title', 'Header Settings')
@section('content')
<section class="gj_header_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Header Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Header Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'header_setting','class'=>'gj_header_form','files' => true)) }}

                        <div class="gj_box dark gj_inside_box">
                            <header>
                                <h5 class="gj_heading"> Top Header Menus  </h5>
                            </header>
                            
                            <div class="col-md-12">
                                <div class="gj_hdr_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('category'))
                                            <p class="error"> 
                                                {{ $errors->first('category') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_hdr_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_hdr">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Priority</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_hdr_bdy">
                                                @if((isset($header)) && (count($header) != 0))
                                                    @foreach ($header as $hrkeys => $hrvalues)
                                                        <tr id="gj_tr_hdr_{{$hrkeys+1}}">
                                                            <td>
                                                                <select class="gj_category form-control" name="category[]">
                                                                    <option value="">Select Category</option>
                                                                    @if(isset($all_cats) && sizeof($all_cats) != 0)
                                                                        @foreach ($all_cats as $ackey => $acvalue)
                                                                            <option <?php if($acvalue->id == $hrvalues->category) { echo 'selected'; } ?> value="{{$acvalue->id}}">{{$acvalue->main_cat_name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input class="form-control gj_priority" placeholder="Enter priority" name="priority[]" type="text" value="{{$hrvalues->priority}}">
                                                            </td>

                                                            <td>
                                                                <button type="button" class="gj_hdr_rem"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>

                                        <input type='button' value='Add Button' id='hdr_addbut'>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

                    {{ Form::close() }}
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
    @if((isset($header_lnk)) && (count($header_lnk) != 0))
        var ctt = <?php echo count($header_lnk) + 1;?>;
    @else
        var ctt = 1;
    @endif

    $("#hdr_addbut").click(function () {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_hdr_' + ctt);
        newTextBoxDiv.after().html('<td><select class="gj_category form-control" name="category[]"><?php echo $cat_opts; ?></select></td><td><input class="form-control gj_priority" placeholder="Enter priority" name="priority[]" type="text" value=""></td><td><button type="button"  class="gj_hdr_rem"><i class="fa fa-trash"></i></button></td>');
        newTextBoxDiv.appendTo("#gj_hdr_bdy");
        ctt++;
    });

    $('body').on('click','.gj_hdr_rem',function() {
        ctt--;
        $(this).closest('tr').remove();
    });
</script>
@endsection