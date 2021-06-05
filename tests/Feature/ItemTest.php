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

        $this->item = factory(Item::class)->create();

        $this->user = factory(User::class)->create();
    }

    // 一覧画面へのアクセス
    public function testGetIndex()
    {
        $reponse = $this->actingAs($this->user)
            ->get('/items');

        $reponse->assertStatus(200)
            ->assertViewIs('items.index');
    }
}
