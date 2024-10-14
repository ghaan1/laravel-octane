<?php

namespace App\DataTables;

use App\Services\LogAktivitasService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogAktivitasDataTables
{
  protected $logAktivitasService;

  public function __construct(LogAktivitasService $logAktivitasService)
  {
    $this->logAktivitasService = $logAktivitasService;
  }

  public function getData(Request $request)
  {
    $query = $this->logAktivitasService->getLogAktiviasQuery();

    // Menerapkan pencarian jika ada input 'search'
    if ($search = $request->input('search.value')) {
      $query = $this->logAktivitasService->searchLogAktivias($query, $search);
    }

    // Hitung total record sebelum filtering
    $totalRecords = $query->count();

    // Order berdasarkan kolom yang dipilih
    if ($order = $request->input('order.0')) {
      $columnIndex = $order['column'];
      $columnName = $request->input("columns.{$columnIndex}.data");
      $direction = $order['dir'];

      // Urutkan data berdasarkan kolom yang dipilih
      if ($columnName != 'iteration') {
        $query->orderBy($columnName, $direction);
      }
    }

    // Hitung total record setelah filtering
    $totalFiltered = $query->count();

    // Penerapan pagination
    $length = $request->input('length');
    $start = $request->input('start');
    $query->skip($start)->take($length);

    // Mengambil data
    $data = $query->get();

    // Format data untuk dikembalikan ke DataTables
    return [
      'draw' => intval($request->input('draw')),
      'recordsTotal' => $totalRecords,
      'recordsFiltered' => $totalFiltered,
      'data' => $data->map(function ($log, $index) use ($start) {
        Carbon::setLocale('id');
        return [
          'iteration' => $start + $index + 1,
          'id_log' => $log->id_log,
          'datetime_log' => Carbon::parse($log->datetime_log)->translatedFormat('j F Y H:i'),
          'nama_user' => $log->nama_user,
          'keterangan_log' => $log->keterangan_log,
          'endpoint_log' => $log->endpoint_log,
          'data_awal' => json_decode($log->data_awal, true),  // Decode JSON ke array asosiatif
          'data_akhir' => json_decode($log->data_akhir, true), // Decode JSON ke array asosiatif
        ];
      }),
    ];
  }
}