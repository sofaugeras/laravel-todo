<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'libelle' => 'Pro'],
            ['id' => 2, 'libelle' => 'Famille'],
            ['id' => 3, 'libelle' => 'Sport'],
            ['id' => 4, 'libelle' => 'Associatif'],
            // Ajoutez d'autres catégories au besoin
        ];

        // Insertion des données dans la table 'categories'
        DB::table('categories')->insert($categories);
    }
}
