<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="pokemonApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Informacje o pokemonach</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css'])
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/services/InfoService.js"></script>
        <script src="/js/services/BannedService.js"></script>
        <script src="/js/controllers/PokemonInfoController.js"></script>
    </head>
    <body ng-controller="PokemonInfoController">
        <div class="container">
            <h1>Informacje o pokemonach</h1>

            <div class="message" ng-class="{'message-ok': messageType === 'ok', 'message-error': messageType === 'error'}" ng-if="message">
                @{{ message }}
            </div>

            <div class="form-row">
                <select ng-model="selectedPokemon" ng-change="addPokemonToList()">
                    <option value="">Wybierz pokemona...</option>
                    @foreach ($pokemons as $pokemon)
                        <option value="{{ $pokemon['name'] }}">{{ ucfirst($pokemon['name']) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-row form-row-center">
                <label>Lista pokemonów: <span>(@{{ selectedPokemons.length }})</span></label>
                <button class="btn btn-primary" ng-click="showPokemonInfo()" ng-disabled="loading">
                    <span ng-if="!loading">Pokaż informacje</span>
                    <span ng-if="loading">Ładowanie...</span>
                </button>
            </div>

            <ul class="pokemon-list" ng-if="selectedPokemons.length > 0">
                <li ng-repeat="pokemon in selectedPokemons">
                    <span>@{{ pokemon | capitalize }}</span>
                    <button class="btn-delete" ng-click="removePokemon(pokemon)">Usuń</button>
                </li>
            </ul>

            <div ng-if="pokemonInfoList.length > 0">
                <h2>Wyniki</h2>
                <div class="pokemon-card" ng-repeat="pokemon in pokemonInfoList">
                    <div class="pokemon-card-header">
                        <img ng-src="@{{ pokemon.sprite }}" alt="@{{ pokemon.name }}" class="pokemon-sprite">
                        <div>
                            <h3>@{{ pokemon.name | capitalize }} <span class="pokemon-id">#@{{ pokemon.id }}</span></h3>
                            <div class="pokemon-types">
                                <span class="pokemon-type" ng-repeat="type in pokemon.types">@{{ type }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="pokemon-details">
                        <div class="pokemon-measure">
                            <span class="label">Wzrost</span>
                            <span>@{{ pokemon.height / 10 }} m</span>
                        </div>
                        <div class="pokemon-measure">
                            <span class="label">Waga</span>
                            <span>@{{ pokemon.weight / 10 }} kg</span>
                        </div>
                    </div>
                    <div class="pokemon-stats">
                        <div class="pokemon-stat" ng-repeat="stat in pokemon.stats">
                            <span class="stat-name">@{{ stat.name }}</span>
                            <span class="stat-value">@{{ stat.value }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <a href="/" class="btn btn-back">Powrót</a>
            </div>
        </div>
    </body>
</html>
