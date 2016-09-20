<?php
/**
 * Created by PhpStorm.
 * User: rashinika
 * Date: 8/30/2016
 * Time: 1:53 AM
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminEmployeesDeleteRequest;
use App\Http\Requests\AdminEmployeesRequest;
use App\Libraries\Helper;
use App\Repositories\Contracts\Admin\EmployeesRepositoryInterface;
use Illuminate\Support\Facades\Input;

class EmployeesController extends Controller
{
    /**
     * @var EmployeesRepositoryInterface
     */
    private $empRepo;
    /**
     * @var Helper
     */
    private $helper;

    /**
     * EmployeesController constructor.
     * @param EmployeesRepositoryInterface $empRepo
     * @param Helper $helper
     */
    public function __construct(EmployeesRepositoryInterface $empRepo, Helper $helper)
    {
        $this->empRepo = $empRepo;
        $this->helper = $helper;
    }

    public function index()
    {
        $params = [
            'name' => trim(Input::get('name')),
            'city' => trim(Input::get('city')),
            'phone' => trim(Input::get('phone')),
            'fax' => trim(Input::get('fax'))
        ];

        $returnData = $this->empRepo->getEmployeesList($params);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['data' => $returnData['data']]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => $returnData['msg']]
                );
        }
    }

    /**
     * Get employee details using id
     * @param $empID
     * @return object
     */
    public function show($empID)
    {
        $returnData = $this->empRepo->editEmployee($empID);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['data' => $returnData['data']]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => $returnData['msg']]
                );
        }
    }

    /**
     * @param AdminEmployeesRequest $request
     * @return object
     */
    public function store(AdminEmployeesRequest $request)
    {
        $returnData = $this->empRepo->createEmployee(Input::all());
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => $returnData['msg'], 'data' => $returnData['data']]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => $returnData['msg']]
                );
        }
    }

    /**
     * Update employee details
     * @param AdminEmployeesRequest $request
     * @param $empID
     * @return object
     */
    public function update(AdminEmployeesRequest $request, $empID)
    {
        $returnData = $this->empRepo->updateEmployee($empID, Input::all());
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => $returnData['msg'], 'data' => $returnData['data']]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => $returnData['msg']]
                );
        }
    }

    /**
     * Get employee details for edit
     * @param $empID
     * @return object
     */
    public function edit($empID)
    {
        $returnData = $this->empRepo->editEmployee($empID);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['data' => $returnData['data']]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => $returnData['msg']]
                );
        }
    }

    /**
     * Delete employees using ids
     * @param AdminEmployeesDeleteRequest $request
     * @return object
     */
    public function deleteEmployee(AdminEmployeesDeleteRequest $request)
    {
        $returnData = $this->empRepo->updateEmployeeStatus(Input::get('emp_ids'),
            ['status' => $this->helper->getConstants('status-code', 'delete_status')]);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => trans('employee.delete.user_delete_success')]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => trans('employee.delete.error')]
                );
        }
    }

    /**
     * Delete employees using ids
     * @param AdminEmployeesDeleteRequest $request
     * @return object
     */
    public function resignEmployee(AdminEmployeesDeleteRequest $request)
    {
        $returnData = $this->empRepo->updateEmployeeStatus(Input::get('emp_ids'),
            ['resign' => $this->helper->getConstants('status-code', 'not_active_status')]);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => trans('employee.enabled.employee_enabled_success')]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => trans('employee.enabled.error')]
                );
        }
    }

    /**
     * Reactivated employees using ids
     * @param AdminEmployeesDeleteRequest $request
     * @return object
     */
    public function activatedEmployee(AdminEmployeesDeleteRequest $request)
    {
        $returnData = $this->empRepo->updateEmployeeStatus(Input::get('emp_ids'),
            ['resign' => $this->helper->getConstants('status-code', 'active_status')]);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => trans('employee.disabled.employee_disabled_success')]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => trans('employee.disabled.error')]
                );
        }
    }
}