@extends('layouts.master')
@section('title', 'Add Products')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .w-h-inp{
        width:150px;
       height: 37px !important;
    }
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 44px !important;
}
</style>
<section class="gj_product_setting">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.product_sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark">
                
                @if($errors->any())
                    <div class="alert alert-danger" id="error-alert">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-edit"></i></div>-->
                <!--    <h5 class="gj_heading">  </h5>-->
                <!--</header>-->

                <div class="col-md-12">
                     <form action="{{ route('store_product') }}" method="POST" class="gj_product_form" enctype="multipart/form-data">
                     @csrf
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                             <h3 class="gj_heading"> Add Products </h3>
                         </div>
                         <div>
                              <div class="gj_box dark gj_inside_box">
                            <!--<header>-->
                            <!--    <h5 class="gj_heading"> Products Details  </h5>-->
                            <!--</header>-->
                            
                            <div class="row" style="margin:0;">
                                <div class="form-group col-lg-12">
                                    <label for="product_title">product Title</label>
                                    <span class="error">* 
                                        @if ($errors->has('product_title'))
                                            {{ $errors->first('product_title') }}
                                        @endif
                                    </span>
                                    <input type="text" name="product_title" class="form-control gj_product_title" placeholder="Enter product Title in English"  value="{{  old('product_title') }}">

                                    <!--<span class="gj_ptit_edit"><i class="fa fa-pencil"></i></span>-->
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="product_desc">product Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('product_desc'))
                                            {{ $errors->first('product_desc') }}
                                        @endif
                                    </span>
                                    <textarea name="product_desc" id="product_desc" class="form-control gj_product_desc" rows="5" 
                                                  placeholder="Enter product Description in English">{{ old('product_desc') }}</textarea>

                                    <p class="gj_not" style="color:red"><em>Note : Just give the content format here as you wish to display in the frontend. (Eg: Paragraph should be given if needed) </em></p>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="product_weight">Product Weight (gram)</label>
                                    <span class="error">* 
                                        @if ($errors->has('product_weight'))
                                            {{ $errors->first('product_weight') }}
                                        @endif
                                    </span>
                                    <input type="text" name="product_weight" class="form-control gj_product_weight" placeholder="Enter Product Weight in Gram (eg:150)"  value="{{ old('product_weight') }}" >

                                </div>

                                <div class="form-group">
                                    {{ Form::label('product_length', 'Product Length (cm)') }}
                                    <span class="error">* 
                                        @if ($errors->has('product_length'))
                                            {{ $errors->first('product_length') }}
                                        @endif
                                    </span>

                                    {{ Form::text('product_length', Input::old('product_length'), array('class' => 'form-control gj_product_length','placeholder' => 'Enter Product Length in Centimeter (eg:10)')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('product_width', 'Product Width (cm)') }}
                                    <span class="error">* 
                                        @if ($errors->has('product_width'))
                                            {{ $errors->first('product_width') }}
                                        @endif
                                    </span>

                                    {{ Form::text('product_width', Input::old('product_width'), array('class' => 'form-control gj_product_width','placeholder' => 'Enter Product Width in Centimeter (eg:10)')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('product_height', 'Product Height (cm)') }}
                                    <span class="error">* 
                                        @if ($errors->has('product_height'))
                                            {{ $errors->first('product_height') }}
                                        @endif
                                    </span>

                                    {{ Form::text('product_height', Input::old('product_height'), array('class' => 'form-control gj_product_height','placeholder' => 'Enter Product Height in Centimeter (eg:10)')) }}
                                </div> --}}

                                <!--<div class="form-group">-->
                                <!--<label for="brand">Select Brands</label>-->
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('brand'))-->
                                <!--            {{ $errors->first('brand') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                    <?php 
                                        // $opt = '';
                                        // $brand = \DB::table('brands')->where('is_block',1)->get();
                                        // if(($brand) && (count($brand) != 0)){
                                        //     foreach ($brand as $key => $value) {
                                        //         $opt.='<option value="'.$value->id.'">'.$value->brand_name.'</option>';
                                        //     }
                                        // } 
                                    ?>
                                <!--    <select id="brand" name="brand" class="form-control">-->
                                <!--        <option value="0" selected>Select Brands</option>-->
                                        <?php 
                                        // echo $opt; 
                                        ?>
                                <!--    </select>-->
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                <!--<label for="model_no">Model No</label>-->
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('model_no'))-->
                                <!--            {{ $errors->first('model_no') }}-->
                                <!--        @endif-->
                                <!--    </span>-->
                                 <!--<input type="text" name="model_no" class="form-control gj_model_no" placeholder="Enter Model No"  value="{{ old('model_no') }}" >-->
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                <!--<label for="varient">Varient</label>-->
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('varient'))-->
                                <!--            {{ $errors->first('varient') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                               
                                    <!--<input type="text" name="varient" class="form-control gj_varient" placeholder="Enter Varient"  value="{{ old('varient') }}" >-->
                           <!--</div>-->

                                <div class="form-group col-lg-12 select-cs-cont" >
                                    <label for="main_cat_name">Select Main Category Name</label>
                                    <span class="error">* 
                                        @if ($errors->has('main_cat_name'))
                                            {{ $errors->first('main_cat_name') }}
                                        @endif
                                    </span>

                                    <?php 
                                        $opt = '';
                                        $main = \DB::table('category_management_settings')->where('is_block',1)->get();
                                        if(($main) && (count($main) != 0)){
                                            foreach ($main as $key => $value) {
                                                $opt.='<option value="'.$value->id.'">'.$value->main_cat_name.'</option>';
                                            }
                                        } 
                                    ?>
                                    <select id="main_cat_name" name="main_cat_name" class="form-control">
                                        <option value="" selected disabled>Select Main Category</option>
                                        <?php echo $opt; ?>
                                    </select>
                                </div>

                               {{-- <div class="form-group col-lg-12 select-cs-cont">
                                    <label for="sub_cat_name">Select Sub Category Name</label>
                                    <span class="error">* 
                                        @if ($errors->has('sub_cat_name'))
                                            {{ $errors->first('sub_cat_name') }}
                                        @endif
                                    </span>

                                    <select id="sub_cat_name" name="sub_cat_name" disabled class="form-control">
                                        <option value="" selected disabled>Select Sub Category Name</option>
                                    </select>
                                </div> --}}
                                
                                {{-- <div class="form-group col-lg-12">
                                    <label for="features">Product Notes</label>
                                    <span class="error">
                                        @if ($errors->has('product_notes'))
                                            {{ $errors->first('product_notes') }}
                                        @endif
                                    </span>
                                    <textarea name="product_notes"  rows="5" placeholder="Enter product Notes" class="form-control gj_features" >{{old('product_notes')}}</textarea>

                                 </div>

                               <div class="form-group">
                                    {{ Form::label('sub_sub_cat_name', 'Select Sub Sub Category Name') }}
                                    <span class="error">*
                                        @if ($errors->has('sub_sub_cat_name'))
                                            {{ $errors->first('sub_sub_cat_name') }}
                                        @endif
                                    </span>

                                    <select id="sub_sub_cat_name" name="sub_sub_cat_name" disabled class="form-control">
                                        <option value="" selected disabled>Select Sub Sub Category Name</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    {{ Form::label('manufacturer', 'Manufacturer') }}
                                    <span class="error">* 
                                        @if ($errors->has('manufacturer'))
                                            {{ $errors->first('manufacturer') }}
                                        @endif
                                    </span>

                                    {{ Form::text('manufacturer', Input::old('manufacturer'), array('class' => 'form-control gj_manufacturer','placeholder' => 'Enter Manufacturer')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('tags', 'Select Tags') }}
                                    <span class="error"> 
                                        @if ($errors->has('tags'))
                                            {{ $errors->first('tags') }}
                                        @endif
                                    </span>--}}

                                    <?php 
                                        // $opt = '';
                                        // $tag = \DB::table('tags')->where('is_block',1)->get();
                                        // if(($tag) && (count($tag) != 0)){
                                        //     foreach ($tag as $key => $value) {
                                        //         $opt.='<option value="'.$value->id.'">'.$value->tag_title.'</option>';
                                        //     }
                                        // } 
                                    ?>

                                <!--    <select id="tags" name="tags[]" class="form-control" multiple="multiple">-->
                                        <?php 
                                        // echo $opt; 
                                        ?>
                                <!--    </select>-->
                                <!--</div>-->
                                
                                {{--<div class="form-group col-lg-4">
                                    <label for="rang_price">Rang Price</label>
                                    <span class="error">* 
                                        @if ($errors->has('rang_price'))
                                            {{ $errors->first('rang_price') }}
                                        @endif
                                    </span>
                                    <input type="number" name="rang_price" id="rang_price" class="form-control gj_rang_price" placeholder="Enter Rang Price"  value="{{ old('rang_price') }}" >
                                   
                                </div> --}}

                                <div class="form-group col-lg-4">
                                    <label for="original_price">Selling Price</label>
                                    <span class="error">* 
                                        @if ($errors->has('original_price'))
                                            {{ $errors->first('original_price') }}
                                        @endif
                                    </span>
                                    <input type="number" name="original_price" id="original_price" class="form-control gj_original_price" placeholder="Enter Selling Price"  value="{{ old('original_price') }}" >
                                   
                                </div>

                               {{-- <div class="form-group col-lg-4">
                                    <label for="tax">Tax (%)</label>
                                    <span class="error">* 
                                        @if ($errors->has('tax'))
                                            {{ $errors->first('tax') }}
                                        @endif
                                    </span>

                                    <input class="form-control gj_tax" placeholder="Enter Tax in percentage" name="h_tax"  type="number"  value="{{old('tax')}}"> 
                                
                                </div>  --}}

                                <div class="form-group col-lg-4">
                                    <label for="discounted_price">Discounted Selling Price</label>
                                    <span class="error">* 
                                        @if ($errors->has('discounted_price'))
                                            {{ $errors->first('discounted_price') }}
                                        @endif
                                    </span>

                                    <input type="number" name="discounted_price" class="form-control gj_discounted_price" id="gj_discounted_price" placeholder="Enter Discounted Selling Price"  value="{{  old('discounted_price') }}" >
                                   
                                </div>

                               {{-- <div class="form-group col-lg-4">
                                    <label for="tax_amount">Tax Amount</label>
                                    <span class="error">* 
                                        @if ($errors->has('tax_amount'))
                                            {{ $errors->first('tax_amount') }}
                                        @endif
                                    </span>

                                    <input class="form-control gj_h_tax_amount" placeholder="Enter Tax in Amount" name="h_tax_amount" disabled type="number" value="{{old('h_tax_amount')}}"> 

                                     <input class="form-control gj_tax_amount" placeholder="Enter Tax in Amount" name="tax_amount" type="hidden" value="{{ old('tax_amount')}}">
                                
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="product_cost">Final Selling Price</label>
                                    <span class="error">* 
                                        @if ($errors->has('product_cost'))
                                            {{ $errors->first('product_cost') }}
                                        @endif
                                    </span>
                                    <input class="form-control gj_h_product_cost" placeholder="Enter Final Selling Price" name="h_product_cost" disabled type="number" value="{{ old('h_product_cost')}}"> 

                                     <input class="form-control gj_h_product_cost" placeholder="Enter Final Selling Price" name="product_cost" type="hidden" value="{{ old('product_cost')}}">
                               
                                </div>  --}}

                                {{--<div class="form-group">
                                    {{ Form::label('service_charge', 'Service Charge') }}
                                    <span class="error"> 
                                        @if ($errors->has('service_charge'))
                                            {{ $errors->first('service_charge') }}
                                        @endif
                                    </span>

                                    {{ Form::text('service_charge', Input::old('service_charge'), array('class' => 'form-control gj_service_charge','placeholder' => 'Enter Service Charge')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('tax_type', 'Select Shipping Type') }}
                                    <span class="error">* 
                                        @if ($errors->has('tax_type'))
                                            {{ $errors->first('tax_type') }}
                                        @endif
                                    </span>

                                    <select id="tax_type" name="tax_type" class="form-control">
                                        <option value="0">Select Shipping Type</option>
                                        <option value="1">Inclusive</option>
                                        <option value="2">Exclusive</option>
                                    </select>
                                </div>--}}

                                {{--<div class="form-group col-lg-4">
                                    <label for="shiping_charge">Domestic Shipping</label>
                                    <span class="error">*
                                        @if ($errors->has('shiping_charge'))
                                            {{ $errors->first('shiping_charge') }}
                                        @endif
                                    </span>
                                    <input class="form-control gj_shiping_charge" placeholder="Enter Domestic Shipping Charge" name="shiping_charge" type="number" value="{{old('shiping_charge')}}">
                               
                                </div>
                                
                                <div class="form-group col-lg-4">
                                    <label for="shiping_charge">International Shipping</label>
                                    <span class="error">*
                                        @if ($errors->has('inter_shiping_charge'))
                                            {{ $errors->first('inter_shiping_charge') }}
                                        @endif
                                    </span>
                                    <input class="form-control gj_shiping_charge" placeholder="Enter International Shipping Charge" name="inter_shiping_charge" type="number" value="{{old('inter_shiping_charge')}}">
                               
                                </div>--}}

                                <div class="form-group col-lg-4">
                                    <label for="onhand_qty">On Hand Quantity</label>
                                    <span class="error">* 
                                        @if ($errors->has('onhand_qty'))
                                            {{ $errors->first('onhand_qty') }}
                                        @endif
                                    </span>
                                    <input class="form-control gj_onhand_qty" placeholder="Enter On Hand Quantity" name="onhand_qty" type="number" value="{{old('onhand_qty')}}">
                               
                                </div>

                                <!--<div class="form-group">-->
                                <!--<label for="measurement_unit">Select Measurement Units</label>-->
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('measurement_unit'))-->
                                <!--            {{ $errors->first('measurement_unit') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                    <?php 
                                        // $opt = '';
                                        // $measure = \DB::table('measurement_units')->where('is_block',1)->get();
                                        // if(($measure) && (count($measure) != 0)){
                                        //     foreach ($measure as $key => $value) {
                                        //         @$opt.='<option value="'.$value->id.'">'.$value->unit_name.'</option>';
                                        //     }
                                        // } 
                                    ?>

                                    <!--<select id="measurement_unit" name="measurement_unit" class="form-control">-->
                                    <!--    <option value="0" selected disabled>Select Measurement Units</option>-->
                                        <?php 
                                        // echo $opt; 
                                        ?>
                                <!--    </select>-->
                                <!--</div>-->

                                {{--<div class="form-group col-lg-12">
                                    <label for="features">Features</label>
                                    <span class="error">* 
                                        @if ($errors->has('features'))
                                            {{ $errors->first('features') }}
                                        @endif
                                    </span>

                                    <textarea name="features"  rows="5" placeholder="Enter Features" class="form-control gj_features" >{{old('features')}}</textarea>

                                    <p class="gj_not" style="color:red"><em>Note : Just give the content format here as you wish to display in the frontend. (Eg: Paragraph should be given if needed)</em></p>
                                </div>
                                
                                <div class="form-group col-lg-6">
                                    <label for="features">Delivery</label>
                                    <span class="error">
                                        @if ($errors->has('delivery'))
                                            {{ $errors->first('delivery') }}
                                        @endif
                                    </span>
                                    <textarea name="delivery_text"  rows="5" placeholder="Enter Delivery" class="form-control gj_features" >{{old('delivery_text')}}</textarea>

                                 </div>
                                
                                <div class="form-group col-lg-6">
                                    <label for="features">Care Instructions</label>
                                    <span class="error"> 
                                        @if ($errors->has('instuctions'))
                                            {{ $errors->first('instuctions') }}
                                        @endif
                                    </span>
                                    <textarea name="instructions"  rows="5" placeholder="Enter Care Instructions" class="form-control gj_features" >{{old('instructions')}}</textarea>

                                 </div>
                                 
                                 <div class="form-group col-lg-6">
                                    <label for="features">Disclaimer</label>
                                    <span class="error"> 
                                        @if ($errors->has('disclaimer'))
                                            {{ $errors->first('disclaimer') }}
                                        @endif
                                    </span>
                                    <textarea name="disclaimer"  rows="5" placeholder="Enter Disclaimer" class="form-control gj_features" >{{old('disclaimer')}}</textarea>

                                 </div> 
                                 
                                 <div class="form-group col-lg-6">
                                    <label for="features">Note </label>
                                    <span class="error"> 
                                        @if ($errors->has('note'))
                                            {{ $errors->first('note') }}
                                        @endif
                                    </span>
                                    <textarea name="note"  rows="5" placeholder="Enter Note" class="form-control gj_features" >{{old('note')}}</textarea>

                                 </div> --}}

                                <!--<div class="form-group">-->
                                <!--<label for="shiping_policy">Shipping & Return Policy</label>-->
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('shiping_policy'))-->
                                <!--            {{ $errors->first('shiping_policy') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                {{--    {{ Form::textarea('shiping_policy', Input::old('shiping_policy'), array('class' => 'form-control gj_shiping_policy','placeholder' => 'Enter Shipping & Return Policy','rows'=>'5')) }}--}}

                                <!--    <p class="gj_not" style="color:red"><em>Note : Just give the content format here as you wish to display in the frontend. (Eg: Paragraph should be given if needed)</em></p>-->
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('offers_flag', 'Set Offers') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('offers_flag'))-->
                                <!--            {{ $errors->first('offers_flag') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                <!--    <div class="gj_py_ro_div">-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="offers_flag" value="1"> Active-->
                                <!--        </span>-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="offers_flag" value="0"> Deactive-->
                                <!--        </span>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <div class="form-group col-lg-12">
                                    <label for="featuredproduct_flag">Featured Products</label>
                                    <span class="error">* 
                                        @if ($errors->has('featuredproduct_flag'))
                                            {{ $errors->first('featuredproduct_flag') }}
                                        @endif
                                    </span>

                                    <div class="gj_py_ro_div">
                                        <span class="gj_py_ro">
                                            <input type="radio" name="featuredproduct_flag" value="1"> Yes
                                        </span>
                                        <span class="gj_py_ro">
                                            <input type="radio" name="featuredproduct_flag" value="0"> No
                                        </span>
                                    </div>
                                </div>

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('toprated_flag', 'Top Rated') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('toprated_flag'))-->
                                <!--            {{ $errors->first('toprated_flag') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                <!--    <div class="gj_py_ro_div">-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="toprated_flag" value="1"> Yes-->
                                <!--        </span>-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="toprated_flag" value="0"> No-->
                                <!--        </span>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('best_seller_flag', 'Best Seller') }}--}}
                                <!--    <span class="error">* -->
                                <!--        @if ($errors->has('best_seller_flag'))-->
                                <!--            {{ $errors->first('best_seller_flag') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                <!--    <div class="gj_py_ro_div">-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="best_seller_flag" value="1"> Yes-->
                                <!--        </span>-->
                                <!--        <span class="gj_py_ro">-->
                                <!--            <input type="radio" name="best_seller_flag" value="0"> No-->
                                <!--        </span>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <div class="form-group col-lg-12">
                                    <label for="new_arrival">New Arrival</label>
                                    <span class="error">* 
                                        @if ($errors->has('new_arrival'))
                                            {{ $errors->first('new_arrival') }}
                                        @endif
                                    </span>

                                    <div class="gj_py_ro_div">
                                        <span class="gj_py_ro">
                                            <input type="radio" name="new_arrival" value="1"> Yes
                                        </span>
                                        <span class="gj_py_ro">
                                            <input type="radio" name="new_arrival" value="0"> No
                                        </span>
                                    </div>
                                </div>

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('delivery', 'Delivery') }}--}}
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('delivery'))-->
                                <!--            {{ $errors->first('delivery') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                {{--    {{ Form::number('delivery', Input::old('delivery'), array('class' => 'form-control gj_delivery','placeholder' => 'Enter Delivery in Days')) }}--}}
                                <!--</div>-->

                                <!--<div class="form-group">-->
                                {{--    {{ Form::label('store_name', 'Select Stores') }}--}}
                                <!--    <span class="error"> -->
                                <!--        @if ($errors->has('store_name'))-->
                                <!--            {{ $errors->first('store_name') }}-->
                                <!--        @endif-->
                                <!--    </span>-->

                                    <?php 
                                        $opt = '';
                                        // $store = \DB::table('stores')->where('is_block',1)->get();
                                        // if((isset($store)) && (count($store) != 0)){
                                        //     foreach ($store as $key => $value) {
                                        //         $opt.='<option value="'.$value->id.'">'.$value->store_name.'</option>';
                                        //     }
                                        // } 
                                    ?>

                                <!--    <select id="store_name" name="store_name" class="form-control">-->
                                <!--        <option value="0" selected>Select Stores</option>-->
                                        <?php 
                                        // echo @$opt;
                                        ?>
                                <!--    </select>-->
                                <!--</div>-->

                                <div class="form-group col-lg-12">
                                        <label for="featured_product_img">Upload Featured Product Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('featured_product_img'))
                                            {{ $errors->first('featured_product_img') }}
                                        @endif
                                    </span>
                                    <!--<p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p>-->

                                    <input type="file" name="featured_product_img" id="featured_product_img" accept="image/*" class="gj_featured_product_img">
                                </div>
                            </div>
                        </div>

                        <div class="gj_box dark gj_inside_box">
                            <!--<header>-->
                            <!--    <h5 class="gj_heading"> Products Attributes  </h5>-->
                            <!--</header>-->
                            
                            <div class="col-md-12">
                                <div class="gj_p_att_div">
                                    <div class="gj_tot_err">
                                       @if ($errors->has('att_name'))
                                            <p class="error"> 
                                                {{ $errors->first('att_name') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('att_value'))
                                            <p class="error"> 
                                                {{ $errors->first('att_value') }}
                                            </p>
                                        @endif

                                     {{--    @if ($errors->has('att_description'))
                                            <p class="error"> 
                                                {{ $errors->first('att_description') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('att_price'))
                                            <p class="error"> 
                                                {{ $errors->first('att_price') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('att_tax_amount'))
                                            <p class="error"> 
                                                {{ $errors->first('att_tax_amount') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('att_cost'))
                                            <p class="error"> 
                                                {{ $errors->first('att_cost') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('att_qty'))
                                            <p class="error"> 
                                                {{ $errors->first('att_qty') }}
                                            </p>
                                        @endif  --}}

                                        @if ($errors->has('att_colors'))
                                            <p class="error"> 
                                                {{ $errors->first('att_colors') }}
                                            </p>
                                        @endif
                                        @if ($errors->has('att_image'))
                                            <p class="error"> 
                                                {{ $errors->first('att_image') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="attributes_flag">Set Attributes</label>
                                        <span class="error">* 
                                            @if ($errors->has('attributes_flag'))
                                                {{ $errors->first('attributes_flag') }}
                                            @endif
                                        </span>

                                        <div class="gj_py_ro_div">
                                            <span class="gj_py_ro">
                                                <input type="radio" name="attributes_flag" value="1"> Active
                                            </span>
                                            <span class="gj_py_ro">
                                                <input type="radio" checked name="attributes_flag" value="0"> Deactive
                                            </span>
                                        </div>
                                    </div>

                                    <div class="gj_p_att_resp table-responsive">
                                        <table class="table table-bordered gj_tab_att">
                                            <thead>
                                                <tr>
                                                    <th>Default</th>
                                                    <th>Color Code</th>
                                                    <th>Color Name</th>
                                                    <th>Image</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                    
                                            <tbody id="color_att_body">
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="att_default[]" class="gj_att_default" value="2">
                                                        <input type="hidden" class="v_att_default" name="v_att_default[]" value="2">
                                                    </td>
                                    
                                                    <td>
                                                        <input type="text" name="att_colors[]" class="form-control" placeholder="Color Code">
                                                        <small><a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a></small>
                                                    </td> 
                                    
                                                    <td>
                                                        <input type="text" name="att_colors_name[]" class="form-control" placeholder="Color Name">
                                                    </td>
                                    
                                                    <td>
                                                        <input type="file" name="att_image[]" class="form-control" accept="image/*">
                                                    </td>
                                    
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-color-row">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    
                                        <button type="button" id="addColorRow" class="btn btn-primary">
                                            Add New
                                        </button>
                                    </div>

                                    <!--<div class="gj_p_att_resp table-responsive">-->
                                    <!--    <table class="table table-stripped table-bordered gj_tab_att">-->
                                    <!--        <thead>-->
                                    <!--            <tr>-->
                                    <!--                <th>Default</th>-->
                                    <!--                <th>Color Code</th>-->
                                    <!--                <th>Color Name</th>-->
                                                    <!--<th class="gj_att_values">Value</th>-->
                                                    <!--<th>Cost</th>-->
                                                    <!--<th>Tax</th>-->
                                                    <!--<th>Price</th>-->
                                                    <!--<th>Qty</th>-->
                                                    <!--<th>Description</th>-->
                                    <!--                <th>Attribute Image</th>-->
                                    <!--                <th>#</th>-->
                                    <!--            </tr>-->
                                    <!--        </thead>-->
                                    <!--        <tbody id="gj_att_bdy">-->
                                    <!--            <?php $atts_flds = ""; ?>-->
                                    <!--            <tr id="gj_tr_att_1">-->
                                    <!--                <td>-->
                                    <!--                    <input type="radio" name="att_default[]" class="gj_att_default" value="2">-->
                                    <!--                    <input type="hidden" class="v_att_default" name="v_att_default[]" value="2">-->
                                    <!--                </td>-->
                                    <!--                <td>-->
                                    <!--                    <input type="text" class="form-control " placeholder="Enter Color Code" name="att_colors[]" id="colors_1">-->
                                    <!--                    <a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a>-->
                                    <!--                </td>-->
                                    <!--                <td>-->
                                    <!--                    <input type="text" class="form-control " placeholder="Enter Color Name" name="att_colors_name[]" id="colors_name_1">-->
                                    <!--                </td>-->
                                                    
                                    <!--                <td>-->
                                    <!--                    <input type="file" name="att_image[]" id="att_image_1" accept="image/*" class="gj_att_image form-control">-->
                                    <!--                </td>-->
                                    <!--                <td>-->
                                    <!--                    <button type='button' id='removeButton_1' class="gj_att_rem"><i class="fa fa-trash"></i></button>-->
                                    <!--                </td>-->
                                    <!--            </tr>-->
                                    <!--        </tbody>-->
                                    <!--    </table>-->

                                    <!--    <input type='button' value='Add New' id='addButton'>-->
                                        <!-- <input type='button' value='Get TextBox Value' id='getButtonValue'> -->
                                    <!--</div>-->
                                    
                                    <div class="gj_p_att_resp table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Attribute</th>
                                                    <th>Value</th>
                                                    <!--<th>Image</th>-->
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                    
                                            <tbody id="general_att_body">
                                                <tr>
                                    
                                                    <td>
                                                        <select name="att_name[]" class="form-control gj_att_name">
                                                            <option value="">Select Attribute</option>
                                                            @foreach($attributes as $att)
                                                                <option value="{{ $att->id }}">{{ $att->att_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                    
                                                    <td>
                                                        <select name="att_value[]" class="form-control gj_attr_values">
                                                            <option value="">Select Value</option>
                                                        </select>
                                                    </td>
                                    
                                                    <!--<td>-->
                                                    <!--    <input type="file" name="att_image[]" class="form-control" accept="image/*">-->
                                                    <!--</td>-->
                                    
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-att-row">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    
                                        <button type="button" id="addGeneralRow" class="btn btn-primary">
                                            Add New
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{--<div class="gj_box dark gj_inside_box" style="margin:0;">
                            <div class="col-lg-12">
                                 <h3 class="gj_heading"> Products Images  </h3>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="gj_p_img_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('p_name'))
                                            <p class="error"> 
                                                {{ $errors->first('p_name') }}
                                            </p>
                                        @endif

                                        @if ($errors->has('p_image'))
                                            <p class="error"> 
                                                {{ $errors->first('p_image') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="gj_p_img_resp table-responsive">
                                        <table class="table table-stripped table-bordered gj_tab_pimg">
                                            <thead>
                                                <tr>
                                                    <th>Product Image Name</th>
                                                    <th>Product Image</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody id="gj_pimg_bdy">
                                                <tr id="gj_tr_pimg_1">
                                                    <td>
                                                        <input class="form-control gj_p_name" placeholder="Enter Product Name" name="p_name[]" type="text" id="p_name_1">
                                                    </td>
                                                    <td>
                                                        <input type="file" name="p_image[]" id="p_image_1" accept="image/*" class="gj_p_image form-control">
                                                    </td>
                                                    <td>
                                                        <button type='button' id='img_removeButton_1' class="gj_pimg_rem"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <input type='button' value='Add New' id='img_addButton' class="add_btn_cs w-h-inp">
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        <div class="gj_box dark gj_inside_box" style="margin:0;">
                            <div class="col-lg-12">
                                <h3 class="gj_heading"> Products Images </h3>
                            </div>
                        
                            <div class="col-md-12">
                                <div class="gj_p_img_div">
                                    <div class="gj_tot_err">
                                        @if ($errors->has('p_image'))
                                            <p class="error">{{ $errors->first('p_image') }}</p>
                                        @endif
                                    </div>
                        
                                    <div class="form-group">
                                                           
                                        <input type="file" name="p_image[]" id="p_image" accept="image/*" multiple class="form-control">
                                    </div>
                        
                                    <div id="image_preview" class="row" style="gap: 10px; display: flex; flex-wrap: wrap;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="update-btn-box ">
                             <input type="submit" class="btn btn-primary mx_auto w-h-inp" value="Add Product">
                        </div>
                        

                        

                    </form>
                </div>
                         </div>
                     </div>
                       
            </div>
        </div>
    </div>
</section>

<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="cropImagePreview" src="" style="max-width: 100%; max-height: 500px;">
                <div class="form-check mt-3 text-start">
                    <input type="checkbox" class="form-check-input" id="useOriginalImage">
                    <label for="useOriginalImage" class="form-check-label">
                        Use Original Image (Skip Cropping)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Save Image</button>
            </div>
        </div>
    </div>
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#product_desc'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', '|',
            'bulletedList', 'numberedList', '|',
            'link', '|',
            'undo', 'redo'
        ]
    })
    .catch(error => {
        console.error(error);
    });
</script>



<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#error-alert').fadeOut('slow');
        }, 3000); 
    });
</script>
<script>
$(document).ready(function() {
    let cropper;
    let currentInput = null;
    let rawImageData = null;

    // --- FEATURED PRODUCT IMAGE ---
    $("#featured_product_img").on("change", function(e) {
        const file = e.target.files[0];
        if (file) {
            currentInput = this;
            const reader = new FileReader();
            reader.onload = function(event) {
                rawImageData = event.target.result;
                $("#cropImagePreview").attr("src", rawImageData);
                $("#cropModal").modal("show");
            };
            reader.readAsDataURL(file);
        }
    });

    // --- MULTIPLE PRODUCT IMAGES ---
    $("#p_image").on("change", function(e) {
        const file = e.target.files[0];
        if (file) {
            currentInput = this;
            const reader = new FileReader();
            reader.onload = function(event) {
                rawImageData = event.target.result;
                $("#cropImagePreview").attr("src", rawImageData);
                $("#cropModal").modal("show");
            };
            reader.readAsDataURL(file);
        }
    });

    // Initialize cropper
    $("#cropModal").on("shown.bs.modal", function() {
        const image = document.getElementById("cropImagePreview");
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            responsive: true,
            autoCropArea: 1, // Show full image initially
        });
    }).on("hidden.bs.modal", function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        $("#useOriginalImage").prop("checked", false); // reset checkbox
    });

    // Handle crop button click
    $("#cropImageBtn").on("click", function() {
        const useOriginal = $("#useOriginalImage").is(":checked");

        if (useOriginal) {
            // Use the original file
            const dataTransfer = new DataTransfer();
            const blob = dataURLtoBlob(rawImageData);
            const file = new File([blob], "original_image.jpg", { type: "image/jpeg" });
            dataTransfer.items.add(file);
            currentInput.files = dataTransfer.files;
            $("#cropModal").modal("hide");
            return;
        }

        // Otherwise, use the cropped version
        if (cropper && currentInput) {
            const canvas = cropper.getCroppedCanvas({ width: 800, height: 800 });
            canvas.toBlob(function(blob) {
                const file = new File([blob], "cropped_image.jpg", { type: "image/jpeg" });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                currentInput.files = dataTransfer.files;
                $("#cropModal").modal("hide");
            }, "image/jpeg", 0.9);
        }
    });

    // Helper function to convert base64 to Blob
    function dataURLtoBlob(dataurl) {
        const arr = dataurl.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], {type:mime});
    }
});
</script>



<script>
// let allFiles = [];

// document.getElementById('p_image').addEventListener('change', function(e) {
//     const previewContainer = document.getElementById('image_preview');
//     const newFiles = Array.from(e.target.files);

//     allFiles = allFiles.concat(newFiles);

//     previewContainer.innerHTML = ""; // Clear current previews

//     const dataTransfer = new DataTransfer();

//     allFiles.forEach((file, index) => {
//         if (file.type.startsWith('image/')) {
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 const wrapper = document.createElement('div');
//                 wrapper.style.position = 'relative';

//                 const img = document.createElement('img');
//                 img.src = e.target.result;
//                 img.style.width = '100px';
//                 img.style.height = '100px';
//                 img.style.objectFit = 'cover';
//                 img.style.margin = '5px';
//                 img.style.border = '1px solid #ddd';
//                 img.style.borderRadius = '5px';

//                 const removeBtn = document.createElement('button');
//                 removeBtn.innerHTML = '&times;';
//                 removeBtn.type = 'button';
//                 removeBtn.style.position = 'absolute';
//                 removeBtn.style.top = '2px';
//                 removeBtn.style.right = '2px';
//                 removeBtn.style.background = 'red';
//                 removeBtn.style.color = 'white';
//                 removeBtn.style.border = 'none';
//                 removeBtn.style.borderRadius = '50%';
//                 removeBtn.style.width = '20px';
//                 removeBtn.style.height = '20px';
//                 removeBtn.style.cursor = 'pointer';

//                 removeBtn.onclick = function() {
//                     allFiles.splice(index, 1);
//                     // Trigger change event again to refresh
//                     document.getElementById('p_image').dispatchEvent(new Event('change', { bubbles: true }));
//                 };

//                 wrapper.appendChild(img);
//                 wrapper.appendChild(removeBtn);
//                 previewContainer.appendChild(wrapper);
//             };
//             reader.readAsDataURL(file);

//             // Rebuild file input
//             dataTransfer.items.add(file);
//         }
//     });

//     // Assign updated file list to input
//     document.getElementById('p_image').files = dataTransfer.files;
// });
</script>



<script>
    function gj_round(value, decPlaces) {
        var val = value * Math.pow(10, decPlaces);
        var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

        // -342.055 => -342.06
        if (fraction == -0.5) fraction = -0.6;

        val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
        return val;
    }

    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#main_cat_name").select2();
        $("#sub_cat_name").select2();
        $("#sub_sub_cat_name").select2();
        $("#tags").select2();
        $("#measurement_unit").select2();
        $("#store_name").select2();
        $("#tax_type").select2();
    });

    /*$('#discounted_price').on('change',function() {
        if($(this).val()) {
            var dp = parseFloat($(this).val());
            var mrp = 0;
            var gst = 0;
            if($('#original_price').val()) {
                mrp = parseFloat($('#original_price').val());
            }

            if($('#tax').val()) {
                gst = parseFloat($('#tax').val());
            }

            if(mrp!= 0 && gst != 0) {
                var tpp = dp * (gst/100);
                var tp = dp + tpp;
                if(mrp <= tp) {
                    $.confirm({
                        title: '',
                        content: 'Include GST Price is ' + tp + ', This Price is more than Original Price!',
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
                    $('#product_cost').val('');
                }
            } else {
                $.confirm({
                    title: '',
                    content: 'Please Enter Original price And Category or Add Tax!',
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
        } else {
            $.confirm({
                title: '',
                content: 'Please Enter Discounted price!',
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
    });*/

    // $('#gj_discounted_price').on('change',function() {
    //     if($(this).val()) {
    //         var dp = parseFloat($(this).val());
    //         var mrp = 0;
    //         var gst = 0;
    //         if($('#original_price').val()) {
    //             mrp = parseFloat($('#original_price').val());
    //         }

    //         if($('#tax').val()) {
    //             gst = parseFloat($('#tax').val());
    //         }

    //         if(mrp!= 0 && gst != 0) {
    //             if(mrp > dp) {
    //                 var tpp = (dp * gst)/(100 + gst);
    //                 var tp = dp - tpp;
    //                 tpp = gj_round(tpp, 2);
    //                 tp = gj_round(tp, 2);
    //                 var pc = gj_round(pc, 2);
    //                 pc = tp + tpp;
    //                 if(mrp <= tp) {
    //                     $.confirm({
    //                         title: '',
    //                         content: 'Include GST Price is ' + tp + ', This Price is more than Original Price!',
    //                         icon: 'fa fa-exclamation',
    //                         theme: 'modern',
    //                         closeIcon: true,
    //                         animation: 'scale',
    //                         type: 'blue',
    //                         buttons: {
    //                             Ok: function(){
    //                             }
    //                         }
    //                     });
    //                     $('#product_cost').val('');
    //                     $('.gj_h_product_cost').val('');
    //                     $('.gj_tax_amount').val('');
    //                     $('.gj_h_tax_amount').val('');
    //                     $(this).val('');
    //                 } else {
    //                     $('#product_cost').val(tp);
    //                     $('.gj_h_product_cost').val(tp);
    //                     $('.gj_tax_amount').val(tpp);
    //                     $('.gj_h_tax_amount').val(tpp);
    //                     $('.gj_discounted_price').val(pc);
    //                 }
    //             } else {
    //                 $.confirm({
    //                     title: '',
    //                     content: 'Please Enter Discounted Price Less Than Original price!',
    //                     icon: 'fa fa-exclamation',
    //                     theme: 'modern',
    //                     closeIcon: true,
    //                     animation: 'scale',
    //                     type: 'blue',
    //                     buttons: {
    //                         Ok: function(){
    //                         }
    //                     }
    //                 });  
    //                 $('#product_cost').val('');
    //                 $('.gj_h_product_cost').val('');
    //                 $('.gj_tax_amount').val('');
    //                 $('.gj_h_tax_amount').val('');
    //                 $(this).val('');
    //             }
    //         } else {
    //             $.confirm({
    //                 title: '',
    //                 content: 'Please Enter Original price And Add Tax!',
    //                 icon: 'fa fa-exclamation',
    //                 theme: 'modern',
    //                 closeIcon: true,
    //                 animation: 'scale',
    //                 type: 'blue',
    //                 buttons: {
    //                     Ok: function(){
    //                     }
    //                 }
    //             });

    //             $('#product_cost').val('');
    //             $('.gj_h_product_cost').val('');
    //             $('.gj_tax_amount').val('');
    //             $('.gj_h_tax_amount').val('');
    //             $(this).val('');
    //         }
    //     } else {
    //         $.confirm({
    //             title: '',
    //             content: 'Please Enter Discounted Price!',
    //             icon: 'fa fa-exclamation',
    //             theme: 'modern',
    //             closeIcon: true,
    //             animation: 'scale',
    //             type: 'blue',
    //             buttons: {
    //                 Ok: function(){
    //                 }
    //             }
    //         });

    //         $('#product_cost').val('');
    //         $('.gj_h_product_cost').val('');
    //         $('.gj_tax_amount').val('');
    //         $('.gj_h_tax_amount').val('');
    //         $(this).val('');
    //     }
    // });
