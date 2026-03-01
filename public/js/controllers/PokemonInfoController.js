app.controller('PokemonInfoController', ['$scope', 'InfoService', 'BannedService', function ($scope, InfoService, BannedService) {

    $scope.selectedPokemon = '';
    $scope.selectedPokemons = [];
    $scope.pokemonInfoList = [];
    $scope.bannedPokemons = [];
    $scope.loading = false;
    $scope.message = '';
    $scope.messageType = '';

    BannedService.getAllBannedPokemons()
        .then(function (data) {
            $scope.bannedPokemons = data;
        })
        .catch(function () {
            $scope.message = 'Błąd podczas pobierania listy zakazanych pokemonów';
            $scope.messageType = 'error';
        });

    $scope.addPokemonToList = function () {
        var name = $scope.selectedPokemon;
        if (!name) return;

        var alreadyAdded = $scope.selectedPokemons.some(function (p) {
            return p === name;
        });
        if (alreadyAdded) return;

        $scope.selectedPokemons.push(name);
        $scope.selectedPokemon = '';
    };

    $scope.removePokemon = function (name) {
        $scope.selectedPokemons = $scope.selectedPokemons.filter(function (p) {
            return p !== name;
        });
    };

    $scope.showPokemonInfo = function () {
        if ($scope.selectedPokemons.length === 0) {
            $scope.message = 'Wybierz przynajmniej jednego pokemona!';
            $scope.messageType = 'error';
            return;
        }

        var foundBanned = [];
        var allowed = [];

        for (var i = 0; i < $scope.selectedPokemons.length; i++) {
            var name = $scope.selectedPokemons[i];
            var isBanned = $scope.bannedPokemons.some(function (b) {
                return b.name === name;
            });

            if (isBanned) {
                foundBanned.push(name);
            } else {
                allowed.push(name);
            }
        }

        if (foundBanned.length > 0) {
            $scope.selectedPokemons = allowed;
            $scope.message = 'Pokemony: ' + foundBanned.join(', ') + ' są zakazane, zostały usunięte z listy!';
            $scope.messageType = 'error';
            return;
        }

        $scope.loading = true;
        $scope.message = '';
        $scope.pokemonInfoList = [];

        InfoService.getInfo($scope.selectedPokemons)
            .then(function (data) {
                $scope.pokemonInfoList = data;
            })
            .catch(function () {
                $scope.message = 'Błąd podczas pobierania informacji';
                $scope.messageType = 'error';
            })
            .finally(function () {
                $scope.loading = false;
            });
    };

}]);
