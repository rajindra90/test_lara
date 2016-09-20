<?php

namespace App\Repositories;

use App\Models\UserDeviceTokens;
use App\Repositories\Contracts\UserDeviceTokenRepositoryInterface;

class UserDeviceTokensRepository implements UserDeviceTokenRepositoryInterface
{
    //Private variables
    private $userDeviceTokens;

    public function __construct(UserDeviceTokens $userDeviceTokens)
    {
        $this->userDeviceTokens = $userDeviceTokens;
    }

    /**
     * @description Save details
     *
     * @param $data
     *
     * @return bool|int
     */
    public function create($data)
    {
        return $this->userDeviceTokens->create($data);
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
        return $query = $this->userDeviceTokens->where('id', $id)
                                               ->update($data);
    }

    /**
     * @description Delete record
     *
     * @param $id
     *
     * @return bool|int
     */
    public function delete($id)
    {
        return $this->userDeviceTokens->find($id)->delete();
    }

    /**
     * @description Get details of single item
     *
     * @param $id
     * @param $columns
     *
     * @return array
     */
    public function find($id, $columns = ['*'])
    {
        return $this->userDeviceTokens->find($id, $columns);
    }

    public function validateByToken($token)
    {
        return $this->userDeviceTokens->where('token', $token)
            ->with('user')
            ->get();
    }

    /**
     * Delete device token by using user id and device id
     *
     * @param $device_id
     *
     * @return mixed
     */
    public function deleteDeviceTokens($user_id, $device_id)
    {
        return $query = $this->userDeviceTokens->where('device_id', $device_id)->where('user_id', $user_id)
                                               ->delete();
    }

    /**
     * Inser new device token
     *
     * @param $data
     *
     * @return static
     */
    public function insertDeviceTokens($data)
    {
        return $this->userDeviceTokens->create($data);
    }

    /**
     * Delete device token by using device id
     * @param $device_id
     *
     * @return mixed
     */
    public function deleteUserDeviceToken($device_id)
    {
        return $query = $this->userDeviceTokens->where('device_id', $device_id)
                                               ->delete();
    }

    /**
     * Delete access token using user ids
     * @param $usersId
     *
     * @return mixed
     */
    public function deleteUserDeviceTokenByIds($usersId)
    {
        return $query = $this->userDeviceTokens->where('user_id', $usersId)
                                               ->delete();
    }
}
