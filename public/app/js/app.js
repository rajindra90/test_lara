/**
 * Created by ubuntu on 6/29/16.
 */
var myApp = angular.module('hrmPayroll', ['ngRoute', 'ngCookies','ui.bootstrap']);

myApp.config(function ($routeProvider, $locationProvider) {
    function template(name) {
        return 'app/templates/' + name;
    }

    /**
     * Define the route of the paths
     * isAuth parameter defines the state of the route
     * -1 == Not logged in
     * 0 == Weather login or logout
     * 1 == login
     */
    $routeProvider
        .when('/', {
            templateUrl: template('admin/login.html'),
            reloadOnSearch: true,
            controller: 'userController',
            authenticated: false
        });
    $routeProvider
        .when('/dashboard', {
            templateUrl: template('dashboard/dashboard.html'),
            reloadOnSearch: true,
            controller: 'userController',
            authenticated: true
        });
    $routeProvider
        .when('/employee/add', {
            templateUrl: template('employees/create.html'),
            reloadOnSearch: true,
            controller: 'employeeAddController',
            authenticated: true
        });
    $routeProvider
        .when('/employees/list', {
            templateUrl: template('employees/list.html'),
            reloadOnSearch: true,
            controller: 'employeeAddController',
            authenticated: true
        });
    $routeProvider
        .when(('/employees/edit/:empID'), {
            templateUrl: template('employees/edit.html'),
            reloadOnSearch: true,
            controller: 'employeeEditController',
            authenticated: true
        });
    $routeProvider
        .when('/branches/list', {
            templateUrl: template('branches/list.html'),
            reloadOnSearch: true,
            controller: 'branchListController',
            authenticated: true
        });
    $routeProvider
        .when('/branch/add', {
            templateUrl: template('branches/create.html'),
            reloadOnSearch: true,
            controller: 'branchAddController',
            authenticated: true
        });
    $routeProvider
        .when(('/branch/edit/:branchID'), {
            templateUrl: template('branches/edit.html'),
            reloadOnSearch: true,
            controller: 'branchEditController',
            authenticated: true
        });
    $routeProvider
        .when('/form/create', {
            templateUrl: template('form/create.html'),
            reloadOnSearch: true,
            controller: 'formCreateController',
            authenticated: true
        });
    $routeProvider.otherwise('/');
    /**
     * This will remove hash bang from the routes
     */
    $locationProvider.html5Mode(true).hashPrefix('!');

});

myApp.run(["$rootScope", "$location", 'userModel', function ($rootScope, $location, userModel) {
    $rootScope.$on("$routeChangeStart", function (event, next, current) {
        if (next.$$route.authenticated) {
            if (!userModel.getAuthStatus()) {
                $location.path('/');
            }
        }
        if (next.$$route.originalPath == '/') {
            if (userModel.getAuthStatus()) {
                $location.path(current.$$route.originalPath);
            }
        }
    })
}]);
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

myApp.controller('formCreateController', ['$scope', '$timeout', '$location', 'userModel', 'branchModel', function ($scope, $timeout, $location, userModel, branchModel) {
    $scope.successStatus = false;
    $scope.errorStatus = false;
    $timeout(function () {

    }, 100);
}]);

/**
 * Created by Rajindra on 8/16/2016.
 */
myApp.controller('mainController', ['$scope', 'userModel', function ($scope, userModel) {
    $scope.isError = false;
    $scope.errors = {}
    $scope.loggedIn = false;
    $scope.$on("userLogged",function () {
        if (userModel.getAuthStatus()) {
            $scope.loggedIn = true;
        } else {
            $scope.loggedIn = false;
        }
    });

    if(userModel.getAuthStatus()){
        $scope.loggedIn = true;
    }
    angular.extend($scope, {})

}]);
myApp.controller('userController', ['$scope', '$location','$rootScope', 'userModel', function ($scope, $location,$rootScope, userModel) {
    angular.extend($scope, {

        doLogin: function () {
            var loginData = {
                username: $scope.login.username,
                password: $scope.login.password
            };
            userModel.doLogin(loginData).then(function (data) {
                $rootScope.$broadcast("userLogged");
                $location.path('/dashboard');
            });

        },
        doLogout: function () {
            userModel.doLogout();
            window.location.href = '/';
        }
    });
}]);


