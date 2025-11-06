@extends("template")

@section("title", "Ma Todo List")

@section("content")
<br />

<div class="container-fluid row justify-content-center alert alert-success" role="alert">
    <div class="col-4">
    Liste des todos classés par date
    </div>
</div>
<br />
<!-- Liste des todos classés par date -->
@foreach ($todos as $todo)
<div class="container">
    <div class="card">
        <div class="card-body">
                <span>{{ $todo->texte }}</span> 
                <samp>{{ $todo->date_fin }}</samp>
        </div>
    </div>
</div>
<br />
@endforeach

@endsection