<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 6/22/16
 * Time: 12:11 AM
 */

namespace App\Http\Controllers\Admin;

use App\Libraries\Helper;
use App\Repositories\Contracts\Admin\UsersRepositoryInterface;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var UsersRepositoryInterface
     */
    private $userRepo;
    /**
     * @var Helper
     */
    private $helper;

    /**
     * UserController constructor.
     * @param UsersRepositoryInterface $userRepo
     * @param Helper $helper
     */
    function __construct(UsersRepositoryInterface $userRepo, Helper $helper)
    {
        $this->userRepo = $userRepo;
        $this->helper = $helper;
    }

    /**
     * Admin user login
     * @param UserLoginRequest $request
     * @return $this
     */
    public function userLogin(UserLoginRequest $request)
    {
        $returnValue = $this->userRepo->checkUserLogin(Input::all());

        if ($returnValue['success']) {
            return $this->helper->response(
                $this->helper->getConstants('header-code', 'success_code'),
                ['data' => $returnValue['data']]
            );
        } else {
            return $this->helper->response(
                $this->helper->getConstants('header-code', 'exception_code'),
                ['message' => $returnValue['msg']]
            );
        }
    }
}