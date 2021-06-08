<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // App\Models\Userをインポート

class MoneyTest extends TestCase
{
    use RefreshDatabase; //既存のデータに依存しないようにする

    public function setUp() :void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    // 金額集計ページへのアクセス
    public function testGetMoney()
    {
        $response = $this->actingAs($this->user)
            ->get('/monies');

        $response->assertStatus(200)
            ->assertViewIs('monies.total');
    }
}
