<?php

namespace Modules\ProfileManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ProfileManagement\Entities\Profile;

class ProfileFactory extends Factory
{

    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '0612345678',
            'user_id' => 1,
            'profile_pic_id' => null,
        ];
    }
}
