@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')
    @php
        $product_path = 'images/featured_products';
        $product_img_path = 'images/products';
        $gallery = $product ? $product->PImages()->where('is_block', 1)->get() : collect();
    @endphp

    <style>
        .product-form-shell {
            background: #f7f8fb;
            border-radius: 8px;
            padding: 18px;
        }

        .product-form-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .product-form-head h3 {
            margin: 0 0 4px;
            font-weight: 700;
        }

        .product-form-head p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .product-form-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px;
            margin-bottom: 16px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
        }

        .product-form-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 1px solid #eef0f4;
        }

        .product-form-card-title i {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #eef6ff;
            color: #2563eb;
        }

        .product-form-card-title h4 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
        }

        .product-form-card-title p {
            margin: 2px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .product-form-card label {
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        .product-form-card .form-control {
            border-radius: 6px;
            min-height: 42px;
            border-color: #d9dee8;
        }

        .product-form-card textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .field-help {
            display: block;
            margin-top: 5px;
            color: #6b7280;
            font-size: 12px;
        }

        .required-mark {
            color: #dc2626;
        }

        .feature-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fafafa;
            cursor: pointer;
        }

        .feature-checkbox input {
            margin: 0;
        }

        .image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            margin-top: 10px;
            background: #fff;
        }

        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .gallery-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            background: #fff;
        }

        .product-form-actions {
            position: sticky;
            bottom: 0;
            z-index: 4;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 0 0;
            background: #f7f8fb;
        }

        .product-form-actions .btn {
            min-width: 130px;
            border-radius: 6px;
            padding: 10px 16px;
        }

        @media screen and (max-width: 767px) {
            .product-form-shell {
                padding: 12px;
            }

            .product-form-card {
                padding: 14px;
            }

            .product-form-actions {
                position: static;
                flex-direction: column;
            }

            .product-form-actions .btn {
                width: 100%;
            }
        }
    </style>

    <section class="gj_email_setting">
        <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
        <div class="row gj_row">
            <div class="col-lg-2 adminLeftSide" id="adminSideNav">
                <button type="button" class="Mob-side-close" onclick="openadminSide()"><i
                        class="fa-solid fa-xmark"></i></button>
                @include('layouts.product_sidebar')
            </div>

            <div class="col-lg-10">
                <div class="gj_box dark">
                    @if($errors->any())
                        <div class="alert alert-danger" id="error-alert">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('update_product') }}" method="POST" class="gj_product_form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="attributes_flag" value="0">
                        <input type="hidden" name="new_arrival" value="{{ $product->new_arrival ?? 0 }}">
                        <input type="hidden" name="old_featured_product_img" value="{{ $product->featured_product_img }}">

                        @foreach($gallery as $image)
                            <input type="hidden" name="old_p_image[]" value="{{ $image->image }}">
                        @endforeach

                        <div class="main-right-container container-field row mx_0 px_5 mb-field">
                            <div class="col-lg-12">
                                <div class="product-form-shell">
                                    <div class="product-form-head">
                                        <div>
                                            <h3 class="gj_heading">Edit Product</h3>
                                            <p>Update the product card, detail page, gallery, and stock information from one
                                                place.</p>
                                        </div>
                                        <a href="{{ route('manage_product') }}" class="btn btn-outline-secondary">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>

                                    <div class="product-form-card">
                                        <div class="product-form-card-title">
                                            <i class="fa fa-info-circle"></i>
                                            <div>
                                                <h4>Basic Details</h4>
                                                <p>This content appears on product cards and the detail page.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label>Product Title <span class="required-mark">*</span></label>
                                                <input type="text" name="product_title" class="form-control"
                                                    value="{{ old('product_title', $product->product_title) }}">
                                                @if($errors->has('product_title'))<span
                                                class="error">{{ $errors->first('product_title') }}</span>@endif
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Stock Quantity <span class="required-mark">*</span></label>
                                                <input type="number" name="onhand_qty" class="form-control"
                                                    value="{{ old('onhand_qty', $product->onhand_qty) }}" min="0">
                                                @if($errors->has('onhand_qty'))<span
                                                class="error">{{ $errors->first('onhand_qty') }}</span>@endif
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Price <span class="required-mark">*</span></label>
                                                <input type="number" step="0.01" name="original_price" class="form-control"
                                                    value="{{ old('original_price', $product->original_price) }}">
                                                <span class="field-help">This price is used for product cards, details, and
                                                    cart.</span>
                                                @if($errors->has('original_price'))<span
                                                class="error">{{ $errors->first('original_price') }}</span>@endif
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>Short Description</label>
                                                <input type="text" name="short_description" class="form-control"
                                                    value="{{ old('short_description', $product->short_description) }}">
                                                <span class="field-help">Keep this short. It appears below the product
                                                    title.</span>
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>Full Description <span class="required-mark">*</span></label>
                                                <textarea name="product_desc" class="form-control"
                                                    rows="5">{{ old('product_desc', $product->product_desc) }}</textarea>
                                                @if($errors->has('product_desc'))<span
                                                class="error">{{ $errors->first('product_desc') }}</span>@endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-form-card">
                                        <div class="product-form-card-title">
                                            <i class="fa fa-list"></i>
                                            <div>
                                                <h4>Product Specifications</h4>
                                                <p>These fields build the feature list shown in the frontend template.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>Capacity</label>
                                                <input type="text" name="product_capacity" class="form-control"
                                                    value="{{ old('product_capacity', $product->product_capacity) }}">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Type</label>
                                                <input type="text" name="product_type" class="form-control"
                                                    value="{{ old('product_type', $product->product_type) }}">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Power</label>
                                                <input type="text" name="product_power" class="form-control"
                                                    value="{{ old('product_power', $product->product_power) }}">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Size</label>
                                                <input type="text" name="product_size" class="form-control"
                                                    value="{{ old('product_size', $product->product_size) }}">
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label>Feature Text</label>
                                                <input type="text" name="product_feature_text" class="form-control"
                                                    value="{{ old('product_feature_text', $product->product_feature_text) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-form-card">
                                        <div class="product-form-card-title">
                                            <i class="fa fa-image"></i>
                                            <div>
                                                <h4>Images & Visibility</h4>
                                                <p>Replace the main image, add gallery images, and choose where this product
                                                    appears.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>Main Product Image</label>
                                                <input type="file" name="featured_product_img" class="form-control"
                                                    accept="image/*">
                                                <span class="field-help">Upload a new file only if you want to replace the
                                                    current main image.</span>
                                                @if($product->featured_product_img)
                                                    <img src="{{ asset($product_path . '/' . $product->featured_product_img) }}"
                                                        alt="{{ $product->product_title }}" class="image-preview">
                                                @endif
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label>Add Gallery Images</label>
                                                <input type="file" name="p_image[]" class="form-control" accept="image/*"
                                                    multiple>
                                                <span class="field-help">New files are added to the current gallery.</span>
                                                @if($gallery->count())
                                                    <div class="gallery-preview">
                                                        @foreach($gallery as $image)
                                                            <img src="{{ asset($product_img_path . '/' . $image->image) }}"
                                                                alt="{{ $product->product_title }}">
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group col-lg-12">
                                                <label class="feature-checkbox">
                                                    <input type="checkbox" name="featuredproduct_flag" value="1" {{ old('featuredproduct_flag', $product->featuredproduct_flag) ? 'checked' : '' }}>
                                                    <span>Show this product in Featured Products on the home page</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-form-actions">
                                        <a href="{{ route('manage_product') }}" class="btn btn-default">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection