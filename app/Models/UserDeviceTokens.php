<?php
/**
 * @file    UserDeviceTokens.php
 *
 * UserDeviceTokens Request
 *
 * PHP Version 5
 *
 * @author  <Author full name> <Author email>
 *
 * @copyright Copyright Eyepax IT Consulting (Pvt) Ltd.
 */
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class UserDeviceTokens extends Model
{
    /**
         * The database table used by the model.
         *
         * @var string
         */
    protected $table = 'user_device_tokens';
    //public $timestamps = false;
    protected $fillable = ['device_id','token','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
