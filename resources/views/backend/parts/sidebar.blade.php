<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('backend-assets/media/logos/default-dark.svg') }}"
                class="h-25px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('backend-assets/media/logos/default-small.svg') }}"
                class="h-20px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">

                    @foreach ($menuGroups as $group)
                        @if ($group->menuItems->isEmpty() && $group->permissions === null)
                            @continue
                        @endif

                        @php
                            // Check if the group has any items the user can access
                            $hasAccessibleItems = $group->menuItems
                                ->filter(function ($item) {
                                    return Auth::user()->can($item->menuItemPermissions->name);
                                })
                                ->isNotEmpty();
                        @endphp

                        @if ($group->menuItems->isEmpty() || $hasAccessibleItems)
                            @can($group->permissions->name)
                                @php
                                    $isGroupActive =
                                        Route::is($group->permissions->name) ||
                                        $group->menuItems->contains(function ($item) {
                                            return Route::is($item->menuItemPermissions->name);
                                        });
                                @endphp
                                <!--begin:Menu item-->
                                <div data-kt-menu-trigger="{{ $group->menuItems->isEmpty() ? '' : 'click' }}"
                                    class="menu-item {{ $group->menuItems->isEmpty() ? '' : 'menu-accordion' }} {{ $isGroupActive ? 'here show' : '' }}">
                                    <!--begin:Menu link-->
                                    @if ($group->menuItems->isEmpty())
                                        <a href="{{ route($group->permissions->name) }}"
                                            class="menu-link {{ $isGroupActive ? 'active' : '' }}">
                                            <span class="menu-icon">
                                                <i class="{{ $group->icon_menu_group }} fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">{{ $group->nama_menu_group }}</span>
                                        </a>
                                    @else
                                        <span class="menu-link {{ $isGroupActive ? 'active' : '' }}">
                                            <span class="menu-icon">
                                                <i class="{{ $group->icon_menu_group }} fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">{{ $group->nama_menu_group }}</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                    @endif
                                    <!--end:Menu link-->

                                    @if (!$group->menuItems->isEmpty())
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion {{ $isGroupActive ? 'show' : '' }}">
                                            @foreach ($group->menuItems as $item)
                                                @can($item->menuItemPermissions->name)
                                                    <div
                                                        class="menu-item {{ Route::is($item->menuItemPermissions->name) ? 'active' : '' }}">
                                                        <a class="menu-link {{ Route::is($item->menuItemPermissions->name) ? 'active' : '' }}"
                                                            href="{{ route($item->menuItemPermissions->name) }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">{{ $item->nama_menu_item }}</span>
                                                        </a>
                                                    </div>
                                                @endcan
                                            @endforeach
                                        </div>
                                        <!--end:Menu sub-->
                                    @endif
                                </div>
                                <!--end:Menu item-->
                            @endcan
                        @endif
                    @endforeach

                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
</div>
