<?php

/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 7/3/16
 * Time: 1:38 PM
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password',
        'status'
    ];
}