@extends('layouts.master')
@section('title', 'Manage Services')
@section('content')
<section class="gj_footer_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row">
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10">
            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif

                <div class="col-md-12">
                    <form action="{{ route('store_home_services') }}" class="gj_footer_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="main-right-container container-field row mx_0 px_5 mb-field">
                            <div class="col-lg-12 mb-3">
                                <h3 class="gj_heading"> Manage Services </h3>
                            </div>

                            <div class="col-md-12">
                                <div class="gj_tot_err">
                                    @if ($errors->any())
                                        <p class="error">{{ $errors->first() }}</p>
                                    @endif
                                </div>

                                <div class="table-responsive container-field-table">
                                    <table class="table table-stripped table-bordered gj_tab_f_pay">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="services_bdy">
                                            @if(isset($services) && count($services) != 0)
                                                @foreach($services as $key => $service)
                                                    <tr>
                                                        <td>
                                                            @if($service->image)
                                                                <div class="gj_aimg_div">
                                                                    <img src="{{ asset($service->image) }}" class="img-responsive gj_old_prod_img">
                                                                </div>
                                                            @endif
                                                            <input type="hidden" name="service_id[]" value="{{ $service->id }}">
                                                            <input type="hidden" name="old_service_image[]" value="{{ $service->image }}">
                                                            <input type="file" name="service_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="service_title[]" class="form-control" placeholder="Enter Title" value="{{ $service->title }}">
                                                        </td>
                                                        <td>
                                                            <textarea name="service_description[]" class="form-control" rows="3" placeholder="Enter Description">{{ $service->description }}</textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="service_priority[]" class="form-control" value="{{ $service->priority }}">
                                                        </td>
                                                        <td>
                                                            <select name="service_status[]" class="form-control">
                                                                <option value="1" {{ $service->is_block == 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $service->is_block == 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="service_rem td-dlt" data-id="{{ $service->id }}"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="service_id[]" value="">
                                                        <input type="hidden" name="old_service_image[]" value="">
                                                        <input type="file" name="service_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                                                    </td>
                                                    <td><input type="text" name="service_title[]" class="form-control" placeholder="Enter Title"></td>
                                                    <td><textarea name="service_description[]" class="form-control" rows="3" placeholder="Enter Description"></textarea></td>
                                                    <td><input type="number" name="service_priority[]" class="form-control" value="1"></td>
                                                    <td>
                                                        <select name="service_status[]" class="form-control">
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </td>
                                                    <td><button type="button" class="service_rem td-dlt"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="btn-grp">
                                    <input type="button" value="Add Service" id="service_addbut" class="add_btn_cs">
                                </div>
                            </div>
                        </div>

                        <div class="update-btn-box">
                            <input class="btn btn-primary mx_auto" type="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('p.alert').delay(7000).slideUp(700);

        var serviceIndex = {{ isset($services) && count($services) != 0 ? count($services) : 1 }};

        $('#service_addbut').on('click', function () {
            var row = `
                <tr>
                    <td>
                        <input type="hidden" name="service_id[]" value="">
                        <input type="hidden" name="old_service_image[]" value="">
                        <input type="file" name="service_image[]" accept="image/*" class="gj_p_image gj_edit_p_image form-control">
                    </td>
                    <td><input type="text" name="service_title[]" class="form-control" placeholder="Enter Title"></td>
                    <td><textarea name="service_description[]" class="form-control" rows="3" placeholder="Enter Description"></textarea></td>
                    <td><input type="number" name="service_priority[]" class="form-control" value="${serviceIndex + 1}"></td>
                    <td>
                        <select name="service_status[]" class="form-control">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </td>
                    <td><button type="button" class="service_rem td-dlt"><i class="fa fa-trash"></i></button></td>
                </tr>
            `;

            $('#services_bdy').append(row);
            serviceIndex++;
        });

        $('body').on('click', '.service_rem', function () {
            var row = $(this).closest('tr');
            var serviceId = $(this).data('id');

            if ($('#services_bdy tr').length <= 1) {
                alert('At least one service is required.');
                return;
            }

            if (!serviceId) {
                row.remove();
                return;
            }

            $.ajax({
                url: "{{ route('delete_home_service') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: serviceId
                },
                success: function (response) {
                    if (response.success) {
                        row.remove();
                    } else {
                        alert('Failed to delete.');
                    }
                },
                error: function () {
                    alert('Something went wrong. Try again.');
                }
            });
        });
    });
</script>
@endsection
