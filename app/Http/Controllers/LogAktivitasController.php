<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\DataTables\LogAktivitasDataTables;
use App\StoreClass\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller implements HasMiddleware
{
  protected $logAktivitasDataTable;


  public static function middleware(): array
  {
    return [
      'auth',
      'verified',
      new Middleware(PermissionMiddleware::using('log.aktivitas.index'), only: ['index']),
    ];
  }

  public function __construct(LogAktivitasDataTables $logAktivitasDataTable)
  {
    $this->logAktivitasDataTable = $logAktivitasDataTable;
  }

  public function index(Request $request)
  {
    if ($request->ajax()) {
      return response()->json($this->logAktivitasDataTable->getData($request));
    }

    return view('backend.log-aktivitas.index');
  }
}
