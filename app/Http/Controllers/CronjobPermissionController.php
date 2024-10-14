<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class CronjobPermissionController extends Controller
{
  public function templateTambahPermissionKeRole()
  {

    // Step 0: Clear cache spaties permission
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Step 1: Input Permission yang mau diassign ke rolenya 
    $permissions = [
      // 'test.index',
      // 'test.create',
    ];

    // Step 1.1: Cek apakah permission sudah ada di database atau belum
    foreach ($permissions as $permissionName) {
      if (!Permission::where('name', $permissionName)->exists()) {
        Permission::create(['name' => $permissionName]);
      }
    }

    // Step 2: Cari role 'superadmin' atau role lain
    $roleCek = Role::where('name', 'superadmin')->first();

    if (!$roleCek) {
      return response()->json([
        'message' => 'Superadmin role not found.',
      ], 404);
    }

    // Step 3: Assign permission ke role superadmin
    $roleCek->givePermissionTo($permissions);

    return response()->json([
      'message' => 'Permissions successfully assigned to superadmin and menu items updated.',
      'permissions' => $permissions,
    ]);
  }

  public function updatePermissionSuperadmin()
  {
    // Step 0: Clear cache spaties permission
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Step 1: Cari role 'superadmin' atau role lain
    $superAdminRole = Role::where('name', 'superadmin')->first();

    if (!$superAdminRole) {
      return response()->json([
        'message' => 'Superadmin role not found.',
      ], 404);
    }

    // Step 2: Detach semua permission yang ada dari superadmin
    $superAdminRole->syncPermissions([]); // Detach semua permissions

    // Step 3: Dapatkan semua permission yang tersedia di database
    $allPermissions = Permission::all();

    // Step 4: Assign semua permission ke superadmin
    $superAdminRole->givePermissionTo($allPermissions);

    return response()->json([
      'message' => 'All permissions successfully assigned to superadmin.',
      'permissions' => $allPermissions->pluck('name'),
    ]);
  }
}