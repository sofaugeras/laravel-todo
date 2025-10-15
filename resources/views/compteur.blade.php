@extends("template")

@section("title", "Ma Todo List")

@section("content")
<br />  <br />  
<div class="container">
    <div class="card">
        <div class="card-body">
        <li class="nav-item active">
            <i class="bi bi-card-checklist"></i>Nombre de tâches non terminées : {{$compteNonTerm}}
        </li>
        <li class="nav-item active">
            <i class="bi bi-card-checklist"></i>Nombre de tâches terminées : {{$compteTerm}}
        </li>
        <li class="nav-item active">
            <i class="bi bi-card-checklist"></i>Nombre de tâches supprimées : {{$compteSuppr}}
        </li>
        <li class="nav-item active">
            <i class="bi bi-card-checklist"></i>Nombre de tâches total : {{$compteNonTerm + $compteTerm + $compteSuppr}}
        </li>
    </div>
</div>  
@endsection