<?php

namespace App\Http\Requests\API\Request;

use Illuminate\Foundation\Http\FormRequest;

class RequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'timeslot_id' => 'required|integer',
            'teacher_id' => 'required|integer',
            'administrative_employee_id' => 'required|integer',
            'comment' => 'string|min:2|max:255|nullable',
            'is_approved_by_admin' => 'boolean|nullable',
            'is_approved_by_teacher' => 'boolean|nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'timeslot_id.required' => 'Veuillez sélectionner un créneau',
            'teacher_id.required' => 'Veuillez sélectionner un formateur',
            'comment.min' => 'Le commentaire doit avoir au minimum 2 caractères',
            'comment.max' => 'Le commentaire doit avoir au maximum 255 caractères',
        ];
    }
}
