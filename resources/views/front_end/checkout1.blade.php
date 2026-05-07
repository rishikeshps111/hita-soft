<?php  
    $general = \DB::table('general_settings')->first();
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View CheckOut')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
@section('content')

<style>
    .custom-popup-class {
    width: 70%; /* Adjust the width as needed */
    max-width: 600px; /* Set a maximum width if desired */
    height: auto; /* The height will adjust based on content */
}
</style>
    <section class="ps-section--account ps-checkout">
        <div class="container">
            <div class="ps-section__header text-center">
                <h3>Checkout Information</h3>
            </div>
            
            @if (isset($items) && count($items) != 0)
              <div class="ps-section__content">
                  {{ Form::open(array('url' => 'checkout_verif','class'=>'gj_ch_trans ps-form--checkout','id'=>'gj_ch_trans','files' => true)) }}
                    @csrf
                      <div class="ps-form__content">
                          <div class="row">
                              <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ">
                                  <div class="ps-form__billing-info">
                             
                                      <h4 class="ps-form__heading">Shipping Address</h4>
                                      <hr>

                                      <input id="user_id" type="hidden" placeholder="user_id" name="user_id" class="form-control input-md" value="{{$users->id}}">
                                      
                                      
                                       <div class="form-group">
                                                  <label>Full Name *</label>
                                                  <span class="error">
                                                      @if ($errors->has('full_name'))
                                                          {{ $errors->first('full_name') }}
                                                      @endif
                                                  </span> 
                                                  <input class="form-control" type="text" placeholder="" value="{{(isset($ships) && ($ships->full_name) ? $ships->full_name : $lusr->full_name)}}"  name="full_name" readonly>
                                              </div>
                                              <!--<div class="form-group">-->
                                              <!--    <label>First Name *</label>-->
                                              <!--    <span class="error">-->
                                              <!--        @if ($errors->has('first_name'))-->
                                              <!--            {{ $errors->first('first_name') }}-->
                                              <!--        @endif-->
                                              <!--    </span> -->
                                              <!--    <input class="form-control" type="text" placeholder="" value="{{(isset($ships) && ($ships->first_name) ? $ships->first_name : $users->first_name)}}"  name="first_name">-->
                                              <!--</div>-->
                               
                                              <!--<div class="form-group">-->
                                              <!--    <label>Last Name *</label>-->
                                              <!--    <span class="error">-->
                                              <!--        @if ($errors->has('last_name'))-->
                                              <!--            {{ $errors->first('last_name') }}-->
                                              <!--        @endif-->
                                              <!--    </span> -->
                                              <!--    <input class="form-control" type="text" placeholder="" value="{{(isset($ships) && ($ships->last_name) ? $ships->last_name : $users->last_name)}}" name="last_name">-->
                                              <!--</div>-->

                                        <div class="row">
                                          <div class="col-sm-6">
                                              <div class="form-group">
                                                <label>Email </label>
                                                <span class="error">
                                                      @if ($errors->has('email'))
                                                          {{ $errors->first('email') }}
                                                      @endif
                                                  </span> 
                                                <input class="form-control" type="text" placeholder="" value="{{(isset($ships) && ($ships->email) ? $ships->email : $users->email)}}" name="email" readonly>
                                              </div>
                                          </div>
                                          <div class="col-sm-6">
                                            <div class="form-group">
                                              <label>Phone number </label>
                                              <span class="error">
                                                      @if ($errors->has('contact_no'))
                                                          {{ $errors->first('contact_no') }}
                                                      @endif
                                                  </span> 
                                              <input class="form-control" type="text" placeholder="" value="{{(isset($ships) && ($ships->contact_no) ? $ships->contact_no : $users->phone)}}" name="contact_no" readonly>
                                            </div>
                                          </div>
                                      </div>                 
                  
                                  
                                      <div class="form-group">
                                          <label>Address * </label>
                                          <span class="error">
                                                      @if ($errors->has('address'))
                                                          {{ $errors->first('address') }}
                                                      @endif
                                                  </span> 
                                          <input class="form-control" type="text" placeholder="(House No, Building, Street, Area..)" name="address" value="{{(isset($ships) && ($ships->address) ? $ships->address : '')}}">
                                      </div>
                  
                                      <div class="form-group">
                                          <label>Pincode * </label>
                                          <span class="error">
                                                      @if ($errors->has('pincode'))
                                                          {{ $errors->first('pincode') }}
                                                      @endif
                                                  </span> 
                                          <input class="form-control" type="text" placeholder="" name="pincode" value="{{(isset($ships) && ($ships->pincode) ? $ships->pincode : '')}}">
                                      </div>
                  
                                      <div class="form-group">
                                          <label>Locality / Town *</label>
                                          <span class="error">
                                                      @if ($errors->has('landmark'))
                                                          {{ $errors->first('landmark') }}
                                                      @endif
                                                  </span> 
                                          <input class="form-control" type="text" placeholder="" name="landmark" value="{{(isset($ships) && ($ships->landmark) ? $ships->landmark : '')}}">
                                      </div>

                                      <!--<div class="row">-->
                                      <!--    <div class="col-sm-6">-->
                                      <!--        <div class="form-group">-->
                                      <!--            <label>State *</label>-->
                                      <!--            <span class="error">-->
                                      <!--                @if ($errors->has('state'))-->
                                      <!--                    {{ $errors->first('state') }}-->
                                      <!--                @endif-->
                                      <!--            </span> -->

                                      <!--            <select class="form-control" name="state" id="state">-->
                                      <!--              <option value="">Select State</option>-->
                                      <!--              @if(isset($state) && sizeof($state) != 0)-->
                                      <!--                @foreach($state as $stk => $stv)-->
                                      <!--                  @if(isset($ships) && $ships->state == $stv->id)-->
                                      <!--                    <option selected value="{{$stv->id}}">{{$stv->state}}</option>-->
                                      <!--                  @elseif($users->state == $stv->id)-->
                                      <!--                    <option selected value="{{$stv->id}}">{{$stv->state}}</option>-->
                                      <!--                  @else-->
                                      <!--                    <option value="{{$stv->id}}">{{$stv->state}}</option>-->
                                      <!--                  @endif-->
                                      <!--                @endforeach-->
                                      <!--              @endif-->
                                      <!--            </select>-->
                                      <!--        </div>-->
                                      <!--    </div>-->

                                      <!--    <div class="col-sm-6">-->
                                      <!--        <div class="form-group">-->
                                      <!--            <label>City / District *</label>-->
                                      <!--            <span class="error">-->
                                      <!--                @if ($errors->has('city'))-->
                                      <!--                    {{ $errors->first('city') }}-->
                                      <!--                @endif-->
                                      <!--            </span> -->

                                      <!--            <select class="form-control" name="city" id="city" disabled>-->
                                      <!--              <option value="">Select City/District</option>-->
                                      <!--            </select>-->
                                      <!--        </div>-->
                                      <!--    </div>-->
                                      <!--</div>-->
                  
                  <!-- <div class="addrxbtn">
                    <a href="#"> Add Address  </a> 
                    <a href="#"> Add Coupon Code  </a> 
                  </div> -->
                  
                  
                  <!-- <h4> Save Address As </h4>
                  
                  <div class="addrxbtn">
                    <a href="#"> Home  </a> 
                    <a href="#"> Work  </a> 
                  </div> -->
                                      <!-- <div class="form-group">
                                          <div class="ps-checkbox">
                                              <input class="form-control" type="checkbox" id="save-next-time" placeholder="" name="default">
                                              <label for="save-next-time"> Make this my default addrress</label>
                                          </div>
                                      </div> -->
                                  </div>
                              </div>

                              <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                  <div class="ps-block--checkout-order">
                                      <div class="ps-block__content">
                                          <figure>
                                              <figcaption><strong>Product</strong><strong>Total</strong></figcaption>
                                          </figure>

                                          <figure class="ps-block__items">
                                            @foreach ($items as $key => $value)
                                              <a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                  <strong>{{$value->name}}</strong>
                                                  <span> 
                                                      <small> 
                                                          <span class="money"> <i class="fa fa-inr"></i> </span> 
                                                          <span class="gj_all_cart_pce" id="prod_{{$value->product_id}}"> {{ round(($value->qty * $value->discounted_price),2) }}</span>
                                                      </small>
                                                  </span>
                                              </a>

                                              <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                            @endforeach
                                          </figure>

                                          <figure>
                                              <figcaption><strong>Subtotal</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_sub_cart_total">0.00</span></strong></figcaption>

                                              <figcaption><strong>Shipping</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_ship_tot">0.00</span></strong></figcaption>

                                              <figcaption><strong>Discount</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_dis_cart_total">{{(isset($offer_discounts) && $offer_discounts) ? $offer_discounts : '0.00'}}</span></strong></figcaption>

                                              <figcaption><strong>Net Total</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_total">0.00</span></strong></figcaption>

                                              <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                                              <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot">
                                              <input type="hidden" name="cart_dis_tot" class="gj_cart_dis_tot" value="{{(isset($offer_discounts) && $offer_discounts) ? $offer_discounts : '0'}}">
                                              <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                                          </figure> 
                                          
                                          <button type="button" class="ps-btn ps-btn--fullwidth">PROCEED TO COMPLETE </button>
                                      </div>
                  
                  
                  
                  
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
            @else
                <p class="gj_no_data">Products Not Found</p>
            @endif
        </div>
    </section>
