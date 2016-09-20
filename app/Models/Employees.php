<?php
/**
 * Created by PhpStorm.
 * User: rashinika
 * Date: 8/30/2016
 * Time: 2:03 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Employees extends  Model
{
    protected $table = 'employees';

    protected $fillable = [
        'epf',
        'first_name',
        'last_name',
        'middle_name',
        'name',
        'birthday',
        'gender',
        'marital_status',
        'nic_num',
        'driving_license',
        'job_title',
        'pay_grade',
        'address1',
        'address2',
        'city',
        'postal_code',
        'home_phone',
        'mobile_phone',
        'work_phone',
        'private_email',
        'section',
        'joined_date',
        'confirmation_date',
        'b_salary',
        'allowance',
        'trans_allow',
        'special_allow',
        'confirmation_date',
    ];
}