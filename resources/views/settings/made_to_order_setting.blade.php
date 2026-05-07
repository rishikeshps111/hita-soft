@extends('layouts.master')
@section('title', 'Footer Settings')
@section('content')
<section class="gj_footer_setting">
         <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row min-h-cs">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">
            
            <div class="gj_box dark">
                 @if(Session::has('message'))
                        <p class="alert mt-2 {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                  
                <div class="col-md-12 px-0" >
                     <form action="{{ route('store_madeToOrderl_setting') }}" method="POST" class="gj_footer_form " multipart="multipart/form-data" >
                     @csrf
                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12 mb-3">
                             <h3 class="gj_heading">Made To Order Note</h3>
                         </div>
                          <div class="form-group col-lg-12 mb-3">
                            <label for="note">Note</label>
                            <span class="error">* 
                                @if ($errors->has('made_to_order_note'))
                                    {{ $errors->first('made_to_order_note') }}
                                @endif
                            </span>
                            @if(isset($general))
                                <input type="hidden" name="id" value="{{ $general->id ? $general->id : '' }}" class="form-control">
                                 <input type="text" name="made_to_order_note" placeholder="Enter the Note" value="{{ $general->made_to_order_note ? $general->made_to_order_note : '' }}" class="form-control">

                            @else
                                 <input type="hidden" name="id" value="{{ old('id') }}" class="form-control">
    
                                <input type="text" name="made_to_order_note" value="{{ old('made_to_order_note') }}" class="form-control">
    
                            @endif
                                
                        </div>
                        <input type="submit" class="btn btn-primary mx_auto" value="Update">

                     </div>
                     </form>
                     
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

