<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'group_id' => Group::factory(),
            'status' => Activity::PROCCESSING,
            'start_time' => $this->faker->dateTimeBetween('+0 days', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'place' => $this->faker->address,
        ];
    }
}
