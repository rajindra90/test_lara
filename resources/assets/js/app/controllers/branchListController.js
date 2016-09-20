/**
 * Created by rashinika on 9/4/2016.
 */
myApp.controller('branchListController', ['$scope', '$timeout', '$routeParams', '$location', 'userModel', 'branchModel', function ($scope, $timeout, $routeParams, $location, userModel, branchModel) {
    $scope.branchList = {};
    $scope.totalItems;
    $scope.perPage;
    $scope.nextPage;
    $scope.params={};
    var pageNumber = $.trim($routeParams.page);
    $timeout(function () {
        $scope.getBranches(pageNumber);
    }, 100);

    $scope.getBranches = function (pageNum) {
        branchModel.getBranches(pageNum).success(function (response) {
            $scope.branchList = response.data.data;
            $scope.totalItems = response.data.last_page;
            $scope.perPage = response.data.per_page;
            $scope.nextPage = $scope.params.page + 1;
          //   $location.path('/branches/list?page=' + pageNum);
           // console.log($scope.params.page)
        });
    }

}]);
