@extends('layouts.master')
@section('title', 'About Us Page Settings')
@section('content')
@php
    $aboutData = $about_page ? $about_page->toArray() : [];
    $data = array_merge($defaults, array_filter($aboutData, function ($value) {
        return $value !== null && $value !== '';
    }));
    $whoContent = old('who_content', implode("\n", $data['who_content'] ?? []));
    $whatItems = old('what_items', implode("\n", $data['what_items'] ?? []));
    $coreValues = old('core_value_title') ? [] : ($data['core_values'] ?? []);
    $coreCount = max(5, count($coreValues));
@endphp

<style>
    .about-admin-wrap {
        padding: 0 18px 24px;
    }

    .about-admin-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
        padding: 18px 20px;
        background: #f8fafc;
        border: 1px solid #e6ebf1;
        border-radius: 8px;
    }

    .about-admin-head h3 {
        margin: 0 0 4px;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    .about-admin-head p,
    .field-help {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.45;
    }

    .about-admin-card {
        margin-bottom: 18px;
        padding: 20px;
        background: #fff;
        border: 1px solid #e6ebf1;
        border-radius: 8px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
    }

    .about-admin-card h4 {
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f7;
        font-size: 17px;
        font-weight: 700;
        color: #111827;
    }

    .about-admin-card label {
        font-weight: 600;
        color: #334155;
    }

    .about-image-preview {
        width: 100%;
        max-width: 240px;
        height: 120px;
        margin-bottom: 10px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .about-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .core-value-row {
        position: relative;
        margin-bottom: 12px;
        padding: 14px 48px 14px 14px;
        background: #f8fafc;
        border: 1px solid #e6ebf1;
        border-radius: 8px;
    }

    .core-value-remove {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 30px;
        height: 30px;
        border: 0;
        border-radius: 6px;
        background: #fee2e2;
        color: #b91c1c;
    }

    .about-actions {
        position: sticky;
        bottom: 0;
        z-index: 2;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 20px;
        background: rgba(255, 255, 255, 0.96);
        border-top: 1px solid #e6ebf1;
    }

    .about-actions .btn {
        min-width: 140px;
    }
</style>

<section class="gj_abou_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10">
            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                @if($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif

                <form action="{{ route('store_about_page') }}" method="POST" class="gj_about_cms_form" enctype="multipart/form-data">
                    @csrf
                    <div class="about-admin-wrap">
                        <div class="about-admin-head">
                            <div>
                                <h3>About Us Page Settings</h3>
                                <p>Update the public About Us page sections from one place.</p>
                            </div>
                            <a href="{{ route('about_us') }}" target="_blank" class="btn btn-default">
                                <i class="fa fa-eye"></i> Preview
                            </a>
                        </div>

                        <div class="about-admin-card">
                            <h4>Page Banner</h4>
                            <div class="row">
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Banner Title</label>
                                    <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title', $data['banner_title'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Banner Image</label>
                                    @if(!empty($data['banner_image']))
                                        <div class="about-image-preview"><img src="{{ asset($data['banner_image']) }}"></div>
                                    @endif
                                    <input type="hidden" name="old_banner_image" value="{{ $data['banner_image'] ?? '' }}">
                                    <input type="file" name="banner_image" accept="image/*" class="form-control">
                                    <p class="field-help">Used behind the page title.</p>
                                </div>
                            </div>
                        </div>

                        <div class="about-admin-card">
                            <h4>Who We Are</h4>
                            <div class="row">
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Section Title</label>
                                    <input type="text" name="who_title" class="form-control" value="{{ old('who_title', $data['who_title'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Section Image</label>
                                    @if(!empty($data['who_image']))
                                        <div class="about-image-preview"><img src="{{ asset($data['who_image']) }}"></div>
                                    @endif
                                    <input type="hidden" name="old_who_image" value="{{ $data['who_image'] ?? '' }}">
                                    <input type="file" name="who_image" accept="image/*" class="form-control">
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Paragraphs</label>
                                    <textarea name="who_content" class="form-control" rows="7">{{ $whoContent }}</textarea>
                                    <p class="field-help">Use one paragraph per line.</p>
                                </div>
                            </div>
                        </div>

                        <div class="about-admin-card">
                            <h4>What We Do</h4>
                            <div class="row">
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Section Title</label>
                                    <input type="text" name="what_title" class="form-control" value="{{ old('what_title', $data['what_title'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Section Image</label>
                                    @if(!empty($data['what_image']))
                                        <div class="about-image-preview"><img src="{{ asset($data['what_image']) }}"></div>
                                    @endif
                                    <input type="hidden" name="old_what_image" value="{{ $data['what_image'] ?? '' }}">
                                    <input type="file" name="what_image" accept="image/*" class="form-control">
                                </div>
                                <div class="form-group col-lg-4 mb-3">
                                    <label>Intro Text</label>
                                    <textarea name="what_content" class="form-control" rows="5">{{ old('what_content', $data['what_content'] ?? '') }}</textarea>
                                </div>
                                <div class="form-group col-lg-12 mb-3">
                                    <label>Feature Points</label>
                                    <textarea name="what_items" class="form-control" rows="5">{{ $whatItems }}</textarea>
                                    <p class="field-help">Use one point per line.</p>
                                </div>
                            </div>
                        </div>

                        <div class="about-admin-card">
                            <h4>Mission & Vision</h4>
                            <div class="row">
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Mission Title</label>
                                    <input type="text" name="mission_title" class="form-control" value="{{ old('mission_title', $data['mission_title'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Mission Content</label>
                                    <textarea name="mission_content" class="form-control" rows="3">{{ old('mission_content', $data['mission_content'] ?? '') }}</textarea>
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Vision Title</label>
                                    <input type="text" name="vision_title" class="form-control" value="{{ old('vision_title', $data['vision_title'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Vision Content</label>
                                    <textarea name="vision_content" class="form-control" rows="3">{{ old('vision_content', $data['vision_content'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="about-admin-card">
                            <h4>Core Values</h4>
                            <div class="form-group">
                                <label>Section Title</label>
                                <input type="text" name="core_values_title" class="form-control" value="{{ old('core_values_title', $data['core_values_title'] ?? '') }}">
                            </div>

                            <div id="coreValuesList">
                                @for($i = 0; $i < $coreCount; $i++)
                                    @php $core = $coreValues[$i] ?? []; @endphp
                                    <div class="core-value-row">
                                        <button type="button" class="core-value-remove" title="Remove"><i class="fa fa-trash"></i></button>
                                        <div class="row">
                                            <div class="form-group col-lg-4 mb-2">
                                                <label>Value Title</label>
                                                <input type="text" name="core_value_title[]" class="form-control" value="{{ old('core_value_title.'.$i, $core['title'] ?? '') }}">
                                            </div>
                                            <div class="form-group col-lg-8 mb-2">
                                                <label>Description</label>
                                                <textarea name="core_value_description[]" class="form-control" rows="2">{{ old('core_value_description.'.$i, $core['description'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <button type="button" id="addCoreValue" class="add_btn_cs">
                                <i class="fa fa-plus"></i> Add Core Value
                            </button>
                        </div>

                        <div class="about-admin-card">
                            <h4>Leadership</h4>
                            <div class="row">
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Background Image</label>
                                    @if(!empty($data['leadership_bg_image']))
                                        <div class="about-image-preview"><img src="{{ asset($data['leadership_bg_image']) }}"></div>
                                    @endif
                                    <input type="hidden" name="old_leadership_bg_image" value="{{ $data['leadership_bg_image'] ?? '' }}">
                                    <input type="file" name="leadership_bg_image" accept="image/*" class="form-control">
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Label</label>
                                    <input type="text" name="leadership_label" class="form-control" value="{{ old('leadership_label', $data['leadership_label'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Leader Name</label>
                                    <input type="text" name="leadership_name" class="form-control" value="{{ old('leadership_name', $data['leadership_name'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Designation</label>
                                    <input type="text" name="leadership_designation" class="form-control" value="{{ old('leadership_designation', $data['leadership_designation'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-6 mb-3">
                                    <label>Content</label>
                                    <textarea name="leadership_content" class="form-control" rows="3">{{ old('leadership_content', $data['leadership_content'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="about-admin-card">
                            <h4>Our Presence</h4>
                            <div class="row">
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Label</label>
                                    <input type="text" name="presence_label" class="form-control" value="{{ old('presence_label', $data['presence_label'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Name</label>
                                    <input type="text" name="presence_name" class="form-control" value="{{ old('presence_name', $data['presence_name'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Phone</label>
                                    <input type="text" name="presence_phone" class="form-control" value="{{ old('presence_phone', $data['presence_phone'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-3 mb-3">
                                    <label>Email</label>
                                    <input type="text" name="presence_email" class="form-control" value="{{ old('presence_email', $data['presence_email'] ?? '') }}">
                                </div>
                                <div class="form-group col-lg-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="presence_address" class="form-control" rows="4">{{ old('presence_address', $data['presence_address'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-actions">
                        <a href="{{ route('about_us') }}" target="_blank" class="btn btn-default">Preview</a>
                        <button type="submit" class="btn btn-primary">Update Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('p.alert').delay(7000).slideUp(700);

        $('#addCoreValue').on('click', function() {
            $('#coreValuesList').append(`
                <div class="core-value-row">
                    <button type="button" class="core-value-remove" title="Remove"><i class="fa fa-trash"></i></button>
                    <div class="row">
                        <div class="form-group col-lg-4 mb-2">
                            <label>Value Title</label>
                            <input type="text" name="core_value_title[]" class="form-control">
                        </div>
                        <div class="form-group col-lg-8 mb-2">
                            <label>Description</label>
                            <textarea name="core_value_description[]" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `);
        });

        $('body').on('click', '.core-value-remove', function() {
            if ($('.core-value-row').length <= 1) {
                alert('At least one core value is required.');
                return;
            }

            $(this).closest('.core-value-row').remove();
        });
    });
</script>
@endsection
