<?php

use Illuminate\Database\Seeder;
use App\Models\BuyItem;

class BuyItemsTableSeeder extends Seeder
{
    public function run()
    {
        factory(BuyItem::class, 20)->create([
            'name' => 'パピコ',
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'ピノ',
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'ブラックサンダー'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'じゃがりこ'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'ポテチ'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'オーザック'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'マイクポップコーン'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => '歌舞伎揚'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'コーラ'
        ]);

        factory(BuyItem::class, 20)->create([
            'name' => 'コーヒー'
        ]);
    }
}
