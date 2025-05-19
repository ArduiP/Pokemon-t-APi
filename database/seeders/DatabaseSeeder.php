<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CategoriesSeeder::class,
            AddressSeeder::class,
            pagoSeeder::class,
                        cardsSeeder::class,
            ProductoSeeder::class,
            TicketSeeder::class,
            TicketLineSeeder::class,

        ]);
    }
}
