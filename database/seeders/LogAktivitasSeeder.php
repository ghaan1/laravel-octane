<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $batchSize = 10000; // Jumlah row per batch
        $totalRows = 1000000; // Total row yang ingin kita buat
        $iterations = $totalRows / $batchSize;

        for ($i = 0; $i < $iterations; $i++) {
            $data = [];
            for ($j = 0; $j < $batchSize; $j++) {
                $data[] = [
                    'datetime_log' => $faker->dateTimeThisYear(),
                    'userId_log' => $faker->randomNumber(),
                    'keterangan_log' => $faker->sentence(),
                    'endpoint_log' => $faker->url(),
                    'data_awal' => json_encode([
                        'data' => $faker->word,
                        'info' => $faker->sentence,
                    ]),
                    'data_akhir' => json_encode([
                        'data' => $faker->word,
                        'info' => $faker->sentence,
                    ]),
                ];
            }
            // Insert data per batch ke dalam database
            DB::table('log_aktivitas')->insert($data);
            $this->command->info("Inserted batch " . ($i + 1) . " of " . $iterations);
        }
    }
}
