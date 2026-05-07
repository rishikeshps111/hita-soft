@extends('layouts.master')
@section('title', 'Manage Coupon')
@section('content')
<style>
    .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
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
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12">
                          <div class=" back-container">
                              <h3 class="gj_heading"> Redeem List</h3>
                          <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                          </div>
                            <div class="gj_manage_filter mt__3 top-btns">
                                <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>
                            </div>
                           
                     </div>
                     <div class="col-lg-12">
                    <div class="table-responsive gj_manage_user" style="margin-top:10px;">
                        <table class="table table-bordered table-striped" id="redeem-list-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <!--<th>#</th>-->
                                    <th>User</th>
                                    <th>Phone No</th>
                                    <th>Order No</th>
                                    <th>Date</th>
                                    <th>Order Amount</th>
                                    <th>Discount Applied</th>
                                    <th>Coupon Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_user_bdy">
                                    @if($usages)
                                    @php ($i = 1)
                                    
                                    @foreach($usages as $usage)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <!--<td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$coupon->id}}" id="Checkbox{{$i}}" /></td>-->
                                            
                                            <td class="gj_m_n_e">{{$usage->user->full_name}}</td>
                                            <td class="gj_m_n_e">
                                               {{$usage->user->phone}}
                                            </td>
                                            <td>{{$usage->order->order_code ?? ''}}</td>
                                            <td>{{ \Carbon\Carbon::parse($usage->used_at)->format('d-m-Y') }}</td>
                                            <td>{{$usage->order->net_amount ?? ''}}</td>
                                            <td>Rs. {{$usage->order->coupon_discount ?? ''}}</td>
                                            <td>{{$usage->order->coupon_code ?? ''}}</td>
                                            <td>
                                            <span class="text-success">Active</span>
                                           
                                            </td>
                                        </tr>
                                        @php ($i = $i+1)
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                 </div>
               

               

                
            </div>
            
            

        </div>
    </div>
</section>



<script> 
$(document).ready(function() { $('#user_id').on('change', function() 
{ 
    $('#gj_filter_pdts_form').submit();
    }); 
}); 
</script>
<script>
    $(document).ready(function() { 
        $('#gj_mge_user_table').dataTable({
            "paginate": true,
            "searching": true,
            "bInfo" : true,
            "sort": true
        });
    });
    
    $('.gj_mge_user_del').on('click',function(){
        var id = 0;
        if($(this).attr('id')) {
            id = $(this).attr('id');
        }

        $.confirm({
            title: '',
            content: 'Are You Sure to Delete?',
            icon: 'fa fa-trash-o',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Yes: function(){
                    $.ajax({
                        type: 'post',
                        url: '{{url('/delete_coupons')}}',
                        data: {id: id, type: 'delete'},
                        success: function(data){
                            if(data == 0){
                                window.location.reload();
                            } else {
                                $.confirm({
                                    title: '',
                                    content: 'No Action Performed!',
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
                            }
                        }
                    });
                },
                No:function() {
                }
            }
        });
    });
    
</script>    

<script>
    document.getElementById('export_csv').addEventListener('click', function () {
        let table = document.getElementById('redeem-list-table');
        let rows = table.querySelectorAll('tr');
        let csv = [];

        rows.forEach(function (row) {
            let cols = row.querySelectorAll('td, th');
            let rowData = [];
            cols.forEach(function (col) {
                let data = col.innerText.replace(/(\r\n|\n|\r)/gm, '').trim(); // remove newlines
                data = data.replace(/"/g, '""'); // escape double quotes
                rowData.push('"' + data + '"');
            });
            csv.push(rowData.join(','));
        });

        // Download CSV
        let csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
        let downloadLink = document.createElement('a');
        downloadLink.download = 'redeem_list.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });
</script>


@endsection

