<?php

use Illuminate\Database\Seeder;
use App\Models\UserGoal;

class UserGoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserGoal::class, 20)->create();
    }
}
