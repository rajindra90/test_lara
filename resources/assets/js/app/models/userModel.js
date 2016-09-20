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