@php
    $statusText = function ($status) {
        return [
            0 => 'Order Pending',
            1 => 'Order Placed',
            2 => 'Order Dispatched',
            3 => 'Order Delivered',
            4 => 'Order Complete',
            5 => 'Order Cancelled',
        ][$status] ?? '------';
    };

    $paymentStatus = function ($status) {
        return [
            0 => 'Pending',
            1 => 'Paid',
            2 => 'Failed',
        ][$status] ?? 'Pending';
    };

    $returnStatus = function ($status) {
        return [
            0 => '------',
            1 => 'Order Return Initialized',
            2 => 'Order Return Confirmed',
            3 => 'Order Return Cancelled',
        ][$status] ?? '------';
    };

    $details = collect($orders->details ?? []);
    $taxTotal = $details->sum('tax_amount');
@endphp

@extends('layouts.frontend')
@section('title', 'View Order')

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">

@section('content')
<section class="section-padding bg-section">
    <div class="container" style="overflow-x: auto;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="view-order-container">
                    <h3>
                        View Order
                        <div class="back-to-order">
                            <a href="{{ route('my_account', ['tab' => 'myOrders']) }}"><i class="fa-solid fa-arrow-left"></i></a>
                        </div>
                    </h3>

                    @if($orders)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="view-order-details-top">
                                    <p>Contact Person : <span>{{ $orders->contact_person ?: '------' }}</span></p>
                                    <p>Contact No : <span>{{ $orders->contact_no ?: '------' }}</span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Total Items : <span>{{ $orders->total_items ?: $details->sum('qty') }}</span></li>
                                            <li>Order Code : <span>{{ $orders->order_code ?: ('Order' . str_pad($orders->id, 5, '0', STR_PAD_LEFT)) }}</span></li>
                                            <li>Order Status : <span>{{ $orders->order_status_text ?? $statusText((int) $orders->order_status) }}</span></li>
                                            <li>Order Date : <span>{{ $orders->order_date ? date('d-m-Y', strtotime($orders->order_date)) : date('d-m-Y', strtotime($orders->created_at)) }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Estimate Delivery Date : <span>{{ $orders->delivery_date ? date('d-m-Y', strtotime($orders->delivery_date)) : '------' }}</span></li>
                                            <li>Delivery Status : <span>{{ $orders->delivery_status ?: '------' }}</span></li>
                                            <li>Payment Mode : <span>{{ $orders->payment_mode ?: '------' }}</span></li>
                                            <li>Payment Status : <span class="badge bg-warning">{{ $paymentStatus((int) $orders->payment_status) }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Return Order Status : <span>{{ $returnStatus((int) $orders->return_order_status) }}</span></li>
                                            <li>Reference Order : <span>{{ optional($orders->Reference)->order_code ?? '------' }}</span></li>
                                            <li>Replace Order : <span>{{ $orders->replace_order ?: 'No' }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>COD Charge : <span>{{ number_format((float) ($orders->cod_charge ?? 0), 2) }}</span></li>
                                            <li>Tax Amount : <span>{{ number_format((float) $taxTotal, 2) }}</span></li>
                                            <li>Net Amount : <span>Rs. {{ number_format((float) ($orders->net_amount ?? 0), 2) }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="view-order-details-top">
                                <p>Discount : <span>{{ $orders->discount_flag ?: '------' }}</span></p>
                                <p>Discount Rate : <span>Rs. {{ number_format((float) ($orders->discount ?? 0), 2) }}</span></p>
                            </div>
                        </div>

                        <div class="view-order-bottom">
                            <div class="over-scrol">
                                <table class="table order-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Items</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Tax</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($details as $detail)
                                            <tr>
                                                <td>{{ optional($detail->Products)->product_title ?? $detail->product_title ?? 'Product' }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td>Rs. {{ number_format((float) ($detail->unitprice ?? 0), 2) }}</td>
                                                <td>Rs. {{ number_format((float) ($detail->tax_amount ?? 0), 2) }}</td>
                                                <td>Rs. {{ number_format((float) ($detail->totalprice ?? 0), 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No order items found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="view-order-bottom">
                            <label>Shipping Address</label>
                            <p>{{ $orders->shipping_address ?: '------' }}</p>
                            <p><strong>Shipping Charge : </strong>{{ number_format((float) ($orders->shipping_charge ?? 0), 2) }}</p>
                        </div>

                        <div class="view-order-bottom">
                            <label>Remarks</label>
                            <p>{{ $orders->remarks ?: 'No content' }}</p>
                        </div>
                    @else
                        <p class="text-center mb-0">Order not found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
