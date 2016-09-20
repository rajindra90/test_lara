<?php

namespace App\Http\Requests;

class BranchCreateRequest extends Request
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
            'name' => 'script_tags_free|required|min:3|max:55',
            'address1' => 'script_tags_free|required|min:3|max:55',
            'address2' => 'script_tags_free|min:3|max:55',
            'city' => 'script_tags_free|required|min:3|max:55',
            'phone' => 'script_tags_free|required|min:10|max:15',
            'fax' => 'script_tags_free|min:10|max:15'
        ];
    }
}
