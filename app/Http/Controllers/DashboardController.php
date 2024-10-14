<?php

namespace App\Http\Controllers;

use App\StoreClass\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\PermissionMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            'verified',
            new Middleware(PermissionMiddleware::using('dashboard'), only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        return view('backend.dashboard.index');
    }
}
