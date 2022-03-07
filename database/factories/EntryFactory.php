<?php

namespace Database\Factories;

use App\Models\Entry;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->word,
            'date' => $this->faker->date,
            'text' => $this->faker->text,
            'uuid' => $this->faker->uuid,
            'file' => $this->faker->text(255),
            'datetime' => $this->faker->dateTime,
            'bool' => $this->faker->boolean,
            'number' => $this->faker->randomNumber(2),
            'json' => [],
        ];
    }
}
