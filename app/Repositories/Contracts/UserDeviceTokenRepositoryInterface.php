<?php
    /**
     * @file    UserDeviceTokenRepositoryInterface.php
     *
     * UserDeviceTokenRepositoryInterface RepositoryInterface
     *
     * PHP Version 5
     *
     * @author  Prasanna Jayananthasarma <prasanna.j@eyepax.com>
     *
     * @copyright Copyright Eyepax IT Consulting (Pvt) Ltd.
     */

namespace App\Repositories\Contracts;

interface UserDeviceTokenRepositoryInterface
{
    public function validateByToken($token);
}
