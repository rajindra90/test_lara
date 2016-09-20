<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminBranchesDeleteRequest;
use App\Http\Requests\BranchCreateRequest;
use App\Http\Requests\BranchUpdateRequest;
use app\Libraries\Helper;
use App\Repositories\Contracts\Admin\BranchRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class BranchesController extends Controller
{
    /**
     * @var BranchRepository
     */
    private $branchRepo;
    /**
     * @var
     */
    private $helper;

    public function __construct(BranchRepositoryInterface $branchRepo, Helper $helper)
    {
        $this->branchRepo = $branchRepo;
        $this->helper = $helper;
    }

    /**
     * Display a listing of the branches.
     *
     * @return object
     */
    public function index()
    {
        $params = [
            'name' => trim(Input::get('name')),
            'city' => trim(Input::get('city')),
            'phone' => trim(Input::get('phone')),
            'fax' => trim(Input::get('fax'))
        ];
        $returnData = $this->branchRepo->getBranchList($params);
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
     * Store a newly created resource in storage.
     *
     * @param  BranchCreateRequest $request
     *
     * @return object
     */
    public function store(BranchCreateRequest $request)
    {
        $returnData = $this->branchRepo->createBranch(Input::all());
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($branchID)
    {
        $returnData = $this->branchRepo->editBranch($branchID);
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
     * Show the form for editing the specified resource.
     *
     * @param  int $branchID
     *
     * @return object
     */
    public function edit($branchID)
    {
        $returnData = $this->branchRepo->editBranch($branchID);
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
     * Update the specified resource in storage.
     *
     * @param  BranchUpdateRequest $request
     * @param  string $branchID
     *
     * @return object
     */
    public function update(BranchUpdateRequest $request, $branchID)
    {
        $returnData = $this->branchRepo->updateBranch($branchID, Input::all());
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
     * Delete branch using ids
     * @param AdminBranchesDeleteRequest $request
     * @return object
     */
    public function deleteBranch(AdminBranchesDeleteRequest $request)
    {
        $returnData = $this->branchRepo->updateBranchStatus(Input::get('branch_ids'),
            ['status' => $this->helper->getConstants('status-code', 'delete_status')]);
        if ($returnData['success']) {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'success_code'),
                    ['message' => trans('branch.delete.branch_delete_success')]
                );
        } else {
            return $this->helper
                ->response(
                    $this->helper->getConstants('header-code', 'exception_code'),
                    ['message' => trans('branch.delete.error')]
                );
        }
    }
}
