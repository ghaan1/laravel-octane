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
                        <li class="breadcrumb-item text-muted">Log Aktivitas</li>
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
                                <input type="text" id="log_aktivitas_search" data-kt-log-aktivitas-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Cari Log" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        <!--begin::Table-->
                        <div id="log_aktivitas_table">
                            @include('backend.log-aktivitas.table')
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
@endsection

@push('customScripts')
    <script>
        $(document).ready(function() {
            // ============================ Start DataTable ==============================
            var table = $('#kt_table_log_aktivitas').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [1, 'desc']
                ],
                ajax: '{{ route('log.aktivitas.index') }}',
                columns: [{
                        data: 'iteration',
                        name: 'iteration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id_log',
                        name: 'id_log',
                        render: function(data, type, row) {
                            return '<span class="badge badge-success">' + data + '</span>';
                        }
                    },
                    {
                        data: 'datetime_log',
                        name: 'datetime_log'
                    },
                    {
                        data: 'nama_user',
                        name: 'nama_user'
                    },
                    {
                        data: 'keterangan_log',
                        name: 'keterangan_log'
                    },
                    {
                        data: 'endpoint_log',
                        name: 'endpoint_log'
                    },
                    {
                        data: 'data_awal',
                        name: 'data_awal',
                        render: function(data, type, row) {
                            // Menampilkan JSON dalam format yang rapi dengan line break dan indentasi
                            return '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                        }
                    },
                    {
                        data: 'data_akhir',
                        name: 'data_akhir',
                        render: function(data, type, row) {
                            // Menampilkan JSON dalam format yang rapi dengan line break dan indentasi
                            return '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                        }
                    }
                ]
            });



            $('#log_aktivitas_search').on('keyup', function() {
                table.search(this.value).draw();
            });
            // ============================ End DataTable ==============================
        });
    </script>
@endpush
