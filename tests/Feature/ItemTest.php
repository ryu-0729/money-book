<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item; // App\Models\Itemをインポート
use App\Models\User; // App\Models\Userをインポート

class ItemTest extends TestCase
{
    use RefreshDatabase; //既存のデータに依存しないようにする

    public function setUP() :void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->item = factory(Item::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->anotherUser = factory(User::class)->create();
    }

    // 一覧画面へのアクセス
    public function testGetIndex()
    {
        $reponse = $this->actingAs($this->user)
            ->get('/items');

        $reponse->assertStatus(200)
            ->assertViewIs('items.index');
    }

    // 商品登録画面へのアクセス
    public function testGetCreate()
    {
        $response = $this->actingAs($this->user)
            ->get('/items/create');

        $response->assertStatus(200)
            ->assertViewIs('items.create');
    }

    // 商品登録
    public function testPostStore()
    {
        $postItem = [
            'name' => 'test',
            'price' => 1500,
        ];
        
        $response = $this->actingAs($this->user)
            ->post('/items', $postItem);

        $response->assertStatus(302)
            ->assertRedirect('/items');

        $this->assertDatabaseHas('items', $postItem);
    }

    // 商品登録で商品名、金額が空白
    public function testPostStoreEmptyNameAndPrice()
    {
        $postItem = [
            'name' => '',
            'price' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from('/items/create')
            ->post('/items', $postItem);

        $response->assertSessionHasErrors([
            'name' => '商品名は必須です',
            'price' => '金額は必須です'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/items/create');
    }

    // 商品登録で金額が負の数
    public function testPostStoreInvalidPrice()
    {
        $postItem = [
            'name' => 'test',
            'price' => -2,
        ];

        $response = $this->actingAs($this->user)
            ->from('/items/create')
            ->post('/items', $postItem);

        $response->assertSessionHasErrors([
            'price' => '金額が不正の値です'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/items/create');
    }

    // 他人の詳細ページへのアクセス
    public function testNonGetShow()
    {
        $response = $this->actingAs($this->anotherUser)
            ->get('/items/' . $this->item->id);

        $response->assertStatus(403);
    }

    // 他人の編集ページにアクセス
    public function testNonGetEdit()
    {
        $response = $this->actingAs($this->anotherUser)
            ->get('/items/' . $this->item->id . '/edit');

        $response->assertStatus(403);
    }

    // 更新で商品名、金額が空白
    public function testPutUpdateEmptyNameAndPrice()
    {
        $updateData = [
            'name' => '',
            'price' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from('/items/' . $this->item->id . '/edit')
            ->put('/items/' . $this->item->id, $updateData);

        $response->assertSessionHasErrors([
            'name' => '商品名は必須です',
            'price' => '金額は必須です',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/items/' . $this->item->id . '/edit');
    }

    // 登録商品削除
    public function testSoftDelete()
    {
        $this->assertDatabaseHas('items', $this->item->toArray());

        $response = $this->actingAs($this->user)
            ->delete('/items/' . $this->item->id);

        $response->assertStatus(302)
            ->assertRedirect('/items');
    }
}
