<?php
/**
 * Created by PhpStorm.
 * User: rashinika
 * Date: 8/30/2016
 * Time: 2:04 AM
 */

namespace App\Repositories\Admin;

use app\Libraries\Helper;
use App\Models\Employees;
use App\Repositories\Contracts\Admin\EmployeesRepositoryInterface;
use Mockery\CountValidator\Exception;

class EmployeesRepository implements EmployeesRepositoryInterface
{
    /**
     * @var Employees
     */
    private $empMod;
    /**
     * @var Helper
     */
    private $helper;

    /**
     * EmployeesRepository constructor.
     * @param Employees $empMod
     * @param Helper $helper
     */
    public function __construct(Employees $empMod, Helper $helper)
    {
        $this->empMod = $empMod;
        $this->helper = $helper;
    }

    /**
     * Create new employee
     * @param $request
     * @return array
     */
    public function createEmployee($request)
    {
        try{
            if ($empData = $this->empMod->create($request)) {
                return [
                    'success' => true,
                    'data' => $empData,
                    'msg' => trans('employee.create.successfully')
                ];
            } else {
                return [
                    'success' => false,
                    'msg' => trans('employee.create.error')
                ];
            }
        }catch (Exception $ex){
            return [
                'success' => false,
                'msg' => $ex
            ];
        }


    }

    /**
     * Update employee details
     * @param $empID
     * @param $request
     * @return array
     */
    public function updateEmployee($empID, $request)
    {
        if ($this->update($empID, $request)) {
            $empData = $this->getEmployeeByID($empID, $this->helper->getConstants('status-code', 'active_status'));
            return [
                'success' => true,
                'data' => $empData,
                'msg' => trans('employee.update.update_successfully')
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('employee.update.not_update_successfully')
            ];
        }
    }

    /**
     * @description Update details
     *
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($id, $data)
    {
        return $query = $this->empMod->where('id', $id)
            ->update($data);
    }

    /**
     * Get employee data using emp id
     *
     * @param $empID
     * @param $status
     *
     * @return mixed
     */
    public function getEmployeeByID($empID, $status = 1)
    {
        return $this->empMod->select(
            'id',
            'epf',
            'first_name',
            'last_name',
            'middle_name',
            'name',
            'birthday',
            'gender',
            'marital_status',
            'nic_num',
            'driving_license',
            'job_title',
            'pay_grade',
            'address1',
            'address2',
            'city',
            'postal_code',
            'home_phone',
            'mobile_phone',
            'work_phone',
            'private_email',
            'section',
            'joined_date',
            'confirmation_date',
            'b_salary',
            'allowance',
            'trans_allow',
            'special_allow',
            'confirmation_date'
        )->where('id', $empID)
            ->where('status', $status)
            ->first();

    }

    /**
     * Edit employee get
     * @param $empID
     * @param $status
     * @return array
     */
    public function editEmployee($empID)
    {
        if ($empData = $this->getEmployeeByID($empID, $this->helper->getConstants('status-code', 'active_status'))) {
            return [
                'success' => true,
                'data' => $empData
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('employee.list.error')
            ];
        }
    }

    /**
     * Delete employee details
     * @param $empIDS
     * @param $statusData
     * @return array
     */
    public function updateEmployeeStatus($empIDS, $statusData)
    {
        if ($empIDS) {
            $query = \DB::table('employees');
            foreach ($empIDS as $empId) {
                $query->orWhere('id', $empId);
            }

            if ($query->update($statusData)) {
                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false
                ];
            }
        }
    }

    public function getEmployees($status = 1)
    {
        return $this->empMod->select(
            'id',
            'epf',
            'first_name',
            'last_name',
            'middle_name',
            'name',
            'birthday',
            'gender',
            'marital_status',
            'nic_num',
            'driving_license',
            'job_title',
            'pay_grade',
            'address1',
            'address2',
            'city',
            'postal_code',
            'home_phone',
            'mobile_phone',
            'work_phone',
            'private_email',
            'section',
            'joined_date',
            'confirmation_date',
            'b_salary',
            'allowance',
            'trans_allow',
            'special_allow',
            'confirmation_date'
        )->where('status', $status)
            ->orderBy('id', 'desc')
            ->paginate(5);
    }

    public function getEmployeesList($params)
    {
        if ($empData = $this->getEmployees($this->helper->getConstants('status-code', 'active_status'))
        ) {
            return [
                'success' => true,
                'data' => $empData
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('branch.list.error')
            ];
        }
    }
}