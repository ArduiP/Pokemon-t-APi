<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiketLineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tiket_lines')->insert([
            [
                'id_tiket' => 1,
                'id_producto' => 1,
                'quantity' => 2,
                'price' => 5.00,
                'deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tiket' => 1,
                'id_producto' => 2,
                'quantity' => 1,
                'price' => 5.50,
                'deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tiket' => 2,
                'id_producto' => 3,
                'quantity' => 4,
                'price' => 10.00,
                'deleted' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
