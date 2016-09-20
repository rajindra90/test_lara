<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 2016-07-03
 * Time: 5:57 PM
 */

namespace App\Http\Requests;

class AdminEmployeesRequest extends Request
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
            'epf' => 'script_tags_free|required|unique:employees,epf,NULL,id,status,!-1',
            'first_name' => 'script_tags_free|required',
            'name' => 'script_tags_free|required',
            'middle_name' => 'script_tags_free|required',
            'last_name' => 'script_tags_free|required',
            'birthday' => 'script_tags_free|required',
            'gender' => 'script_tags_free|required',
            'nic_num' => 'script_tags_free|required',
            'marital_status' => 'script_tags_free|required',
        ];
    }
}
