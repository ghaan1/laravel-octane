<?php

namespace App\DataTables;

use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserDataTables
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getData(Request $request)
    {
        $query = $this->userService->getUserQuery();

        if ($search = $request->input('search.value')) {
            $query = $this->userService->searchUsers($query, $search);
        }

        $totalRecords = $query->count();

        if ($order = $request->input('order.0')) {
            $columnIndex = $order['column'];
            $columnName = $request->input("columns.{$columnIndex}.data");
            $direction = $order['dir'];

            if ($columnName == 'role') {
                $query->orderBy('roles.name', $direction);
            } elseif ($columnName != 'iteration') {
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
            'data' => $data->map(function ($user, $index) use ($start) {
                Carbon::setLocale('id');
                return [
                    'iteration' => $start + $index + 1,
                    'name' => $user->name,
                    'role' => $user->roles->pluck('name')->implode(', '),
                    'email' => $user->email,
                    'created_at' => Carbon::parse($user->created_at)->translatedFormat('j F Y'),
                    'updated_at' => Carbon::parse($user->updated_at)->translatedFormat('j F Y'),
                    'actions' => $this->getActions($user),
                ];
            }),
        ];
    }

    protected function getActions($user)
    {

        $editButton = auth()->user()->can('user.edit', $user) ? '
            <button class="btn btn-warning btn-sm me-2 edit-button" data-id="' . $user->id . '">Ubah</button>' : '';
        $deleteButton = auth()->user()->can('user.delete', $user) ? '
            <button class="btn btn-danger btn-sm delete-button" data-id="' . $user->id . '">Hapus</button>' : '';

        return '<div class="text-center">' . $editButton . $deleteButton . '</div>';
    }
}
