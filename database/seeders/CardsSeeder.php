<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CardsSeeder extends Seeder
{
    public function run()
    {
        // Obtenemos los sets desde la base de datos
        $sets = DB::table('categories')->select('id', 'id_set')->get();

        foreach ($sets as $set) {
            $page = 1;

            do {
                $response = Http::get('https://api.pokemontcg.io/v2/cards', [
                    'q' => 'set.id:' . $set->id_set,
                    'page' => $page,
                    'pageSize' => 250
                ]);

                if (!$response->successful()) {
                    break;
                }

                $cards = $response->json()['data'];

                foreach ($cards as $card) {
                    DB::table('cards')->updateOrInsert(
                        ['id_card' => $card['id']],
                        [
                            'id_set' => $set->id,
                            'name' => $card['name'],
                            'image_small' => $card['images']['small'] ?? '',
                            'image_large' => $card['images']['large'] ?? '',   
                            'description' => json_encode($card),
                            'deleted' => 0,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                $hasMore = count($cards) === 250;
                $page++;
            } while ($hasMore);
        }
    }
}
