<div class="gj_left_menu">
    <div id="gj_left" class="slider-parent active">
        <!-- <div class="media user-media well-small">
            <div class="media-body">
                <h5 class="media-heading">Merchants</h5>
            </div>
            <br>
        </div> -->
        <?php 
            $value = session()->get('user'); 
        ?>
        @if($value)
            @if($value->user_type == 1)
                <ul id="gj_menu" class="">
                    <li class="panel active">
                        <a href="{{ route('manage_coupons') }}">
                            <i class="fa fa-ticket"></i> Manage Coupon
                       </a>                   
                    </li>
                    
                    <li class="panel active">
                        <a href="{{ route('add_coupons') }}">
                            <i class="fa fa-tag"></i> Add Coupon
                       </a>                   
                    </li>
                    <li class="panel active">
                        <a href="{{ route('view_coupons') }}">
                            <i class="fa fa-tag"></i> Coupon Usage Report
                       </a>                   
                    </li>

                    
                    <!--<li class="panel">-->
                    <!--    <a href="{{ route('feedbacks') }}">-->
                    <!--        <i class="fa fa-comments-o"></i> Manage Feed Back-->
                    <!--    </a>                   -->
                    <!--</li>-->
                </ul>
            @elseif($value->user_type == 2 || $value->user_type == 3)
                <ul id="gj_menu" class="">
                    <li class="panel active">
                        <a href="{{ route('manage_coupons') }}">
                            <i class="fa fa-users"></i> Manage Coupon
                       </a>                   
                    </li>

                </ul>
            @endif
        @endif
    </div>
</div>