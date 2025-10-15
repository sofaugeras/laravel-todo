<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
    
    
use App\Models\Todos;

class TodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemples de tâches
        $todos = [
            ['texte' => 'Faire les courses', 'termine' => 0 , 'important' => 1 ],
            ['texte' => 'Acheter du pain', 'termine' => 0 , 'important' => 0],
            // Ajoutez d'autres tâches au besoin
        ];
        // Insertion des données dans la table 'categories'
        DB::table('todos')->insert($todos);
    }

    
}
?>