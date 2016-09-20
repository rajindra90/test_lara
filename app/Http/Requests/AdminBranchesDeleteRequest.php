<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 2016-07-03
 * Time: 5:57 PM
 */

namespace App\Http\Requests;

class AdminBranchesDeleteRequest extends Request
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
            'branch_ids' => 'required|array'
        ];
    }
}
