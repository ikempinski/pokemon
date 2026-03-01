app.controller('BannedPokemonsController', ['$scope', '$window', 'BannedService', function ($scope, $window, BannedService) {

    $scope.secretKey = '';
    $scope.selectedPokemon = '';
    $scope.reason = '';
    $scope.message = '';
    $scope.messageType = '';
    $scope.bannedPokemons = $window.bannedPokemonsData || [];

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

    $scope.addBannedPokemon = function () {
        if (!$scope.secretKey) {
            $scope.showMessage('Podaj klucz API (X-SUPER-SECRET-KEY)!', 'error');
            return;
        }

        if (!$scope.selectedPokemon) {
            $scope.showMessage('Wybierz pokemona!', 'error');
            return;
        }

        var alreadyBanned = $scope.bannedPokemons.some(function (p) {
            return p.name === $scope.selectedPokemon;
        });

        if (alreadyBanned) {
            $scope.showMessage('Pokemon o nazwie ' + $scope.selectedPokemon + ' jest już zakazany!', 'error');
            return;
        }

        BannedService.addBannedPokemon($scope.selectedPokemon, $scope.reason, $scope.secretKey)
            .then(function () {
                $scope.reloadWithMessage('Pokemon został dodany pomyślnie', 'ok');
            })
            .catch(function (error) {
                if (error.status === 401) {
                    $scope.showMessage('Nieprawidłowy klucz API!', 'error');
                } else {
                    $scope.showMessage('Błąd podczas dodawania pokemona', 'error');
                }
            });
    };

    $scope.deleteBannedPokemon = function (id) {
        if (!$scope.secretKey) {
            $scope.showMessage('Podaj klucz API (X-SUPER-SECRET-KEY)!', 'error');
            return;
        }

        BannedService.deleteBannedPokemon(id, $scope.secretKey)
            .then(function () {
                $scope.reloadWithMessage('Pokemon został usunięty pomyślnie', 'ok');
            })
            .catch(function (error) {
                if (error.status === 401) {
                    $scope.showMessage('Nieprawidłowy klucz API!', 'error');
                } else {
                    $scope.showMessage('Błąd podczas usuwania pokemona', 'error');
                }
            });
    };

}]);
