<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTables;
use App\Http\Requests\RoleRequest;
use App\Models\MenuGroup;
use App\Services\RoleService;
use App\StoreClass\LogAktivitas;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    protected $roleService;
    protected $roleDataTable;

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            new Middleware(PermissionMiddleware::using('role.index'), only: ['index']),
            new Middleware(PermissionMiddleware::using('role.create'), only: ['store']),
            new Middleware(PermissionMiddleware::using('role.edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('role.delete'), only: ['destroy']),
        ];
    }

    public function __construct(RoleService $roleService, RoleDataTables $roleDataTable)
    {
        $this->roleService = $roleService;
        $this->roleDataTable = $roleDataTable;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->roleDataTable->getData($request));
        }

        $roles = Role::withCount('users')->get();
        $permissions = Permission::all();
        $menuGroups = MenuGroup::with('menuItems')->get();
        return view('backend.role.index', compact('permissions', 'menuGroups', 'roles'));
    }

    public function create()
    {
        //Tidak digunakan
    }

    public function store(RoleRequest $request)
    {
        $result = $this->roleService->createRole($request->all());
        if ($result['status']) {
            LogAktivitas::log('Menambah role', request()->path(), $request->all(), null, Auth::user()->id);
            return response()->json(['success' => true, 'message' => 'Role berhasil dibuat']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function edit($id)
    {
        $result = $this->roleService->editRole($id);
        if ($result['status']) {
            return response()->json($result['data']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function update(RoleRequest $request, Role $role)
    {
        $result = $this->roleService->updateRole($role, $request->all());
        if ($result['status']) {
            return response()->json(['success' => true, 'message' => 'Role berhasil diperbarui']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function destroy(Role $role)
    {
        $result = $this->roleService->deleteRole($role);
        if ($result['status']) {
            LogAktivitas::log('Menghapus role', request()->path(), $role, null, Auth::user()->id);
            return response()->json(['success' => true, 'message' => 'Role berhasil dihapus']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function data()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
