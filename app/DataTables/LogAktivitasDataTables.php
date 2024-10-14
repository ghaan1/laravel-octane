<?php

namespace App\DataTables;

use App\Services\LogAktivitasService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Octane\Facades\Octane;

class LogAktivitasDataTables
{
  protected $logAktivitasService;

  public function __construct(LogAktivitasService $logAktivitasService)
  {
    $this->logAktivitasService = $logAktivitasService;
  }

  public function getData(Request $request)
  {
    // Prepare the base query
    $query = $this->logAktivitasService->getLogAktiviasQuery();

    // Apply search filter if provided
    if ($search = $request->input('search.value')) {
      $query = $this->logAktivitasService->searchLogAktivias($query, $search);
    }

    // Get total record count (before filtering) concurrently
    [$totalRecords, $filteredData] = Octane::concurrently([
      fn() => $this->logAktivitasService->getLogAktiviasQuery()->count(), // Count before filtering
      fn() => (clone $query)->count(),  // Count after filtering
    ]);

    // Apply ordering
    if ($order = $request->input('order.0')) {
      $columnIndex = $order['column'];
      $columnName = $request->input("columns.{$columnIndex}.data");
      $direction = $order['dir'];

      // Order by the selected column, but skip 'iteration'
      if ($columnName != 'iteration') {
        $query->orderBy($columnName, $direction);
      }
    }

    // Apply pagination
    $length = $request->input('length');
    $start = $request->input('start');
    $query->skip($start)->take($length);

    // Retrieve data concurrently
    [$data] = Octane::concurrently([
      fn() => $query->get(),
    ]);

    // Set Carbon locale once
    Carbon::setLocale('id');

    // Format the data for DataTables
    return [
      'draw' => intval($request->input('draw')),
      'recordsTotal' => $totalRecords,
      'recordsFiltered' => $filteredData,
      'data' => $data->map(function ($log, $index) use ($start) {
        return [
          'iteration' => $start + $index + 1,
          'id_log' => $log->id_log,
          'datetime_log' => Carbon::parse($log->datetime_log)->translatedFormat('j F Y H:i'),
          'nama_user' => $log->nama_user,
          'keterangan_log' => $log->keterangan_log,
          'endpoint_log' => $log->endpoint_log,
          'data_awal' => json_decode($log->data_awal, true), // Decode JSON to associative array
          'data_akhir' => json_decode($log->data_akhir, true), // Decode JSON to associative array
        ];
      }),
    ];
  }
}
