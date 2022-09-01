<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $Branch = $this->request->all();
        $id = isset($Branch['id']) ? $Branch['id'] : '';

        $validation = [
            'branch_name' => 'required|string|unique:branches,branch_name,' . $id . 'id',
        ];

        return $validation;
    }
}
