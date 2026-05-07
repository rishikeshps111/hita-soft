@extends('layouts.master')
@section('title', 'Add Size')
@section('content')
<section class="gj_email_setting">
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
       <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Add Size  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                

                <div class="col-md-12">
                    <form action="{{ route('store_size') }}" method="POST" class="gj_size_form" enctype="multipart/form-data">
                     @csrf
                      <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                              <h3 class="gj_heading"> Add Size</h3>
                          </div>
                         <div class="col-lg-12 mt__1">
                        <div class="form-group">
                            <label for="size">Size</label>
                            <span class="error">* 
                                @if ($errors->has('size'))
                                    {{ $errors->first('size') }}
                                @endif
                            </span>

                              <input type="text" name="size" class="form-control gj_size" placeholder="Size"  value="{{ old('size') }}" >

                        </div>
                        </div>

                            <div class="col-lg-12 mt__1">
                                 <div class="update-btn-box ">
                                    <input type="submit" class="btn btn-primary mx_auto" value="Update">
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
        // $("#size").select2();
    });
</script>
@endsection
