@extends('layouts.master')
@section('title', 'Edit Attributes')
@section('content')
<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Edit Attributes  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                <div class="col-md-12">
                     <form action="{{ route('update_attributes') }}" method="POST" class="gj_attributes_form" enctype="multipart/form-data">
                     @csrf
                      <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                        @if($attributes)
                          <input type="hidden" name="attributes_id" class="form-control gj_attributes_id" value="{{ $attributes->id }}" >
                        @endif
                            <div class="col-lg-12">
                              <h3 class="gj_heading"> Edit Attributes</h3>
                          </div>
                         <div class="col-lg-6 mt__1">
                        <div class="form-group select-cs-cont">
                            <label for="att_name">Attribute Name</label>
                            <span class="error">* 
                                @if ($errors->has('att_name'))
                                    {{ $errors->first('att_name') }}
                                @endif
                            </span>

                            <select name="att_name" id="att_name" class="gj_att_name form-control">
                                <option value="0">-- Select Attributes Name --</option>
                                @if(isset($atts) && count($atts) !=0 )
                                    @foreach ($atts as $key => $value)
                                        @if($value->id == $attributes->att_name)
                                            <option selected value="{{$value->id}}">{{$value->att_name}}</option>
                                        @else
                                            <option value="{{$value->id}}">{{$value->att_name}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        </div>

                        <div class="col-lg-6 mt__1">
                        <div class="form-group">
                            <label for="att_value">Attributes Value</label>
                            <span class="error">* 
                                @if ($errors->has('att_value'))
                                    {{ $errors->first('att_value') }}
                                @endif
                            </span>

                             <input type="text" name="att_value" class="form-control gj_att_value" placeholder="Enter Attributes Value"  value="{{ old('att_value',$attributes->att_value) }}" >

                        </div>
                        </div>

                        <div class="col-lg-6 mt__1">
                        <div class="gj_ban_img_whole">
                            <?php 
                            $file_path = 'images/attributes';
                            ?>
                            @if(isset($attributes))
                                @if($attributes->att_image != '')
                                <div class="form-group">
                                    <label for="current_att_image">Current Attributes Image</label>
                                    <div class="gj_cbni_div">
                                       <img src="{{ asset($file_path.'/'.$attributes->att_image)}}" class="img-responsive"> 
                                    </div>
                                    
                                    <input type="hidden" name="old_att_image" class="form-control" value="{{$attributes->att_image}}">
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="att_image">Upload Attributes Image</label>
                                <span class="error">* 
                                    @if ($errors->has('att_image'))
                                        {{ $errors->first('att_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                                <input type="file" name="att_image" id="att_image" accept="image/*" class="gj_att_image">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12 mt__1">
                        <div class="form-group">
                            <label for="att_desc">Attribute Description</label>
                            <span class="error">* 
                                @if ($errors->has('att_desc'))
                                    {{ $errors->first('att_desc') }}
                                @endif
                            </span>

                            <textarea name="att_desc" class="form-control gj_att_desc" placeholder="Enter Attributes Descriptiion" rows="5">{{ old('att_desc',$attributes->att_desc) }}</textarea>
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
        $("#att_name").select2(); 
    });
</script>
@endsection
