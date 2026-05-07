@extends('layouts.master')
@section('title', 'View Enqueries')
@section('content')
<section class="gj_enquiries_setting">
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
  @include('layouts.message_sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                    <div class="col-lg-12 back-container">
                         <h3 class="gj_heading"> View Enqueries  </h3>
                         <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                     <div class="col-lg-12">
                    <div class="table-responsive gj_manage_enquiries adm-product-view">
                        <table class="table table-striped" id="gj_vw_enquiries_table">
                            @if($enquiries)
                                <tbody>
                                    <tr>
                                    <th class="w-50">Name</th>
                                    <td class="w-50">{{$enquiries->contact_name}}</td>
                                </tr>
                                <tr>
                                    <th>E-Mail</th>
                                    <td>{{$enquiries->contact_email}}</td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td>{{$enquiries->subject}}</td>
                                </tr>
                                <tr>
                                    <th style=" vertical-align:top;">Message</th>
                                    <td><?php echo nl2br($enquiries->message); ?></td>
                                </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
                </div>
                
               
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('p.alert').delay(1000).slideUp(300);
    });
</script>
@endsection
