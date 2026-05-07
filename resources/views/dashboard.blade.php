@extends('layouts.master')
@section('title', 'Dashboard')
@section('sidebar')
    @parent
    <p>This refers to the master sidebar.</p>
@endsection
@section('content')
<div class="container dash-cont" >
    <div class="row">
        <div class="col-lg-12">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="gj_box card-cs-ad">
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-dashboard"></i></div>-->
                <!--    <h5 class="gj_heading"> Dashboard </h5>-->
                <!--</header>-->
                <h3>Dashboard</h3>

                <div class="col-lg-12 px_0 ">
                    <div class="gj_dbd_items text-center dash-container">          
                    <div class="row">
                       
                         <div class="col-lg-4 mb-3">
                               <a class="text-none" href="{{ route('all_orders') }}">
                                   <div class="custom-dashboard-card dashcard1">
                                        <div class="custom-card-left bg__3">
                                           <i class="fa-solid fa-file-pen"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Total Orders</h3>
                                                <span class="label label-warning">{{$total_odr['cnt']}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div>
                        {{--    <div class="col-lg-4 mb-3">
                               <a class="text-none" href="{{ route('custom_orders') }}">
                                   <div class="custom-dashboard-card dashcard2">
                                        <div class="custom-card-left bg__2">
                                            <i class="fa-solid fa-chalkboard-user"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Custom Orders</h3>
                                                <span class="label label-warning">{{$custom_odr['cnt']}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div> --}}
                        
                          <div class="col-lg-4 mb-3">
                               <a class="text-none" href="{{ route('all_orders') }}">
                                   <div class="custom-dashboard-card dashcard3">
                                        <div class="custom-card-left bg__4">
                                           <i class="fa-solid fa-house-flag"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Order Placed</h3>
                                                <span class="label label-warning">{{$place_odr['cnt']}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div>
                          <div class="col-lg-4 mb-3" >
                               <a class="text-none" href="{{ route('all_orders') }}" >
                                    <div class="custom-dashboard-card dashcard2">
                                        <div class="custom-card-left bg__2">
                                           <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Orders Completed</h3>
                                               <span class="label btn_metis_2">{{$complete_odr['cnt']}}</span>
                                         </div>
                                   </div>
                        
                          
                        </a> 
                          </div>
                          
                          <div class="col-lg-4 mb-3" style="margin-top:10px;">
                               <a class="text-none" href="{{ route('cancel_all_orders') }}" >
                                    <div class="custom-dashboard-card dashcard4">
                                        <div class="custom-card-left bg__1">
                                           <i class="fa-solid fa-circle-check"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Orders Cancelled</h3>
                                               <span class="label btn_metis_2">{{$cancel_odr['cnt']}}</span>
                                         </div>
                                   </div>
                        
                          
                        </a> 
                          </div>
                          
                           <div class="col-lg-4 mb-3" style="margin-top:10px;">
                               <a class="text-none" href="{{ route('cancel_req_orders') }}">
                                   <div class="custom-dashboard-card dashcard1">
                                        <div class="custom-card-left bg__3">
                                           <i class="fa-solid fa-file-pen"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Cancel Order Requests</h3>
                                                <span class="label label-warning">{{$cancel_odr_req['cnt']}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div>
                          
                          <div class="col-lg-4 mb-3 " style="margin-top:10px;">
                               <a class="text-none" href="{{ route('all_orders') }}">
                                   <div class="custom-dashboard-card dashcard3">
                                        <div class="custom-card-left bg__4">
                                           <i class="fa-solid fa-indian-rupee-sign"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Total Sales</h3>
                                                <span class="label label-warning">{{$total_sales_sum}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div>
                          
                        {{--  <div class="col-lg-4 mb-3 " style="margin-top:10px;">
                               <a class="text-none" href="{{ route('all_orders') }}">
                                   <div class="custom-dashboard-card dashcard1">
                                        <div class="custom-card-left bg__3">
                                           <i class="fa-solid fa-indian-rupee-sign"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Total Profit</h3>
                                                <span class="label label-warning">{{$totalProfit}}</span>
                                         </div>
                                   </div>
                        </a>
                          </div>
                          
                           <div class="col-lg-4 mb-3 " style="margin-top:10px;">
                               <a class="text-none" href="{{ route('custom_orders') }}">
                                   <div class="custom-dashboard-card dashcard2">
                                        <div class="custom-card-left bg__2">
                                           <i class="fa-solid fa-indian-rupee-sign"></i>
                                        </div>
                                         <div class="custom-card-right">
                                             <h3>Total Custom Order Profit</h3>
                                                <span class="label label-warning">{{$customOrderProfit}}</span>
                                         </div>
                                   </div>
                                </a>
                          </div> --}}
                          
                          <div class="col-lg-12">
                              <hr>
                          </div>
                          
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-lg-3 mb-3">
                               <a class=" active text-none" href="{{ route('manage_product') }}">
                            <div class="dashboard-card-three">
                               
                                <div class="custom-card-right">
                                    <h3>Active Products </h3>
                                       <span class="label label-danger">{{$active_products['cnt']}}</span>
                                </div>
                                 <div class="custom-card-left bg__1">
                                 <i class="fa-solid fa-ring"></i>
                                </div>
                            </div>
                            
                            
                         
                        </a>
                        </div>
                         <div class="col-lg-3 mb-3" >
                                                                                             
                        <a class="text-none" href="{{ route('manage_user') }}">
                              <div class="dashboard-card-three">
                                  
                                         <div class="custom-card-right">
                                             <h3>Registered Customers</h3>
                                            <span class="label label-danger">{{$customers['cnt']}}</span>
                                         </div>
                                          <div class="custom-card-left bg__2">
                                          <i class="fa-solid fa-users"></i>
                                        </div>
                              </div>
                           
                          
                           
                        </a>
                          </div>
                          
                          <div class="col-lg-3 mb-3">
                                                                                             
                        <a class="text-none" href="{{ route('manage_enquiries') }}">
                              <div class="dashboard-card-three">
                                  
                                         <div class="custom-card-right">
                                             <h3>Enquiry</h3>
                                            <span class="label label-primary">{{$enquiries['cnt']}}</span>
                                         </div>
                                          <div class="custom-card-left bg__3">
                                         <i class="fa-solid fa-circle-question"></i>
                                        </div>
                              </div>
                           
                          
                           
                        </a>
                          </div>
                          
                          <div class="col-lg-3 mb-3" >
                               <a class=" active text-none" href="{{ route('all_transaction') }}">
                            <div class="dashboard-card-three">
                               
                                <div class="custom-card-right">
                                    <h3>Transactions</h3>
                                       <span class="label label-danger">{{$transaction['cnt']}}</span>
                                </div>
                                 <div class="custom-card-left bg__4">
                                   <i class="fa-solid fa-indian-rupee-sign"></i>
                                </div>
                            </div>
                            
                            
                         
                        </a>
                        </div>
                    </div>
                  
                    
                     
                     
                        <!--<a class="gj_quick_btn1" href="{{ route('manage_offer') }}">-->
                        <!--    <i class="fa fa-minus-square-o fa-2x"></i>-->
                        <!--    <span> Offers  </span>-->
                        <!--    <span class="label label-success">{{$offers['cnt']}}</span>-->
                        <!--</a> -->
                       
                      
                        
                        <!--<a class="gj_quick_btn1" href="{{ route('manage_merchant') }}">-->
                        <!--    <i class="fa fa-check-square-o fa-2x"></i>-->
                        <!--    <span> Merchants  </span>-->
                        <!--    <span class="label label-danger">{{$merchant['cnt']}} </span>-->
                        <!--</a>-->
                        
                        <!--<a class="gj_quick_btn1" href="{{ route('manage_merchant') }}">-->
                        <!--    <i class="fa fa-check-square-o fa-2x"></i>-->
                        <!--    <span> Stores  </span>-->
                        <!--    <span class="label label-danger">{{$store['cnt']}}</span>-->
                        <!--</a>-->

                        <!--<a class="gj_quick_btn1" href="{{ route('manage_enquiries') }}">-->
                        <!--    <i class="fa fa-check-square-o fa-2x"></i>-->
                        <!--    <span> Client Enquiry  </span>-->
                        <!--    <span class="label label-danger">{{$enquiries['cnt']}} </span>-->
                        <!--</a> -->
                    </div>
                        
                    <!--<div style="height:30px"></div>-->
                </div>
            </div>

            <!--<div class="row">-->
            <!--    <div class="col-lg-12">-->
            <!--        <a style="color:#fff" href="{{ route('home') }}" target="_blank"><button class="btn btn-success btn-sm btn-grad" style="margin-bottom:10px;"> Go to Live  </button></a>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="gj_box dark gj_next_box">
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-edit"></i></div>-->
                <!--    <h5 class="gj_heading"> Users  </h5>-->
                <!--</header>-->

                <!--<div class="row gj_row">-->
                <!--    <div class="col-md-12">-->
                <!--        <div class="gj_hd_lastyear_div">-->
                <!--            <p class="gj_hd_lastyear"> Last One Year Users Details </p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <div class="row gj_row">
                    <div class="col-md-12">
                        <div class="gj_stat_div">
                            <div id="gj_tot_stat_bar" class="gj_tot_stat_bar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gj_box dark gj_next_box">
                <div class="chart-box">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="gj_box dark gj_inside_box chart-inner-box">
                             <h3 class="gj_heading"> Total Customers  </h3>

                            <div class="gj_tot_cus_pie">
                                <div id="gj_tot_customers_pie" class="gj_tot_customers_pie"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                             <div class="gj_box dark gj_inside_box chart-inner-box">
                           <h3 class="gj_heading"> Total Products  </h3>

                            <div class="gj_tot_pdt_pie">
                                <div id="gj_tot_products_pie" class="gj_tot_products_pie"></div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-lg-6 mb-3" style="margin-top:10px;">
                            <div class="gj_box dark gj_inside_box chart-inner-box">
                               <h3 class="gj_heading"> Product Count by Category</h3>
    
                                <div class="gj_tot_pdt_pie">
                                    <div id="gj_category_product_pie" class="gj_category_product_pie"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mb-3" style="margin-top:10px;">
                            <div class="gj_box dark gj_inside_box chart-inner-box">
                               <h3 class="gj_heading">Order Count by Category</h3>
    
                                <div class="gj_tot_pdt_pie">
                                    <div id="orderPieChart" class="orderPieChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>

        <div class="gj_box dark gj_next_box">
    <div class="chart-box">
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div class="chart-inner-box">

                    <div class="title-between">
                        <h3 class="gj_heading">Transactions</h3>
                        <div class="gj_hd_lastyear_div">
                            <p class="gj_hd_lastyear">Transactions Report</p>
                        </div>
                    </div>

                    {{-- 🔹 Date Range Filter --}}
                    <form method="GET" class="mb-3" id="transFilterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label>From Month</label>
                                <input type="month" name="from" class="form-control"
                                       value="{{ request('from', '2023-01') }}">
                            </div>
                            <div class="col-md-3">
                                <label>To Month</label>
                                <input type="month" name="to" class="form-control"
                                       value="{{ request('to', date('Y-m')) }}">
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Show Report</button>
                            </div>
                        </div>
                    </form>

                    <div class="gj_trans_div">
                        <div id="gj_tot_trans_bar" class="gj_tot_trans_bar"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div> 
</div>

<script src="{{ asset('highcharts/highcharts.js')}}"></script>
<script src="{{ asset('highcharts/exporting.js')}}"></script>
<script src="{{ asset('highcharts/export-data.js')}}"></script>
<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
    });
     $(".gj_stat_div").hide();

    /*last one year users chart script start*/
    <?php if((sizeof($merchant) != 0) && (sizeof($customers) != 0)) { ?>
        Highcharts.chart('gj_tot_stat_bar', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Merchants',
                data: [
                    <?php
                        $year = date('Y');
                        for ($i=1; $i <= 12; $i++) {
                            echo $merchant['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_merchants'].',';
                        }
                    ?>
                ]

            }, {
                name: 'Customers',
                data: [
                    <?php
                        $year = date('Y');
                        for ($i=1; $i <= 12; $i++) {
                            echo $customers['cnt_last_'.date('F',mktime(0,0,0,$i,1,$year)).'_customers'].',';
                        }
                    ?>
                ]

            }]
        });
    <?php } else {
        echo '$(".gj_stat_div").html("<p class=gj_nodata>No Data Here</p>");';
    }
    ?>
    /*last one year users chart script end*/

    /*Total Customers Pie chart Script Start*/
    <?php if((sizeof($customers) != 0)) { ?>
        Highcharts.chart('gj_tot_customers_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            // tooltip: {
            //     pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
            // },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Customers',
                colorByPoint: true,
                data: [{
                    name: 'Website Customers',
                    y: <?php echo $customers['web_cnt']; ?>,
                    sliced: true,
                    selected: true,
                    color:'#4bb2c5'
                }
                // , {
                //     name: 'Facebook Customers',
                //     y: <?php echo $customers['fb_cnt']; ?>,
                //     color:'#eaa228'
                // }, {
                //     name: 'Google Customers',
                //     y: <?php echo $customers['gg_cnt']; ?>,
                //     color:'#C6F9D2'
                // }
                ]
            }]
        });
    <?php } else {
        echo '$(".gj_tot_cus_pie").html("<p class=gj_nodata>No Data Here</p>");';
    } ?>
    /*Total Customers Pie chart Script End*/

    /*Total Products Pie chart Script Start*/
    <?php if((sizeof($products) != 0)) { ?>
        Highcharts.chart('gj_tot_products_pie', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            // tooltip: {
            //     pointFormat: '{series.name}: <b>{point.percentage:.1f}</b>'
            // },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Products',
                colorByPoint: true,
                data: [{
                    name: 'Active Products',
                    y: <?php echo $products['act_cnt']; ?>,
                    sliced: true,
                    selected: true,
                    color:'green'
                }, {
                    name: 'Inactive Products',
                    y: <?php echo $products['inact_cnt']; ?>,
                    color:'red'
                },
                // }, {
                //     name: 'Admin Products',
                //     y: <?php echo $products['adm_cnt']; ?>,
                //     color:'#4bb2c5'
                // }, 
                // {
                //     name: 'Merchant Products',
                //     y: <?php echo $products['mer_cnt']; ?>,
                //     color:'#eaa228'
                // }
                ]
            }]
        });
    <?php } else {
        echo '$(".gj_tot_pdt_pie").html("<p class=gj_nodata>No Data Here</p>");';
    } ?>
    /*Total Products Pie chart Script End*/
    
    
    <?php if (!empty($category_products)) { ?>
        Highcharts.chart('gj_category_product_pie', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y}'
                    },
                    showInLegend: true
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Products',
                colorByPoint: true,
                data: [
                    <?php foreach($category_products as $i => $cat): ?>
                    {
                        name: "<?php echo $cat['name']; ?>",
                        y: <?php echo $cat['count']; ?>
                    }<?php echo ($i < count($category_products)-1) ? ',' : ''; ?>
                    <?php endforeach; ?>
                ]
            }]
        });
    <?php } else {
        echo '$(".gj_category_product_pie").html("<p class=gj_nodata>No Data Here</p>");';
    } ?>
    
    
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('orderPieChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b> orders ({point.percentage:.1f}%)'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} orders'
                    }
                }
            },
            series: [{
                name: 'Orders',
                colorByPoint: true,
                data: [
                    @foreach($categoryOrderCounts as $item)
                        {
                            name: "{{ $item->main_cat_name }}",
                            y: {{ $item->order_count }}
                        }@if(!$loop->last),@endif
                    @endforeach
                ]
            }]
        });
    });


 /* Last 6 months Transaction chart script start */
