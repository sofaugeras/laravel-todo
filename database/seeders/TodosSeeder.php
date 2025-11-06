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
            ['texte' => 'Faire les courses', 'termine' => 0 , 'important' => 1 , 'listes_id'=>1, 'user_id'=>1, 'date_fin'=>'2025-01-30'],
            ['texte' => 'Acheter du pain', 'termine' => 0 , 'important' => 0, 'listes_id'=>1,'user_id'=>1, 'date_fin'=>'2025-11-30'],
            ['texte' => 'Acheter du lait', 'termine' => 0 , 'important' => 0, 'listes_id'=>1,'user_id'=>1, 'date_fin'=>'2025-02-03'],
            ['texte' => 'Acheter des oeufs', 'termine' => 0 , 'important' => 0, 'listes_id'=>2,'user_id'=>1, 'date_fin'=>'2025-07-23'],
            ['texte' => 'Acheter du beurre', 'termine' => 0 , 'important' => 0, 'listes_id'=>2,'user_id'=>1, 'date_fin'=>'2025-11-30'],
            ['texte' => 'Acheter des pâtes', 'termine' => 0 , 'important' => 0, 'listes_id'=>2,'user_id'=>1, 'date_fin'=>'2025-11-30'],
            ['texte' => 'Réviser pour l examen', 'termine' => 0 , 'important' => 1, 'listes_id'=>NULL,'user_id'=>2,'date_fin'=>'2023-11-30'],
            ['texte' => 'Aller à la salle de sport', 'termine' => 1, 'important' => 0, 'listes_id'=>NULL,'user_id'=>1,'date_fin'=>'2023-11-30'],
            // Ajoutez d'autres tâches au besoin
        ];
        // Insertion des données dans la table 'categories'
        DB::table('todos')->insert($todos);
    }

    
}
?>