<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Listes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listes>
 */
class ListesFactory extends Factory
{
   protected $model = Listes::class;

    public function definition(): array
    {
        return [
            'titre' => fake()->words(2, true), // par ex. "Maison", "Bureau perso"
        ];
    }

}
