<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupRequest extends FormRequest
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
        $group = $this->route('group');

        $rules = [
            'name' => [
                'required',
                'string',
                'min:4',
                'max:255',
                Rule::unique('groups')->ignore($group),
            ],
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ];

        /*if ($this->route()->methods()[0] === 'PUT'){
            $rules['users'] = 'required|array|min:1';
        }*/


        return $rules;
    }
}

