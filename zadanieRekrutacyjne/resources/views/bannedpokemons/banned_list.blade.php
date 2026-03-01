<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="pokemonApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lista zakazanych pokemonów</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
        <script>
            window.bannedPokemonsData = @json($bannedPokemons);
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/services/BannedService.js"></script>
        <script src="/js/controllers/BannedPokemonsController.js"></script>
    </head>
    <body ng-controller="BannedPokemonsController">
        <div class="container">
            <h1>Lista zakazanych pokemonów</h1>

            <div class="message" ng-class="{'message-ok': messageType === 'ok', 'message-error': messageType === 'error'}" ng-if="message">
                @{{ message }}
            </div>

            <div class="form-row">
                <input type="password" ng-model="secretKey" placeholder="Klucz API">
            </div>

            <div class="form-row">
                <select ng-model="selectedPokemon">
                    <option value="">Wybierz pokemona...</option>
                    @foreach ($pokemons as $pokemon)
                        <option value="{{ $pokemon['name'] }}">{{ ucfirst($pokemon['name']) }}</option>
                    @endforeach
                </select>
                <input type="text" ng-model="reason" placeholder="Powód zakazu (opcjonalnie)">
                <button class="btn btn-primary" ng-click="addBannedPokemon()">Dodaj</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Powód</th>
                        <th style="text-align: right;">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="pokemon in bannedPokemons">
                        <td>@{{ pokemon.name | capitalize }}</td>
                        <td>@{{ pokemon.reason || '—' }}</td>
                        <td style="text-align: right;">
                            <button class="btn-delete" ng-click="deleteBannedPokemon(pokemon.id)">Usuń</button>
                        </td>
                    </tr>
                    <tr ng-if="bannedPokemons.length === 0">
                        <td colspan="3" class="empty-state">Brak zakazanych pokemonów.</td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">
                <a href="/" class="btn btn-back">Powrót</a>
            </div>
        </div>
    </body>
</html>
