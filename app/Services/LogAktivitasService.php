<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;

class LogAktivitasService
{
  public function getLogAktiviasQuery()
  {
    try {
      $query = DB::table("log_aktivitas")
        ->leftJoin('users', 'users.id', '=', 'log_aktivitas.userId_log')
        ->select(
          'log_aktivitas.id_log',
          'log_aktivitas.datetime_log',
          'log_aktivitas.userId_log',
          'users.name as nama_user',
          'log_aktivitas.keterangan_log',
          'log_aktivitas.endpoint_log',
          'log_aktivitas.data_awal',
          'log_aktivitas.data_akhir',
        );

      return $query;
    } catch (Exception $e) {
      return ['status' => false, 'message' => 'Gagal mengambil data log aktivitas: ' . $e->getMessage()];
    }
  }

  public function searchLogAktivias($query, $search)
  {
    try {
      return $query->where('log_aktivitas.id_log', 'like', "%{$search}%")
        ->orWhere('log_aktivitas.datetime_log', 'like', "%{$search}%")
        ->orWhere('users.name', 'like', "%{$search}%")
        ->orWhere('log_aktivitas.keterangan_log', 'like', "%{$search}%")
        ->orWhere('log_aktivitas.endpoint_log', 'like', "%{$search}%");
    } catch (Exception $e) {
      return ['status' => false, 'message' => 'Gagal mencari log aktivitas: ' . $e->getMessage()];
    }
  }
}
