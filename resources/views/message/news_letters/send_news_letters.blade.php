@extends('layouts.master')
@section('title', 'Send News Letters')
@section('content')
<section class="gj_send_news_letters_setting">
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
  @include('layouts.message_sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark">
                <p id="newsletter_message" style="display:none;" class="alert alert-success"></p>

                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12">
                          <h3 class="gj_heading"> Send News Letters  </h3>
                     </div>
                     <div class="col-md-12">
                    <form action="" method="POST" class="gj_snl_form" enctype="multipart/form-data">
                   @csrf
                        <div class="form-group">
                             <label for="email_to">E-Mail To</label>
                            <span class="error">* 
                                @if ($errors->has('email_to'))
                                    {{ $errors->first('email_to') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div df-gap">
                                <span class="gj_py_ro">
                                    <input type="radio" checked name="email_to" value="1"> All Subcriber
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" name="email_to" value="2"> Particular Subcriber
                                </span>
                                {{--<span class="gj_py_ro">
                                    <input type="radio" name="email_to" value="3"> All Enquiries Mail
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" name="email_to" value="4"> Particular Enquiries Mail
                                </span>--}}
                            </div>
                        </div>

                        <div class="form-group gj_part_hide">
                            <label for="part_subs">Select Particular Subcriber</label>
                            <span class="error">* 
                                @if ($errors->has('part_subs'))
                                    {{ $errors->first('part_subs') }}
                                @endif
                            </span>

                            @if ($subcribers && (count($subcribers) != 0))
                                <select class="gj_part_subs form-control" name="part_subs[]" multiple="multiple">
                                    @foreach ($subcribers as $key => $value)
                                        <option value="{{$value->id}}">{{$value->email}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        {{--<div class="form-group gj_part_enq_hide">
                            <label for="part_enq">Select Particular Enquiries Mail</label>
                            <span class="error">* 
                                @if ($errors->has('part_enq'))
                                    {{ $errors->first('part_enq') }}
                                @endif
                            </span>

                            @if ($contacts && (count($contacts) != 0))
                                <select class="gj_part_enq form-control" name="part_enq[]" multiple="multiple">
                                    @foreach ($contacts as $key => $value)
                                        <option value="{{$value->id}}">{{$value->contact_email}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>--}}

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <span class="error">* 
                                @if ($errors->has('subject'))
                                    {{ $errors->first('subject') }}
                                @endif
                            </span>
                            <input type="text" name="subject" id="subject" class="form-control gj_subject" placeholder="Subject in English"  value="{{  old('subject') }}" >

                        </div>

                        <div class="form-group">
                             <label for="message">Message</label>
                            <span class="error">* 
                                @if ($errors->has('message'))
                                    {{ $errors->first('message') }}
                                @endif
                            </span>

                            <textarea class="message" placeholder="Message ..." name="message" id="message"></textarea>
                            <p>Eg : Thanks For Your Subcribe. We Will Contact you Soon.</p>
                        </div>
                        
                            <input type="button" id="update" class="btn btn-primary mx_auto" value="Send News Letter">


                    </form>
                </div>
                 </div>
               

                
            </div>
        </div>
    </div>
</section>


<link rel="stylesheet" type="text/css" href="{{ asset('css/editor.css')}}">
<script src="{{ asset('js/editor.js')}}"></script>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#message").Editor();
        $(".gj_part_subs").select2();
        $(".gj_part_enq").select2();

        if($("input[name='email_to']").val() == 2) {
            $('.gj_part_hide').show();
            $('.gj_part_enq_hide').hide();
        } else if($("input[name='email_to']").val() == 3) {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').hide();
        } else if($("input[name='email_to']").val() == 4) {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').show();
        } else {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').hide();
        }
    });

    $("input[name='email_to']").on('change',function(){
        if($(this).val() == 2) {
            $('.gj_part_hide').show();
            $('.gj_part_enq_hide').hide();
        } else if($(this).val() == 3) {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').hide();
        } else if($(this).val() == 4) {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').show();
        } else {
            $('.gj_part_hide').hide();
            $('.gj_part_enq_hide').hide();
        } 
    });
    
    
 
    $('#update').on('click',function(){
        var email_to = 0;
        var subject = 0;
        var part_subs = "";
        var part_enqs = "";

        if($("input[name='email_to']:checked").val()) {
            email_to = $("input[name='email_to']:checked").val();
        }

        if($('#subject').val()) {
            subject = $('#subject').val();
        }

        if($('.gj_part_subs').val()) {
            part_subs = $('.gj_part_subs').val();
        }

        if($('.gj_part_enq').val()) {
            part_enqs = $('.gj_part_enq').val();
        }

        var message = $('.Editor-editor').html();
         var msgDiv = $('#newsletter_message');
        // if((subject != 0) && (message != 0) && (email_to != 0)) {
            $.ajax({
                type: 'post',
                url: '{{url('/send_news_letters')}}',
                data: {
                     _token: $('meta[name="csrf-token"]').attr('content'),
                    subject: subject, part_subs: part_subs, part_enqs: part_enqs, message: message, email_to: email_to, type: 'send'},
                success: function(data){
                     if (data.success) {
                    msgDiv.removeClass('alert-danger')
                          .addClass('alert-success')
                          .html(data.message)
                          .slideDown();
    
                    // Trigger actual mailing via fetch
                    fetch("{{ route('send.newsletters.email') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }, 
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(fetchData => {
                        console.log('Email status:', fetchData.status);
                        // Reload page after showing success
                        setTimeout(() => {
                            msgDiv.slideUp(() => {
                                location.reload();
                            });
                        }, 3000); // show message for 3 seconds
                    })
                    .catch(err => console.error('Fetch error:', err));
                    setTimeout(() => {
                location.reload();
            }, 2000);
    
                } else {
                    msgDiv.removeClass('alert-success')
                          .addClass('alert-danger')
                          .html(data.message)
                          .slideDown();
                }
           
                }
            });            
        // } else {
        //     $.confirm({
        //         title: '',
        //         content: 'Please Enter Correct Details!',
        //         icon: 'fa fa-exclamation',
        //         theme: 'modern',
        //         closeIcon: true,
        //         animation: 'scale',
        //         type: 'red',
        //         buttons: {
        //             Ok: function(){
        //             }
        //         }
        //     });                               
        // }
    });
</script>

@endsection
