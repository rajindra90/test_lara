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

