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
                   <h3 class="gj_heading"> Shipping Settings  </h3>

               <form action="{{ route('store_shipping_setting') }}" method="POST" class="gj_geneal_form row mt-5">
                     @csrf

                        <div class="form-group col-lg-4 mb-3">
                            <label for="meta_title">Domestic Shipping</label>

                            <span class="error">* 
                                @if ($errors->has('domestic_shipping'))
                                    {{ $errors->first('domestic_shipping') }}
                                @endif
                            </span>

                            @if(isset($general))
                            
                            <input type="hidden" name="id" value="{{ $general->id ? $general->id : '' }}" class="form-control">
                            <input type="number" name="domestic_shipping" value="{{ $general->domestic_shipping ? $general->domestic_shipping : '' }}" class="form-control">
    
                            @else
                            
                                 <input type="hidden" name="id" value="{{ old('id') }}" class="form-control">
                                <input type="number" name="domestic_shipping" value="{{ old('domestic_shipping') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group col-lg-4 mb-3">
                            <label for="inter_shipping">InterNational Shipping</label>
                            
                            <span class="error">* 
                                @if ($errors->has('inter_shipping'))
                                    {{ $errors->first('inter_shipping') }}
                                @endif
                            </span>

                            @if(isset($general))
                            <input type="number" name="inter_shipping" value="{{ $general->inter_shipping ? $general->inter_shipping : '' }}" class="form-control">
                            @else
                                <input type="number" name="inter_shipping" value="{{ old('inter_shipping') }}" class="form-control">
                            @endif
                        </div>
                        <div class="form-group col-lg-4 mb-3">
                            <label for="free_shipping">Limit for Free Shipping within India</label>
                            
                            <span class="error">* 
                                @if ($errors->has('free_shipping'))
                                    {{ $errors->first('free_shipping') }}
                                @endif
                            </span>

                            @if(isset($general))
                            <input type="number" name="free_shipping" value="{{ $general->free_shipping ? $general->free_shipping : '' }}" class="form-control">
                            @else
                                <input type="number" name="free_shipping" value="{{ old('free_shipping') }}" class="form-control">
                            @endif
                        </div>
                       

                        <div class="form-group col-lg-12 mb-3">
                            <label for="cancel_terms">Text</label>
                            <span class="error">
                                @if ($errors->has('text'))
                                    {{ $errors->first('text') }}
                                @endif                                
                            </span>
                                @if(isset($general))
                                    <textarea name="text" id="gj_cancel_terms" class="form-control" rows="5">{{ $general->text ? $general->text : '' }}</textarea>
                                @else
                                    <textarea name="text" class="form-control" rows="5">{{ old('text') }}</textarea>
                                @endif
                        </div>

                         <input type="submit" class="btn btn-primary mx_auto" value="Update">

                   </form>
                   </div>
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
