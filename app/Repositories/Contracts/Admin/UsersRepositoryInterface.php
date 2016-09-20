<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/3/16
 * Time: 2:28 PM
 */
namespace App\Repositories\Contracts\Admin;

interface UsersRepositoryInterface
{
    public function checkUserLogin($param);
}