<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BuyItem; // App\Models\BuyItemをインポート
use App\Models\User; // App\Models\Userをインポート

class BuyItemTest extends TestCase
{
    use RefreshDatabase; //既存のデータに依存しないようにする

    public function setUP() :void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->buyItem = factory(BuyItem::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->anotherUser = factory(User::class)->create();
    }

    // 一覧画面へのアクセス
    public function testGetIndex()
    {
        $response = $this->actingAs($this->user)
            ->get('/buy_items');

        $response->assertStatus(200)
            ->assertViewIs('buy_items.index');
    }

    // 他人の詳細ページへのアクセス
    public function testNonGetShow()
    {
        $response = $this->actingAs($this->anotherUser)
            ->get('/buy_items/' . $this->buyItem->id);

        $response->assertStatus(403);
    }
}