myApp.factory('branchModel', ['$http', '$cookies', 'userModel', function ($http, $cookies, userModel) {
    var branchModel = {};
    branchModel.doCreateBranch = function (branchData) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/branches',
            method: "POST",
            data: {
                name: branchData.name,
                address1: branchData.address1,
                address2: branchData.address2,
                city: branchData.city,
                phone: branchData.phone,
                fax: branchData.fax,
            }
        });
    };
    branchModel.getBranches = function (pageNum) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/branches?page='+pageNum,
            method: "GET"
        });
    };
    branchModel.getBranchById = function (branchID) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/branches/' + branchID + '/edit',
            method: "GET"
        });
    };
    branchModel.doUpdateBranch = function (branchData, branchID) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/branches/' + branchID,
            method: "PUT",
            data: {
                name: branchData.name,
                address1: branchData.address1,
                address2: branchData.address2,
                city: branchData.city,
                phone: branchData.phone,
                fax: branchData.fax,
            }
        });
    }
    return branchModel;
}]);


/*
 .success(function (response) {
 angular.element('.success-message-container').html(response.data.message);
 $scope.successStatus = true;
 }).error(function (data, status, header) {
 angular.element('.error-message-container').html(data.message);
 $scope.errorStatus = true;
 });*/

myApp.factory('employeeModel', ['$http', 'userModel', function ($http, userModel) {
    var employeeModel = {};
    employeeModel.addEmployee = function (empData) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/employees',
            method: "POST",
            data: {
                epf: empData.epf,
                name: empData.full_name,
                first_name: empData.first_name,
                middle_name: empData.middle_name,
                last_name: empData.last_name,
                gender: empData.gender,
                marital_status: empData.marital_status,
                nic_num: empData.nic_num,
                driving_license: empData.driving_license,
                birthday: empData.birthday,
                address1: empData.address1,
                address2: empData.address2,
                city: empData.city,
                postal_code: empData.postal_code,
                home_phone: empData.home_phone,
                mobile_phone: empData.mobile_phone,
                work_phone: empData.work_phone,
                private_email: empData.private_email,
                section: empData.section,
                pay_grade: empData.pay_grade,
                joined_date: empData.joined_date,
                confirmation_date: empData.confirmation_date,
                salary: empData.salary,
                trans_allow: empData.trans_allow,
                br_allowance: empData.br_allowance,
                special_allow: empData.special_allow,
                att_allow: empData.att_allow
            }
        });
    };
    employeeModel.getEmployees = function (pageNum) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/employees?page='+pageNum,
            method: "GET"
        });
    };
    employeeModel.getEmployeeById = function (empID) {
        return $http({
            'headers': {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'x-auth-token': userModel.getToken(),
            },
            url: baseURL + 'api/employees/' + empID + '/edit',
            method: "GET"
        });
    };
    return employeeModel;
}]);
/**
 * Created by ubuntu on 7/24/16.
 */
myApp.factory('userModel', ['$http', '$cookies', function ($http, $cookies) {
    var userModel = {};
    userModel.doLogin = function (loginData) {
        return $http({
            'headers': {
                'Content-Type': 'application/json'
            },
            url: baseURL + 'api/login',
            method: "POST",
            data: {
                username: loginData.username,
                password: loginData.password,
            }
        }).success(function (response) {
            $cookies.put('auth', JSON.stringify(response));
        }).error(function (data, status, header) {
            return data;
        });
    };
    userModel.getAuthStatus = function () {
        var status = $cookies.get('auth');

        if (status) {
            return true;
        } else {
            return false;
        }
    };
    userModel.doLogout = function () {
        $cookies.remove('auth');
    };
    userModel.getToken = function () {
        var user = this.getLoggedUser();
        user = JSON.parse(user).data;
        return user && user.token ? user.token : '';
    };
    userModel.getLoggedUser = function () {
        return $cookies.get('auth');
    };
    return userModel;
}]);
/**
 * Created by Rajindra on 8/20/2016.
 */
myApp.factory('validationModel', [function () {
    return {

        email: function (email) {
            var pattern = /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            return pattern.test(email);
        },

        numbers: function (value) {
            var pattern = /^[0-9]+$/;
            return pattern.test(value);
        },

        alphaNumeric: function (value) {
            var pattern = /^[a-zA-Z0-9]+$/;
            return pattern.test(value);
        },

        searchText: function (value) {
            var pattern = /^[A-Za-z\d\s]+$/;
            return pattern.test(value);
        },

        empty: function (value) {
            if (typeof value == "undefined" || value == null || value == "null" || value == "") {
                return true;
            } else {
                return false;
            }
        }

    };
}]);
//# sourceMappingURL=app.js.map
