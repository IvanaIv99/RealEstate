<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Unit::class;


    public function definition(): array
    {
        return [
            'id_type' => rand(1,2),
            'size' => rand(1,200),
            'address' => $this->faker->address(),
            'bedrooms' => rand(1,5),
            "price" => rand(10000,1000000),
            "latitude" => rand(-90,90),
            "longitude" => rand(-180,180)
        ];
    }
}
