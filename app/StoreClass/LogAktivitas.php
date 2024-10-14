<?php

namespace App\StoreClass;

use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogAktivitas
{
  public static function log(
    $keterangan,
    $endpoint,
    $data_awal = [],
    $data_akhir = [],
    $userId = null
  ) {
    DB::table('log_aktivitas')->insert([
      'datetime_log' => now(),
      'userId_log' => Auth::user()->id ?? $userId,
      'keterangan_log' => $keterangan,
      'endpoint_log' => $endpoint,
      'data_awal' => json_encode($data_awal),
      'data_akhir' => json_encode($data_akhir),
    ]);
  }
}