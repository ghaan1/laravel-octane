@extends('backend.parts.auth.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="index.html" class="mb-7">
                    <img alt="Logo" src="backend-assets/media/logos/custom-3.svg" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">Isi Disini :)</h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST"
                        action="{{ route('login.post') }}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">Masuk</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->

                        <!--begin::Separator-->
                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Masuk disini</span>
                        </div>
                        <!--end::Separator-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="Email" name="email" autocomplete="off"
                                class="form-control bg-transparent @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!--end::Email-->
                        </div>
                        <!--end::Input group=-->
                        <div class="fv-row mb-10 position-relative">
                            <!--begin::Password-->
                            <input type="password" placeholder="Password" name="password" autocomplete="off"
                                class="form-control bg-transparent @error('password') is-invalid @enderror" />
                            <span class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye"></i>
                            </span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!--end::Password-->
                        </div>
                        <!--end::Input group=-->

                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="remember" />
                                <span class="form-check-label text-gray-700 fw-bold">Remember Me</span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Input group=-->

                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">Sign In</span>
                                <!--end::Indicator label-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
@endsection
@push('customScripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.querySelector('.fa-eye');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