@endsection

@section('before_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
  
//   $(document).ready(function() {
//     // Add event listener to the "Proceed to Complete" button
//     $('.ps-btn--fullwidth').click(function(event) {
//         event.preventDefault(); // Prevent the default form submission

//         // Show a loader using SweetAlert
//         Swal.fire({
//             title: 'Loading',
//             text: 'Please wait...',
//             imageUrl: '{{ asset('images/Spinner.gif') }}', // Add path to your loader image
//             imageWidth: 80,
//             imageHeight: 80,
//             showCancelButton: false,
//             showConfirmButton: false,
//             allowOutsideClick: false,
//             allowEscapeKey: false,
//         });

//         // Simulate a delay to simulate the completion of the process
//         setTimeout(function() {
//             // Close the loader
//             Swal.close();

//             // Show a popup with text and OK button using SweetAlert
//           Swal.fire({
//                 title: 'ORDER PLACED SUCCESSFULLY',
//                 text: 'Reach us on Whatsapp at +91-9633052041.\nPlease share your Order No & Phone No to this WhatsApp No for our quick response.\nWhatsapp No: +91-9633052041.\nCheck your email as well. Thanks!',
//                 icon: 'success',
//                 confirmButtonText: 'OK',
//                 customClass: {
//                     popup: 'custom-popup-class'
//                 }
//             }).then((result) => {
//               if (result.isConfirmed) {
//                     window.location.href = '{{ route('home') }}';
//                 }
//             });

//         }, 2000); // Adjust the delay time as needed
//     });
// });

$(document).ready(function() {
    // Add event listener to the "Proceed to Complete" button
    $('.ps-btn--fullwidth').click(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Check if any required field is empty
        var emptyFields = $('.ps-form__billing-info input[required]').filter(function() {
            return $(this).val() === '';
        });

        if (emptyFields.length > 0) {
            // Display an alert for empty fields using SweetAlert
            Swal.fire({
                title: 'Empty Fields',
                text: 'Please fill in all required fields.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'custom-popup-class'
                }
            });
            return;
        }

        // Show a loader using SweetAlert
        Swal.fire({
            title: 'Loading',
            text: 'Please wait...',
            imageUrl: '{{ asset('images/Spinner.gif') }}', // Add path to your loader image
            imageWidth: 80,
            imageHeight: 80,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });

        // Send an AJAX request to submit the form data
        $.ajax({
            type: 'POST',
            url: '{{ url('checkout_verif') }}', // Replace with the correct URL
            data: $('#gj_ch_trans').serialize(), // Serialize the form data
            success: function(response) {
                // Close the loader
                Swal.close();

                // Handle the response from the server (if needed)
                // You can show another SweetAlert here or perform other actions

                // For example, if you want to redirect after a successful response
                window.location.href = '{{ route('home') }}';
            },
            error: function(xhr, status, error) {
                // Handle errors here, e.g., show an error message using SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'custom-popup-class'
                    }
                });
            }
        });
    });
});


