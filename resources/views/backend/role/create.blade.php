<div class="modal fade" id="kt_modal_add_role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Tambah Role</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" id="close_modal_button">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <form id="kt_modal_add_role_form" class="form" method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                        data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">Nama Role</span>
                            </label>
                            <input class="form-control form-control-solid" placeholder="Masukkan Role" name="name" />
                            <div id="error-name" class="text-danger"></div>
                        </div>
                        <div class="fv-row">
                            <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-light-primary"
                                                    onclick="toggleAllCheckboxes(true)">
                                                    Check All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-light-danger"
                                                    onclick="toggleAllCheckboxes(false)">
                                                    Uncheck All
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($menuGroups as $group)
                                            <tr>
                                                <td class="text-gray-800">
                                                    <strong>{{ $group->nama_menu_group }}</strong>
                                                </td>
                                                <td>
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input group-checkbox" type="checkbox"
                                                            value="{{ $group->id_permission_menu_group }}"
                                                            name="permissions[]">
                                                    </label>
                                                </td>
                                            </tr>
                                            @foreach ($group->menuItems as $item)
                                                <tr>
                                                    <td class="text-gray-800 ps-10">
                                                        {{ $item->nama_menu_item }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap">
                                                            @foreach (json_decode($item->list_permission_menu_item) as $perm)
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid me-5 mb-2">
                                                                    <input
                                                                        class="form-check-input group-{{ $group->id }}"
                                                                        type="checkbox" name="permissions[]"
                                                                        value="{{ $perm->id }}">
                                                                    <span
                                                                        class="form-check-label">{{ $perm->name }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" id="cancel_button">Batal</button>
                        <button type="submit" class="btn btn-primary saveRoleButton">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAllCheckboxes(checked) {
        document.querySelectorAll('.group-checkbox').forEach(function(checkbox) {
            checkbox.checked = checked;
        });
        document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
            checkbox.checked = checked;
        });
    }
</script>
