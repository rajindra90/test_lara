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
