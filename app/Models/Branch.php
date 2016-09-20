<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'sys_branch';

    protected $fillable = [
        'name',
        'address1',
        'address2',
        'city',
        'phone',
        'fax',
        'status',
    ];

}
