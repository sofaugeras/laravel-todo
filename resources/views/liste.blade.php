@extends("template")

@section("title", "Ma Todo List")

@section("content")
<br />
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- Action -->
            <form action="{{ route('liste.save') }}" method="POST" class="addL">
                @csrf 
                <div class="d-flex input-group">
                    <input id="texte" name="texte" type="text" class="form-control" placeholder="Nom de la liste" aria-label="My new idea" aria-describedby="basic-addon1">
                    @if (session('message'))
                        <p class="alert alert-danger">{{ session('message') }}</p>
                    @endif
                    <button class="btn btn-outline-success" type="submit">Créer la liste</button>
                </div>
                <div class="form-group">
                <label>Les Todos</label>
                    
                    @foreach($todos as $todo)
                    <div class="form-check">
                    
                        <input class="form-check-input" type="checkbox" name="todos[]" value="{{ $todo->id }}">
                        <label class="form-check-label">{{ $todo->texte }}</label>
                    
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
<br />
<div class="container-fluid row justify-content-center alert alert-success" role="alert">
    <div class="col-4">
    Liste des todos classés par liste
    </div>
</div>
<br />
<!-- Liste des todos avec le titre de leur liste -->
@foreach ($listes as $liste)
<div class="container">
    <div class="card">
        <div class="card-body">
                <h6 class="card-title">{{ $liste->titre }}</h6>
                
                <ul>
                    @foreach ($liste->todos as $todo)
                        <li>{{ $todo->texte }}</li>
                    @endforeach
                </ul>
            </div>
    </div>
</div>
<br />
@endforeach
@endsection