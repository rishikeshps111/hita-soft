@extends('layouts.master')
@section('title', 'Share Coupon')
@section('content')
<style>
    .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
.btn-sm {
    padding: 5px 10px;
    font-size: 11px;
    line-height: 1.5;
    border-radius: 3px;
    margin-bottom: 3px;
    margin-left: 16px;
}
</style>
<section class="gj_email_setting">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.coupon_sidebar')
        </div>

        <div class="col-lg-10 ">
            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger" id="error-alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif
                
                <div class="col-md-12">
                    <form action="{{ route('send_coupon_to_users') }}" method="POST" class="gj_user_form" enctype="multipart/form-data">
                     @csrf
                     
                     <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">

                     <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12">
                             <h3 class="gj_heading"> Share Coupon</h3>
                         </div>
                         
                         <div class="form-group  col-lg-12">
                            <label>Select Users</label>
                             <button type="button" class="btn btn-sm btn-primary mb-2" onclick="selectAllUsers()">Select All</button>
                            <button type="button" class="btn btn-sm btn-danger mb-2" onclick="deselectAllUsers()">Deselect All</button>
                            <select name="user_ids[]" id="userSelect" class="gj_part_subs form-control" multiple="multiple" >
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="form-group  col-lg-12">
                            <label>Subject (optional)</label>
                            <input type="text" name="subject" class="form-control" placeholder="Coupon Inside!">
                        </div>
                
                        <div class="form-group  col-lg-12" >
                            <label>Message (optional)</label>
                            <textarea name="message" class="form-control" placeholder="Here's your coupon code!">{{ 'Exclusive Coupon Just for You – ' . $coupon->code }}</textarea>
                        </div>
                         
                         
                         
                     </div>
                     <input type="submit" class="btn btn-primary mx_auto" value="Send Coupon">

                    </form>
                </div>
                
                
            </div>
            
        </div>
    </div>
</section>


<script>
    $(document).ready(function() { 
        $(".gj_part_subs").select2();
        $(".gj_part_enq").select2();
         $('#userSelect').select2();

        
    });
</script>
<script>
    function selectAllUsers() {
        let select = $('#userSelect');
        select.find('option').prop('selected', true);
        select.trigger('change'); // Reflect changes if using Select2
    }

    function deselectAllUsers() {
        let select = $('#userSelect');
        select.find('option').prop('selected', false);
        select.trigger('change');
    }
</script>


@endsection
