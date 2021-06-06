<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BuyItem; // App\Models\BuyItemをインポート
use App\Models\User; // App\Models\Userをインポート
use App\Models\Item; // App\Models\Itemをインポート

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
        $this->item = factory(Item::class)->create([
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

    // 購入商品登録ページへのアクセス
    public function testGetCreate()
    {
        $response = $this->actingAs($this->user)
            ->get('/buy_items/create');

        $response->assertStatus(200)
            ->assertViewIs('buy_items.create');
    }

    // 購入商品登録で個数が空白
    public function testPostStoreEmptyQuantity()
    {
        $postBuyItem = [
            'name' => $this->item->name,
            'quantity' => '',
            'price' => $this->item->price * 4,
            'month' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from('/buy_items/create')
            ->post('/buy_items', $postBuyItem);

        $response->assertSessionHasErrors([
            'quantity' => '個数は必須です',
            'month' => '購入月は必須です'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/buy_items/create');
    }

    // 他人の編集ページにアクセス
    public function testNonGetEdit()
    {
        $response = $this->actingAs($this->anotherUser)
            ->get('/buy_items/' . $this->buyItem->id . '/edit');

        $response->assertStatus(403);
    }

    // 更新で個数、月が空白
    public function testPutUpdateEmptyQuantityAndMonth()
    {
        $putBuyItem = [
            'quantity' => '',
            'price' => $this->item->price * 4,
            'month' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from('/buy_items/' . $this->buyItem->id . '/edit')
            ->put('/buy_items/' . $this->buyItem->id, $putBuyItem);

        $response->assertSessionHasErrors([
            'quantity' => '個数は必須です',
            'month' => '購入月は必須です'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/buy_items/' . $this->buyItem->id . '/edit');
    }
}
