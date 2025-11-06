<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Listes;
use App\Models\Todos;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    // Liste
    public function liste()
    {
        // Chargement des todos pour l'utilisateur connecté
        $todos = Todos::all()->where('user_id', auth()->user()->id);
        // Chargement des listes pour les todos pour éventuellement affecter une liste à un todo
        // affichage uniquement si le todo n'appartient pas déjà à une liste
        // if($todos->listes_id == NULL){
        $todos->load('listes');
        // }
        // Chargement des catégories pour les boites à cocher
        $categories = Categories::all();
        // Chargement des listes pour la liste déroulante
        $listes = Listes::all();

        return view('home', compact('todos', 'categories', 'listes'));
    }

    public function saveTodo(Request $request)
    {
        // Vérification des entrées du formulaire
        $request->validate([
            'texte' => 'required|string|max:255',
        ]);
        // Récupération des données du formulaire
        $texte = $request->input('texte');
        $button = $request->input('priority');
        $cats = $request->input('categories');
        $liste = $request->input('liste');
        $date = $request->input('date_fin');
        // Vérification de la saisie
        if ($texte) {
            // Création d'un nouvel objet ToDo (Instance de la classe Todos)
            $todo = new Todos;
            // Récupération du texte du ToDo
            $todo->texte = $texte;
            // Récupération de l'id de l'utilisateur connecté
            $todo->user_id = $request->user()->id;
            // Récupération de la date de fin
            $todo->date_fin = $date;
            // Initialisation de la priorité et de l'état de la tâche
            $todo->termine = 0;
            if ($button == '1') {
                $todo->Important = 1;
            } elseif ($button == '0') {
                $todo->Important = 0;
            }

            // Sauvegarde de la liste
            if ($liste != 'NULL') {
                $todo->listes_id = $liste;
            }
            // Sauvegarde du todo
            $todo->save();
            // Sauvegarde des catégories du todo
            $todo->categories()->attach($cats);

            // Redirection vers la page d'accueil
            return redirect()->route('todo.liste');
        } else {
            return redirect()->route('todo.liste')->with('message', 'Veuillez saisir un ToDo à ajouter');
        }

    }

    public function markAsDone($id)
    {
        $todo = Todos::find($id);
        if ($todo) {
            $todo->termine = 1;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    public function deleteTodo($id)
    {
        $todo = Todos::find($id);
        if ($todo->termine == 1) {
            $todo->Delete();
        }

        return redirect()->route('todo.liste')->with('validation', 'ToDo correctement supprimé');
    }

    public function viewAPropos()
    {
        return view('apropos');
    }

    public function lowerPriority($id)
    {
        $todo = Todos::find($id);
        if ($todo) {
            $todo->Important = 0;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    public function raisePriority($id)
    {
        $todo = Todos::find($id);
        if ($todo) {
            $todo->Important = 1;
            $todo->save();
        }

        return redirect()->route('todo.liste');
    }

    public function viewCompteur()
    {
        // Code verbeux, mais avec mise en évidence des étapes
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

    public function planning()
    {
        // Chargement des todos pour l'utilisateur connecté pour le planning trié par date de fin
        // uniquement si une date de fin et si non terminé
        $todos = Todos::all()->where('user_id', auth()->user()->id)
            ->where('termine', 0)
            ->whereNotNull('date_fin')
            ->sortBy('date_fin');

        return view('planning', compact('todos'));
    }

    /* Utilise POST côté accueil, mais redirige en GET vers la page résultats */
    public function search(Request $request)
    {
        // Récupère le mot à rechercher depuis la query-string (GET). Toujours une chaîne.
        $mot = $request->string('mot')->toString();

        // Construis la requête sur le modèle (remplace Todos par ton modèle réel si besoin).
        $todos = Todos::query()
            // Filtre seulement si un terme est fourni.
            // when($q, ...) évite d’ajouter la clause si $q est vide.
            ->when($mot, fn ($qq) =>
                // Regroupe les conditions de recherche dans une sous-clause where(...)
                $qq->where(fn ($w) =>
                    // LIKE %mot% sur la colonne 'texte'. Ajoute d’autres colonnes ici si nécessaire.
                    $w->where('texte', 'like', "%{$mot}%")
                )
            )
            // Trie du plus récent au plus ancien.
            ->orderByDesc('created_at')
            // Pagination 15 par page.
            ->paginate(15)
            // Conserve les paramètres de la query-string (ex: ?q=...) dans les liens de pagination.
            ->withQueryString();

        // Retourne la vue résultats avec la liste paginée et le terme saisi.
        return view('search', compact('todos', 'mot'));
    }

    /**
     * Reçoit le POST du formulaire d’accueil.
     * Valide puis applique le pattern PRG : POST -> Redirect -> GET.
     * Avantages : pas de re-soumission au rafraîchissement, URL partageable, pagination simple.
     */
    public function searchSubmit(Request $request)
    {
        // Validation minimale du champ mot.
        $data = $request->validate([
            'mot' => ['nullable', 'string', 'max:100'],
        ]);

        // Redirige vers la route GET des résultats avec ?mot=...
        return redirect()->route('todos.search', $data); // redirige vers la page résultats
    }
}
