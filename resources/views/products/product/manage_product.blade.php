@extends('layouts.master')
@section('title', 'Manage Products')
@section('content')
<style>
    .container-field form {
        margin-top: 0;
    }

    .container-field form input,
    .container-field input,
    .container-field form select,
    .container-field select {
        height: 37px;
        padding-left: 10px;
    }

    /*.main-right-container table {*/
    /*    margin-top: 55px !important;*/
    /*}*/

    /*table tr th {*/
    /*  white-space:nowrap;*/
    /*  width:unset;*/

    /*}*/
    table tr th input {
        width: 18px;
        height: 18px;
        margin-bottom: 10px !important;
        margin: auto !important;
        text-align: center;
        display: flex;
    }

    /*.container-field table tr th, .container-field table tr td {*/
    /*    max-width: 146px !important;*/
    /*}*/
    tr td img {
        width: 90px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }

    @media screen and (max-width:567px) {

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: left !important;
        }

        .formtop-cs-tb {
            flex-direction: column;
        }

        .formtop-cs-tb input,
        .formtop-cs-tb button,
        .formtop-cs-tb a {
            width: 100%;
        }
    }

    @media screen and (max-width:991px) {
        .j-between {
            display: unset;
        }
    }

    .th-check-col {
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        align-items: center;
        height: 80px;
    }

    .th-check-col input {
        padding: 0;
        min-width: unset;
        width: 20px;
        height: 20px;
        margin: 0 !important;
    }

    table.dataTable th,
    table.dataTable td {
        box-sizing: border-box !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">

        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i
                    class="fa-solid fa-xmark"></i></button>
            @include('layouts.product_sidebar')
        </div>

        <div class="col-lg-10  pt-30">

            <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="col-lg-12">
                    <h3 class="gj_heading"> Manage Products </h3>
                    <div class="gj_manage_filter mt__3 top-btns">
                        <span class="gj_squaredFour">
                            <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                            <label for="ckbCheckAll">Check all</label>
                        </span>
                        <button class="btn btn-primary" id="Block_value" type="button">Block</button>
                        <button class="btn btn-warning" id="UNBlock_value" type="button">Un Block</button>
                        <button class="btn btn-danger" id="Delete_value" type="button">Delete</button>
                        <!-- <a href="/export_csv"><button class="btn btn-info" id="export_csv" type="button">Export CSV</button></a>    -->
                        <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>

                        <button class="btn btn-info" id="export_all_csv" type="button">Export All CSV</button>
                        <button id="downloadPdfBtn" class="btn btn-info mb-3">Download PDF</button>

                        <!-- <span id="download_csv"></span> -->
                        <a href="#" id="download_csv"><button class="btn btn-info" id="exports_csv"
                                type="button">Download CSV</button></a>
                        <a href="{{ route('product.bulk_upload') }}">
                            <button class="btn btn-info" type="button">Bulk Upload</button>
                        </a>
                    </div>
                </div>




                <div class="col-md-12">
                    <div class=" gj_manage_product mob-row-flex">
                        <div class="row j-between">

                            <div class="col-lg-6">
                                <form action="{{ route('search_products') }}" method="GET"
                                    class="gj_search_pdts_form formtop-cs-tb" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="gj_srh_pdts" id="gj_srh_pdts" class="gj_srh_pdts"
                                        placeholder="Search By Products" value="{{request('gj_srh_pdts')}}">
                                    <button type="submit" class="gj_srh_subm btn btn-primary"
                                        id="gj_srh_pdts_subm">Search</button>

                                    <a href="{{route('manage_product')}}" title="All Products"><button
                                            class="btn btn-success gj_srh_subm" id="Block_value" type="button">All
                                            Products</button></a>
                                </form>
                            </div>
                            {{-- <div class="col-lg-4">
                                <form method="GET" id="gj_filter_pdts_form">
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($category as $cate)
                                        <option value="{{ $cate->id }}" {{ request('category_id')==$cate->id ?
                                            'selected' : '' }}>
                                            {{ $cate->main_cat_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div> --}}

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="gj_mge_product_table">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th style="max-width:90px !important; min-width:80px !important;">
                                            <div class="th-check-col">
                                                <input type="checkbox" class="pdf-column" value="0" checked> S.No
                                            </div>
                                        </th>
                                        <th style="max-width:90px !important; min-width:80px !important;">
                                            <div class="th-check-col">
                                                <input type="checkbox" class="pdf-column" value="1" checked> #
                                            </div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="2" checked> Product <br> Code</div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"><input type="checkbox" class="pdf-column"
                                                    value="3" checked> Product <br> Name</div>
                                        </th>
                                        <!--<th>   <div class="th-check-col"><input type="checkbox" class="pdf-column" value="4" checked> Product <br> Notes</div>-->
                                        <!--</th>-->
                                        {{-- <th>
                                            <div class="th-check-col">
                                                <input type="checkbox" class="pdf-column" value="5" checked> Category
                                            </div>
                                        </th> --}}
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="4" checked> Stock <br> Quantity</div>
                                        </th>
                                        <!--<th>   <div class="th-check-col"><input type="checkbox" class="pdf-column" value="5" checked><div> Rang <br> <span style="white-space:nowrap;">Price</span></div></div>-->
                                        <!-- </th>-->
                                        <th>
                                            <div class="th-check-col"><input type="checkbox" class="pdf-column"
                                                    value="5" checked>
                                                <div><span style="white-space:nowrap;">Price</span></div>
                                            </div>
                                        </th>
                                        {{-- <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="10" checked> Tax Amount</div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="11" checked> Domestic <br> Shipping</div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"><input type="checkbox" class="pdf-column"
                                                    value="12" checked> International <br> Shipping</div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="13" checked> Final Selling Price</div>
                                        </th> --}}
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="6" checked> Product Image</div>
                                        </th>
                                        <th>
                                            <div class="th-check-col"> <input type="checkbox" class="pdf-column"
                                                    value="7" checked> Actions</div>
                                        </th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody id="gj_mge_product_bdy">
                                    @if($product)
                                    @php ($i = 1)
                                    <?php 
                                    $file_path = 'images/featured_products';
    $no_file_path = 'images/noimage';
    $no_images = \DB::table('noimage_settings')->first();
    $images = "";
    if ($no_images) {
        $images = $no_file_path . '/' . $no_images->product_no_image;
    }
                                    ?>
                                    @foreach($product as $key => $value)
                                    <tr>
                                        <td style="max-width:90px !important; min-width:80px !important;">{{$i}}</td>
                                        <td style="max-width:90px !important; min-width:80px !important;"><input
                                                type="checkbox" name="check[]" class="checkBoxClass"
                                                value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
                                        <td>{{$value->product_code ?? ''}}</td>
                                        <td>{{$value->product_title ?? ''}}</td>
                                        <!--<td>{{$value->product_notes ?? '-'}}</td>-->
                                        {{-- <td>{{ $value->MainCat ? $value->MainCat->main_cat_name : '' }}</td> --}}
                                        <td>{{$value->onhand_qty ?? ''}}</td>
                                        <!--<td data-sort="{{ $value->rang_price }}">Rs. {{$value->rang_price?? ''}}</td>-->
                                        <td data-sort="{{ $value->original_price }}">Rs.
                                            {{$value->original_price ?? ''}}
                                        </td>
                                        {{--<td data-sort="{{ $value->tax_amount }}">Rs. {{$value->tax_amount ?? ''}}
                                        </td>
                                        <td data-sort="{{ $value->shiping_charge }}">Rs. {{$value->shiping_charge ??
                                            ''}}</td>
                                        <td data-sort="{{ $value->inter_shiping_charge }}">Rs.
                                            {{$value->inter_shiping_charge ?? '0'}}</td>
                                        <td data-sort="{{ $value->product_cost }}">Rs. {{$value->product_cost ?? ''}}
                                        </td> --}}
                                        <td class="gj_mge_fp_img_td">
                                            @if($value->featured_product_img)
                                                <a href="{{ asset($file_path . '/' . $value->featured_product_img)}}"
                                                    target="_blank"><img
                                                        src="{{ asset($file_path . '/' . $value->featured_product_img)}}"
                                                        class="img-responsive gj_mge_fp_img"></a>
                                            @else
                                                <a href="{{ asset($images)}}" target="_blank"><img src="{{ asset($images)}}"
                                                        class="img-responsive gj_mge_fp_img"></a>
                                            @endif
                                        </td>
                                        <td class="gj_p_actions">
                                            <div class="td-action">
                                                <span>
                                                    <a href="{{ route('edit_product', ['id' => $value->id]) }}"
                                                        data-tooltip="Edit" class="td-edt">
                                                        <i class="fa fa-edit fa-2x"></i>
                                                    </a>
                                                </span>
                                                <span>
                                                    <a href="{{ route('status_product', ['id' => $value->id]) }}"
                                                        data-tooltip="block">
                                                        @if($value->is_block == 1)
                                                            <i class="gj_ok fa fa-check fa-2x"></i>
                                                        @else
                                                            <i class="gj_danger fa fa-ban fa-2x"></i>
                                                        @endif
                                                    </a>
                                                </span>
                                                <span>
                                                    <a href="#" id="{{$value->id}}" class="gj_mge_product_del td-dlt"
                                                        data-tooltip="Delete">
                                                        <i class="fa fa-trash fa-2x"></i>
                                                    </a>
                                                </span>
                                                <span>
                                                    <a href="{{ route('view_product', ['id' => $value->id]) }}"
                                                        id="{{$value->id}}" class="gj_mge_product_vw td-vw"
                                                        data-tooltip="View">
                                                        <button><i class="fa fa-eye fa-2x"></i></button>
                                                    </a>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @php ($i = $i + 1)
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


<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById("downloadPdfBtn").addEventListener("click", function () {
        const selectedCols = Array.from(document.querySelectorAll(".pdf-column:checked"))
            .map(cb => parseInt(cb.value));

        const allRows = document.querySelectorAll("#gj_mge_product_table tbody tr");
        const checkedBoxes = document.querySelectorAll(".checkBoxClass:checked");

        const tempTable = document.createElement("table");
        tempTable.className = "table table-bordered table-striped width-tb-cs";

        const thead = document.querySelector("#gj_mge_product_table thead").cloneNode(true);
        const headCells = thead.querySelectorAll("th");

        headCells.forEach((cell, index) => {
            if (!selectedCols.includes(index)) {
                cell.remove();
            }
        });

        tempTable.appendChild(thead);

        const tbody = document.createElement("tbody");

        const cloneAndTrimRow = (row) => {
            const cells = row.querySelectorAll("td");
            const newRow = document.createElement("tr");
            cells.forEach((cell, index) => {
                if (selectedCols.includes(index)) {
                    newRow.appendChild(cell.cloneNode(true));
                }
            });
            return newRow;
        };

        if (checkedBoxes.length > 0) {
            checkedBoxes.forEach(box => {
                const row = box.closest("tr");
                tbody.appendChild(cloneAndTrimRow(row));
            });
        } else {
            allRows.forEach(row => {
                tbody.appendChild(cloneAndTrimRow(row));
            });
        }

        tempTable.appendChild(tbody);

        const wrapper = document.createElement("div");
        wrapper.style.width = "1500px";
        wrapper.style.overflow = "auto";
        wrapper.appendChild(tempTable);

        const style = document.createElement("style");
        style.textContent = `
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            word-wrap: break-word;
        }
    `;
        wrapper.appendChild(style);

        const opt = {
            margin: 0.5,
            filename: 'selected-products-list.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a3', orientation: 'landscape' }
        };

        html2pdf().from(wrapper).set(opt).save();
    });
</script>

<script>
    $(document).ready(function () {
        $('#category_id').on('change', function () {
            $('#gj_filter_pdts_form').submit();
        });
    }); 
</script>
<script>
    $(document).ready(function () {
        $('#gj_mge_product_table').dataTable({
            "paginate": true,
            "searching": false,
            "bInfo": true,
            "sort": true,
            "ordering": true,
            "columnDefs": [
                { targets: '_all', orderable: true }
            ]
        });
        $("#download_csv").hide();
    });

    $(document).ready(function () {
        $("#ckbCheckAll").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });

        $(".checkBoxClass").change(function () {
            if (!$(this).prop("checked")) {
                $("#ckbCheckAll").prop("checked", false);
            }
        });

        $('p.alert').delay(1000).slideUp(300);
    });

    $('#Block_value').on('click', function () {
        var all = [];
        $("input:checkbox[class=checkBoxClass]:checked").each(function () {
            all.push($(this).val());
        });
        if (all.length === 0) {
            $.confirm({
                title: '',
                content: 'Please select atleast one Item by ticking the check box',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function () {
                    }
                }
            });
        } else {
            $.ajax({
                type: 'post',
                url: '{{url('/product_block')}}',
                data: { ids: all, type: 'block' },
                success: function (data) {
                    if (data == 0) {
                        window.location.reload();
                    } else {
                        // $.confirm({
                        //     title: '',
                        //     content: 'No Action Performed!',
                        //     icon: 'fa fa-exclamation',
                        //     theme: 'modern',
                        //     closeIcon: true,
                        //     animation: 'scale',
                        //     type: 'purple',
                        //     buttons: {
                        //         Ok: function(){
                        window.location.reload();
                        //         }
                        //     }
                        // });
                    }
                }
            });
        }
    });

    $('#UNBlock_value').on('click', function () {
        var all = [];
        $("input:checkbox[class=checkBoxClass]:checked").each(function () {
            all.push($(this).val());
        });
        if (all.length === 0) {
            $.confirm({
                title: '',
                content: 'Please select atleast one Item by ticking the check box',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function () {
                    }
                }
            });
        } else {
            $.ajax({
                type: 'post',
                url: '{{url('/product_unblock')}}',
                data: { ids: all, type: 'unblock' },
                success: function (data) {
                    if (data == 0) {
                        window.location.reload();
                    } else {
                        // $.confirm({
                        //     title: '',
                        //     content: 'No Action Performed!',
                        //     icon: 'fa fa-exclamation',
                        //     theme: 'modern',
                        //     closeIcon: true,
                        //     animation: 'scale',
                        //     type: 'purple',
                        //     buttons: {
                        //         Ok: function(){
                        window.location.reload();
                        //         }
                        //     }
                        // });
                    }
                }
            });
        }
    });

    $('#Delete_value').on('click', function () {
        var all = [];
        $("input:checkbox[class=checkBoxClass]:checked").each(function () {
            all.push($(this).val());
        });
        if (all.length === 0) {
            $.confirm({
                title: '',
                content: 'Please select atleast one Item by ticking the check box',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function () {
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Are You Sure to Delete?',
                icon: 'fa fa-trash-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    Yes: function () {
                        $.ajax({
                            type: 'post',
                            url: '{{url('/delete_product_all')}}',
                            data: { ids: all, type: 'unblock' },
                            success: function (data) {
                                if (data == 0) {
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
                                            Ok: function () {
                                                window.location.reload();
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    },
                    No: function () {
                    }
                }
            });
        }
    });

    $('.gj_mge_product_del').on('click', function () {
        var id = 0;
        if ($(this).attr('id')) {
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
                Yes: function () {
                    $.ajax({
                        type: 'post',
                        url: '{{url('/delete_product')}}',
                        data: { id: id, type: 'delete' },
                        success: function (data) {
                            if (data == 0) {
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
                                        Ok: function () {
                                            window.location.reload();
                                        }
                                    }
                                });
                            }
                        }
                    });
                },
                No: function () {
                }
            }
        });
    });

    $('#export_csv').on('click', function () {
        var all = [];
        $("input:checkbox[class=checkBoxClass]:checked").each(function () {
            all.push($(this).val());
        });
        var selectedColumns = [];
        $(".pdf-column:checked").each(function () {
            selectedColumns.push($(this).val());
        });
        var categoryId = $('#category_id').val();
        if (all.length === 0) {
            $.confirm({
                title: '',
                content: 'Please select atleast one Item by ticking the check box',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function () {
                    }
                }
            });
        } else {
            $.ajax({
                type: 'post',
                url: '{{url('/export_csv')}}',
                data: { ids: all, type: 'export', category_id: categoryId, columns: selectedColumns },
                success: function (response) {
                    if (response) {
                        $("#download_csv").show();
                        $("#download_csv").attr("href", response);
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
                                Ok: function () {
                                    window.location.reload();
                                }
                            }
                        });
                    }
                    $(function () {
                        setTimeout(function () {
                            window.location.reload();
                        }, 5000);
                    });
                }
            });
        }
    });

    $('#export_all_csv').on('click', function () {
        var categoryId = $('#category_id').val();
        var selectedColumns = [];
        $(".pdf-column:checked").each(function () {
            selectedColumns.push($(this).val());
        });
        $.ajax({
            type: 'post',
            url: '{{url('/export_csv')}}',
            data: { type: 'export_all', category_id: categoryId, columns: selectedColumns },
            success: function (response) {
                if (response) {
                    window.location.href = "<?php echo route('home'); ?>/" + response;
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
                            Ok: function () {
                                window.location.reload();
                            }
                        }
                    });
                }
            }
        });
    });
</script>
@endsection
