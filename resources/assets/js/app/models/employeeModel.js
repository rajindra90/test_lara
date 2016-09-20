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