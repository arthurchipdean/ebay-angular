var app = angular.module('App', ['appControllers','appFilters','appServices', 'appDirectives','angular-loading-bar','ngRoute','ngSanitize','angularUtils.directives.dirPagination']);


app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'templates/search.html',
                controller: 'SearchCtrl'
            }).
            when('/test/:testId', {
                templateUrl: 'partials/test-result.html',
                controller: 'TestResultCtrl'
            }).
            when('/test', {
                templateUrl: 'partials/tests.html',
                controller: 'TestViewCtrl'
            }).
            when('/login', {
                templateUrl: 'partials/login.html',
                controller: 'LoginCtrl'
            }).
            when('/logout', {
                controller:'LogoutCtrl',
                templateUrl:'partials/login.html'
            }).
            otherwise({
                redirectTo: '/'
            });
    }
]);
