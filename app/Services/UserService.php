<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserService
{
    public function createUser($data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            $role = Role::findById($data['role'])->name;
            $user->assignRole($role);

            DB::commit();
            return ['status' => true, 'user' => $user];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => 'Gagal membuat pengguna: ' . $e->getMessage()];
        }
    }

    public function updateUser(User $user, $data)
    {
        DB::beginTransaction();
        try {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            $role = Role::findById($data['role'])->name;
            $user->syncRoles([$role]);

            DB::commit();
            return ['status' => true, 'user' => $user];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()];
        }
    }

    public function deleteUser(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return ['status' => true];
        } catch (QueryException $e) {
            DB::rollback();
            if ($e->getCode() === '23000') {
                return ['status' => false, 'message' => 'Gagal menghapus pengguna: Pengguna ini memiliki data terkait yang tidak dapat dihapus.'];
            }
            return ['status' => false, 'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()];
        } catch (Exception $e) {
            DB::rollback();
            return ['status' => false, 'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()];
        }
    }

    public function editUser(User $user)
    {
        try {
            $user->load('roles:id,name');
            $user->role_id = $user->roles->first() ? $user->roles->first()->id : null;
            return ['status' => true, 'user' => $user];
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Gagal mengambil data pengguna: ' . $e->getMessage()];
        }
    }

    public function getUserQuery()
    {
        try {
            return User::with('roles')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.*');
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Gagal mengambil data pengguna: ' . $e->getMessage()];
        }
    }

    public function searchUsers($query, $search)
    {
        try {
            return $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('users.created_at', 'like', "%{$search}%")
                    ->orWhere('users.updated_at', 'like', "%{$search}%")
                    ->orWhere('roles.name', 'like', "%{$search}%");
            });
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Gagal mencari pengguna: ' . $e->getMessage()];
        }
    }
}