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