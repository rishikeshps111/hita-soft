<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->invoice_no }}</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f9fafc;
            color: #333;
        }

        .invoice-box {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 25px;
            border: 1px solid #dcdcdc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
        }



        .footer {
            margin-top: 60px;
            font-size: 12px;
            color: #555;
            text-align: center;
        }

        .terms {
            margin-top: 30px;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        /* .invoice-box .header{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
        } */
        .invoice-box h1 {
            font-size: 29px;
            color: #000;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .invoice-box h3 {
            font-size: 16px;
            color: #7e7e7e;
        }

        /* .invoice-box .header p{
            text-align: end;
            width: 100%;
            font-weight: 600;
            font-size: 15px;
        } */
        .section-top {
            padding: 10px 0;
        }

        /* .section-top ul{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        } */
        .section-top ul li {
            font-size: 15px;
            font-weight: 600;
        }

        .section-top ul li span {
            font-weight: 400;
        }

        .section-info-dt {
            width: 49%;
            border: 1px solid #b9b8b8;
            border-radius: 7px;
            overflow: hidden;
        }

        .section-info-dt h3 {
            background-color: #B73182;
            color: #fff;
            padding: 10px;
        }

        .section-info-dt ul {
            margin: 0;
            padding: 0;
            padding-left: 20px;
            list-style: none;
        }

        .section-info-dt ul li {
            margin: 10px 0;
            font-size: 15px;
        }

        .section-table table {
            border-collapse: collapse;
        }

        .section-table table tr th {
            background-color: #B73182;
            color: #fff;
            padding: 7px;
            font-weight: 500;
            border: 1px solid #ccc;
            text-align: center;
        }

        .section-table table tr td {
            padding: 10px;
            border: 1px solid #ccc !important;
            font-size: 15px;
            text-align: center;

        }

        .summary-info {
            padding: 10px 0;
            /* padding-top: 20px; */
        }

        .summary-info ul {
            width: 50%;
            margin: 0;
            padding: 0;
            margin-left: auto;
            list-style: none;
        }

        .summary-info ul li {
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

   
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">

            <h1>INVOICE</h1>
            <h3><a href="{{route('home')}}">RANG BY BHAVANA </a></h3>
            
        </div>

        <div class="section-top">
            <ul class="invoice-flex-ul"
                style="  margin: 0;  padding: 0;   list-style: none;">
                <li class="invoice-top-li" style="width: 100%;  ">Invoice No : <span>{{ $order->invoice_no
                        }}</span></li>
                <li class="invoice-top-li" style="width: 100%;  ">Order Code : <span>{{ $order->order_code
                        }}</span></li>
                <li class="invoice-top-li" style=" width: 100%; margin-top: 5px; ">Invoice Date : <span> {{
                        $order->invoice_date }}</span></li>
                <li class="invoice-top-li" style=" width: 100%; margin-top: 5px; ">Bill Date : <span> {{
                    $order->invoice_date }}</span></li>
                 
                <li class="invoice-top-li" style=" width: 100%; margin-top: 5px; ">Payment Mode : <span>  @if($order->payment_mode == 0)
                                            {{'------'}}
                                        @elseif ($order->payment_mode == 1)
                                            {{'Cash On Delivery'}}
                                        @elseif ($order->payment_mode == 2)
                                            {{'PhonePe'}}
                                        @elseif ($order->payment_mode == 3)
                                            {{'Cash On Pickup'}}
                                        @elseif ($order->payment_mode == 4)
                                            {{'Easebuzz'}}
                                        @else
                                            {{'------'}}
                                        @endif</span></li>   

            </ul>

        </div>

        <div class="section-info" style="  display: unset;  justify-content: space-between;  padding: 10px 0;">
            <div class="section-info-dt" style="width: 100%; margin: 10px 0;">
                <h3>Bill To</h3>
                <ul>
                    <li><b>{{ $user->full_name }}</b></li>
                    <li> {{ $order->shipping_address ?? 'N/A' }}</li>
                    <li> {{ $user->email }}</li>
                    <li> {{ $user->phone }}</li>
                </ul>

            </div>
            <div class="section-info-dt" style="width: 100%;margin-left: auto; margin-bottom: 10px;">
                <h3>Ship To</h3>
                <ul>
                    <li>{{ $order->shipping_address ?? 'N/A' }}</li>
                    <li> {{ $user->phone }}</li>
                </ul>

            </div>

        </div>

        <div class="section-table">
            <!--<h3>Order Summary</h3>-->
            <table class="items-table" style="width: 100%;">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        <th>Item & Description</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Tax Amount</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($order->orderDetails as $item) 
    
                    <tr>
                        <!--<td> -->
                        <!--    @if($item->Products->featured_product_img)-->
                                
                        <!--            <img src="{{base_path($product_path.'/'.$item->Products->featured_product_img)}}" -->
                        <!--                 alt="{{ $item->product_title }}" -->
                        <!--                 style="max-width:150px;">-->
                                
                        <!--    @endif-->
                        <!--</td>-->
                        <td>{{ $item->product_title ?? '-' }}</td> 
                        <td>{{ $item->order_qty }}</td>
                        <td>{{ number_format($item->unitprice, 2) }}</td>
                        <td>{{ number_format($order->tax_amount, 2)}}</td>
                        <td>{{ number_format($item->totalprice, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="summary-info">
            <ul style="width: 40%;">
                <li>Subtotal : <span style="display: flex; margin-left: auto;">{{ number_format($order->total_amount, 2)
                        }}</span></li>
               {{-- <li>Tax ({{ $order->tax_percent ?? '-' }}) : <span style="display: flex; margin-left: auto;">{{
                        number_format($order->tax_amount, 2) }}</span></li> --}}
                <li>Shipping : <span style="display: flex; margin-left: auto;">{{ number_format($order->shipping_charge,
                        2) }}</span></li>
                <li>Total : <span style="display: flex; margin-left: auto;">{{ number_format($order->net_amount, 2)
                        }}</span></li>
            </ul>
        </div>



        <!--<div class="terms">-->
        <!--    <strong>Terms & Conditions:</strong><br>-->
        <!--    All payments are due upon receipt of this invoice. Late payments may be subject to interest as per applicable laws.-->
        <!--</div>-->

        <div class="footer">
            Thank you for shopping with us!
        </div>
    </div>
</body>

</html>