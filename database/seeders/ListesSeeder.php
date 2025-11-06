<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listes = [
            ['titre' => 'Liste 1'],
            ['titre' => 'Urgentissime'],

        ];

        // Insertion des données dans la table 'categories'
        DB::table('listes')->insert($listes);
    }
}
