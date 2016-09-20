myApp.controller('employeeAddController', ['$scope', '$timeout', '$location', 'userModel', 'employeeModel', function ($scope, $timeout, $location, userModel, employeeModel) {
    $scope.successStatus = false;
    $scope.employee={};
    $timeout(function () {
        $('#empWizard').bootstrapWizard({'tabClass': 'nav nav-pills'});
        $(".select_drop").select2();
        $('#joined_date').datepicker({
            autoclose: true
        });
        $('#birthday').datepicker({
            autoclose: true
        });
        $('#confirmation_date').datepicker({
            autoclose: true
        });
    }, 100);

    $scope.addNewEmployee = function () {
        if ($scope.employeeAdd.$valid) {
            var employeeData = {
                epf: $scope.employee.epf,
                full_name: $scope.employee.full_name,
                first_name: $scope.employee.first_name,
                middle_name: $scope.employee.middle_name,
                last_name: $scope.employee.last_name,
                gender: $scope.employee.gender,
                marital_status: $scope.employee.marital_status,
                nic_num: $scope.employee.nic_num,
                driving_license: $scope.employee.driving_license,
                birthday: $scope.employee.birthday,
                address1: $scope.employee.address1,
                address2: $scope.employee.address2,
                city: $scope.employee.city,
                postal_code: $scope.employee.postal_code,
                home_phone: $scope.employee.home_phone,
                mobile_phone: $scope.employee.mobile_phone,
                work_phone: $scope.employee.work_phone,
                private_email: $scope.employee.private_email,
                section: $scope.employee.section,
                pay_grade: $scope.employee.pay_grade,
                joined_date: $scope.employee.joined_date,
                confirmation_date: $scope.employee.confirmation_date,
                salary: $scope.employee.salary,
                trans_allow: $scope.employee.trans_allow,
                br_allowance: $scope.employee.br_allowance,
                special_allow: $scope.employee.special_allow,
                att_allow: $scope.employee.att_allow
            };
            employeeModel.addEmployee(employeeData).success(function (response) {
                angular.element('.success-message-container').html(response.message);
                $scope.successStatus = true;
                $scope.errorStatus = false;
                $timeout(function () {
                    $location.path('/employees/list');
                }, 3000);
            }).error(function (data, status, header) {
                angular.element('.error-message-container').html(data.message);
                $scope.errorStatus = true;
                $scope.successStatus = false;
            });

        }
    };

    $scope.choices = [{id: 'choice1'}, {id: 'choice2'}];

    $scope.addNewAllowance = function() {
        var newItemNo = $scope.choices.length+1;
        $scope.choices.push({'id':'choice'+newItemNo});
    };

    $scope.removeAllowance = function() {
        var lastItem = $scope.choices.length-1;
        $scope.choices.splice(lastItem);
    };

}]);
