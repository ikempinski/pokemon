app.service('InfoService', ['$http', '$httpParamSerializerJQLike', function ($http, $httpParamSerializerJQLike) {

    this.getInfo = function (selectedPokemons) {
        return $http.get('/api/info/get', {
            params: { selectedPokemons: selectedPokemons },
            paramSerializer: $httpParamSerializerJQLike
        }).then(function (response) {
            return response.data;
        });
    };

}]);
