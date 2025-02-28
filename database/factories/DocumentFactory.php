<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => uniqid('file_'),
            'type' => DocumentType::Notarius,
            'path' => fake()->url(),
            'data' => json_encode([], true),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
