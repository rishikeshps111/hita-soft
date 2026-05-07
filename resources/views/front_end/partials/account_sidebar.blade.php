@php
    $dashboardUser = session()->get('user');
    $dashboardName = 'My Account';

    if ($dashboardUser) {
        $dashboardName = trim(($dashboardUser->full_name ?? '') ?: trim(($dashboardUser->first_name ?? '') . ' ' . ($dashboardUser->last_name ?? '')));
        $dashboardName = $dashboardName !== '' ? $dashboardName : 'My Account';
    }

    $dashboardImage = asset('assets/img/user.jpg');
    $profilePath = 'images/profile_img';
    $noImagePath = 'images/noimage';
    $noImageSetting = \DB::table('noimage_settings')->first();

    if ($dashboardUser && !empty($dashboardUser->profile_img)) {
        $dashboardImage = asset($profilePath . '/' . $dashboardUser->profile_img);
    } elseif ($noImageSetting && !empty($noImageSetting->profile_no_img)) {
        $dashboardImage = asset($noImagePath . '/' . $noImageSetting->profile_no_img);
    }

    $activeDashboardTab = $activeDashboardTab ?? request('tab', 'profile');
@endphp

<div class="user-profile-preview">
    <img src="{{ $dashboardImage }}" alt="{{ $dashboardName }}">
    <h3>{{ $dashboardName }}</h3>
    <p>{{ $dashboardUser->email ?? '' }}</p>
</div>

<div class="user-dashboard-sidebar">
    <ul>
        <li>
            <a href="{{ route('my_account', ['tab' => 'profile']) }}"
                class="{{ $activeDashboardTab === 'profile' ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        </li>
        <li>
            <a href="{{ route('my_account', ['tab' => 'myAddress']) }}"
                class="{{ $activeDashboardTab === 'myAddress' ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Manage Address
            </a>
        </li>
        <li>
            <a href="{{ route('my_account', ['tab' => 'changePassword']) }}"
                class="{{ $activeDashboardTab === 'changePassword' ? 'active' : '' }}">
                <i class="fa-solid fa-lock"></i> Change Password
            </a>
        </li>
        <li>
            <a href="{{ route('my_account', ['tab' => 'myOrders']) }}"
                class="{{ $activeDashboardTab === 'myOrders' ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> My Orders
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fa-solid fa-comments"></i> Contact Admin
            </a>
        </li>
        <li>
            <a href="#!" data-bs-toggle="modal" data-bs-target="#logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </li>
    </ul>
</div>

<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="logoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="logout-title">Are you sure ?</h3>
            </div>
            <div class="logout-modal-footer">
                <button type="button" data-bs-dismiss="modal">No</button>
                <a href="{{ route('logout') }}">Yes</a>
            </div>
        </div>
    </div>
</div>
