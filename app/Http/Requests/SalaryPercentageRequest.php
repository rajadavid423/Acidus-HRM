<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryPercentageRequest extends FormRequest
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
            'basic' => 'required|numeric|max:100',
            'hra' => 'required|numeric|max:100',
            'esi' => 'required|numeric|max:100',
            'pf' => 'required|numeric|max:100',
            'company_esi' => 'required|numeric|max:100',
            'company_pf' => 'required|numeric|max:100'
        ];
    }
}
