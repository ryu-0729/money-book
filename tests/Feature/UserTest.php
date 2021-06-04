<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // App\Models\Userをインポート
use Illuminate\Support\Str; // Str::randomを使用したいため追記

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

    // 他人の詳細以外にアクセス
    public function testNonGetShow()
    {
        $response = $this->actingAs($this->user)
            ->get('/users/' . $this->anotherUser->id);

        $response->assertStatus(403);
    }

    // 自身の編集ページへのアクセス
    public function testGetEdit()
    {
        $response = $this->actingAs($this->user)
            ->get('/users/' . $this->user->id . '/edit');

        $response->assertStatus(200)
            ->assertViewIs('users.edit');
    }

    // 他人編集ページへのアクセス
    public function testNonGetEdit()
    {
        $response = $this->actingAs($this->user)
            ->get('/users/' . $this->anotherUser->id . '/edit');

        $response->assertStatus(403);
    }

    // 自身の更新処理
    public function testPutUpdate()
    {
        $updateData = [
            'name' => 'update User',
        ];

        $response = $this->actingAs($this->user)
            ->put('/users/' . $this->user->id, $updateData);

        $response->assertStatus(302)
            ->assertRedirect('/users/' . $this->user->id);

        $this->assertDatabaseHas('users', $updateData);
    }

    // 他人の更新処理
    public function testNonPutUpdate()
    {
        $updateData = [
            'name' => 'update User',
        ];

        $response = $this->actingAs($this->user)
            ->put('/users/' . $this->anotherUser->id, $updateData);

        $response->assertStatus(403);
    }

    // 自身の更新で名前が空白
    public function testPutUpdateEmptyName()
    {
        $updateData = [
            'name' => '',
        ];

        $response = $this->actingAs($this->user)
            ->from('/users/' . $this->user->id . '/edit')
            ->put('/users/' . $this->user->id, $updateData);

        $response->assertSessionHasErrors(['name' => '名前は必須項目です']);

        $response->assertStatus(302)
            ->assertRedirect('/users/' . $this->user->id . '/edit');
    }

    // 自身の更新で名前が255字以上
    public function testPutUpdateMaxLength()
    {
        $updateData = [
            'name' => Str::random(256),
        ];

        $response = $this->actingAs($this->user)
            ->from('/users/' . $this->user->id . '/edit')
            ->put('/users/' . $this->user->id, $updateData);

        $response->assertSessionHasErrors(['name' => '名前は255文字以内でお願いします']);

        $response->assertStatus(302)
            ->assertRedirect('/users/' . $this->user->id . '/edit');
    }
}
