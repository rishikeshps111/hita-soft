@extends('layouts.master')
@section('title', 'Manage Products')
@section('content')

<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.product_sidebar')
        </div>

        <div class="col-lg-10 pt-30">
            <div class="">
                  <div class=" main-right-container container-field row mx_0 px_5 mb-field" style="padding:15px !important;">
                        <h3>Bulk Upload Products (CSV)</h3>
                <a href="{{ route('products.download-template') }}">Download CSV Template</a>

                <form action="{{ route('product.bulk_upload.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="csv_file">Upload CSV file:</label>
                        <input type="file" name="csv_file" class="form-control" required accept=".csv">
                    </div>
            
                    <button type="submit" class="btn btn-success mt-2">Upload</button>
                </form>
            
                <hr>
            
                <p>📝 <strong>Note:</strong> Your CSV should have the following headers:</p>
                <pre>product_title,product_desc,main_cat_name,sub_cat_name,rang_price,selling_price,tax,final_selling_price,tax_amount,discount_selling_price,tax,onhand_qty,features,attributes_flag,featured_product,new_arrival,delivery,instructions,disclaimer,note
</pre>
                  </div>
              
            </div>
        </div>
    </div>
</section>
@endsection