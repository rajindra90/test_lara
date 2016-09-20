<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 2016-07-03
 * Time: 5:57 PM
 */

namespace App\Http\Requests;

class UserLoginRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'script_tags_free|required|max:50',
            'password' => 'script_tags_free|required|max:30|min:6'
        ];
    }
}
