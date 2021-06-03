<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // App\Models\Userをインポート

class UserTest extends TestCase
{
    use RefreshDatabase; //既存のデータに依存しないようにする

    public function setUp() :void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->anotherUser = factory(User::class)->create();
    }

    // 自身の編集ページにアクセス
    public function testGetShow()
    {
        $response = $this->actingAs($this->user)
            ->get('/users/' . $this->user->id);

        $response->assertStatus(200)
            ->assertViewIs('users.show');
    }

    // 自身の詳細以外にアクセス
    public function testNonGetShow()
    {
        $response = $this->actingAs($this->user)
            ->get('/users/' . $this->anotherUser->id);

        $response->assertStatus(403);
    }
}
