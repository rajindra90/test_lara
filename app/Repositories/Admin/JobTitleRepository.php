<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\Admin\JobTitleRepositoryInterface;
use App\Models\JobTitle;

/**
 * Class JobTitleRepositoryEloquent
 * @package namespace App\Repositories\Admin;
 */
class JobTitleRepository extends BaseRepository implements JobTitleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobTitle::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
