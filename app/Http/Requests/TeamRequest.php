<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
        $team = $this->request->all();
        $id = isset($team['id']) ? $team['id'] : '';

        //info("data");

        $validation = [
            'team_name' => 'required|string|unique:teams,team_name,' . $id . 'id',
            'description' => 'required|string',
            'responsible_person' => 'required',
        ];

        return $validation;
    }
}
