<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $id = $this->route('id');
        $input = $this->request->all();
        $validation = [
            'name' => 'required|string|max:100',
            'employee_id' => 'required|string|max:20|unique:users,employee_id,' . $id . ',id',
            'designation_id' => 'nullable|integer|exists:designations,id',
            'shift_id' => 'nullable|integer|exists:shifts,id',
            'dob' => 'nullable|date',
            'process_id' => 'nullable|integer|exists:processes,id',
            'gender' => 'required|in:Male,Female',
            'team_id' => 'nullable|integer|exists:teams,id',
            'client_id' => 'nullable|integer|exists:clients,id',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'phone_number' => 'nullable|numeric|digits:10|unique:users,phone_number,' . $id . ',id',
            'aadhar_number' => 'nullable|numeric|digits:12|unique:users,aadhar_number,' . $id . ',id',
            'esi_number' => 'nullable|string|digits:17|unique:users,esi_number,' . $id . ',id',
            'uan_number' => 'nullable|string|digits:12|unique:users,uan_number,' . $id . ',id',
            'date_of_joining' => 'required|date',
            'date_of_leaving' => 'nullable|date',
            'cl' => 'required|numeric',
            'sl' => 'required|numeric',
            'pl' => 'required|numeric',
            'salary' => 'required|numeric',
            'basic' => 'required|numeric',
            'hra' => 'required|numeric',
            'esi' => 'required|numeric',
            'pf' => 'required|numeric',
            'insurance' => 'required|numeric',
            'net_amount' => 'required|numeric',
            'bank_id' => 'nullable|integer|exists:banks,id',
            'account_number' => 'required|string|max:50|unique:users,account_number,'. $id .',id,bank_id,'. $input['bank_id'],
            'ifsc' => 'required|string|max:50',
            'assignRole' => 'required',
            'email' => 'required|email|max:50|unique:users,email,' . $id . ',id',
        ];

        if($this->isMethod("POST"))
        {
            $validation["password"] = 'required|confirmed|min:8|max:20';
        }

        if($this->isMethod("PUT"))
        {
            $validation["password"] = 'nullable|confirmed|min:8|max:20';
        }
        return $validation;
    }
}
