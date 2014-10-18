var appServices = angular.module('appServices', []);

appServices.factory("SearchService", function($rootScope, $http) {
    return {
        search: function() {
            var args = arguments[0];
            var params = "?q="+args.query+'&sort='+args.sort;
            if(typeof args.page != 'undefined')
                params+='&page='+args.page;
            if(typeof args.freeShipping != 'undefined' && args.freeShipping == true)
                params+='&freeShipping=true';
            if(typeof args.category != 'undefined' && args.category != '-1')
                params+='&category='+args.category;
            return  $http.get('search.php'+params);
        },
        save_search: function() {
            var args = arguments[0];
            return $http.post('save-search.php', args);
        },
        get_saved_searches: function() {
            return $http.get('save-search.php');
        }
    }
});

appServices.factory('CategoryService', function($http) {
    return {
        get: function(categoryID) {
            return $http.get('categories.php?id='+categoryID);
        }
    }

})