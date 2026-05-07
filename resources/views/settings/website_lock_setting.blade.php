@extends('layouts.master')
@section('title', 'Website Lock Settings')
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
                   <h3 class="gj_heading"> Website Lock Settings  </h3>

               <form action="{{ route('website-lock.update') }}" method="POST" class="gj_geneal_form row mt-5">
                     @csrf

                        <div class="form-group col-lg-4 mb-3">
                            <label for="meta_title">Enable Website Lock</label>

                            <input type="checkbox" name="is_enabled" value="1" {{ $lock->is_enabled ? 'checked' : '' }} class="form-control" style="margin-top:-22px;height: 20px;">
                        </div>

                        <div class="form-group col-lg-4 mb-3">
                            <label for="inter_shipping">Set Passcode</label>
                            
                            <input type="text" name="passcode" value="{{ $lock->passcode }}" class="form-control" maxlength="4">

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
