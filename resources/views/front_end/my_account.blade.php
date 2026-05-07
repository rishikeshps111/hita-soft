@php
    $user = $user_data ?? session()->get('user');
    $activeTab = request('tab', 'profile');
    $activeTab = in_array($activeTab, ['profile', 'myAddress', 'changePassword', 'myOrders']) ? $activeTab : 'profile';

    $fullName = trim(($user->full_name ?? '') ?: trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')));
    $firstName = $user->first_name ?? '';
    $lastName = $user->last_name ?? '';

    if ($fullName && !$firstName && !$lastName) {
        $parts = explode(' ', $fullName, 2);
        $firstName = $parts[0] ?? '';
        $lastName = $parts[1] ?? '';
    }

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

    $allOrders = collect($orders ?? [])
        ->merge(collect($past_orders ?? []))
        ->merge(collect($cancel_orders ?? []))
        ->sortByDesc('id');
@endphp

@extends('layouts.frontend')
@section('title', 'My Account')

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">

@section('content')
<section class="section-padding">
    <div class="container">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }} auto-dismiss">
                {{ Session::get('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger auto-dismiss">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-lg-3">
                @include('front_end.partials.account_sidebar', ['activeDashboardTab' => $activeTab])
            </div>

            <div class="col-lg-9">
                @if($activeTab === 'profile')
                    <div class="profile-container">
                        <div class="row">
                            <div class="account-top-btns">
                                <h3>Profile</h3>
                            </div>
                        </div>

                        <form action="{{ route('update_profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <div class="profile-field">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="full_name" class="form-control shadow-none" placeholder="Enter Your Name" value="{{ old('full_name', $fullName) }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="profile-field">
                                        <label>Gender</label>
                                        <select name="gender" class="form-select shadow-none">
                                            <option value="">---Select---</option>
                                            <option value="Male" {{ old('gender', $user->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $user->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="profile-field">
                                        <label>Customer Type</label>
                                        <select name="customer_type" class="form-select shadow-none">
                                            <option value="">---Select---</option>
                                            <option value="Wholesale" {{ old('customer_type', $user->customer_type ?? '') == 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                                            <option value="Retail" {{ old('customer_type', $user->customer_type ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>Contact No <span class="text-danger">*</span></label>
                                        <div class="country-code">
                                            <span>
                                                <select class="form-select shadow-none">
                                                    <option value="+91">+91</option>
                                                </select>
                                            </span>
                                            <input type="text" name="phone" class="form-control shadow-none" placeholder="Enter Your Phone" value="{{ old('phone', $user->phone ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>Alternate Contact No</label>
                                        <div class="country-code">
                                            <span>
                                                <select class="form-select shadow-none">
                                                    <option value="+91">+91</option>
                                                </select>
                                            </span>
                                            <input type="text" name="phone2" class="form-control shadow-none" placeholder="Enter Alternate Phone" value="{{ old('phone2', $user->phone2 ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="profile-field">
                                        <label>E-mail <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control shadow-none" placeholder="Enter Your Email" value="{{ old('email', $user->email ?? '') }}">
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>Date of Birth</label>
                                        <input type="date" name="dob" class="form-control shadow-none" value="{{ old('dob', $user->dob ?? '') }}" max="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" class="form-control shadow-none" placeholder="Enter Your Pincode" value="{{ old('pincode', $user->pincode ?? '') }}" maxlength="6" pattern="[0-9]{6}" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="profile-field">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea name="address1" class="form-control shadow-none" placeholder="(House No, Building, Street, Area)">{{ old('address1', $user->address1 ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="profile-field">
                                        <label>City / Locality</label>
                                        <input type="text" name="address2" class="form-control shadow-none" placeholder="Enter City or Locality" value="{{ old('address2', $user->address2 ?? '') }}">
                                    </div>
                                </div> -->
                                <div class="col-lg-12 mb-3">
                                    <div class="profile-field">
                                        <label>Upload Profile image <span class="text-danger">image size must be 250 x 200 pixels</span></label>
                                        <input type="file" name="profile_img" class="form-control shadow-none p_0" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="profile-sub-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @elseif($activeTab === 'myAddress')
                    <div class="profile-container">
                        <div class="row">
                            <div class="account-top-btns">
                                <h3 class="d-flex justify-content-between align-items-center">
                                    My Address
                                    <a href="#!" data-bs-toggle="modal" data-bs-target="#AddressModal" class="add-address-btn" id="addAddressButton">Add new address</a>
                                </h3>
                            </div>
                        </div>

                        <div class="row">
                            @forelse($address as $item)
                                <div class="col-lg-12 mb-3">
                                    <div class="address-container">
                                        <div class="address-icon">
                                            <i class="fa-solid fa-house"></i>
                                        </div>
                                        <div class="address-dt">
                                            <h3>
                                                {{ $item->title ?: $item->address_type }}
                                                @if($item->is_default)
                                                    <a href="#!" class="active">Default</a>
                                                @else
                                                    <a href="#!" class="make-default-address" data-url="{{ route('address.make_default', $item->id) }}">Make Default</a>
                                                @endif
                                            </h3>
                                            <p>{{ $item->address2 }} {{ $item->address3 ? ', ' . $item->address3 : '' }} {{ $item->locality ? ', ' . $item->locality : '' }} - {{ $item->pincode }}</p>
                                            <div class="addres-dt-icons">
                                                <a href="#!" class="edit-address"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#AddressModal"
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-address2="{{ $item->address2 }}"
                                                    data-address3="{{ $item->address3 }}"
                                                    data-locality="{{ $item->locality }}"
                                                    data-pincode="{{ $item->pincode }}"
                                                    data-default="{{ $item->is_default }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="{{ route('address.delete', $item->id) }}" class="delete-address"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12">
                                    <div class="address-container">
                                        <div class="address-dt">
                                            <h3>No saved addresses</h3>
                                            <p>Add a shipping address to speed up checkout.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @elseif($activeTab === 'changePassword')
                    <div class="profile-container">
                        <div class="row">
                            <div class="account-top-btns">
                                <h3>Change Password</h3>
                            </div>
                        </div>

                        <form action="{{ route('check_forgot') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="profile-field">
                                        <label>Current Password <span class="text-danger">*</span></label>
                                        <input type="password" name="current_password" class="form-control shadow-none" placeholder="Enter Current Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>New Password <span class="text-danger">*</span></label>
                                        <input type="password" name="new_password" class="form-control shadow-none" placeholder="Enter New Password">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="profile-field">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="confirm_password" class="form-control shadow-none" placeholder="Enter Confirm Password">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="profile-sub-btn">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="profile-container">
                        <div class="row">
                            <div class="account-top-btns">
                                <h3>My Orders</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="over-scrol">
                                    <table class="table order-table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Order Date</th>
                                                <th>Order Status</th>
                                                <th>Estimated <br>Delivery Date</th>
                                                <th>Quantity</th>
                                                <th>Total Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($allOrders as $order)
                                                @php
                                                    $qty = $order->total_items ?: collect($order->details ?? [])->sum('qty');
                                                    $canCancel = (int) $order->order_status === 1 && !in_array((int) $order->cancel_approved, [2, 3]) && \Carbon\Carbon::parse($order->created_at)->diffInHours(now()) <= 24;
                                                @endphp
                                                <tr>
                                                    <td>{{ $order->order_code ?? ('Order' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }}</td>
                                                    <td class="nowrap">{{ $order->order_date ? date('d-m-Y', strtotime($order->order_date)) : date('d-m-Y', strtotime($order->created_at)) }}</td>
                                                    <td>{{ $order->order_status_text ?? $statusText((int) $order->order_status) }}</td>
                                                    <td class="nowrap">{{ $order->delivery_date ? date('d-m-Y', strtotime($order->delivery_date)) : '------' }}</td>
                                                    <td>{{ $qty ?: '0' }}</td>
                                                    <td>Rs. {{ number_format((float) ($order->net_amount ?? 0), 2) }}</td>
                                                    <td>
                                                        <div class="td-actions">
                                                            <a href="{{ route('my_track_orders', ['id' => $order->id]) }}">Track Order</a>
                                                            <a href="{{ route('my_view_orders', ['id' => $order->id]) }}">View Order</a>
                                                            @if($canCancel)
                                                                <a href="#!" class="dashboard-cancel-order" data-id="{{ $order->id }}">Cancel Order</a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Orders are empty.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="AddressModal" tabindex="-1" aria-labelledby="AddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="AddressModalLabel">My Address</h1>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="address_id" id="address_id">
                    <div class="row">
                        <div class="checkout-radio">
                            <ul class="checkout-now">
                                <li>
                                    <input type="radio" id="adHome" name="address1" value="Home">
                                    <label for="adHome">Home</label>
                                </li>
                                <li>
                                    <input type="radio" id="adOffice" name="address1" value="Office">
                                    <label for="adOffice">Office</label>
                                </li>
                                <li>
                                    <input type="radio" id="adNew" name="address1" value="New" checked>
                                    <label for="adNew">New</label>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="profile-field">
                                <label>Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="address_title" class="form-control shadow-none" placeholder="Enter Title" value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="profile-field">
                                <label>Address <span class="text-danger">*</span></label>
                                <textarea name="address2" id="address_address2" placeholder="(House No, Building, Street, Area)" class="form-control shadow-none">{{ old('address2') }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="profile-field">
                                <label>Street / Society / Office Name <span class="text-danger">*</span></label>
                                <input type="text" name="address3" id="address_address3" class="form-control shadow-none" placeholder="Street address" value="{{ old('address3') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="profile-field">
                                <label>Locality / Town <span class="text-danger">*</span></label>
                                <input type="text" name="locality" id="address_locality" class="form-control shadow-none" placeholder="Enter Your City" value="{{ old('locality') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="profile-field">
                                <label>Pincode <span class="text-danger">*</span></label>
                                <input type="number" name="pincode" id="address_pincode" class="form-control shadow-none" placeholder="Enter Your Pincode" value="{{ old('pincode') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 mb-1">
                            <div class="shiping-form-field check-field">
                                <input type="checkbox" class="form-check shadow-none" id="defaultAddress" name="default" value="1">
                                <label for="defaultAddress"> Do you make this address as default address?</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <button type="submit" class="profile-sub-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('before_scripts')
<script>
    document.querySelectorAll('.edit-address').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('address_id').value = this.dataset.id || '';
            document.getElementById('address_title').value = this.dataset.title || '';
            document.getElementById('address_address2').value = this.dataset.address2 || '';
            document.getElementById('address_address3').value = this.dataset.address3 || '';
            document.getElementById('address_locality').value = this.dataset.locality || '';
            document.getElementById('address_pincode').value = this.dataset.pincode || '';
            document.getElementById('defaultAddress').checked = this.dataset.default === '1';
        });
    });

    const addAddressButton = document.getElementById('addAddressButton');
    if (addAddressButton) {
        addAddressButton.addEventListener('click', function () {
            document.getElementById('address_id').value = '';
            document.getElementById('address_title').value = '';
            document.getElementById('address_address2').value = '';
            document.getElementById('address_address3').value = '';
            document.getElementById('address_locality').value = '';
            document.getElementById('address_pincode').value = '';
            document.getElementById('defaultAddress').checked = false;
        });
    }

    document.querySelectorAll('.make-default-address').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            fetch(this.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(function () {
                window.location.href = "{{ route('my_account', ['tab' => 'myAddress']) }}";
            });
        });
    });

    document.querySelectorAll('.delete-address').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const deleteUrl = this.href;

            Swal.fire({
                title: 'Delete address?',
                text: 'This address will be removed from your account.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'No',
                confirmButtonColor: '#0a082d',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    document.querySelectorAll('.dashboard-cancel-order').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const orderId = this.dataset.id;

            Swal.fire({
                title: 'Cancel order?',
                text: 'Are you sure you want to cancel this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel order',
                cancelButtonText: 'No',
                confirmButtonColor: '#0a082d',
                cancelButtonColor: '#6c757d'
            }).then(function (result) {
                if (!result.isConfirmed) {
                    return;
                }

                fetch("{{ route('customer_cancel_order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id: orderId, type: 'cancel' })
                }).then(function () {
                    Swal.fire({
                        title: 'Request sent',
                        text: 'Your cancellation request has been submitted.',
                        icon: 'success',
                        confirmButtonColor: '#0a082d'
                    }).then(function () {
                        window.location.href = "{{ route('my_account', ['tab' => 'myOrders']) }}";
                    });
                }).catch(function () {
                    Swal.fire({
                        title: 'Unable to cancel',
                        text: 'Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#0a082d'
                    });
                });
            });
        });
    });
</script>
@endsection
