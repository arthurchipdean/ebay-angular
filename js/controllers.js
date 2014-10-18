var appControllers = angular.module('appControllers', []);

appControllers.controller('SearchCtrl', function($scope, SearchService,CategoryService) {
    $scope.sort = 'BestMatch';
    $scope.category = '-1';
    $scope.freeShipping = false;
    $scope.advanced_search = false;
    SearchService.get_saved_searches().success(function(data) {
        $scope.saved_searches = data.saved_searches;
    })
    $scope.pageChanged = function(page) {
      search(page).success(function(data) {
            $scope.items = data.results;
            $scope.count = data.count;
        });
    };
    CategoryService.get('-1').success(function(data) {
        $scope.categories = data.categories;
    });
    $scope.search = function() {
       search("").success(function(data) {
           $scope.items = data.results;
           $scope.pagination = { current: 1 };
           $scope.count = data.count;

       });
    };
    $scope.save_search = function() {
        var params = get_params();
        params.name = $scope.name;
        SearchService.save_search(params);
    };
    function search(page) {
        q = get_params();
        if(page != "") q.page = page;
        return  SearchService.search(q);
    }
    function get_params() {
        return {q:$scope.query,sort:$scope.sort,freeShipping:$scope.freeShipping,category:$scope.category,MaxBid:$scope.MaxBid,MinBid:$scope.MinBid,MinPrice:$scope.MinPrice,MaxPrice:$scope.MaxPrice};
    }

});
