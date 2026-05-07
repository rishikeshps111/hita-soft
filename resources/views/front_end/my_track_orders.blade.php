@php
    $orderStatus = (int) ($orders->order_status ?? 0);
    $isCancelled = $orderStatus === 5 || (int) ($orders->cancel_approved ?? 0) === 1 || !empty($orders->is_deleted);

    $trackSteps = [
        [
            'label' => 'Order Placed',
            'image' => 'assets/img/track/1.png',
            'active' => $orderStatus >= 1 && !$isCancelled,
            'date' => ($orders && $orderStatus >= 1) ? ($orders->order_date ?: $orders->created_at) : null,
            'class' => 'w__80',
        ],
        [
            'label' => 'Order Dispatched',
            'image' => 'assets/img/track/2.png',
            'active' => $orderStatus >= 2 && !$isCancelled,
            'date' => ($orders && $orderStatus >= 2) ? $orders->updated_at : null,
            'class' => 'w__80',
        ],
        [
            'label' => 'Order Delivered',
            'image' => 'assets/img/track/3.png',
            'active' => $orderStatus >= 3 && !$isCancelled,
            'date' => ($orders && $orderStatus >= 3) ? $orders->delivery_date : null,
            'class' => '',
        ],
        [
            'label' => 'Order Completed',
            'image' => 'assets/img/track/4.png',
            'active' => $orderStatus >= 4 && !$isCancelled,
            'date' => ($orders && $orderStatus >= 4) ? $orders->updated_at : null,
            'class' => '',
        ],
        [
            'label' => 'Order Cancel',
            'image' => 'assets/img/track/5.png',
            'active' => $isCancelled,
            'date' => $isCancelled ? ($orders->cancel_date ?: $orders->updated_at) : null,
            'class' => '',
        ],
    ];
@endphp

@extends('layouts.frontend')
@section('title', 'Track Order')

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">

@section('content')
<section class="section-padding bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title column-title">
                    <h3>Track Order</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="back-to-order">
                    <a href="{{ route('my_account', ['tab' => 'myOrders']) }}"><i class="fa-solid fa-arrow-left"></i></a>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="track-container">
                    @if($orders)
                        <ul>
                            @foreach($trackSteps as $step)
                                <li class="{{ $step['active'] ? 'track-active' : '' }}">
                                    <div class="track-img">
                                        <img src="{{ asset($step['image']) }}" alt="{{ $step['label'] }}" class="{{ $step['class'] }}">
                                        <p>{{ $step['label'] }}</p>
                                        <small>{{ $step['date'] ? date('d-m-Y', strtotime($step['date'])) : '--------' }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="track-bottom">
                            <p><strong>Order Date :</strong> {{ $orders->order_date ? date('l, F d, Y', strtotime($orders->order_date)) : date('l, F d, Y', strtotime($orders->created_at)) }}</p>
                            <p><strong>Estimated delivery :</strong> {{ $orders->delivery_date ? date('l, F d, Y', strtotime($orders->delivery_date)) : '------' }}</p>
                            @if(!empty($orders->shipments))
                                <p><strong>Courier :</strong> {{ $orders->shipments->courier_name ?? '------' }}</p>
                                <p><strong>Tracking No :</strong> {{ $orders->shipments->tracking_id ?? '------' }}</p>
                            @endif
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
