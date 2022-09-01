<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
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
        $Designation = $this->request->all();
        $id = isset($Designation['id']) ? $Designation['id'] : '';

        $validation = [
            'designation_name' => 'required|string|unique:designations,designation_name,' . $id . 'id',
            'description' => 'required|string',
        ];

        return $validation;
    }
}
