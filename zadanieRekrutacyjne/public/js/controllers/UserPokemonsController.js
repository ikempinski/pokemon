app.controller('UserPokemonsController', ['$scope', '$window', 'UserPokemonsService', function ($scope, $window, UserPokemonsService) {

    $scope.secretKey = '';
    $scope.pokemonName = '';
    $scope.message = '';
    $scope.messageType = '';
    $scope.userPokemons = $window.userPokemonsData || [];
    $scope.pokemons = $window.pokemonsData || [];

    var params = new URLSearchParams($window.location.search);
    var msg = params.get('msg');
    var type = params.get('type');
    if (msg) {
        $scope.message = msg;
        $scope.messageType = type;
        history.replaceState(null, '', $window.location.pathname);
    }

    $scope.showMessage = function (text, type) {
        $scope.message = text;
        $scope.messageType = type;
    };

    $scope.reloadWithMessage = function (text, type) {
        var url = new URL($window.location.href);
        url.searchParams.set('msg', text);
        url.searchParams.set('type', type);
        $window.location.href = url.toString();
    };

    $scope.addUserPokemon = function () {
        if (!$scope.secretKey) {
            $scope.showMessage('Podaj klucz API (X-SUPER-SECRET-KEY)!', 'error');
            return;
        }

        if (!$scope.pokemonName) {
            $scope.showMessage('Podaj nazwę pokemona!', 'error');
            return;
        }

        var alreadyExistsPokemon = $scope.userPokemons.some(function (p) {
            return p.name.toLowerCase() === $scope.pokemonName.toLowerCase();
        });

        var existsInPokeApi = $scope.pokemons.some(function (p) {
            return p.name.toLowerCase() === $scope.pokemonName.toLowerCase();
        });

        if (existsInPokeApi) {
            $scope.showMessage('Pokemon o nazwie ' + $scope.pokemonName + ' już istnieje w PokeAPI!', 'error');
            return;
        }

        if (alreadyExistsPokemon) {
            $scope.showMessage('Pokemon o nazwie ' + $scope.pokemonName + ' już istnieje na liście własnych pokemonów!', 'error');
            return;
        }

        UserPokemonsService.addUserPokemon($scope.pokemonName, $scope.secretKey)
            .then(function () {
                $scope.reloadWithMessage('Pokemon został dodany do listy własnych pokemonów', 'ok');
            })
            .catch(function (error) {
                if (error.status === 401) {
                    $scope.showMessage('Nieprawidłowy klucz API!', 'error');
                } else {
                    $scope.showMessage('Błąd podczas dodawania pokemona do listy własnych pokemonów', 'error');
                }
            });
    };

    $scope.deleteUserPokemon = function (id) {
        if (!$scope.secretKey) {
            $scope.showMessage('Podaj klucz API (X-SUPER-SECRET-KEY)!', 'error');
            return;
        }

        UserPokemonsService.deleteUserPokemon(id, $scope.secretKey)
            .then(function () {
                $scope.reloadWithMessage('Pokemon został usunięty z listy własnych pokemonów', 'ok');
            })
            .catch(function (error) {
                if (error.status === 401) {
                    $scope.showMessage('Nieprawidłowy klucz API!', 'error');
                } else {
                    $scope.showMessage('Błąd podczas usuwania pokemona z listy własnych pokemonów', 'error');
                }
            });
    };

}]);