</script>

<script type="text/javascript">
  $("#state").select2();
  $("#city").select2();

  $('#state').on('change',function() {
    var st = $(this).val();
    if(st) {
      $.ajax({
          type: 'post',
          url: '{{url('/select_city')}}',
          data: {st: st, type: 'city'},
          success: function(data){
              if(data){
                  $("#city").html(data);
                  $("#city").removeAttr("disabled");
              } else {
                  $.confirm({
                      title: '',
                      content: 'Please Select State!',
                      icon: 'fa fa-ban',
                      theme: 'modern',
                      closeIcon: true,
                      animation: 'scale',
                      type: 'blue',
                      buttons: {
                          Ok: function(){
                          }
                      }
                  });
                  $("#city").val('');
                  $("#city").prop("disabled", true);
              }
          }
      });
    } else {
      $.confirm({
          title: '',
          content: 'Please Select State!',
          icon: 'fa fa-ban',
          theme: 'modern',
          closeIcon: true,
          animation: 'scale',
          type: 'blue',
          buttons: {
              Ok: function(){
              }
          }
      });
    }
  });

  if($('#state').val()) {
      var city = '';
      @if(isset($ships) && $ships->city)
        city = <?php echo $ships->city; ?>;
      @elseif($users->city)
        city = <?php echo $users->city; ?>;
      @endif

      var st = $('#state').val();
      $.ajax({
          type: 'post',
          url: '{{url('/select_city')}}',
          data: {st: st, city: city, type: 'city'},
          success: function(data){
              if(data){
                  $("#city").html(data);
                  $("#city").removeAttr("disabled");
              } else {
                  $.confirm({
                      title: '',
                      content: 'Please Select State!',
                      icon: 'fa fa-ban',
                      theme: 'modern',
                      closeIcon: true,
                      animation: 'scale',
                      type: 'blue',
                      buttons: {
                          Ok: function(){
                          }
                      }
                  });
                  $("#city").val('');
                  $("#city").prop("disabled", true);
              }
          }
      });
    }
