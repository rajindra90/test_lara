myApp.controller('branchEditController', ['$scope', '$timeout', '$location', '$routeParams', 'userModel', 'branchModel', function ($scope, $timeout, $location, $routeParams, userModel, branchModel) {
    $scope.successStatus = false;
    $scope.errorStatus = false;
    $scope.branch = {};
    var branchID = $.trim($routeParams.branchID);
    $timeout(function () {
        $scope.getBranchData(branchID);
    }, 100);

    $scope.getBranchData = function (branchID) {
        if (branchID != '') {
            branchModel.getBranchById(branchID).success(function (response) {
                $scope.branch.branch_name = response.data.name;
                $scope.branch.address1 = response.data.address1;
                $scope.branch.address2 = response.data.address2;
                $scope.branch.city = response.data.city;
                $scope.branch.phone = response.data.phone;
                $scope.branch.fax = response.data.fax;
            });
        }
    }

    $scope.updateBranch = function () {
        if ($scope.branchEdit.$valid) {
            var branchData = {
                name: $scope.branch.branch_name,
                address1: $scope.branch.address1,
                address2: $scope.branch.address2,
                city: $scope.branch.city,
                phone: $scope.branch.phone,
                fax: $scope.branch.fax,
            };

            branchModel.doUpdateBranch(branchData, branchID).success(function (response) {
                angular.element('.success-message-container').html(response.message);
                $scope.successStatus = true;
                $scope.errorStatus = false;
                $timeout(function () {
                    $location.path('/branches/list');
                }, 3000);
            }).error(function (data, status, header) {
                angular.element('.error-message-container').html(data.message);
                $scope.errorStatus = true;
                $scope.successStatus = false;
            });
        }
    }

}]);
