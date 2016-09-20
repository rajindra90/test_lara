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