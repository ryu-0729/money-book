<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class, 2)->create([
            'role' => '管理者'
        ]);
    }
}