<?php
 if (
    (isset($cod_trans) && sizeof($cod_trans) != 0) ||
    (isset($online_trans) && sizeof($online_trans) != 0) ||
    (isset($phone_trans) && sizeof($phone_trans) != 0) ||
    (isset($cop_trans) && sizeof($cop_trans) != 0)
) { ?>
    Highcharts.chart('gj_tot_trans_bar', {
        chart: { type: 'column' },
        title: { text: '' },
        credits: { enabled: false },
        xAxis: {
            categories: [<?php echo '"' . implode('","', $months) . '"'; ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: { text: '' }
        },
        plotOptions: {
            column: { pointPadding: 0.2, borderWidth: 0 }
        },
        series: [{
            name: 'COD Transaction',
            data: [
                <?php
                    foreach ($months as $m) {
                        $key = 'cnt_last_' . $m . '_cod_trans';
                        echo isset($cod_trans[$key]) ? $cod_trans[$key] : 0;
                        echo ',';
                    }
                ?>
            ]
        }, {
            name: 'Easebuzz Transaction',
            data: [
                <?php
                    foreach ($months as $m) {
                        $key = 'cnt_last_' . $m . '_online_trans';
                        echo isset($online_trans[$key]) ? $online_trans[$key] : 0;
                        echo ',';
                    }
                ?>
            ]
        }, {
            name: 'PhonePe Transaction',
            data: [
                <?php
                    foreach ($months as $m) {
                        $key = 'cnt_last_' . $m . '_phone_trans';
                        echo isset($phone_trans[$key]) ? $phone_trans[$key] : 0;
                        echo ',';
                    }
                ?>
            ]
        }, {
            name: 'COP Transaction',
            data: [
                <?php
                    foreach ($months as $m) {
                        $key = 'cnt_last_' . $m . '_cop_trans';
                        echo isset($cop_trans[$key]) ? $cop_trans[$key] : 0;
                        echo ',';
                    }
                ?>
            ]
        }]
    });
<?php } else { ?>
    $(".gj_trans_div").html("<p class='gj_nodata'>No Data Here</p>");
<?php } ?>

</script>
@endsection