@extends('layouts.master')
@section('title', 'Change Cancel Order Status')
@section('content')
<section class="gj_ccos_setting" sty>
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Change Cancel Order Status  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12">
                          <h3 class="gj_heading"> Change Cancel Order Status  </h3>
                          <a href="javascript:history.back()" class="btn btn-outline-secondary" style="margin-left:90%;">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                     </div>
                     <div class="col-lg-12">
                     <form action="{{ route('cancel_req_status') }}" method="POST" class="gj_ccos_form" enctype="multipart/form-data">
                     @csrf
                        @if($orders)
                            <input type="hidden" name="order_id" value="{{ $orders->id }}" class="form-control gj_odr_id">
                        @endif

                        <div class="form-group">
                            <label for="order_code">Order Code</label>
                            <span class="error">* 
                                @if ($errors->has('order_code'))
                                    {{ $errors->first('order_code') }}
                                @endif
                            </span>
                            <input type="text" name="order_code" class="form-control gj_order_code" placeholder="Enter Order Code"  value="{{ $orders->order_code ? $orders->order_code : old('order_code') }}" readonly>

                        </div>

                        <div class="form-group">
                             <label for="cancel_remarks">Remarks</label>
                            <span class="error">* 
                                @if ($errors->has('cancel_remarks'))
                                    {{ $errors->first('cancel_remarks') }}
                                @endif
                            </span>
                            <textarea name="cancel_remarks" class="form-control gj_cancel_remarks" rows="5" placeholder="Enter Cancel Order Remarks">{{ $orders->cancel_remarks ? $orders->cancel_remarks : old('cancel_remarks') }}</textarea>

                        </div>

                        <div class="form-group">
                            <label for="cancel_approved">Cancel Order Status</label>
                            <span class="error">* 
                                @if ($errors->has('cancel_approved'))
                                    {{ $errors->first('cancel_approved') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div df-gap">
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($orders->cancel_approved == 3) { echo "checked"; } ?> name="cancel_approved" value="3"> Process
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($orders->cancel_approved == 1) { echo "checked"; } ?> name="cancel_approved" value="1"> Accept
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($orders->cancel_approved == 2) { echo "checked"; } ?> name="cancel_approved" value="2"> Reject
                                </span>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary mx_auto" value="Submit">

                    </form>
                </div>
                 </div>
                

                
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
    });
</script>
@endsection
