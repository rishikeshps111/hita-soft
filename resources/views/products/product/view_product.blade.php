@extends('layouts.master')
@section('title', 'View Products')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<style>
    .td-file-img {
    /*width: 400px;*/
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

.td-file-img:hover {
    transform: scale(2.5); /* Adjust zoom level */
    z-index: 1000;
    position: relative;
}

</style>
<section class="gj_vw_products">
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
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                 <div class="col-lg-12">
                       <div class="d-flex justify-content-between align-items-center mb-3 back-container">
                       <h3 class="gj_heading mb-0">View Products</h3>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                        
                    </div>
                 </div>
                    <div class="col-lg-12">
                        <div class="adm-product-view">
                             <div class="gj_box dark gj_inside_box">
                      
                        
                        <div >
                            @if($product)
                                <div class="table-responsive gj_vw_p_res">
                                    <table class="table table-striped">
                                        <tr>
                                            <th class="w-50">Product Code</th>
                                            <td class="w-50">{{$product->product_code}}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Title</th>
                                            <td>{{$product->product_title}}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Description</th>
                                            <td><?php echo $product->product_desc; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Product Notes</th>
                                            <td><?php echo $product->product_notes; ?></td>
                                        </tr>
                                        {{--<tr>
                                            <th>Brand</th>
                                            <td>
                                                @if($product->brand)
                                                    {{$product->ProductBrand->brand_name}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Model Number</th>
                                            <td>
                                                @if($product->model_no)
                                                    {{$product->model_no}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Varient</th>
                                            <td>
                                                @if($product->varient)
                                                    {{$product->varient}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>Main Category</th>
                                            <td>{{ optional($product->MainCat)->main_cat_name ?? 'N/A' }}</td>
                                        </tr>
                                       {{-- <tr>
                                            <th>Sub Category</th>
                                            <td>{{ optional($product->SubCat)->sub_cat_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sub Sub Category</th>
                                            <td>{{ optional($product->SubSubCat)->sub_sub_cat_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Manufacturer</th>
                                            <td>{{ $product->manufacturer ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Product Tags</th>
                                            <td>
                                                <?php 
                                                    $tags = json_decode($product->tags);
                                                    if($tags && count($tags) != 0) {
                                                        foreach ($tags as $key => $value) {
                                                            $tag = \DB::table('tags')->where('id',$value)->where('is_block',1)->first();
                                                            if(($tag)){
                                                                echo $tag->tag_title.', ';
                                                            }
                                                        }
                                                    } else {
                                                        echo "------";
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                         <tr>
                                            <th>Rang Price</th>
                                            <td>Rs. {{$product->rang_price}}</td>
                                        </tr>--}}
                                        <tr>
                                            <th>Price</th>
                                            <td>Rs. {{$product->original_price}}</td>
                                        </tr>
                                        
                                       {{--  <tr>
                                            <th>Tax %</th>
                                            <td>{{$product->tax}}%</td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th>Tax Amount</th>
                                            <td>Rs. {{$product->tax_amount}}</td>
                                        </tr>

                                        <tr>
                                            <th>Final Selling Cost</th>
                                            <td>Rs. {{$product->product_cost}}</td>
                                        </tr>


                                        
                                       <tr>
                                            <th>Service Charge</th>
                                            <td>
                                                @if ($product->service_charge)
                                                  Rs. {{$product->service_charge}}
                                                @else
                                                  Rs. 0.00
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Shipping Type</th>
                                            <td>
                                                @if ($product->tax_type == 1)
                                                  {{'Inclusive'}}
                                                @elseif ($product->tax_type == 2)
                                                  {{'Exclusive'}}
                                                @else
                                                  {{'-------'}}
                                                @endif
                                            </td>
                                        </tr>--}}

                                       {{-- <tr>
                                            <th>Domestic Shipping </th>
                                            <td>
                                                @if ($product->shiping_charge)
                                                  Rs. {{$product->shiping_charge}}
                                                @else
                                                  Rs. 0.00
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>International Shipping </th>
                                            <td>
                                                @if ($product->inter_shiping_charge)
                                                  Rs. {{$product->inter_shiping_charge}}
                                                @else
                                                  Rs. 0.00
                                                @endif
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>On Hand Quantity</th>
                                            <td>{{$product->onhand_qty}}</td>
                                        </tr>
                                       {{-- <tr>
                                            <th>Measurement Units</th>
                                            <td>{{ optional($product->Measurement)->unit_name ?? 'N/A' }}</td>
                                        </tr>--}}
                                       {{-- <tr>
                                            <th>Features</th>
                                            <td><?php echo $product->features; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Shipping & Return Policy</th>
                                            <td>
                                                @if($product->shiping_policy)
                                                    <?php echo $product->shiping_policy; ?>
                                                @else
                                                    --------
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Offers</th>
                                            <td>
                                                @if($product->offers_flag == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>Featured Product</th>
                                            <td>
                                                @if($product->featuredproduct_flag == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Top Rated</th>
                                            <td>
                                                @if($product->toprated_flag == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                        </tr>
                                       {{-- <tr>
                                            <th>Created User</th>
                                            <td>
                                                @if($product->created_user)
                                                    {{$product->Creatier->first_name}} {{$product->Creatier->last_name}}
                                                @else
                                                    --------
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Modified User</th>
                                            <td>
                                                @if($product->modified_user)
                                                    {{$product->Modifier->first_name}} {{$product->Modifier->last_name}}
                                                @else
                                                    --------
                                                @endif
                                            </td>
                                        </tr>--}}
                                        {{--<tr>
                                            <th>Delivery</th>
                                            <td>
                                                @if($product->delivery)
                                                    {{$product->delivery}} Days
                                                @else
                                                    --------
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Store</th>
                                            <td>
                                                @if($product->store)
                                                    {{$product->Store->store_name}}
                                                @else
                                                    --------
                                                @endif
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($product->is_block == 1)
                                                    Active
                                                @else
                                                    Deactive
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>
                                                <?php echo date("d-m-Y", strtotime($product->created_at)); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Featured Product image</th>
                                            <?php 
                                            $file_path = 'images/featured_products';
                                            ?>
                                            <td>
                                                @if($product->featured_product_img)
                                                    <div class="gj_vw_p_img">
                                                        <a href="{{ asset($file_path.'/'.$product->featured_product_img) }}" data-lightbox="featured" data-title="Featured Product">
                                                            <img src="{{ asset($file_path.'/'.$product->featured_product_img) }}" class="img-responsive td-file-img" style="max-width: 150px;">
                                                        </a>
                                                      </div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Attributes</th>
                                            <td>
                                                @if($product->attributes_flag == 1)
                                                    Active
                                                @else
                                                    Deactive
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                         <h3 class="gj_heading"> Products Attributes  </h3>
                         <div class="adm-product-view">
                              @if($product)
                        <div class="gj_box dark gj_inside_box">
                           
                            
                            <div >
                                @if($product->attributes_flag == 1)
                                    @if($product->Attributes && count($product->Attributes) != 0)
                                        <div class="table-responsive gj_vw_att_res">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Color</th>
                                                    <th>Attributes Image</th>
                                                </tr>
                                                @foreach($product->Attributes as $key => $value)
                                                    <tr>
                                                        <td>
                                                            @if($value->colors)
                                                                {{$value->colors}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                        {{--<td>
                                                            @if($value->attribute_values)
                                                                {{$value->AttributeValue->att_value}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->att_cost)
                                                                Rs. {{$value->att_cost}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($value->att_tax_amount)
                                                                Rs. {{$value->att_tax_amount}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->att_price)
                                                                Rs. {{$value->att_price}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->att_qty)
                                                                {{$value->att_qty}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->description != '')
                                                                {{$value->description}}
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>--}}
                                                        <td>
                                                            <?php 
                                                            $file_path = 'images/attributes';
                                                            ?>
                                                            @if($value->image != '')
                                                                <div class="gj_vw_p_img ">
                                                                    <a href="{{ asset($file_path.'/'.$value->image) }}" data-lightbox="attribute" data-title="Attribute Image">
                                                                        <img src="{{ asset($file_path.'/'.$value->image) }}" class="img-responsive" style="max-width: 150px;">
                                                                    </a>
                                                                   </div>
                                                            @else
                                                                -----
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @else
                                        <div class="gj_vw_not_att">
                                            <p>No Data Available</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="gj_vw_not_att">
                                        <p>Attributes Set Deactive</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="adm-product-view">
                        
                        <div class="gj_box dark gj_inside_box">
                         
                                <h3 class="gj_heading"> Products Images  </h3>
                            
                            
                            <div >
                                @if($product->PImages && count($product->PImages) != 0)
                                    <div class="table-responsive gj_vw_att_res bottom-adm-img">
                                        <table class="table table-bordered">
                                            <tr>
                                                <!--<th>Product Image Name</th>-->
                                                <th>Product Image</th>
                                            </tr>
                                            @foreach($product->PImages as $key => $value)
                                                <tr>
                                                    {{--<td>
                                                        @if($value->p_name != '')
                                                            {{$value->p_name}}
                                                        @else
                                                            -----
                                                        @endif
                                                    </td>--}}
                                                    <td>
                                                        <?php 
                                                        $file_path = 'images/products';
                                                        ?>
                                                        @if($value->image != '')
                                                            <div class="gj_vw_p_img ">
                                                                <a href="{{ asset($file_path.'/'.$value->image) }}" data-lightbox="product" data-title="Product Image">
                                                                    <img src="{{ asset($file_path.'/'.$value->image) }}" class="img-responsive" style="max-width: 150px;">
                                                                </a>
                                                            </div>
                                                        @else
                                                            -----
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                @else
                                    <div class="gj_vw_not_att">
                                        <p>No Data Available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                         </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>
</section>




<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
    $(document).ready(function() {
        $('#featured_img, .zoomable-img').elevateZoom({
            zoomType: "lens",
            lensShape: "round",
            lensSize: 150
        });
    });
</script>


@endsection
