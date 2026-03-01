app.service('UserPokemonsService', ['$http', function ($http) {

    this.addUserPokemon = function (name, secretKey) {
        return $http.post('/api/userpokemons/add', { name: name }, {
            headers: {
                'X-SUPER-SECRET-KEY': secretKey
            }
        }).then(function (response) {
            return response.data;
        });
    };

    this.deleteUserPokemon = function (id, secretKey) {
        return $http.post('/api/userpokemons/delete/' + id, {}, {
            headers: {
                'X-SUPER-SECRET-KEY': secretKey
            }
        }).then(function (response) {
            return response.data;
        });
    };
}]);
