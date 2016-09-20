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