function calculateProductCost() {
    let dp = parseFloat($('#gj_discounted_price').val()) || 0;
    let mrp = parseFloat($('#original_price').val()) || 0;
    let gst = parseFloat($('.gj_tax').val()) || 0;

    let priceForTax = dp > 0 ? dp : mrp;
    
    if (!priceForTax) {
        // $('#product_cost').val('');
        $('.gj_h_product_cost').val('');
        $('.gj_tax_amount').val('');
        $('.gj_h_tax_amount').val('');
        return;
    }

    if (!gst) {
       $('.gj_tax').val('');
        return;
    }

    gst = gst / 100;

    let taxAmount = priceForTax * gst;
    let finalPrice = priceForTax + taxAmount;          // Total price including tax

    $('#product_cost').val(finalPrice.toFixed(2));
    $('.gj_h_product_cost').val(finalPrice.toFixed(2));
    $('.gj_tax_amount').val(taxAmount.toFixed(2));
    $('.gj_h_tax_amount').val(taxAmount.toFixed(2));
    $('.gj_discounted_price').val(dp);
}

$('.gj_tax, #original_price, #gj_discounted_price').on('input change', function () {
    calculateProductCost();
});



    $('body').on('change','.gj_att_price',function() {
        if($(this).val()) {
            var dp = parseFloat($(this).val());
            var mrp = 0;
            var gst = 0;
            if($('#original_price').val()) {
                mrp = parseFloat($('#original_price').val());
            }

            if($('#tax').val()) {
                gst = parseFloat($('#tax').val());
            }

            if(mrp!= 0 && gst != 0) {
                if(mrp > dp) {
                    var tpp = (dp * gst)/(100 + gst);
                    var tp = dp - tpp;
                    tpp = gj_round(tpp, 2);
                    tp = gj_round(tp, 2);
                    var pc = tp + tpp;
                    pc = gj_round(pc, 2);
                    if(mrp <= tp) {
                        $.confirm({
                            title: '',
                            content: 'Include GST Price is ' + tp + ', This Price is more than Original Price!',
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
                        $(this).closest('tr').find('.gj_att_h_cost').val('');
                        $(this).closest('tr').find('.gj_att_cost').val('');
                        $(this).closest('tr').find('.gj_att_h_tax_amount').val('');
                        $(this).closest('tr').find('.gj_att_tax_amount').val('');
                        $(this).val('');
                    } else {
                        $(this).closest('tr').find('.gj_att_h_cost').val(tp);
                        $(this).closest('tr').find('.gj_att_cost').val(tp);
                        $(this).closest('tr').find('.gj_att_h_tax_amount').val(tpp);
                        $(this).closest('tr').find('.gj_att_tax_amount').val(tpp);
                        $(this).closest('tr').find('.gj_att_price').val(pc);
                    }
                } else {
                    $.confirm({
                        title: '',
                        content: 'Please Enter Attribute Cost Less Than Original price!',
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
                    $(this).closest('tr').find('.gj_att_h_cost').val('');
                    $(this).closest('tr').find('.gj_att_cost').val('');
                    $(this).closest('tr').find('.gj_att_h_tax_amount').val('');
                    $(this).closest('tr').find('.gj_att_tax_amount').val('');
                    $(this).val('');
                }
            } else {
                $.confirm({
                    title: '',
                    content: 'Please Enter Original price And Add Tax!',
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

                $(this).closest('tr').find('.gj_att_h_cost').val('');
                $(this).closest('tr').find('.gj_att_cost').val('');
                $(this).closest('tr').find('.gj_att_h_tax_amount').val('');
                $(this).closest('tr').find('.gj_att_tax_amount').val('');
                $(this).val('');
            }
        } else {
            $.confirm({
                title: '',
                content: 'Please Enter Product Cost!',
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

            $(this).closest('tr').find('.gj_att_h_cost').val('');
            $(this).closest('tr').find('.gj_att_cost').val('');
            $(this).closest('tr').find('.gj_att_h_tax_amount').val('');
            $(this).closest('tr').find('.gj_att_tax_amount').val('');
            $(this).val('');
        }
    });

    $('#main_cat_name').on('change',function() {
        var main_cat = $(this).val();
        if(main_cat) {
            cat_name = $("option:selected", this).text();
            // $('.gj_product_title').val(cat_name);

            $.ajax({
                type: 'post',
                url: '{{url('/select_sub_cat')}}',
                data: {main_cat: main_cat, type: 'sub_cat'},
                success: function(data){
                    if(data){
                        $("#sub_cat_name").html(data);
                        $("#sub_cat_name").removeAttr("disabled");

                        /*$.ajax({
                            type: 'post',
                            url: '{{url('/get_tax')}}',
                            data: {main_cat: main_cat, type: 'get_tax'},
                            success: function(data){
                                if(data != 'error'){
                                    $(".gj_tax").val(data);
                                } else {
                                    $.confirm({
                                        title: '',
                                        content: 'Tax Not Available, Please Add Tax!',
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
                                    $(".gj_tax").val('');
                                }
                            }
                        });*/
                    } else {
                        // $.confirm({
                        //     title: '',
                        //     content: 'No Sub Category Available for this Main Category!',
                        //     icon: 'fa fa-exclamation',
                        //     theme: 'modern',
                        //     closeIcon: true,
                        //     animation: 'scale',
                        //     type: 'blue',
                        //     buttons: {
                        //         Ok: function(){
                        //         }
                        //     }
                        // });
                        // $("#sub_cat_name").html(data);
                    }
                }
            });
        }
    });

    // $('#sub_cat_name').on('change',function() {
    //     var sub_cat = $(this).val();
    //     if(sub_cat) {
    //         sub_cat_name = $("option:selected", this).text();
    //         cat_name = $("option:selected", '#main_cat_name').text();
            
    //         $('.gj_product_title').val(cat_name + ' ' + sub_cat_name);

    //         $.ajax({
    //             type: 'post',
    //             url: '{{url('/select_sub_sub_cat')}}',
    //             data: {sub_cat: sub_cat, type: 'sub_sub_cat'},
    //             success: function(data){
    //                 if(data){
    //                     $("#sub_sub_cat_name").html(data);
    //                     $("#sub_sub_cat_name").removeAttr("disabled");
    //                 } else {
    //                     $.confirm({
    //                         title: '',
    //                         content: 'No Sub Sub Category Available for this Sub Category!',
    //                         icon: 'fa fa-exclamation',
    //                         theme: 'modern',
    //                         closeIcon: true,
    //                         animation: 'scale',
    //                         type: 'blue',
    //                         buttons: {
    //                             Ok: function(){
    //                             }
    //                         }
    //                     });
    //                     $("#sub_sub_cat_name").html(data);
    //                 }
    //             }
    //         });
    //     }
    // });

    $('#sub_sub_cat_name').on('change',function() {
        var sub_sub_cat = $(this).val();
        if(sub_sub_cat) {
            sub_sub_cat_name = $("option:selected", this).text();
            cat_name = $("option:selected", '#main_cat_name').text();
            sub_cat_name = $("option:selected", '#sub_cat_name').text();
            
            $('.gj_product_title').val(cat_name + ' ' + sub_cat_name + ' ' + sub_sub_cat_name);
        }
    });

    // $('.gj_attr_values').on('change',function() {
    //     var att_vals = $(this).val();
    //     if(att_vals) {
    //         att_vals = $("option:selected", this).text();
    //         cat_name = $("option:selected", '#main_cat_name').text();
    //         sub_cat_name = $("option:selected", '#sub_cat_name').text();
    //         sub_sub_cat_name = $("option:selected", '#sub_sub_cat_name').text();
            
    //         $('.gj_product_title').val(cat_name + ' ' + sub_cat_name + ' ' + sub_sub_cat_name + ' ' + att_vals);
    //     }
    // });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        if($("input[name='attributes_flag']:checked").val() == 1) {
            $('.gj_p_att_resp').show();
            $('#onhand_qty').attr('readOnly', true);
        } else {
            $('.gj_p_att_resp').hide();
            $('#onhand_qty').attr('readOnly', false);
        }

        $('body').on('change','input[name="attributes_flag"]',function() {
            if($("input[name='attributes_flag']:checked").val() == 1) {
                $('.gj_p_att_resp').show();
                $('#onhand_qty').attr('readOnly', true);
            } else {
                $('.gj_p_att_resp').hide();
                $('#onhand_qty').attr('readOnly', false);
            }
        });

        $('.gj_att_default').each(function () {
            if (this.checked) {
                $(this).val('1');
                $(this).closest('tr').find('.v_att_default').val('1');
            } else {
                $(this).val('2');
                $(this).closest('tr').find('.v_att_default').val('2');
            }
        });

        $('body').on('change','.gj_att_default',function() {
            if ($(this).prop("checked")){
                $('.gj_att_default').val('2');
                $('.v_att_default').val('2');
                $(this).val('1');
                $(this).closest('tr').find('.v_att_default').val('1');

                if($(this).closest('tr').find(".gj_attr_values").val() && $(this).closest('tr').find(".gj_attr_values").val() != 0) {
                    tss = $(this).closest('tr').find(".gj_attr_values");
                    att_vals = $("option:selected", tss).text();
                    cat_name = $("option:selected", '#main_cat_name').text();
                    sub_cat_name = $("option:selected", '#sub_cat_name').text();
                    sub_sub_cat_name = $("option:selected", '#sub_sub_cat_name').text();
                    
                    // $('.gj_product_title').val(cat_name + ' ' + sub_cat_name + ' ' + sub_sub_cat_name + ' ' + att_vals);
                }                
            } else {
                $(this).val('2');
                $('.v_att_default').val('2');
            }
        });

        $('body').on('change','.gj_att_name',function() {
            var att_n = 0;
            if ($(this).val()) {
                att_n = $(this).val();
            }
            var ths = $(this);

            $.ajax({
                type: 'post',
                url: '{{url('/select_att_vals')}}',
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
        // <td><input type="text" class="form-control gj_att_price" placeholder="Enter Price" name="att_price[]" id="price_' + counter + '"></td><td><input type="text" class="form-control gj_att_h_tax_amount" placeholder="Enter Tax Amount" name="att_h_tax_amount[]" id="h_tax_amount_' + counter + '" disabled><input type="hidden" class="form-control gj_att_tax_amount" placeholder="Enter Tax Amount" name="att_tax_amount[]" id="tax_amount_' + counter + '"></td><td><input type="text" class="form-control gj_att_h_cost" placeholder="Enter Cost" name="att_h_cost[]" id="att_h_cost_' + counter + '" disabled><input type="hidden" class="form-control gj_att_cost" placeholder="Enter Cost" name="att_cost[]" id="cost_' + counter + '"></td><td><input type="text" class="form-control gj_att_qty" placeholder="Enter Quantity" name="att_qty[]" id="att_qty_' + counter + '"></td><td><textarea class="form-control gj_att_description" placeholder="Enter description" name="att_description[]" id="description_' + counter + '" rows="1"></textarea></td>
// <td><select id="attribute_name_' + counter + '" name="attribute_name[]" class="form-control gj_att_name"><option value="0" selected>Select Attribute</option><?php echo $atts_flds; ?></select></td><td><select id="attvalue_' + counter + '" name="att_value[]" class="form-control gj_attr_values"><option value="0" selected>Select Attributes Value</option></select></td>
        // var counter = 2;
        // $("#addButton").click(function () {
        //     var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_att_' + counter);
        //     newTextBoxDiv.after().html('<td><input type="radio" name="att_default[]" class="gj_att_default" value="2"><input type="hidden" class="v_att_default" name="v_att_default[]" value="2"></td><td><input type="text" class="form-control " placeholder="Enter Color Code" name="att_colors[]" id="colors_' + counter + '"></td><td><input type="text" class="form-control " placeholder="Enter Color Name" name="att_colors_name[]" id="colors_name_' + counter + '"></td><td><input type="file" name="att_image[]" id="att_image_' + counter + '" accept="image/*" class="gj_att_image form-control"></td><td><button type="button" id="removeButton_' + counter + '" class="gj_att_rem"><i class="fa fa-trash"></i></button></td>');
        //     // newTextBoxDiv.appendTo("#TextBoxesGroup");
        //     newTextBoxDiv.appendTo("#gj_att_bdy");
        //     counter++;
        // });

        // $('body').on('click','.gj_att_rem',function() {
        //     if(counter==1){
        //         $.confirm({
        //             title: '',
        //             content: 'No more textbox to remove!',
        //             icon: 'fa fa-ban',
        //             theme: 'modern',
        //             closeIcon: true,
        //             animation: 'scale',
        //             type: 'red',
        //             buttons: {
        //                 Ok: function(){
        //                 }
        //             }
        //         });
        //         return false;
        //     }   
        
        //     counter--;
        //     $(this).closest('tr').remove();
        // });
        
        let colorCounter = 1;

            $('#addColorRow').on('click', function () {
            
                colorCounter++;
            
                let row = `
                    <tr>
                        <td>
                            <input type="radio" name="att_default[]" class="gj_att_default" value="2"><input type="hidden" class="v_att_default" name="v_att_default[]" value="2">
                        </td>
            
                        <td>
                            <input type="text" name="att_colors[]" class="form-control" placeholder="Enter Color Code">
                            <small><a href="https://htmlcolorcodes.com/" target="_blank">htmlcolorcodes.com</a></small>
                        </td>
            
                        <td>
                            <input type="text" name="att_colors_name[]" class="form-control" placeholder="Enter Color Name">
                        </td>
            
                        <td>
                            <input type="file" name="att_image[]" class="form-control" accept="image/*">
                        </td>
            
                        <td>
                            <button type="button" class="btn btn-danger remove-color-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            
                $('#color_att_body').append(row);
            });
            
            $('body').on('click', '.remove-color-row', function () {
            
                if ($('#color_att_body tr').length === 1) {
                    $.alert('At least one color attribute is required');
                    return;
                }
            
                $(this).closest('tr').remove();
            });

        let generalCounter = 1;
        
        $('#addGeneralRow').on('click', function () {
        
            generalCounter++;
        
            let row = `
                <tr>
        
                    <td>
                        <select name="att_name[]" class="form-control gj_att_name">
                            <option value="">Select Attribute</option>
                            ${$('#general_att_body tr:first .gj_att_name').html()}
                        </select>
                    </td>
        
                    <td>
                        <select name="att_value[]" class="form-control gj_attr_values">
                            <option value="">Select Value</option>
                        </select>
                    </td>
        
                    <td>
                        <button type="button" class="btn btn-danger remove-att-row">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        
            $('#general_att_body').append(row);
        });
        
        $('body').on('click', '.remove-att-row', function () {
        
            if ($('#general_att_body tr').length === 1) {
                $.alert('At least one attribute is required');
                return;
            }
        
            $(this).closest('tr').remove();
        });

        // var cnt = 2;
        // $("#img_addButton").click(function () {
        //     var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_pimg_' + cnt);
        //     newTextBoxDiv.after().html('<td><input class="form-control gj_p_name" placeholder="Enter Product Name" name="p_name[]" type="text" id="p_name_' + cnt + '"></td><td><input type="file" name="p_image[]" id="p_image_' + cnt + '" accept="image/*" class="gj_p_image form-control"></td><td><button type="button" id="img_removeButton_' + cnt + '" class="gj_pimg_rem"><i class="fa fa-trash"></i></button></td>');
        //     // newTextBoxDiv.appendTo("#TextBoxesGroup");
        //     newTextBoxDiv.appendTo("#gj_pimg_bdy");
        //     cnt++;
        // });

        // $('body').on('click','.gj_pimg_rem',function() {
        //     if(cnt==1){
        //         $.confirm({
        //             title: '',
        //             content: 'No more textbox to remove!',
        //             icon: 'fa fa-ban',
        //             theme: 'modern',
        //             closeIcon: true,
        //             animation: 'scale',
        //             type: 'red',
        //             buttons: {
        //                 Ok: function(){
        //                 }
        //             }
        //         });
        //         return false;
        //     }   
        
        //     cnt--;
        //     $(this).closest('tr').remove();
        // });
        
        // $("#getButtonValue").click(function () {
        //     var msg = '';
        //     for(i=1; i<counter; i++){
        //         msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
        //     }
        //     alert(msg);
        // });
    });
</script>

<!-- Editor Script Start -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'product_desc' );
        CKEDITOR.replace( 'features' );
        CKEDITOR.replace( 'shiping_policy' );
    </script>
<!-- Editor Script End -->

<!-- ProTitle Script Start -->
    <script type="text/javascript">
        $(".gj_ptit_edit").click(function () {
            // $('.gj_product_title').removeAttr('readonly');
        });

        $(".gj_product_title").focusout(function () {
            $(this).attr('readonly', false);
        });
    </script>
<!-- ProTitle Script End -->
@endsection