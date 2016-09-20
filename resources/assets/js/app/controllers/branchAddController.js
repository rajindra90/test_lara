myApp.controller('branchAddController', ['$scope', '$timeout', '$location', 'userModel', 'branchModel', function ($scope, $timeout, $location, userModel, branchModel) {
    $scope.successStatus = false;
    $scope.errorStatus = false;
    angular.extend($scope, {
        addNewBranch: function () {
            if ($scope.branchAdd.$valid) {
                var branchData = {
                    name: $scope.branch.branch_name,
                    address1: $scope.branch.address1,
                    address2: $scope.branch.address2,
                    city: $scope.branch.city,
                    phone: $scope.branch.phone,
                    fax: $scope.branch.fax,
                };

                branchModel.doCreateBranch(branchData).success(function (response) {
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
    });
}]);