</script>

<script type="text/javascript">
    function cal_sum() {
        var sum = 0;
        var ship = 0;
        var dis = 0;

        $(".gj_all_cart_pce").each(function() {
            var value = $(this).text();

            if(!isNaN(value) && value.length != 0) {
              sum += parseFloat(value);
            }
        });


        $(".gj_sc_shiping_charge").each(function() {
            var sh_value = $(this).val();

            if(!isNaN(sh_value) && sh_value.length != 0) {
              ship += parseFloat(sh_value);
            }
        });

        if($('.gj_cart_dis_tot').val()) {
          dis = $('.gj_cart_dis_tot').val();
        }


        ctot = (sum + ship) - dis;

        sum = (sum).toFixed(2);
        $('.gj_all_sub_cart_total').text(sum);
        $('.gj_cart_sub_tot').val(sum);

        ship = (ship).toFixed(2);
        $('.gj_all_cart_ship_tot').text(ship); 
        $('.gj_cart_ship_tot').val(ship); 

        ctot = (ctot).toFixed(2);
        $('.gj_all_cart_total').text(ctot);
        $('.gj_cart_totalval').val(ctot);
    }

    cal_sum();
</script>

<!-- <script>
    function gj_round(value, decPlaces) {
      var val = value * Math.pow(10, decPlaces);
      var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

      // -342.055 => -342.06
      if (fraction == -0.5) fraction = -0.6;

      val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
      return val;
    }

    function cut_off(sum, shc, sc, tax_tot, cnt_shc) {
        var is_cod = $("input[name='payment_method']:checked").val();
        if(is_cod && is_cod == 1){
            is_cod = 1;
        } else {
            is_cod = 2;
        }

        $.ajax({
          type: 'post',
          url: '{{url('/check_cut_off')}}',
          data: {sum: sum, tax_tot: tax_tot, cnt_shc: cnt_shc, shc: shc, sc: sc, is_cod: is_cod, type: 'check_cut_off'},    
          dataType:"json",   
          success: function(data){
            if(data['error'] == 1){
              $('#cut_off').val(data['shc']);

              $('.gj_ch_sub_tot').html(data['sum']);
              $('#sub_total').val(data['sum']);

              $('.gj_ch_tax_tot').html(data['tax_tot']);
              $('#tax_total').val(data['tax_tot']);

              // $('.gj_ch_sc_tot').html(data['sc']);
              $('#serv_total').val(data['sc']);

              $('.gj_ch_shc_tot').html(data['shc']);
              $('#ship_total').val(data['shc']);

              $('.gj_ch_cod').html(data['cod_amount']);
              $('#cod_charge').val(data['cod_amount']);


              $('.gj_ch_grand_tot').html(data['tot']);
              $('#net_amount').val(data['tot']);          
            }
          }
        });
    }

    function sum() {
        var sum = 0;
        var tax_tot = 0;
        var gj = 0;
        var sc = 0;
        var shc = 0; 
        var cnt_shc = 0; 
        
        $(".gj_ch_p").each(function() {
          var value = $(this).text();
          if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
          }
        });

        $(".gj_ch_tax_amt").each(function() {
          var values = $(this).val();
          if(!isNaN(values) && values.length != 0) {
            tax_tot += parseFloat(values);
          }
        });

        $(".gj_ch_sc").each(function() {
          var value = $(this).val();
          if(!isNaN(value) && value.length != 0) {
            sc += parseFloat(value);
          }
        });

        // $(".gj_ch_shc").each(function() {
        //   var value = $(this).val();
        //   if(!isNaN(value) && value.length != 0) {
        //     shc += parseFloat(value);
        //   }
        // });
        
        if($(".product-item").find(".gj_ch_shc").length) {
            cnt_shc = $(".product-item").find(".gj_ch_shc").length;
        }

        var shc = Math.max.apply(Math, $('.gj_ch_shc').map(function(i,elem){ 
            return Number($(elem).val()); 
        }));

        $(".gj_ch_qty").each(function() {
          var value = $(this).val();
          if(!isNaN(value) && value.length != 0) {
            gj += parseFloat(value);
          }
        });

        cut_off(sum, shc, sc, tax_tot, cnt_shc);

        $('#total_items').val(gj);
    }

  $('#shipping').on('change', function() {
    if($(this).is(':checked')) { 
      $('#gj_shipping').slideDown(); 
      $(this).val(1); 
    } else {
      $(this).val(0); 
      $('#gj_shipping').slideUp(); 
    }
  });

    $(document).ready(function() {
        $('p.alert').delay(5000).slideUp(500);
        $('#gj_shipping').hide(); 

        var radioValue = $("input[name='payment_method']:checked").val();
        if(radioValue && radioValue == 1){
            $('.gj_cod_set').show();
        } else {
            $('.gj_cod_set').hide();
        }

        $('input[name="payment_method"]').on('change', function() {
            if($(this).is(':checked')) { 
                if($(this).val() && $(this).val() == 1){
                    $('.gj_cod_set').show();
                } else {
                    $('.gj_cod_set').hide();
                }
            }
            sum();
        });

        if($('#shipping').is(':checked')) { 
          $('#shipping').val(1); 
        } else {
          $('#shipping').val(0); 
        }

        sum();
    });

    $('.gj_ch_qty').on('change', function() {
        var id = $(this).closest('tr').find('.gj_p_id').val();
        var cart_id = $(this).closest('tr').find('.gj_ch_id').val();
        var qty = 1;
        var price = 0;
        var tax_amount = 0;
        var att_name = 0;
        var att_value = 0;
        var tax = 0;
        var tax_type = 0;
        var total = 0.00;
        var is_offer = "No";
        var offer_det_id = 0;
        var hm = $(this);

        if($(this).val() == 0) {
          var qty = 1;
          $(this).val(qty);
          $(this).closest('tr').find('.gj_ch_hqty').val(qty);
        } else {
            var qty = $(this).val();
        }

        if($(this).closest('tr').find('.gj_is_offer').val()) {
          var is_offer = $(this).closest('tr').find('.gj_is_offer').val();
        }

        if($(this).closest('tr').find('.gj_offer_det_id').val()) {
          var offer_det_id = $(this).closest('tr').find('.gj_offer_det_id').val();
        }

        if($(this).closest('tr').find('.gj_ch_att_name').val()) {
            var att_name = $(this).closest('tr').find('.gj_ch_att_name').val();
        }

        if($(this).closest('tr').find('.gj_ch_att_value').val()) {
            var att_value = $(this).closest('tr').find('.gj_ch_att_value').val();
        }

        if($(this).closest('tr').find('.gj_ch_dp').val()) {
            var price = parseFloat($(this).closest('tr').find('.gj_ch_dp').val());
        }

        if($(this).closest('tr').find('.gj_ch_tax_amt').val()) {
            var tax_amount = parseFloat($(this).closest('tr').find('.gj_ch_tax_amt').val());
        }

        if($(this).closest('tr').find('.gj_ch_tax').val()) {
          tax = $(this).closest('tr').find('.gj_ch_tax').val();
        }

        if($(this).closest('tr').find('.gj_ch_tax_type').val()) {
          tax_type = $(this).closest('tr').find('.gj_ch_tax_type').val();
        }

        /*if(tax_type == 2) {
          var calc_tax = ((price * tax)/100);
          price = price + calc_tax;
        }*/

        // var calc_tax = ((price * tax)/100);
        // price = price + calc_tax;

        if(is_offer == 'Yes') {
            qty = 1;
            $(this).attr('disabled', true);
        }

        if(id) {
          $.ajax({
            type: 'post',
            url: '{{url('/check_onhand_qty')}}',
            data: {id: id, is_offer: is_offer, offer_det_id: offer_det_id, qty: qty, price: price, att_name: att_name, att_value: att_value, type: 'check_onhand_qty'}, 
            dataType:"json",   
            success: function(data){
              if(data['error'] == 2){
                $.confirm({
                    title: '',
                    content: 'Out of Stock. Only ' + data['onhand_qty'] + ' Products Avaliable!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                            window.location.reload();
                        }
                    }
                });
                $(hm).val(1);
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else if(data['error'] == 3){
                $.confirm({
                    title: '',
                    content: 'Out of Stock. Products Not Avaliable!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                            window.location.reload();
                        }
                    }
                });
                $(hm).val(1);
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else if (data != 1) {
                $(hm).val(qty);
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(qty);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else {
                $(hm).val('1');
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              }

              var qtys = $(hm).val();
              var totals = $(hm).closest('tr').find('.gj_ch_total').val();
              var tax_amount = $(hm).closest('tr').find('.gj_ch_tax_amt').val();
              $.ajax({
                type: 'post',
                url: '{{url('/update_qty')}}',
                data: {cart_id: cart_id, qtys: qtys, totals: totals, type: 'update_qty'}, 
                dataType:"json",   
                success: function(data) {

                }
              });
            }
          });        
        }
    });
