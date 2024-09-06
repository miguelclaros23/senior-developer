<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\StatusEnum;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'title' => fake()->name()." Task ",
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(StatusEnum::cases())->value,
            'due_date' =>  now(),
            'type' => 0,
        ];
    }

}
