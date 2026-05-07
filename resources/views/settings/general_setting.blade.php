@extends('layouts.master')
@section('title', 'General Settings')
@section('content')
<section class="gj_general_setting">
      <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">
           

            <div class="gj_box dark  main-right-container container-field">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                   <h3 class="gj_heading"> General Settings  </h3>

               <form action="{{ route('store_general_setting') }}" method="POST" class="gj_geneal_form row mt-5">
                     @csrf
                        <div class="form-group col-lg-4 mb-3">
                            <label for="site_name">Site Name</label>
                            <span class="error">* 
                                @if ($errors->has('site_name'))
                                    {{ $errors->first('site_name') }}
                                @endif
                            </span>
                            @if(isset($general))
                                <input type="hidden" name="id" value="{{ $general->id ? $general->id : '' }}" class="form-control">
                                 <input type="text" name="site_name" value="{{ $general->site_name ? $general->site_name : '' }}" class="form-control">
                            @else
                                 <input type="hidden" name="id" value="{{ old('id') }}" class="form-control">
    
                                <input type="text" name="site_name" value="{{ old('site_name') }}" class="form-control">
    
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            <label for="site_description">Site Description</label>
                            <span class="error">* 
                                @if ($errors->has('site_description'))
                                    {{ $errors->first('site_description') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input type="text" name="site_description" value="{{ $general->site_description ? $general->site_description : '' }}" class="form-control">
                            @else
                                <input type="text" name="site_description" value="{{ old('site_description') }}" class="form-control">
                            @endif
                        </div> -->

                        <div class="form-group col-lg-4 mb-3">
                            <label for="meta_title">Meta Title</label>

                            <span class="error">* 
                                @if ($errors->has('meta_title'))
                                    {{ $errors->first('meta_title') }}
                                @endif
                            </span>

                            @if(isset($general))
                            <input type="text" name="meta_title" value="{{ $general->meta_title ? $general->meta_title : '' }}" class="form-control">
    
                            @else
                                <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group col-lg-4 mb-3">
                            <label for="meta_keywords">Meta Keywords</label>
                            
                            <span class="error">* 
                                @if ($errors->has('meta_keywords'))
                                    {{ $errors->first('meta_keywords') }}
                                @endif
                            </span>

                            @if(isset($general))
                            <input type="text" name="meta_keywords" value="{{ $general->meta_keywords ? $general->meta_keywords : '' }}" class="form-control">
                            @else
                                <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label for="meta_description">Meta Description</label>
                            <span class="error">* 
                                @if ($errors->has('meta_description'))
                                    {{ $errors->first('meta_description') }}
                                @endif
                            </span>

                            @if(isset($general))
                            
                                <input type="text" name="meta_description" value="{{ $general->meta_description ? $general->meta_description : '' }}" class="form-control">
                            @else
                                <input type="text" name="meta_description" value="{{ old('meta_description') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group d_none col-lg-6 mb-3">
                            <label for="cod">Enable / Disable COD</label>
                            <span class="error">
                                @if ($errors->has('cod'))
                                    {{ $errors->first('cod') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input class="checkbox" type="checkbox" @if($general->cod == 1)  {{'checked'}} value="1" @else {{''}} value="0" @endif name="cod" id="cod" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @else
                                <input class="checkbox" type="checkbox" value="" name="cod" id="cod" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @endif
                        </div>

                        <div class="form-group  d_none col-lg-6 mb-3">
                            <label for="paypal">Enable / Disable Online Payment</label>
                            <span class="error">
                                @if ($errors->has('paypal'))
                                    {{ $errors->first('paypal') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input class="checkbox" type="checkbox" @if($general->paypal == 1)  {{'checked'}} value="1" @else {{''}} value="0" @endif name="paypal" id="paypal" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @else
                                <input class="checkbox" type="checkbox" name="paypal" value="" id="paypal" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            <label for="pay_Umoney">Enable / Disable PayUmoney</label>
                            <span class="error">
                                @if ($errors->has('pay_Umoney'))
                                    {{ $errors->first('pay_Umoney') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input class="checkbox" type="checkbox" @if($general->pay_Umoney == 1)  {{'checked'}} value="1" @else {{''}} value="0" @endif name="pay_Umoney" id="pay_Umoney" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @else
                                <input class="checkbox" type="checkbox" name="pay_Umoney" id="pay_Umoney" onclick="$(this).attr('value', this.checked ? 1 : 0)"/>
                            @endif
                        </div> -->
                        <p class="gj_not  d_none" style="color:red"><em>Note : Enable/ Disable COD and Online Payment Changes is affected for Checkout Page</em></p>

                        <div class="form-group col-lg-6 mb-3">
                             <label for="frontend_url">Front End Url</label>
                            <span class="error">*
                                @if ($errors->has('frontend_url'))
                                    {{ $errors->first('frontend_url') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input type="text" name="frontend_url" value="{{ $general->frontend_url ? $general->frontend_url : '' }}" class="form-control">
                            @else
                                <input type="text" name="frontend_url" value="{{ old('frontend_url') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group  d_none col-lg-12 mb-3">
                            <label for="backend_url">Back End Url</label>
                            <span class="error">*
                                @if ($errors->has('backend_url'))
                                    {{ $errors->first('backend_url') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input type="text" name="backend_url" value="{{ $general->backend_url ? $general->backend_url : '' }}" class="form-control" readonly>
                            @else
                                <input type="text" name="backend_url" value="{{ old('backend_url') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group  d_none col-lg-12 mb-3">
                            <label for="play_store_url">Play Store Url</label>
                            <span class="error">
                                @if ($errors->has('play_store_url'))
                                    {{ $errors->first('play_store_url') }}
                                @endif
                            </span>

                            @if(isset($general))
                                <input type="text" name="play_store_url" value="{{ $general->play_store_url ? $general->play_store_url : '' }}" class="form-control" >
                            @else
                                <input type="text" name="play_store_url" value="{{ old('play_store_url') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group  d_none col-lg-12 mb-3">
                            <label for="ios_store_url">App Store (iOS)</label>
                            <span class="error">
                                @if ($errors->has('ios_store_url'))
                                    {{ $errors->first('ios_store_url') }}
                                @endif                                
                            </span>

                            @if(isset($general))
                                <input type="text" name="ios_store_url" value="{{ $general->ios_store_url ? $general->ios_store_url : '' }}" class="form-control" >
                            @else
                                <input type="text" name="ios_store_url" value="{{ old('ios_store_url') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group col-lg-12 mb-3">
                            <label for="cancel_terms">Terms & Conditions for Cancel Order</label>
                            <span class="error">
                                @if ($errors->has('cancel_terms'))
                                    {{ $errors->first('cancel_terms') }}
                                @endif                                
                            </span>
                                @if(isset($general))
                                    <textarea name="cancel_terms" id="gj_cancel_terms" class="form-control" rows="5">{{ $general->cancel_terms ? $general->cancel_terms : '' }}</textarea>
                                @else
                                    <textarea name="cancel_terms" class="form-control" rows="5">{{ old('cancel_terms') }}</textarea>
                                @endif
                        </div>

                        {{--<div class="form-group col-lg-12 mb-3">
                            <label for="return_terms">Terms & Conditions for Return/Replace Order</label>
                            <span class="error">
                                @if ($errors->has('return_terms'))
                                    {{ $errors->first('return_terms') }}
                                @endif                                
                            </span>

                            @if(isset($general))
                                <textarea name="return_terms" id="gj_return_terms" class="form-control" rows="5">{{ $general->return_terms ? $general->return_terms : '' }}</textarea>
                            @else
                                <textarea name="return_terms" class="form-control" rows="5">{{ old('return_terms') }}</textarea>
                            @endif
                        </div>--}}

                         <input type="submit" class="btn btn-primary mx_auto" value="Update">

                   </form>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('p.alert').delay(5000).slideUp(700);
</script>

<!-- Editor Script Start -->
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>


    <script>
        CKEDITOR.replace( 'gj_cancel_terms' );
        CKEDITOR.replace( 'gj_return_terms' );
    </script>
<!-- Editor Script End -->
@endsection
