<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
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
            'special_day_allowance' => 'required|numeric',
            'special_allowance' => 'required|numeric',
            'shift_allowance' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'total_earnings' => 'required|numeric',
            'tds_deduction' => 'required|numeric',
            'other_deduction' => 'required|numeric',
            'medi_claim' => 'required|numeric',
            'total_deduction' => 'required|numeric',
            'net_salary' => 'required|numeric',
            'comments' => 'nullable|string',
        ];
    }
}
