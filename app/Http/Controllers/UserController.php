<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTables;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use App\StoreClass\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends Controller implements HasMiddleware
{
    protected $userService;
    protected $userDataTable;

    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            new Middleware(PermissionMiddleware::using('user.index'), only: ['index']),
            new Middleware(PermissionMiddleware::using('user.create'), only: ['store']),
            new Middleware(PermissionMiddleware::using('user.edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('user.delete'), only: ['destroy']),
        ];
    }

    public function __construct(UserService $userService, UserDataTables $userDataTable)
    {
        $this->userService = $userService;
        $this->userDataTable = $userDataTable;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->userDataTable->getData($request));
        }

        return view('backend.user.index');
    }

    public function create()
    {
        // Tidak digunakan
    }

    public function store(UserRequest $request)
    {
        $result = $this->userService->createUser($request->all());
        if ($result['status']) {
            LogAktivitas::log('Menambahkan data user', $request->path(), null, $result['user'], Auth::user()->id);
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dibuat']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function edit(User $user)
    {
        $result = $this->userService->editUser($user);
        if ($result['status']) {
            return response()->json($result['user']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function update(UserRequest $request, User $user)
    {
        $result = $this->userService->updateUser($user, $request->all());
        if ($result['status']) {
            LogAktivitas::log('Mengubah data user', $request->path(), $result['user'], $request->all(), Auth::user()->id);
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil diperbarui']);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }

    public function destroy(User $user)
    {
        $result = $this->userService->deleteUser($user);
        if ($result['status']) {
            LogAktivitas::log('Menghapus data user', request()->path(), $user, null, Auth::user()->id);
            return response()->json(['success' => true, 'message' => 'Pengguna berhasil dihapus']);
        }
        if (strpos($result['message'], 'Pengguna ini memiliki data terkait yang tidak dapat dihapus.') !== false) {
            return response()->json(['success' => false, 'message' => $result['message']], 400);
        }
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }
}