</script> -->

<!-- <script type="text/javascript">
  $('#is_same').on('change', function() {
    if($(this).is(':checked')) {
      if($('#user_id').val()) {
        var user_id = $('#user_id').val();

        $.ajax({
          type: 'post',
          url: '{{url('/data_billing')}}',
          data: {id: user_id, type: 'data_billing'}, 
          dataType:"json",   
          success: function(data) {
            if(data['error'] == 1) {
              $('#s_firstname').val(data['user']['first_name']);
              $('#s_last_name').val(data['user']['last_name']);
              $('#contact_no').val(data['user']['phone']);
              $('#s_landmark').val(data['user']['landmark']);
              $('#address').val(data['user']['address1'] + ',' + data['user']['address2']);
              $('#s_pincode').val(data['user']['pincode']);
              $('#s_country').val(data['user']['country']);
              $('#s_state').val(data['user']['state']);
              $('#s_city').val(data['user']['city']);
            } else {
              $.confirm({
                  title: '',
                  content: 'Please You Have Enter Manually!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'red',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Enter Manually!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    } else {
      if($('#user_id').val()) {
        var user_id = $('#user_id').val();

        $.ajax({
          type: 'post',
          url: '{{url('/data_billing')}}',
          data: {id: user_id, type: 'data_shipping'}, 
          dataType:"json",   
          success: function(data) {
            if(data['error'] == 1) {
              $('#s_firstname').val(data['user']['first_name']);
              $('#s_last_name').val(data['user']['last_name']);
              $('#contact_no').val(data['user']['contact_no']);
              $('#s_landmark').val(data['user']['landmark']);
              $('#address').val(data['user']['address']);
              $('#s_pincode').val(data['user']['pincode']);
              $('#s_country').val(data['user']['country']);
              $('#s_state').val(data['user']['state']);
              $('#s_city').val(data['user']['city']);
            } else {
              $.confirm({
                  title: '',
                  content: 'Please You Have Enter Manually!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'red',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Enter Manually!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    }
  });
</script> -->

@if (isset($items) && count($items) != 0)
 <!--  <script type="text/javascript">
    $(document).ready(function() {
      var country = $('#country').val();
      var state = $('#old_state').val();

      var s_country = $('#s_country').val();
      var s_state = $('#s_old_state').val();
      if(country != 0) {
        $.ajax({
          type: 'post',
          url: '{{url('/select_state')}}',
          data: {country: country, state: state, type: 'state'},
          success: function(data){
            if(data){
              $("#state").html(data);
              $("#state").removeAttr("disabled");

              var st = $('#state').val();
              var city = $('#old_city').val();
              if(st) {
                  $.ajax({
                      type: 'post',
                      url: '{{url('/select_city')}}',
                      data: {st: st, city: city, type: 'city'},
                      success: function(data){
                          if(data){
                              $("#city").html(data);
                              $("#city").removeAttr("disabled");
                          } else {
                              $.confirm({
                                  title: '',
                                  content: 'Please Select State!',
                                  icon: 'fa fa-ban',
                                  theme: 'modern',
                                  closeIcon: true,
                                  animation: 'scale',
                                  type: 'blue',
                                  buttons: {
                                      Ok: function(){
                                      }
                                  }
                              });
                              $("#city").prop("disabled", true);
                          }
                      }
                  });
              } else {
                $.confirm({
                    title: '',
                    content: 'Please Select State!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
              }
            } else {
              $.confirm({
                  title: '',
                  content: 'Please Select Country!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'blue',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
              $("#state").prop("disabled", true);
              $("#city").prop("disabled", true);
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }

      if(s_country != 0) {
        $.ajax({
          type: 'post',
          url: '{{url('/select_state')}}',
          data: {country: s_country, state: s_state, type: 'state'},
          success: function(data){
            if(data){
              $("#s_state").html(data);
              $("#s_state").removeAttr("disabled");

              var s_st = $('#s_state').val();
              var s_city = $('#s_old_city').val();
              if(s_st) {
                  $.ajax({
                      type: 'post',
                      url: '{{url('/select_city')}}',
                      data: {st: s_st, city: s_city, type: 'city'},
                      success: function(data){
                          if(data){
                              $("#s_city").html(data);
                              $("#s_city").removeAttr("disabled");
                          } else {
                              $.confirm({
                                  title: '',
                                  content: 'Please Select State!',
                                  icon: 'fa fa-ban',
                                  theme: 'modern',
                                  closeIcon: true,
                                  animation: 'scale',
                                  type: 'blue',
                                  buttons: {
                                      Ok: function(){
                                      }
                                  }
                              });
                              $("#s_city").prop("disabled", true);
                          }
                      }
                  });
              } else {
                $.confirm({
                    title: '',
                    content: 'Please Select State!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
              }
            } else {
              $.confirm({
                  title: '',
                  content: 'Please Select Country!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'blue',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
              $("#state").prop("disabled", true);
              $("#city").prop("disabled", true);
            }
          }
        });
      } else {
        if($('#shipping').is(':checked')) { 
          $.confirm({
              title: '',
              content: 'Please Select Country!',
              icon: 'fa fa-ban',
              theme: 'modern',
              closeIcon: true,
              animation: 'scale',
              type: 'blue',
              buttons: {
                  Ok: function(){
                  }
              }
          });
        }
      }
    });

    $('#country').on('change',function() {
      var country = $(this).val();
      if(country) {
          $.ajax({
              type: 'post',
              url: '{{url('/select_state')}}',
              data: {country: country, type: 'state'},
              success: function(data){
                  if(data){
                      $("#state").html(data);
                      $("#state").removeAttr("disabled");
                  } else {
                      $.confirm({
                          title: '',
                          content: 'Please Select Country!',
                          icon: 'fa fa-ban',
                          theme: 'modern',
                          closeIcon: true,
                          animation: 'scale',
                          type: 'blue',
                          buttons: {
                              Ok: function(){
                              }
                          }
                      });
                      $("#state").val(0);
                      $("#city").val(0);
                      $("#state").prop("disabled", true);
                      $("#city").prop("disabled", true);
                  }
              }
          });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#state').on('change',function() {
      var st = $(this).val();
      if(st) {
        $.ajax({
            type: 'post',
            url: '{{url('/select_city')}}',
            data: {st: st, type: 'city'},
            success: function(data){
                if(data){
                    $("#city").html(data);
                    $("#city").removeAttr("disabled");
                } else {
                    $.confirm({
                        title: '',
                        content: 'Please Select State!',
                        icon: 'fa fa-ban',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    $("#city").val(0);
                    $("#city").prop("disabled", true);
                }
            }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select State!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#s_country').on('change',function() {
      var country = $(this).val();
      if(country) {
          $.ajax({
              type: 'post',
              url: '{{url('/select_state')}}',
              data: {country: country, type: 'state'},
              success: function(data){
                  if(data){
                      $("#s_state").html(data);
                      $("#s_state").removeAttr("disabled");
                  } else {
                      $.confirm({
                          title: '',
                          content: 'Please Select Country!',
                          icon: 'fa fa-ban',
                          theme: 'modern',
                          closeIcon: true,
                          animation: 'scale',
                          type: 'blue',
                          buttons: {
                              Ok: function(){
                              }
                          }
                      });
                      $("#s_state").val(0);
                      $("#s_city").val(0);
                      $("#s_state").prop("disabled", true);
                      $("#s_city").prop("disabled", true);
                  }
              }
          });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#s_state').on('change',function() {
      var st = $(this).val();
      if(st) {
        $.ajax({
            type: 'post',
            url: '{{url('/select_city')}}',
            data: {st: st, type: 'city'},
            success: function(data){
                if(data){
                    $("#s_city").html(data);
                    $("#s_city").removeAttr("disabled");
                } else {
                    $.confirm({
                        title: '',
                        content: 'Please Select State!',
                        icon: 'fa fa-ban',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    $("#s_city").val(0);
                    $("#s_city").prop("disabled", true);
                }
            }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select State!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });
  </script> -->
  


@endif
@endsection