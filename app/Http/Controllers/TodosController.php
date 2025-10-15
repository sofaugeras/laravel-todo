<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Todos;
use App\Models\Categories;
// use App\Models\Listes;
// use App\Models\users;
use App\Http\Controllers\CategoriesController;

class TodosController extends Controller
{
    //Liste
    public function liste()
    {   
        //Chargement des todos pour l'utilisateur connecté
        $todos = Todos::all();
        return view("home", ["todos" => $todos, "categories" => Categories::all()]);
    }

    public function saveTodo(Request $request){
        //Récupération des données du formulaire
        $texte = $request->input('texte');
        $button = $request->input('priority');
        $cats = $request->input('categories');
        //Vérification de la saisie
        if($texte){
            //Création d'un nouvel objet ToDo (Instance de la classe Todos)
            $todo = new Todos();
            //Récupération du texte du ToDo
            $todo->texte = $texte;  
            //Initialisation de la priorité et de l'état de la tâche
            $todo->termine = 0;
            if($button=='1'){
                $todo->Important = 1;
            } elseif($button=='0'){
                $todo->Important = 0;
            };
            //Sauvegarde du todo
            $todo->save();
            //Redirection vers la page d'accueil
            return redirect()->route('todo.liste');
        } else{
            return redirect()->route('todo.liste')->with('message', "Veuillez saisir un ToDo à ajouter");
        }

    }

    public function markAsDone($id){
        $todo = Todos::find($id);
        if($todo){
            $todo->termine = 1;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    public function deleteTodo($id){
        $todo = Todos::find($id);
        if($todo->termine == 1){
            $todo->Delete();
        }

        return redirect()->route('todo.liste')->with('validation', "ToDo correctement supprimé");
    }

    public function viewAPropos(){
        return view('apropos');
    }

    public function lowerPriority($id){
        $todo = Todos::find($id);
        if($todo){
            $todo->Important = 0;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    public function raisePriority($id){
        $todo = Todos::find($id);
        if($todo){
            $todo->Important = 1;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    function viewCompteur(){
        //Code verbeux, mais avec mise en évidence des étapes
        // $compteNonTerm = 0;
        // $compteTerm = 0;
        // $todos = Todos::all();

        // foreach($todos as $todo){
        //     if($todo->termine == 0){
        //         $compteNonTerm += 1;
        //     }
        //     if ($todo->termine == 1){
        //         $compteTerm += 1;
        //     }
        // }

        // Compter le nombre de todos non terminés
        $compteNonTerm = Todos::where('termine', 0)->count();
        // Compter le nombre de todos terminés
        $compteTerm = Todos::where('termine', 1)->count();
        // Compter le nombre de todos supprimés
        $compteSuppr = Todos::onlyTrashed()->count();

        return view('compteur', compact('compteNonTerm', 'compteTerm', 'compteSuppr'));
    }

    // function planning(){
    //     //Chargement des todos pour l'utilisateur connecté pour le planning trié par date de fin
    //     //uniquement si une date de fin et si non terminé
    //     $todos = Todos::all()->where('user_id', auth()->user()->id)
    //                         ->where('termine', 0)
    //                         ->whereNotNull('date_fin')
    //                         ->sortBy('date_fin');

    //     return view('planning', compact('todos'));
    // }   
}

