myApp.controller('employeeEditController', ['$scope', '$timeout', '$location', '$routeParams', 'userModel', 'employeeModel', function ($scope, $timeout, $location, $routeParams, userModel, employeeModel) {
    $scope.successStatus = false;
    $scope.errorStatus = false;
    $scope.employee = {};
    var empID = $.trim($routeParams.empID);
    $timeout(function () {
        $scope.getEmployeeDataById(empID);
        $(".select_drop").select2();
    }, 100);
    $scope.getEmployeeDataById = function (empID) {
        if (empID != '') {
            employeeModel.getEmployeeById(empID).success(function (response) {
                $scope.employee.epf = response.data.epf;
                $scope.employee.full_name = response.data.name;
                $scope.employee.first_name = response.data.first_name;
                $scope.employee.middle_name = response.data.middle_name;
                $scope.employee.last_name = response.data.last_name;
                $scope.employee.gender = response.data.gender;
                $scope.employee.marital_status = response.data.marital_status;
                $scope.employee.nic_num = response.data.nic_num;
                $scope.employee.driving_license = response.data.driving_license;
                $scope.employee.birthday = response.data.birthday;
                $scope.employee.address1 = response.data.address1;
                $scope.employee.address2 = response.data.address2;
                $scope.employee.city = response.data.city;

            });
        }
    }

   /* $scope.updateBranch = function () {
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
    }*/

}]);
