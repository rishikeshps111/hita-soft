@extends('layouts.master')
@section('title', 'Add Stock Details')
@section('content')

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 44px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
   
    top: 8px !important;
}
</style>

<?php $log = session()->get('user'); ?>

<section class="gj_stock_setting min-90-vh">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.product_sidebar')
        </div>

        <div class="col-lg-10 ">


            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <div class="col-md-12">
                    <form action="{{ route('store_stock') }}" method="POST" class="gj_stock_form" enctype="multipart/form-data">
                     @csrf
                      <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                          <div class="col-lg-12">
                                <h3 class="gj_heading"> Add Stock Details  </h3>
                          </div>
                        <div class="form-group col-lg-4 select-cs-cont"  >
                            <label for="product_id">Select Products</label>
                            <span class="error">* 
                                @if ($errors->has('product_id'))
                                    {{ $errors->first('product_id') }}
                                @endif
                            </span>

                            <?php 
                                $opt = '';
                                $product = '';
                                if($log) {
                                    if($log->user_type == 1) {
                                        $product = \DB::table('products')->where('is_block',1)->get();
                                    } elseif ($log->user_type == 2 || $log->user_type == 3) {
                                        $product = \DB::table('products')->where('is_block',1)->where('created_user', $log->id)->get();
                                    }
                                }
                                if(($product) && (count($product) != 0)){
                                    foreach ($product as $key => $value) {
                                        $opt.='<option value="'.$value->id.'">'.$value->product_title.'</option>';
                                    }
                                } 
                            ?>
                            <select id="product_id" name="product_id" class="form-control">
                                <option value="0" selected disabled>Select Products</option>
                                <?php echo $opt; ?>
                            </select>
                        </div>
                        
                         <div class="gj_substks1 col-lg-8 stock-add-container" >
                              <div class="form-group col-lg-4" id="product-image-container" style="display:none;">
                                    <label>Product Image</label><br>
                                    <img src="" id="product_image_preview" alt="Product Image" style="max-height: 100px; border: 1px solid #ccc; padding: 5px;">
                                </div>
                            <div class="form-group col-lg-4">
                                 <label for="current_qty">Current Quantity</label>
                                <span class="error">* 
                                    @if ($errors->has('current_qty'))
                                        {{ $errors->first('current_qty') }}
                                    @endif
                                </span>
                                 <input type="text" name="d_current_qty" class="form-control gj_d_current_qty" placeholder="Current Quantity"  value="{{ old('d_current_qty') }}" readonly>
                                <input type="hidden" name="current_qty" id="current_qty" class="form-control gj_current_qty" placeholder="Current Quantity"  value="{{ old('current_qty') }}" >

                            </div>

                            <div class="form-group col-lg-4">
                                <label for="addon_qty">Add On Quantity</label>
                                <span class="error">* 
                                    @if ($errors->has('addon_qty'))
                                        {{ $errors->first('addon_qty') }}
                                    @endif
                                </span>
                                <input type="number" name="addon_qty" class="form-control gj_addon_qty" placeholder="Add On Quantity"  value="{{ old('addon_qty') }}" >
                                
                            </div>
                        </div>

                        <div class="gj_substks2">
                        </div>
                        <div class="update-btn-box col-lg-12">
                            <input type="submit" class="btn btn-primary mx_auto w-h-inp h-35" value="Update">
                       </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#product_id").select2();
    });

    $('#product_id').on('change',function(){
        var p_id = $(this).select2('val');
        if(p_id) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_qty')}}',
                data: {p_id: p_id, type: 'qty'},
                dataType: 'text',
                success: function(data){
                    var data = JSON.parse(data);
                    if(data.error == 0){
                        $("#current_qty").val(data.product.onhand_qty);
                        $(".gj_d_current_qty").val(data.product.onhand_qty);

                        if(data.data != "") {
                            $('.gj_substks2').html(data.data);
                            $('.gj_substks1').slideUp();
                            $('.gj_substks2').slideDown();
                        }
                        
                        if (data.featured_product_img) {
                            $('#product_image_preview').attr('src', data.featured_product_img);
                            $('#product-image-container').show();
                        } else {
                            $('#product_image_preview').attr('src', '');
                            $('#product-image-container').hide();
                        }
                    } else if(data.error == 1){
                        $("#current_qty").val(data.product.onhand_qty);
                        $(".gj_d_current_qty").val(data.product.onhand_qty);

                        if(data.data == "") {
                            $('.gj_substks2').html(data.data);
                            $('.gj_substks1').slideDown();
                            $('.gj_substks2').slideUp();
                        }
                        
                          if (data.featured_product_img) {
                            $('#product_image_preview').attr('src', data.featured_product_img);
                            $('#product-image-container').show();
                        } else {
                            $('#product_image_preview').attr('src', '');
                            $('#product-image-container').hide();
                        }
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Quantity Not Available!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'blue',
                            buttons: {
                                Ok: function(){
                                }
                            }
                        });
                        $("#current_qty").val('0');
                        $(".gj_d_current_qty").val('0');
                        $('#product-image-container').hide();
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select Another Time!',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });
</script>
@endsection
