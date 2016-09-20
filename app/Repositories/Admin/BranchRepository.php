<?php

namespace App\Repositories\Admin;

use app\Libraries\Helper;
use App\Repositories\Contracts\Admin\BranchRepositoryInterface;
use App\Models\Branch;


class BranchRepository implements BranchRepositoryInterface
{
    /**
     * @var Branch
     */
    private $branch;
    /**
     * @var Helper
     */
    private $helper;

    /**
     * BranchRepository constructor.
     * @param Branch $branch
     */
    public function __construct(Branch $branch, Helper $helper)
    {
        $this->branch = $branch;
        $this->helper = $helper;
    }

    /**
     * @param $request
     * @return array
     */
    public function createBranch($request)
    {
        if ($branchData = $this->branch->create($request)) {
            return [
                'success' => true,
                'data' => $branchData,
                'msg' => trans('branch.create.successfully')
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('branch.create.error')
            ];
        }
    }

    /**
     * Update branch details
     * @param $branchId
     * @param $request
     * @return array
     */
    public function updateBranch($branchId, $request)
    {
        if ($this->update($branchId, $request)) {
            $branchData = $this->getBranchesByID($branchId,
                $this->helper->getConstants('status-code', 'active_status'));
            return [
                'success' => true,
                'data' => $branchData,
                'msg' => trans('branch.update.update_successfully')
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('branch.update.not_update_successfully')
            ];
        }
    }

    /**
     * Get branch details using branch id
     * @param $branchId
     * @param int $status
     * @return mixed
     */
    public function getBranchesByID($branchId, $status = 1)
    {
        return $this->branch->select(
            'id',
            'name',
            'address1',
            'address2',
            'city',
            'phone',
            'fax',
            'status'
        )->where('id', $branchId)
            ->where('status', $status)
            ->first();

    }
    /**
     * Get branch details using branch id
     * @param int $status
     * @return mixed
     */
    public function getBranchesList($status = 1)
    {
        return $this->branch->select(
            'id',
            'name',
            'address1',
            'address2',
            'city',
            'phone',
            'fax',
            'status'
        )->where('status', $status)
            ->orderBy('id', 'desc')
            ->paginate(10);

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
        return $query = $this->branch->where('id', $id)
            ->update($data);
    }

    /**
     * Get edit branch details
     * @param $branchID
     * @return array
     */
    public function editBranch($branchID)
    {
        if ($branchData = $this->getBranchesByID($branchID,
            $this->helper->getConstants('status-code', 'active_status'))
        ) {
            return [
                'success' => true,
                'data' => $branchData
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('branch.list.error')
            ];
        }
    }

    /**
     * Update branch status
     * @param $branchIDs
     * @param $statusData
     * @return array
     */
    public function updateBranchStatus($branchIDs, $statusData)
    {
        if ($branchIDs) {
            $query = \DB::table('sys_branch');
            foreach ($branchIDs as $braId) {
                $query->orWhere('id', $braId);
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

    public function getBranchList($params)
    {
        if ($branchData = $this->getBranchesList($this->helper->getConstants('status-code', 'active_status'))
        ) {
            return [
                'success' => true,
                'data' => $branchData
            ];
        } else {
            return [
                'success' => false,
                'msg' => trans('branch.list.error')
            ];
        }
    }
}
