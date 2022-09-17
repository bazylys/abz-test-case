<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positionsIds = Position::query()->pluck('id');

        $usersCount = 45;

        while ($usersCount > 0) {

            User::factory()->create([
                'position_id' => $positionsIds->random(),
            ]);

            $usersCount--;
        }


    }
}
