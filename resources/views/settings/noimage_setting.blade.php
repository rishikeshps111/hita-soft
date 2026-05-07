@extends('layouts.master')
@section('title', 'Noimage Settings')
@section('content')
<section class="gj_email_setting">
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
                <div id="flash-message" style="display:none;" class="alert alert-success"></div>
                <div id="flash-error" style="display:none;" class="alert alert-danger"></div>

             

                <div class="col-md-12">
                    <?php 
                    $date = date('M-Y');
                    $file_path = 'images/noimage';
                    ?>
                     <form action="{{route('store_noimage_setting')}}" class="gj_noimage_form" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class=" main-right-container container-field row mx_0 px_5 mb-field no-img-col-padding" >
                                <div class="col-lg-12">
                                     <h3 class="gj_heading"> Noimage Settings  </h3>
                                </div>
                                {{--<div class="col-lg-4 mt__3">
                                    <div class="no-img-box">
                                        <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                <input type="hidden" name="id" class="form-control" value="{{ $noimage->id ? $noimage->id : '' }}" >

                                @if($noimage->no_image !='')
                                <div class="form-group">
                                    <label for="current_noimage">Current No Image</label>
                                    <div class="gj_ni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->no_image)}}" class="img-responsive"> 
                                    </div>
                                     <input type="hidden" name="old_no_image" class="form-control" value="{{ $noimage->no_image ? $noimage->no_image : '' }}" >
                                     
                                    

                                </div>
                                @endif
                            @else
                             <input type="hidden" name="id" class="form-control" value="{{ old('id') }}" >
                            @endif

                            <div class="form-group">
                                <label for="no_image">Upload No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('no_image'))
                                        {{ $errors->first('no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 381 x 215 pixels</em></p>

                                @if(isset($no_image))
                                    <input type="file" name="no_image" id="no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="no_image" id="no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-4 col-md-6 mt__3">
                                    <div class="no-img-box">
                                        <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->profile_no_img !='')
                                <div class="form-group">
                                <label for="current_profile_no_img">Current Profile No Image</label>
                                    <div class="gj_pni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->profile_no_img)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_profile_no_img" class="form-control" value="{{ $noimage->profile_no_img ? $noimage->profile_no_img : '' }}" >
                                    
                                    <button type="button" 
                                            class="btn btn-danger btn-sm mt-2 delete-noimage" 
                                            data-type="profile">
                                        Delete
                                    </button>
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="profile_no_img">Upload Profile No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('profile_no_img'))
                                        {{ $errors->first('profile_no_img') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                                @if(isset($profile_no_img))
                                    <input type="file" name="profile_no_img" id="profile_no_img" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="profile_no_img" id="profile_no_img" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mt__3">
                                    <div class="no-img-box">
                                        <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->product_no_image !='')
                                <div class="form-group">
                                    <label for="current_product_no_image">Current Product No Imag</label>
                                    <div class="gj_cbni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->product_no_image)}}" class="img-responsive"> 
                                    </div>
                                     <input type="hidden" name="product_no_image" class="form-control" value="{{ $noimage->product_no_image ? $noimage->product_no_image : '' }}" >
                                   <button type="button" 
                                            class="btn btn-danger btn-sm mt-2 delete-noimage" 
                                            data-type="product">
                                        Delete
                                    </button>
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="product_no_image">Upload Product No Imag</label>
                                <span class="error">* 
                                    @if ($errors->has('product_no_image'))
                                        {{ $errors->first('product_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p>

                                @if(isset($product_no_image))
                                    <input type="file" name="product_no_image" id="product_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="product_no_image" id="product_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-lg-4 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->deal_no_image !='')
                                <div class="form-group">
                                    <label for="current_deal_no_image">Current Deal No Image</label>
                                    <div class="gj_pni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->deal_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="deal_no_image" class="form-control" value="{{ $noimage->deal_no_image ? $noimage->deal_no_image : '' }}" >
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="deal_no_image">Upload Deal No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('deal_no_image'))
                                        {{ $errors->first('deal_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p>

                                @if(isset($deal_no_image))
                                    <input type="file" name="deal_no_image" id="deal_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="deal_no_image" id="deal_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->stores_no_image !='')
                                <div class="form-group">
                                    <label for="current_stores_no_image">Current Stores No Image</label>
                                    <div class="gj_sni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->stores_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_stores_no_image" class="form-control" value="{{ $noimage->old_stores_no_image ? $noimage->old_stores_no_image : '' }}" >
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="stores_no_image">Upload Stores No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('stores_no_image'))
                                        {{ $errors->first('stores_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 455 x 378 pixels</em></p>

                                @if(isset($stores_no_image))
                                    <input type="file" name="stores_no_image" id="stores_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="stores_no_image" id="stores_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->blog_banner_no_image !='')
                                <div class="form-group">
                                    <label for="current_blog_banner_no_image">Current Blog Banner No Image</label>
                                    <div class="gj_bbni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->blog_banner_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_blog_banner_no_image" class="form-control" value="{{ $noimage->old_blog_banner_no_image ? $noimage->old_blog_banner_no_image : '' }}" >
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="blog_banner_no_image">Upload Blog Banner No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('blog_banner_no_image'))
                                        {{ $errors->first('blog_banner_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 320 x 190 pixels</em></p>

                                @if(isset($blog_banner_no_image))
                                    <input type="file" name="blog_banner_no_image" id="blog_banner_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="blog_banner_no_image" id="blog_banner_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>--}}
                                <div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->banner_no_image !='')
                                <div class="form-group">
                                    <label for="current_banner_no_image">Current Banner No Image</label>
                                    <div class="gj_bni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->banner_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_banner_no_image" class="form-control" value="{{ $noimage->old_banner_no_image ? $noimage->old_banner_no_image : '' }}" >
                                
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="banner_no_image">Upload Banner No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('banner_no_image'))
                                        {{ $errors->first('banner_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 845 x 500 pixels</em></p>

                                @if(isset($banner_no_image))
                                    <input type="file" name="banner_no_image" id="banner_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="banner_no_image" id="banner_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>
                                {{--<div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->category_banner_no_image !='')
                                <div class="form-group">
                                    <label for="current_category_banner_no_image">Current Category Banner No Image</label>
                                    <div class="gj_cbni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->category_banner_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_category_banner_no_image" class="form-control" value="{{ $noimage->old_category_banner_no_image ? $noimage->old_category_banner_no_image : '' }}" >
                                
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="category_banner_no_image">Upload Category Banner No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('category_banner_no_image'))
                                        {{ $errors->first('category_banner_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 250 x 200 pixels</em></p>

                                @if(isset($category_banner_no_image))
                                    <input type="file" name="category_banner_no_image" id="category_banner_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="category_banner_no_image" id="banner_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->ads_no_image !='')
                                <div class="form-group">
                                    <label for="current_ads_no_image">Current Ads No Image</label>
                                    <div class="gj_ani_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->ads_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_ads_no_image" class="form-control" value="{{ $noimage->old_ads_no_image ? $noimage->old_ads_no_image : '' }}" >
                                
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="ads_no_image">Upload Ads No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('ads_no_image'))
                                        {{ $errors->first('ads_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 800 x 400 pixels</em></p>

                                @if(isset($ads_no_image))
                                    <input type="file" name="ads_no_image" id="ads_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="ads_no_image" id="banner_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>--}}
                                <div class="col-lg-4 col-md-6 mt__3">
                                      <div class="no-img-box">
                                          <div class="gj_noimage_whole">
                            @if(isset($noimage))
                                @if($noimage->category_no_image !='')
                                <div class="form-group">
                                    <label for="current_category_no_image">Current Category No Image</label>
                                    <div class="gj_cni_div">
                                       <img src="{{ asset($file_path.'/'.$noimage->category_no_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_category_no_image" class="form-control" value="{{ $noimage->old_category_no_image ? $noimage->old_category_no_image : '' }}" >
                                
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="category_no_image">Upload Category No Image</label>
                                <span class="error">* 
                                    @if ($errors->has('category_no_image'))
                                        {{ $errors->first('category_no_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                                @if(isset($category_no_image))
                                    <input type="file" name="category_no_image" id="category_no_image" accept="image/*" class="gj_noimage">
                                @else
                                    <input type="file" name="category_no_image" id="banner_no_image" accept="image/*" class="gj_noimage">
                                @endif
                            </div>
                        </div>
                                      </div>
                                </div>
                                
                            </div>
                            <div class="update-btn-box">
                                  <input type="submit" class="btn btn-primary  mx_auto" value="Update">
                            </div>
                        


                        
                        
                       

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() { 
        $("#country_name").select2();
        $('p.alert').delay(1000).slideUp(300); 
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-noimage").forEach(function (btn) {
        btn.addEventListener("click", function () {
            let type = this.dataset.type;

            if (!confirm("Are you sure you want to delete this image?")) return;

            fetch("{{ route('delete_noimage') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ type: type })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    let flash = document.getElementById("flash-message");
                    flash.textContent = data.message;
                    flash.style.display = "block";
            
                    setTimeout(() => {
                        flash.style.display = "none";
                    }, 3000);
            
                    if (type === 'profile') {
                        document.getElementById("current_profile_img").remove();
                        btn.remove();
                    } else if (type === 'product') {
                        document.getElementById("current_product_img").remove();
                        btn.remove();
                    }
                } else {
                   let flashErr = document.getElementById("flash-error");
                    flashErr.textContent = data.message;
                    flashErr.style.display = "block";
            
                    setTimeout(() => {
                        flashErr.style.display = "none";
                    }, 3000);
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>


@endsection
