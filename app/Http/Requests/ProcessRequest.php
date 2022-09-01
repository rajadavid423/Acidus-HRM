<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessRequest extends FormRequest
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
        $Process = $this->request->all();
        $id = isset($Process['id']) ? $Process['id'] : '';

        $validation = [
            'process_name' => 'required|string|unique:processes,process_name,' . $id . 'id',
            'description' => 'required|string',
        ];

        return $validation;
    }
}
