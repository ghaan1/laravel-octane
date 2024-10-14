@extends('backend.parts.master')
@section('content')
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">
                <!--begin::Form-->
                <form id="kt_account_profile_details_form" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="text" name="name"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ $user->name }}" readonly />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Email</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <input type="email" name="email"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ $user->email }}" readonly />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Content-->
        </div>

        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Ubah Password</h3>
                </div>
            </div>
            <div class="collapse show">
                <form id="change_password_form" class="form">
                    <div class="card-body border-top p-9">
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password Sekarang</label>
                            <div class="col-lg-8 position-relative">
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Password Sekarang" />
                                <span class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                    style="margin-right: 10px;" onclick="togglePasswordVisibility('current_password')">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <div class="invalid-feedback" id="current_password_error"></div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password Baru</label>
                            <div class="col-lg-8 position-relative">
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control form-control-lg form-control-solid" placeholder="Password Baru" />
                                <span class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                    style="margin-right: 10px;" onclick="togglePasswordVisibility('new_password')">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <div class="invalid-feedback" id="new_password_error"></div>
                            </div>
                        </div>
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Konfirmasi Password
                                Baru</label>
                            <div class="col-lg-8 position-relative">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Konfirmasi Password Baru" />
                                <span class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                    style="margin-right: 10px;"
                                    onclick="togglePasswordVisibility('new_password_confirmation')">
                                    <i class="fa fa-eye"></i>
                                </span>
                                <div class="invalid-feedback" id="new_password_confirmation_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                        <button type="submit" class="btn btn-primary" data-kt-indicator="off">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customScripts')
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.firstElementChild;
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#change_password_form').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan mengubah password akun anda!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah Password!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = $(this).serialize();

                        $.ajax({
                            url: '{{ route('profile.updatePassword') }}',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                });
                                $('#change_password_form')[0].reset();
                                clearErrors();
                            },
                            error: function(response) {
                                if (response.status === 400) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Kesalahan',
                                        text: response.responseJSON.message,
                                    });
                                } else {
                                    var errors = response.responseJSON.errors;
                                    if (errors) {
                                        if (errors.current_password) {
                                            $('#current_password').addClass(
                                                'is-invalid');
                                            $('#current_password_error').text(errors
                                                .current_password[0]).show();
                                        }
                                        if (errors.new_password) {
                                            $('#new_password').addClass('is-invalid');
                                            $('#new_password_error').text(errors
                                                .new_password[0]).show();
                                        }
                                        if (errors.new_password_confirmation) {
                                            $('#new_password_confirmation').addClass(
                                                'is-invalid');
                                            $('#new_password_confirmation_error').text(
                                                    errors.new_password_confirmation[0])
                                                .show();
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            });

            function clearErrors() {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').hide().text('');
            }

            $('input').on('input', function() {
                clearErrors();
            });
        });
    </script>
@endpush
