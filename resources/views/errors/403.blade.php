<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{ asset('backend-assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <style>
        body {
            background-image: url('{{ asset('backend-assets/media/auth/bg3.jpg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ asset('backend-assets/media/auth/bg3-dark.jpg') }}');
        }
    </style>
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush py-5">
                    <div class="card-body py-15 py-lg-20">
                        <!--begin::Logo-->
                        <h1 class="fw-bold fs-2qx text-gray-800 mb-7">Kamu tidak memiliki akses</h1>
                        <!--end::Logo-->
                        <!--begin::Message-->
                        <div class="fw-semibold fs-3 text-muted mb-15">:)
                        </div>
                        <!--end::Message-->
                        <!--begin::Action-->
                        <div class="text-center">
                            <a href="{{ url()->previous() }}" class="btn btn-lg btn-primary fw-bold">Kembali</a>
                        </div>
                        <!--end::Action-->
                        <!--begin::Illustration-->
                        <div class="mb-0">
                            <img src="{{ asset('backend-assets/media/auth/membership.png') }}"
                                class="mw-100 mh-300px theme-light-show" alt="" />
                            <img src="{{ asset('backend-assets/media/auth/membership-dark.png') }}"
                                class="mw-100 mh-300px theme-dark-show" alt="" />
                        </div>
                        <!--end::Illustration-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "backend-assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('backend-assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('backend-assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
