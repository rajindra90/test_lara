<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BranchUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'script_tags_free|required|min:3',
            'address1' => 'script_tags_free|required|min:3',
            'address2' => 'script_tags_free|min:3',
            'city' => 'script_tags_free|required|min:3',
            'phone' => 'script_tags_free|required|min:10|max:15',
            'fax' => 'script_tags_free|min:10|max:15'
        ];
    }
}
