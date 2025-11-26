@extends("template")

@section("title", "Ma Todo List")

@section("content")
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- Action -->
            <form action="{{ route('todo.save') }}" method="POST" class="add">
                @csrf <!-- <<L'annotation ici ! -->
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><span class="oi oi-pencil"></span></span>
                    <input id="texte" name="texte" type="text" class="form-control" placeholder="Prendre une note..." aria-label="My new idea" aria-describedby="basic-addon1">
                    @if (session('message'))
                        <p class="alert alert-danger">{{ session('message') }}</p>
                    @endif
                </div>
                <!-- Date de fin -->
                <input type="datetime-local" name="date_fin">
                
                <!-- Liste déroulante pour les listes -->
                <label for="liste">Si vous souhaitez affecter votre Todo à une liste :</label>
                <select name="liste" id="liste">
                    <option value="NULL"></option>
                    @foreach ($listes as $liste)
                        <option value="{{ $liste->id }}">{{ $liste->titre }}</option>
                    @endforeach
                </select>
                <!-- boites à cocher pour les catégories -->
                <div class="form-group">
                <label>Catégories :</label>
                @foreach($categories as $categorie)
                    <div class="form-check">
                    
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $categorie->id }}">
                        <label class="form-check-label">{{ $categorie->libelle }}</label>
                    
                    </div>
                    @endforeach
                </div>
                <!-- Bouton d'ajout pour déterminer la priorité 0 pour basse, 1 pour haute-->
               <div class="priority-choice">
                    Importance : 
                    <input type="radio" name="priority" id="lowpr" value="0" checked><label for="lowpr"><i class="bi bi-reception-1"></i></label>
                    <input type="radio" name="priority" id="highpr" value="1"><label for="highpr"><i class="bi bi-reception-4"></i></label>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i></button>
                </div>
                
            </form>
        
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
                        <!-- Action à ajouter pour Terminer et supprimer -->
                        @if ($todo->termine === 0)
                            <!-- Si un ToDo n'est pas terminé, Action à ajouter pour terminer -->
                            <a href="{{ route('todo.done', ['id' => $todo->id]) }}" class="btn btn-success"><i class="bi bi-check2-square"></i></a>
                            <!--<button class="btn btn-primary btn-lg"><span class="fa fa-user"></span><br>Terminer</button>-->
                        @elseif ($todo->termine === 1)
                            <!-- Si un ToDo est terminé, Action à ajouter pour supprimer -->
                            <a href="{{ route('todo.delete', ['id' => $todo->id]) }}" class="btn btn-danger"><i class="bi bi-trash3"></i></i></a>
                            
                        @endif
                        @if ($todo->important == 0)
                            <!-- Action à ajouter pour monter la priorité -->
                            <a href="{{ route('todo.raise', ['id'=> $todo->id]) }}"><i class="bi bi-arrow-up-circle"></i></a>
                        @elseif ($todo->important == 1)
                            <!-- Action à ajouter pour descendre la priorité -->
                            <a href="{{ route('todo.lower', ['id' => $todo->id]) }}"><i class="bi bi-arrow-down-circle"></i></a>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item text-center">C'est vide !</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
