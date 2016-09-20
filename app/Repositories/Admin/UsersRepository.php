<?php
/**
 * @file    UsersRepository.php
 *
 * UsersRepository Repository
 *
 * PHP Version 5
 *
 * @author  <Author full name> <Author email>
 *
 * @copyright Copyright Eyepax IT Consulting (Pvt) Ltd.
 */
namespace App\Repositories\Admin;

use App\Libraries\Helper;
use App\Models\User;
use App\Repositories\Contracts\Admin\UsersRepositoryInterface;
use App\Repositories\Contracts\UserDeviceTokenRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    private $user;
    private $helper;
    private $userDeviceTokens;

    function __construct(User $user, Helper $helper, UserDeviceTokenRepositoryInterface $userDeviceTokens)
    {
        $this->user = $user;
        $this->helper = $helper;
        $this->userDeviceTokens = $userDeviceTokens;
    }

    public function checkUserLogin($request)
    {
        $userLogin = array(
            'username' => $request['username'],
            'password' => $request['password'],
            'status' => $this->helper->getConstants('status-code', 'active_status')
        );

        $userDetails = $this->getUserDetailsWithUsername($request['username']);
        if (isset($userDetails)) {
            if (\Auth::attempt($userLogin)) {
                $userDeviceTokens = $this->updateUserToken($userDetails['id'], ';;;lll');

                if ($userDeviceTokens) {
                    $userDetails['device_id'] = $userDeviceTokens['device_id'];
                    $userDetails['token'] = $userDeviceTokens['token'];

                    $this->updateUserLastLogin(\Auth::user()->id);

                    return array('success' => true, 'data' => $userDetails);
                }

            } else {
                return array('success' => false, 'msg' => trans('users.login.details_is_not_correct'));
            }
        } else {
            return array('success' => false, 'msg' => trans('users.login.cant_find_user_belongs_email'));
        }
    }

    public function getUserDetailsWithUsername($username)
    {

        return $this->user->select(
            'id',
            'username',
            'email',
            'status',
            'last_login',
            'created_at',
            'updated_at'
        )->where('username', $username)
            ->where('status', '!=', $this->helper->getConstants('status-code', 'delete_status'))->first();
    }

    /**
     * Update user device token
     *
     * @param $userId
     * @param $inputData
     *
     * @return device token
     */
    public function updateUserToken($userId, $device_id)
    {
        $newAccessToken = $this->helper->generateToken($userId, $device_id);
        $insertArray = array();
        $insertArray['device_id'] = $device_id;
        $insertArray['token'] = $newAccessToken;
        $insertArray['user_id'] = $userId;
        $this->userDeviceTokens->deleteDeviceTokens($userId, $device_id);

        return $this->userDeviceTokens->create($insertArray);
    }

    /**
     * User logout
     *
     * @param $request
     *
     * @return array
     */
    public function userLogout($request)
    {
        if ($this->userDeviceTokens->deleteUserDeviceToken($request['device_id'])) {
            return array(
                'success' => true,
                'msg' => trans('users.logout.successfully')
            );
        } else {
            return array(
                'success' => false,
                'msg' => trans('users.logout.error')
            );
        }
    }

    /**
     * Get login details
     * @param $userId
     * @return mixed
     */
    public function getLoginUserDetails($userId)
    {
        return $this->user
            ->select('id', 'email', 'first_name', 'last_name')
            ->find($userId);

    }

    /**
     * @param $userId
     *
     * @return bool|int
     */
    public function updateUserLastLogin($userId)
    {
        $this->user->timestamps = false;
        $returnValue = $this->update(['last_login' => date('Y-m-d H:i:s')], $userId);
        $this->user->timestamps = true;
        return $returnValue;
    }

    /**
     * @description Update details
     *
     * @param $data
     * @param $id
     *
     * @return bool|int
     */
    public function update($data, $id)
    {
        return $query = $this->user->where('id', $id)
            ->update($data);
    }
}
