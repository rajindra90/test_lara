<?php

namespace App\Repositories\Contracts\Admin;

interface BranchRepositoryInterface
{
    public function createBranch($request);

    public function updateBranch($branchId, $request);

    public function editBranch($branchID);

    public function updateBranchStatus($branchIDs, $statusData);

    public function getBranchList($params);
}
