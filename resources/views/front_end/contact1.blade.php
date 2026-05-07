@extends('layouts.frontend')
@section('title', 'Contact Us')
<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">
@section('content')
    <div class="gj_contact_sec">
        <!-- Contact Banner Section Start -->
        <section class="gj_contact_bann_sec">
            <div class="inban inban8" style="background-image:url('{{asset($contact->banner_image)}}')">
                @if(isset($contact->banner_caption) && $contact->banner_caption)
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                               <h4> {{$contact->banner_caption}}  </h4> 
                            </div>
                        </div>
                    </div>  
                @endif       
            </div>  
        </section>
        <!-- Contact Banner Section End -->

        <!-- Contact Details Section Start -->
        <section class="gj_cont_det_sec">
            <div class="ps-contact-info">
                <div class="container">
                    <div class="ps-section__header text-center">
                        <h4>{{$contact->main_hd}}</h4>
                        <hr>
                    </div>
                    <div class="ps-section__content">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                                <div class="ps-block--contact-info">
                                    <?php echo $contact->content_1; ?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                                <div class="ps-block--contact-info">
                                    <?php echo $contact->content_2; ?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 ">
                                <div class="ps-block--contact-info">
                                    <?php echo $contact->content_3; ?>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Details Section End -->

        <!-- Contact Form Section Start -->
        <section class="gj_cont_form_sec">
            <div class="ps-contact-form">
                <div class="container">
                    {{ Form::open(array('url' => 'contact','class'=>'ps-form--contact-us gj_addcnts_frm','id'=>'contact','accept-charset'=>'UTF-8','files' => true)) }}
                        <h3>{{$contact->touch_hd}}</h3>
                        <div class="row">
                        
                            <div class="col-md-2">
                            
                            </div>
                        
                            <div class="col-md-8 col-lg-8 col-xs-12">                        
                                <div class="row">                                
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <div class="form-group">
                                            <span class="error">
                                                @if ($errors->has('contact_name'))
                                                    {{ $errors->first('contact_name') }}
                                                @endif
                                            </span>

                                            <input class="form-control" type="text" placeholder="Name *" name="contact_name">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                        <div class="form-group">
                                            <span class="error">
                                                @if ($errors->has('contact_email'))
                                                    {{ $errors->first('contact_email') }}
                                                @endif
                                            </span>

                                            <input class="form-control" type="email" placeholder="Email *" name="contact_email">
                                        </div>
                                    </div>
                                    
                                </div>
                                    
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="form-group">
                                            <span class="error">
                                                @if ($errors->has('subject'))
                                                    {{ $errors->first('subject') }}
                                                @endif
                                            </span>

                                            <input class="form-control" type="text" placeholder="Subject *" name="subject">
                                        </div>
                                    </div>
                                    
                                </div>
                                    
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="form-group">
                                            <span class="error">
                                                @if ($errors->has('message'))
                                                    {{ $errors->first('message') }}
                                                @endif
                                            </span>

                                            <textarea class="form-control" rows="5" placeholder="Message" name="message"></textarea>
                                        </div>
                                    </div>                                    
                                </div>                                   
                            </div>                                    
                            
                            <div class="col-md-2">
                                
                            </div>
                        </div>

                        <div class="form-group submit">
                            <button type="submit" class="ps-btn">Send message</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </section>
        <!-- Contact Form Section End -->
    </div>
<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700); 
    });
</script>

<script>
    $(document).ready(function(){
        /*$(".gj_cont_info").each(function(){
            var embed ="<iframe width='100%' height='315' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
            $('.gj_map_div').html(embed);
        }); */
    });
</script>
@endsection
