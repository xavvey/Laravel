<?php

namespace Database\Seeders;

use Modules\ProfileManagement\Entities\Profile;
use Modules\profileManagement\Database\Factories\ProfileFactory;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::factory()->count(100)->create();
    }
}
