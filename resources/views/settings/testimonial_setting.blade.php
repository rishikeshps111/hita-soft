<?php  
    $l_pages_opts='<option value="#">Select CMS Page</option>';
    if(isset($cms_pages) && sizeof($cms_pages) != 0) {
        foreach ($cms_pages as $cpkey => $cpvalue) {
            $l_pages_opts.= '<option value="'.route('pages', ['name' => $cpvalue->page_name]).'">'.$cpvalue->page_name.'</option>';
        }
    }
?>

@extends('layouts.master')
@section('title', 'Testimonial Settings')
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
                <div class="col-md-12">
                     <form action="{{route('store_testimonial_setting')}}" class="gj_footer_form" method="POST" enctype="multipart/form-data">
                        @csrf
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12 mb-3">
                             <h3 class="gj_heading"> Testimonial Details  </h3>
                         </div>
                          <div class="col-md-12">
                                <div class="gj_f_pay_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('testimonial_name'))
                                            <p class="error"> 
                                                {{ $errors->first('testimonial_name') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_f_pay_resp table-responsive container-field-table">
                                        <table class="table table-stripped table-bordered gj_tab_f_pay">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>User Type</th>
                                                    <th>Message</th>
                                                    <th>Image</th>
                                                    <!--<th>Rating</th>-->
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                           <tbody id="gj_f_pay_bdy">
                                                @if(isset($testimonial) && count($testimonial) != 0)
                                                    @foreach ($testimonial as $fpkeys => $fpvalues)
                                                        <tr id="gj_tr_f_pay_{{$fpkeys+1}}">
                                                            <td>
                                                                <!-- Hidden input to track existing testimonial IDs for updates -->
                                                                <input type="hidden" name="testimonial_id[]" value="{{ $fpvalues->id ?? '' }}">
                                                                <input class="form-control" placeholder="Enter Name" name="testimonial_name[]" type="text" value="{{ $fpvalues->name ?? '' }}">
                                                            </td>

                                                            <td>
                                                                <input class="form-control" placeholder="Enter User Type" name="testimonial_user_type[]" type="text" value="{{ $fpvalues->user_type ?? '' }}">
                                                            </td>
                                            
                                                            <td>
                                                                <textarea class="form-control" placeholder="Enter Message" name="testimonial_message[]" rows="2">{{ $fpvalues->message ?? '' }}</textarea>
                                                            </td>
                                            
                                                            <td>
                                                                <div class="td-div-cs">
                                                                    @if($fpvalues->image)
                                                                    <div class="gj_aimg_div">
                                                                        <img src="{{ asset($fpvalues->image)}}" class="img-responsive gj_old_prod_img"> 
                                                                    </div>
                                                                    <!-- Keep the old image in case no new one is uploaded -->
                                                                    <input type="hidden" name="old_testimonial_image[]" value="{{ $fpvalues->image }}">
                                                                @else
                                                                    <input type="hidden" name="old_testimonial_image[]" value="">
                                                                @endif
                                                                <input type="file" name="testimonial_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                                                                </div>
                                                            </td>
                                            
                                                            <!--<td>-->
                                                            <!--    <select name="testimonial_rating[]" class="form-control">-->
                                                            <!--        <option value="1" {{ isset($fpvalues->rating) && $fpvalues->rating == 1 ? 'selected' : '' }}>⭐</option>-->
                                                            <!--        <option value="2" {{ isset($fpvalues->rating) && $fpvalues->rating == 2 ? 'selected' : '' }}>⭐⭐</option>-->
                                                            <!--        <option value="3" {{ isset($fpvalues->rating) && $fpvalues->rating == 3 ? 'selected' : '' }}>⭐⭐⭐</option>-->
                                                            <!--        <option value="4" {{ isset($fpvalues->rating) && $fpvalues->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐</option>-->
                                                            <!--        <option value="5" {{ isset($fpvalues->rating) && $fpvalues->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>-->
                                                            <!--    </select>-->
                                                            <!--</td>-->
                                            
                                                            <td>
                                                                <button type="button" class="gj_f_pay_rem td-dlt"  data-id="{{ $fpvalues->id }}"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>

                                        </table>
                                      
                                        
                                    </div>
                                      <div class="btn-grp">
                                            <input type='button' value='Add Button' id='f_pay_addbut' class="add_btn_cs">
                                        </div>

                                </div>
                            </div>
                         </div>
                            <div class="update-btn-box">
                                 <input class="btn btn-primary mx_auto" type="submit" value="Update">
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
    @if(isset($testimonial) && count($testimonial) != 0)
        var fpay = {{ count($testimonial) + 1 }};
    @else
        var fpay = 1;
    @endif

    $(document).ready(function () {
        // Ensure adding a new row only happens when clicking "Add Button"
        $("#f_pay_addbut").off("click").on("click", function () {
            addNewRow();
        });

        // Remove row functionality
        $("body").on("click", ".gj_f_pay_rem", function () {
            if ($("#gj_f_pay_bdy tr").length > 1) {
                $(this).closest("tr").remove();
            } else {
                $.confirm({
                    title: '',
                    content: 'At least one testimonial is required!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        Ok: function () { }
                    }
                });
            }
        });

        function addNewRow() {
            var newRow = `
                <tr id="gj_tr_f_pay_${fpay}">
                    <td><input class="form-control" placeholder="Enter Name" name="testimonial_name[]" type="text"></td>
                    <td><input class="form-control" placeholder="Enter User Type" name="testimonial_user_type[]" type="text"></td>
                    <td><textarea class="form-control" placeholder="Enter Message" name="testimonial_message[]" rows="2"></textarea></td>
                    <td>
                        <input type="file" name="testimonial_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                    </td>
                   
                    <td><button type="button" class="gj_f_pay_rem"><i class="fa fa-trash"></i></button></td>
                </tr>
            `;

            $("#gj_f_pay_bdy").append(newRow);
            fpay++;
        }
    });
    
    
    $(document).ready(function () {
    $("body").on("click", ".gj_f_pay_rem", function () {
        var row = $(this).closest("tr");
        var testimonialId = $(this).data("id");

        if ($("#gj_f_pay_bdy tr").length > 1) {
            if (testimonialId) {
                $.ajax({
                    url: "{{ route('delete_testimonial') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: testimonialId
                    },
                    success: function (response) {
                        if (response.success) {
                            row.remove();
                        } else {
                            alert("Failed to delete.");
                        }
                    },
                    error: function () {
                        alert("Something went wrong. Try again.");
                    }
                });
            } else {
                row.remove(); 
            }
        } else {
            alert("At least one testimonial must remain.");
        }
    });
});

    
</script>


@endsection
