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
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">User
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
                        <li class="breadcrumb-item text-muted">User</li>
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
                                <input type="text" id="user_search" data-kt-user-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Cari user" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Add user-->
                                @can('user.create')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_user">
                                        <i class="ki-duotone ki-plus fs-2"></i> Tambah User
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
                        <div id="user_table">
                            @include('backend.user.table')
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
    @can('user.create')
        @include('backend.user.create')
    @endcan
    @can('user.edit')
        @include('backend.user.edit')
    @endcan
@endsection

@push('customScripts')
    <script>
        $(document).ready(function() {

            // ============================ Start Load data form ==============================
            function loadRoles(selector, selectedRoleId = null) {
                console.log(selectedRoleId);
                $.ajax({
                    url: '{{ route('role.data') }}',
                    type: 'GET',
                    success: function(data) {
                        let roleSelect = $(selector);
                        roleSelect.empty();
                        roleSelect.append('<option value="">Select Role</option>');
                        $.each(data, function(index, role) {
                            roleSelect.append('<option value="' + role.id + '">' + role.name +
                                '</option>');
                        });
                        if (selectedRoleId) {
                            roleSelect.val(selectedRoleId).trigger('change');
                        }
                    }
                });
            }

            $('#kt_modal_add_user').on('show.bs.modal', function() {
                loadRoles('#role');
            });
            // ============================ End Load data form ==============================

            // ============================ Start DataTable ==============================
            var table = $('#kt_table_users').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [4, 'desc']
                ],
                ajax: '{{ route('user.index') }}',
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
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#user_search').on('keyup', function() {
                table.search(this.value).draw();
            });
            // ============================ End DataTable ==============================

            // ============================ Start Reset Form ==============================
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
            // ============================ End Reset Form ==============================


            // ============================ Start Action Cancel Add ==============================
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
                        $('#kt_modal_add_user').modal('hide');
                        resetForm('#kt_modal_add_user_form');
                    }
                });
            });
            // ============================ End Action Cancel Add ==============================


            // ============================ Start Tambah User ==============================
            $('#kt_modal_add_user_form').on('submit', function(e) {
                e.preventDefault();
                var url = '{{ route('user.store') }}';
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
                                    title: 'Berhasil!',
                                    text: response.message
                                });
                                $('#kt_modal_add_user').modal('hide');
                                table.ajax.reload();
                                resetForm('#kt_modal_add_user_form');
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
                                        title: 'Validation Error!',
                                        html: errorMessage
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Eror saat menyimpan data.'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // ============================ End Tambah User ==============================

            // ============================ Start Show Modal Edit ==============================
            $(document).on('click', '.edit-button', function() {
                var id = $(this).data('id');
                var editUrl = '{{ route('user.edit', ':id') }}'.replace(':id', id);

                $.ajax({
                    type: 'GET',
                    url: editUrl,
                    success: function(response) {
                        $('#edit_id_user').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_email').val(response.email);
                        $('#kt_modal_edit_user_form').attr('action',
                            '{{ route('user.update', ':id') }}'.replace(':id', response.id));
                        loadRoles('#edit_role', response.role_id);
                        $('#kt_modal_edit_user').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            });
            // ============================ End Show Modal Edit ==============================

            // ============================ Start Cancel Edit ==============================
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
                        $('#kt_modal_edit_user').modal('hide');
                        resetForm('#kt_modal_edit_user_form');
                    }
                });
            });
            // ============================ End Cancel Edit ==============================

            // ============================ Start Edit User ==============================
            $('#kt_modal_edit_user_form').on('submit', function(e) {
                e.preventDefault();
                var id_user = $('#edit_id_user').val();
                var url = '{{ route('user.update', ':id') }}'.replace(':id', id_user);
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
                                    title: 'Berhasil!',
                                    text: response.message
                                });
                                $('#kt_modal_edit_user').modal('hide');
                                table.ajax.reload();
                                resetForm('#kt_modal_edit_user_form');
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
                                        title: 'Validation Error!',
                                        html: errorMessage
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Error terjadi saat menyimpan data.'
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // ============================ End Edit User ==============================

            // ============================ Start Delete User ==============================
            $(document).on('click', '.delete-button', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak, batalkan!',
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('user.destroy', ':id') }}'.replace(':id', id),
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Error terjadi saat menghapus data.'
                                });
                            }
                        });
                    }
                });
            });
            // ============================ End Delete User ==============================
        });
    </script>
@endpush
