<head>
    <title>{{ $title ?? env('APP_NAME') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- start template seo --}}
    {{-- <meta name="description"
        content="Travel yang Memberikan Anda Ketenangan dan Kekhusyu'an dalam Beribadah. Jangan pernah ragu untuk memenuhi panggilan suci ke Baitullah. Karena setiap langkah menuju tanah suci adalah langkah menuju ampunan dan keberkahan." />
    <meta name="keywords"
        content="Sundrawisata, travel, ketenangan, kekhusyuan, ibadah, Baitullah, ampunan, keberkahan" />
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:title"
        content="Sundrawisata - Travel yang Memberikan Anda Ketenangan dan Kekhusyu'an dalam Beribadah">
    <meta property="og:description"
        content="Travel yang Memberikan Anda Ketenangan dan Kekhusyu'an dalam Beribadah. Jangan pernah ragu untuk memenuhi panggilan suci ke Baitullah. Karena setiap langkah menuju tanah suci adalah langkah menuju ampunan dan keberkahan.">
    <meta property="og:url" content="https://sundrawisata.id">
    <meta property="og:site_name" content="Sundrawisata">
    <meta property="og:image" content="{{ asset('frontend-assets/assets/sundra-wisata-logo.jpg') }}">
    <meta name="twitter:image" content="{{ asset('frontend-assets/assets/sundra-wisata-logo.jpg') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title"
        content="Sundrawisata - Travel yang Memberikan Anda Ketenangan dan Kekhusyu'an dalam Beribadah">
    <meta name="twitter:description"
        content="Travel yang Memberikan Anda Ketenangan dan Kekhusyu'an dalam Beribadah. Jangan pernah ragu untuk memenuhi panggilan suci ke Baitullah. Karena setiap langkah menuju tanah suci adalah langkah menuju ampunan dan keberkahan.">
    <meta name="twitter:url" content="https://sundrawisata.id">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://sundrawisata.id" />
    <link rel="shortcut icon" href="{{ asset('frontend-assets/assets/logo-sundra-wisata.png') }}" /> --}}
    {{-- end template seo --}}

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <!--begin::Vendor Stylesheets-->
    <link href="{{ asset('backend-assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend-assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('backend-assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend-assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"
        type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('customStyles')
</head>
