<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Todos;
use App\Models\Listes;

class ListeController extends Controller
{
    //Liste
    public function viewliste()
    {
        //Partie formulaire
        //Recup de la liste des todos non encore attribués à une liste
        $todos = Todos::whereNull('listes_id')->get();
        //Partie affichage de la liste
        //Recup de la liste des listes avec leurs Todos
        $listes = Listes::with('todos')->get();
        return view('liste', compact('todos',  'listes'));
    }

    public function saveListe(Request $request){
        //Recup du titre de la liste
        $texte = $request->input('texte');
        //Recup des todos à ajouter à la liste : tableau de id
        $todos = $request->input('todos');

        if($texte){
            //Instanciation du model de la liste
            $liste = new Listes();
            //Affectation du titre
            $liste->titre = $texte;
            $liste->save();
            //Pour chaque todo à ajouter, on met à jour le champ listes_id, avec l'id de la liste nouvellement créée
            foreach($todos as $todo){
                $todo = Todos::find($todo);
                $todo->listes_id = $liste->id;
                $todo->save();
            }
            return redirect()->route('liste.liste');
        } else{
            return redirect()->route('liste.liste')->with('message', "Veuillez saisir une liste à ajouter");
        }

    }
}
