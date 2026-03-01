var app = angular.module('pokemonApp', []);

app.filter('capitalize', function () {
    return function (input) {
        if (!input) return '';
        return input.charAt(0).toUpperCase() + input.slice(1);
    };
});
