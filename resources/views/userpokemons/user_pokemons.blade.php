<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="pokemonApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Własne pokemony</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
        <script>
            window.userPokemonsData = @json($userPokemons);
            window.pokemonsData = @json($pokemons);
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/services/UserPokemonsService.js"></script>
        <script src="/js/controllers/UserPokemonsController.js"></script>
    </head>
    <body ng-controller="UserPokemonsController">
        <div class="container">
            <h1>Własne pokemony</h1>

            <div class="message" ng-class="{'message-ok': messageType === 'ok', 'message-error': messageType === 'error'}" ng-if="message">
                @{{ message }}
            </div>

            <div class="form-row">
                <input type="password" ng-model="secretKey" placeholder="Klucz API">
            </div>

            <div class="form-row">
                <input type="text" ng-model="pokemonName" placeholder="Nazwa pokemona">
                <button class="btn btn-primary" ng-click="addUserPokemon()">Dodaj</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th style="text-align: right;">Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="pokemon in userPokemons">
                        <td>@{{ pokemon.name }}</td>
                        <td style="text-align: right;">
                            <button class="btn-delete" ng-click="deleteUserPokemon(pokemon.id)">Usuń</button>
                        </td>
                    </tr>
                    <tr ng-if="userPokemons.length === 0">
                        <td colspan="2" class="empty-state">Brak własnych pokemonów.</td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">
                <a href="/" class="btn btn-back">Powrót</a>
            </div>
        </div>
    </body>
</html>
