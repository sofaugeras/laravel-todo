@extends("template")

@section("title", "Recherche de Todo")

@section("content")

    <!-- -- Page de résultats de la recherche de todos -- -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">
            @if($mot)
                Résultats pour « {{ $mot }} »
            @else
                Tous les résultats
            @endif
        </h1>
        <span class="text-muted">
            {{ $todos->total() }} résultat{{ $todos->total() > 1 ? 's' : '' }}
        </span>
    </div>
            <!-- Liste des TODOS-->
            <ul class="list-group">
                @if (session('validation'))
                    <p class="alert alert-success">{{ session('validation') }}</p>
                @endif
                @forelse ($todos as $todo)
                    <li class="list-group-item">
                        <!-- Affichage de la priorité -->
                        @if ($todo->important == 0)
                            <i class="bi bi-reception-1"></i>
                        @elseif ($todo->important == 1)
                            <i class="bi bi-reception-4"></i>
                        @endif

                        <!-- Affichage du texte -->
                        <span class="text-primary ">{{ $todo->texte }}</span>

                        <!-- Affichage de la date de création -->
                        <samp>créé le : {{ $todo->created_at }}</samp>
                        <!-- Affichage de la date de fin -->
                        <samp class="text-danger">à faire avant le : {{ $todo->date_fin }}</samp>
                        <!-- Nom de la liste associée --> 
                        <!-- Si un ToDo appartient à une liste, afficher le nom de la liste -->
                        @if ($todo->listes_id != NULL)
                        <div class="form-group">
                            <label><i class="bi bi-arrow-bar-right"></i> Appartient à la Liste : </label>
                            <span>{{ $todo->listes->titre}}</span>
                                
                        </div>
                        @endif
                        <!-- Affichage de la catégorie -->
                        @if(!empty($todo->categories) && $todo->categories->count() > 0)
                        <div class="form-group">
                            <label><i class="bi bi-boxes"></i>Catégories :</label>
                                @foreach($todo->categories as $category)
                                    <span>{{ $category->libelle }}</span>
                                @endforeach
                        </div>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item text-center">Aucun résultat trouvé !</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

@endsection
