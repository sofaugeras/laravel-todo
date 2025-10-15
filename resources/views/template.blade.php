<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>



        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Ma Todo List</a>
            <a class="btn btn-primary ms-3" href="liste">Liste</a>
            <a class="btn btn-danger ms-3" href="compteur">Compteur</a>
        </nav>

        @yield('content')

    </body>
</html>