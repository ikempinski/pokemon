app.service('BannedService', ['$http', function ($http) {

    this.addBannedPokemon = function (name, reason, secretKey) {
        return $http.post('/api/banned/add', { name: name, reason: reason }, {
            headers: {
                'X-SUPER-SECRET-KEY': secretKey
            }
        }).then(function (response) {
            return response.data;
        });
    };

    this.deleteBannedPokemon = function (id, secretKey) {
        return $http.post('/api/banned/delete/' + id, {}, {
            headers: {
                'X-SUPER-SECRET-KEY': secretKey
            }
        }).then(function (response) {
            return response.data;
        });
    };

    this.getAllBannedPokemons = function () {
        return $http.get('/api/banned/getAll')
            .then(function (response) { return response.data; });
    };

}]);
