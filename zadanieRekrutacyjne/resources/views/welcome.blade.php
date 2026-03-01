<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
    </head>
    <body>
        <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
            <a href="/banned" class="btn btn-primary">Lista zakazanych pokemonów</a>
            <a href="/pokemons" class="btn btn-primary">Informacje o pokemonach</a>
            <a href="/userpokemons" class="btn btn-primary">Własne pokemony</a>
        </div>
    </body>
</html>
