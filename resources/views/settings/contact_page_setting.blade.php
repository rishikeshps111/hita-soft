@extends('layouts.master')
@section('title', 'Contact Us Page Settings')
@section('content')
@php
    $contactData = $contact ? $contact->toArray() : [];
    $data = array_merge($defaults, array_filter($contactData, function ($value) {
        return $value !== null && $value !== '';
    }));
@endphp

<style>
    .contact-admin-card {
        margin-bottom: 18px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e6ebf1;
        border-radius: 8px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
    }

    .contact-admin-card h4 {
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f7;
        font-size: 17px;
        font-weight: 700;
    }

    .contact-image-preview {
        width: 100%;
        max-width: 260px;
        height: 130px;
        margin-bottom: 10px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .contact-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<section class="gj_contact_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10">
            <div class="gj_box dark main-right-container container-field">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @if($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif

                <form action="{{ route('store_contact_page_setting') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="contact-admin-card">
                        <h3 class="gj_heading">Contact Us Page Settings</h3>
                        <div class="row">
                            <div class="form-group col-lg-6 mb-3">
                                <label>Banner Title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title', $data['banner_title'] ?? '') }}">
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                <label>Banner Image</label>
                                @if(!empty($data['banner_image']))
                                    <div class="contact-image-preview"><img src="{{ asset($data['banner_image']) }}"></div>
                                @endif
                                <input type="hidden" name="old_banner_image" value="{{ $data['banner_image'] ?? '' }}">
                                <input type="file" name="banner_image" accept="image/*" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="contact-admin-card">
                        <h4>Contact Details</h4>
                        <div class="row">
                            <div class="form-group col-lg-12 mb-3">
                                <label>Form Intro Text</label>
                                <textarea name="form_intro" rows="3" class="form-control">{{ old('form_intro', $data['form_intro'] ?? '') }}</textarea>
                            </div>
                            <div class="form-group col-lg-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" rows="4" class="form-control">{{ old('address', $data['address'] ?? '') }}</textarea>
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ old('email', $data['email'] ?? '') }}">
                            </div>
                            <div class="form-group col-lg-6 mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $data['phone'] ?? '') }}">
                            </div>
                            <div class="form-group col-lg-12 mb-3">
                                <label>Google Map Embed URL</label>
                                <textarea name="map_iframe" rows="4" class="form-control">{{ old('map_iframe', $data['map_iframe'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="update-btn-box">
                        <a href="{{ route('contact_us') }}" target="_blank" class="btn btn-default">Preview</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('p.alert').delay(7000).slideUp(700);
    });
</script>
@endsection
