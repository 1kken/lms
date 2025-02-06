<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storebook_issueRequest extends FormRequest
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
            'student_id' => "required|exists:students,student_id",
            'rfid' => "required|exists:books,rfid",
        ];
    }
}
