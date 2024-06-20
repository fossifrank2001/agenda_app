<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'logo' => $this->faker->imageUrl(100, 100, 'business'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Group $group) {
            $users = User::inRandomOrder()->take(rand(1, 5))->pluck('id');
            $group->users()->attach($users);
        });
    }
}
