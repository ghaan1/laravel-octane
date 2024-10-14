<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" lang="en">
@include('backend.parts.header')
@stack('customStyles')

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
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
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('backend-assets/media/auth/bg4.jpg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('backend-assets/media/auth/bg4-dark.jpg');
            }
        </style>
        <!--end::Page bg image-->
        @yield('content')
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
    @stack('customScripts')
    <!--end::Javascript-->

</body>

</html>
