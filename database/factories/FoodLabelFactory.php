<?php

namespace Database\Factories;

use App\Models\FoodLabel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodLabel>
 */
class FoodLabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = 'Paket '.fake()->words(3, true);
        $date = fake()->dateTimeBetween('-1 month', '+1 week')->format('Y-m-d');

        return [
            'title' => $title,
            'slug' => FoodLabel::generateUniqueSlug($title, $date),
            'menu_date' => $date,
            'recipient_group' => fake()->randomElement(['Siswa SD', 'Balita & Ibu Hamil', 'Umum']),
            'description' => fake()->sentence(),
            'energy' => fake()->randomFloat(2, 450, 750),
            'protein' => fake()->randomFloat(2, 15, 30),
            'fat' => fake()->randomFloat(2, 10, 25),
            'carbohydrate' => fake()->randomFloat(2, 60, 95),
            'fiber' => fake()->randomFloat(2, 4, 10),
            'consumption_limit_hours' => fake()->randomElement([3.0, 3.5, 4.0, 4.5]),
            'status' => 'published',
            'published_at' => now(),
            'created_by' => User::factory(),
            'updated_by' => null,
        ];
    }

    /**
     * Indicate that the label is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the label is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }
}
