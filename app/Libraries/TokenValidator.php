<?php
/**
 * Created by PhpStorm.
 * User: prasanna_j
 * Date: 13-Jan-2016
 * Time: 10:35 AM
 */

namespace App\Libraries;

use App\Repositories\Contracts\Admin\UsersRepositoryInterface;
use App\Repositories\Contracts\UserDeviceTokenRepositoryInterface;

class TokenValidator
{
    private $userDeviceRepo;
    private $userRepo;
    public static $currentUser = null;
    public static $scopeAdminUser = null;

    public function __construct(
        UserDeviceTokenRepositoryInterface $userDeviceRepo,
        UsersRepositoryInterface $userRepo
    ) {
    
        $this->userDeviceRepo = $userDeviceRepo;
        $this->userRepo = $userRepo;
    }

    public function validateToken($token)
    {

        $user = $this->userDeviceRepo->validateByToken($token);

        if (!$user->isEmpty()) {
            $user = $user->first();
            $user->details = $this->userRepo->getLoginUserDetails($user->user_id);

            $user->token = $token;
            TokenValidator::$currentUser = $user;

            return true;
        } else {
            return false;
        }
    }
}
