<?php
/**
 * Created by PhpStorm.
 * User: rashinika
 * Date: 8/30/2016
 * Time: 2:04 AM
 */

namespace App\Repositories\Contracts\Admin;


interface EmployeesRepositoryInterface
{
    public function getEmployeesList($param);
    public function createEmployee($request);
    public function updateEmployee($empID,$request);
    public function editEmployee($empID);
    public function updateEmployeeStatus($empID,$data);
}