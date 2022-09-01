<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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
        $validation = [
            "user_id" => 'required|integer|exists:users,id',
            "start_date" => 'required|date',
            "end_date" => 'required|date',
            "duration" => 'required|string',
            "leave_type" => 'required|string',
            "no_of_days" => 'required',
            "reason" => 'required|string',
        ];

        return $validation;
    }
}
