<?php

namespace App\DataTables;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class RoleDataTables
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function getData(Request $request)
    {
        $query = $this->roleService->getRoleQuery();

        if ($search = $request->input('search.value')) {
            $query = $this->roleService->searchRoles($query, $search);
        }

        $totalRecords = $query->count();

        if ($order = $request->input('order.0')) {
            $columnIndex = $order['column'];
            $columnName = $request->input("columns.{$columnIndex}.data");
            $direction = $order['dir'];

            // Ensure the column exists in the database schema
            if (Schema::hasColumn('roles', $columnName)) {
                $query->orderBy($columnName, $direction);
            }
        }

        $totalFiltered = $query->count();
        $length = $request->input('length');
        $start = $request->input('start');
        $query->skip($start)->take($length);

        $data = $query->get();

        return [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data->map(function ($role, $index) use ($start) {
                return [
                    'iteration' => $start + $index + 1,
                    'name' => $role->name,
                    'actions' => $this->getActions($role),
                ];
            }),
        ];
    }


    protected function getActions($role)
    {
        $editButton = auth()->user()->can('role.edit') ? '<button class="btn btn-warning btn-sm me-2 edit-button" data-id="' . $role->id . '">Ubah</button>' : '';
        $deleteButton = auth()->user()->can('role.delete') ? '<button class="btn btn-danger btn-sm delete-button" data-id="' . $role->id . '">Hapus</button>' : '';

        return '<div class="text-center">' . $editButton . $deleteButton . '</div>';
    }
}
