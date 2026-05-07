@extends('layouts.master')
@section('title', 'Add COD')
@section('content')
<section class="gj_add_cod_setting">
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">


            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add Payment Setting </h5>
                </header>

                <div class="col-md-12">
                      <form action="{{ route('add_cod') }}" method="POST" class="gj_cod_form" enctype="multipart/form-data">
                          @csrf
                        
                        <div class="form-group">
                            <label for="above_amount">COD Amount</label>
                            <span class="error">* 
                                @if ($errors->has('above_amount'))
                                    {{ $errors->first('above_amount') }}
                                @endif
                            </span>
                            
                            <input type="text" name="above_amount" class="form-control gj_above_amount" placeholder="Enter COD Amount" value="{{old('above_amount')}}">
                       
                            <p class="gj_ex_cod">Eg:2500 (This Amount is calculate for Net Amount Above 2500 and set to COD charges is particular COD Amount.)</p>
                        </div>

                        <div class="form-group">
                            <label for="cod_amount">COD Charge</label>
                            <span class="error">* 
                                @if ($errors->has('cod_amount'))
                                    {{ $errors->first('cod_amount') }}
                                @endif
                            </span>
                            <input type="text" name="cod_amount" class="form-control gj_cod_amount" placeholder="Enter COD Charge" value="{{old('cod_amount')}}">
                      
                        </div>

                        <div class="form-group">
                             <label for="remarks">Remarks</label>
                            <span class="error"> 
                                @if ($errors->has('remarks'))
                                    {{ $errors->first('remarks') }}
                                @endif
                            </span>

                            <textarea name="remarks" class="form-control gj_remarks" rows="5" placeholder="Enter Remarks" >{{old('remarks')}}</textarea>
                        </div>
                        
                        <input type="submit" class="btn btn-primary mx_auto" value="Save">

                   </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
    });
</script>
@endsection
