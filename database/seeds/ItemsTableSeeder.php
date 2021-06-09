<?php

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Item::class)->create([
            'name' => 'パピコ',
        ]);

        factory(Item::class)->create([
            'name' => 'ピノ',
        ]);

        factory(Item::class)->create([
            'name' => 'ブラックサンダー'
        ]);

        factory(Item::class)->create([
            'name' => 'じゃがりこ'
        ]);

        factory(Item::class)->create([
            'name' => 'ポテチ'
        ]);

        factory(Item::class)->create([
            'name' => 'オーザック'
        ]);

        factory(Item::class)->create([
            'name' => 'マイクポップコーン'
        ]);

        factory(Item::class)->create([
            'name' => '歌舞伎揚'
        ]);

        factory(Item::class)->create([
            'name' => 'コーラ'
        ]);

        factory(Item::class)->create([
            'name' => 'コーヒー'
        ]);
    }
}
