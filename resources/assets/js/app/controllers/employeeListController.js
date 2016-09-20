myApp.controller('employeeListController', ['$scope', '$timeout', '$routeParams', '$location', 'userModel', 'employeeModel', function ($scope, $timeout, $routeParams, $location, userModel, employeeModel) {
    $scope.employeeList = {};
    $scope.employeeTablePages = {};
    $scope.totalItems;
    $scope.perPage;
    $scope.nextPage;
    $scope.params={};
    var pageNumber = $.trim($routeParams.page);
    $timeout(function () {
        $scope.getEmployees(pageNumber);

    }, 100);
    $scope.getEmployees = function (pageNum) {
        employeeModel.getEmployees(pageNum).success(function (response) {
            $scope.employeeList = response.data.data;
            $scope.totalItems = response.data.last_page;
            $scope.perPage = response.data.per_page;
            $scope.nextPage = $scope.params.page + 1;
        });
    }
}]);
