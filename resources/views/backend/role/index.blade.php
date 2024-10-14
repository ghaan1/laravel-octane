@extends('backend.parts.master')
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Role
                    </h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Role</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" id="role_search" data-kt-user-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Cari Role" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Add user-->
                                @can('role.create')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_role">
                                        <i class="ki-duotone ki-plus fs-2"></i> Tambah Role
                                    </button>
                                @endcan
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <div id="role_table">
                            @include('backend.role.table')
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    @can('role.create')
        @include('backend.role.create')
    @endcan
    @can('role.edit')
        @include('backend.role.edit')
    @endcan
@endsection

@push('customScripts')
    <script>
        $(document).ready(function() {
            // ==================== Start Role DataTable ====================
            var table = $('#kt_table_role').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('role.index') }}',
                columns: [{
                        data: 'iteration',
                        name: 'iteration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#role_search').on('keyup', function() {
                table.search(this.value).draw();
            });
            // ==================== End Role DataTable ====================

            // ==================== Start Reset Validation ====================
            function resetForm(form) {
                $(form)[0].reset();
                $(form).find('input[name="id_user"]').val('');
                $(form).find('select').val('').trigger('change');
                $('.is-invalid').removeClass('is-invalid');
                $('.text-danger').remove();
            }

            function clearValidationErrors(form) {
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.text-danger').remove();
            }
            // ==================== End Reset Validation ====================

            // ==================== Start Close Modal Add ====================
            $('#cancel_button, #close_modal_button').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Datanya akan hilang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, batalkan!',
                    cancelButtonText: 'Tidak, tetap di sini!',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#kt_modal_add_role').modal('hide');
                        resetForm('#kt_modal_add_role_form');
                    }
                });
            });
            // ==================== End Close Modal Add ====================

            // ==================== Start Add Role Form ====================
            $('#kt_modal_add_role_form').on('submit', function(e) {
                e.preventDefault();
                var url = '{{ route('role.store') }}';
                let form = $(this);
                var formData = new FormData(this);

                clearValidationErrors(form);

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan disimpan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Tidak, batalkan!',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                });
                                $('#kt_modal_add_role').modal('hide');
                                table.ajax.reload();
                                resetForm('#kt_modal_add_role_form');
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $('.text-danger').remove();

                                    $.each(errors, function(key, value) {
                                        var element = form.find('[name="' +
                                            key + '"]');
                                        element.addClass('is-invalid');

                                        if (element.is('select')) {
                                            element.next().after(
                                                '<div class="text-danger">' +
                                                value[0] + '</div>');
                                        } else {
                                            element.after(
                                                '<div class="text-danger">' +
                                                value[0] + '</div>');
                                        }
                                    });

                                    var errorMessage = '';
                                    $.each(errors, function(key, value) {
                                        errorMessage += value[0] + '<br>';
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        html: errorMessage
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Error saat menyimpan data.'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // ==================== End Add Role Form ====================

            // ==================== Start Edit Role Form ====================
            $(document).on('click', '.edit-button', function() {
                var id = $(this).data('id');
                var editUrl = '{{ route('role.edit', ':id') }}'.replace(':id', id);

                $.ajax({
                    type: 'GET',
                    url: editUrl,
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#edit_id_role').val(response.id);
                            $('#edit_name').val(response.name);
                            $('#kt_modal_edit_role_form').attr('action',
                                '{{ route('role.update', ':id') }}'.replace(':id', response
                                    .id));

                            $('#kt_modal_edit_role_form').find('input[type="checkbox"]').prop(
                                'checked', false);

                            response.permissions.forEach(function(permission) {
                                $('#kt_modal_edit_role_form').find('input[value="' +
                                    permission + '"]').prop('checked', true);
                            });

                            $('#kt_modal_edit_role').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Data tidak ditemukan.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error saat mengambil data.'
                        });
                    }
                });
            });
            // ==================== End Edit Role Form ====================

            // ==================== Start Cancel Edit Role ====================
            $('#cancel_edit_button, #close_modal_edit_button').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Datanya akan hilang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, batalkan!',
                    cancelButtonText: 'Tidak, tetap di sini!',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#kt_modal_edit_role').modal('hide');
                        resetForm('#kt_modal_edit_role_form');
                    }
                });
            });
            // ==================== End Cancel Edit Role ====================

            // ==================== Start Update Role Form ====================
            $('#kt_modal_edit_role_form').on('submit', function(e) {
                e.preventDefault();
                var id_role = $('#edit_id_role').val();
                var url = '{{ route('role.update', ':id') }}'.replace(':id', id_role);
                let form = $(this);
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                clearValidationErrors(form);

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan diubah!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah!',
                    cancelButtonText: 'Tidak, batalkan!',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                });
                                $('#kt_modal_edit_role').modal('hide');
                                resetForm('#kt_modal_edit_role_form');

                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);


                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $('.text-danger').remove();

                                    $.each(errors, function(key, value) {
                                        var element = form.find('[name="' +
                                            key + '"]');
                                        element.addClass('is-invalid');

                                        if (element.is('select')) {
                                            element.next().after(
                                                '<div class="text-danger">' +
                                                value[0] + '</div>');
                                        } else {
                                            element.after(
                                                '<div class="text-danger">' +
                                                value[0] + '</div>');
                                        }
                                    });

                                    var errorMessage = '';
                                    $.each(errors, function(key, value) {
                                        errorMessage += value[0] + '<br>';
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        html: errorMessage
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Error saat mengubah data.'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // ==================== End Update Role Form ====================

            // ==================== Start Delete Role ====================
            $(document).on('click', '.delete-button', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak, batalkan!',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('role.destroy', ':id') }}'.replace(':id', id),
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
            // ==================== End Delete Role ====================
        });
    </script>
@endpush
