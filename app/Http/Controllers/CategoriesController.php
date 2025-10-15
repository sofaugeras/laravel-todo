<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Categories;


class CategoriesController extends Controller
{
     /**
     * Affiche la liste des catégories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', compact('categories'));

        
    }

    /**
     * Affiche la liste des catégories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeCatégories()
    {
        return view("home", ["categories" => Categories::all()]);
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'libelle' => 'required|string|max:255',
            // Ajoutez d'autres règles de validation au besoin
        ]);

        // Création d'une nouvelle catégorie
        Categorie::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Affiche les détails d'une catégorie spécifique.
     *
     * @param  int  $idcat
     * @return \Illuminate\Http\Response
     */
    public function show($idcat)
    {
        $categorie = Categorie::findOrFail($idcat);
        return view('categories.show', compact('categorie'));
    }
}
