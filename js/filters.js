var appFilters = angular.module('appFilters', []);

appFilters.filter('currency', function() {
    return function(input) {
        switch(input) {
            case'USD':
                return '$';
            break;
        }
    };
});

appFilters.filter('rated', function() {
    return function(input) {
        return input == true ? '<img src="img/rated.png">':'';
    };
});
