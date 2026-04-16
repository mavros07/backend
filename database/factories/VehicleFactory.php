<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $make = $this->faker->randomElement(['Mercedes-Benz', 'Toyota', 'Honda', 'BMW', 'Lexus']);
        $model = $this->faker->randomElement(['C-Class', 'Highlander', 'Accord', 'X7', 'RX 350']);
        $year = (int) $this->faker->numberBetween(2005, (int) date('Y'));
        $title = $year . ' ' . $make . ' ' . $model;
        $slug = Str::slug($title . '-' . Str::random(6));

        return [
            'user_id' => 1,
            'title' => $title,
            'slug' => $slug,
            'status' => 'draft',
            'year' => $year,
            'make' => $make,
            'model' => $model,
            'price' => $this->faker->numberBetween(5000, 250000),
            'mileage' => $this->faker->numberBetween(0, 180000),
            'transmission' => $this->faker->randomElement(['Automatic', 'Manual']),
            'fuel_type' => $this->faker->randomElement(['Petrol', 'Diesel', 'Hybrid', 'Electric']),
            'drive' => $this->faker->randomElement(['FWD', 'RWD', 'AWD', '4WD']),
            'body_type' => $this->faker->randomElement(['Sedan', 'SUV', 'Roadster']),
            'condition' => $this->faker->randomElement(['new', 'used']),
            'engine_size' => $this->faker->randomElement(['2.0L', '3.5L V6', 'Electric']),
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'features' => $this->faker->randomElements(
                ['Leather seats', 'Sunroof', 'Navigation', 'Backup camera', 'Heated seats'],
                $this->faker->numberBetween(1, 3)
            ),
            'exterior_color' => $this->faker->safeColorName(),
            'interior_color' => $this->faker->safeColorName(),
            'vin' => strtoupper(Str::random(17)),
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
