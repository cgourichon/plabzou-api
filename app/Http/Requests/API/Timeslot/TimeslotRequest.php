<?php

namespace App\Http\Requests\API\Timeslot;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TimeslotRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'training' => ['required', 'integer', 'exists:trainings,id'],
            'room' => ['required', 'integer', 'exists:rooms,id'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date'],
            'is_validated' => ['nullable', 'boolean'],
            'learners' => ['required', 'array'],
            'learners.*.id' => ['required', 'exists:users,id'],
            'learners.*.learner.id' => ['required', 'exists:learners,id'],
            'teachers' => ['required', 'array'],
            'teachers.*.id' => ['required', 'exists:users,id'],
            'teachers.*.teacher.id' => ['required', 'exists:teachers,id'],
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
            'training.required' => 'La formation est obligatoire.',
            'training.integer' => 'La formation doit être un entier.',
            'training.exists' => 'La formation n\'existe pas.',
            'room.required' => 'La salle est obligatoire.',
            'room.integer' => 'La salle doit être un entier.',
            'room.exists' => 'La salle n\'existe pas.',
            'starts_at.required' => 'La date de début est obligatoire.',
            'starts_at.date' => 'La date de début doit être une date.',
            'ends_at.required' => 'La date de fin est obligatoire.',
            'ends_at.date' => 'La date de fin doit être une date.',
            'is_validated.boolean' => 'La validation doit être un booléen.',
            'learners.required' => 'Les apprenants sont obligatoires.',
            'learners.array' => 'Les apprenants doivent être un tableau.',
            'learners.*.id.required' => 'L\'apprenant est obligatoire.',
            'learners.*.id.exists' => 'L\'apprenant n\'existe pas.',
            'learners.*.learner.id.required' => 'L\'apprenant est obligatoire.',
            'learners.*.learner.id.exists' => 'L\'apprenant n\'existe pas.',
            'teachers.required' => 'Les formateurs sont obligatoires.',
            'teachers.array' => 'Les formateurs doivent être un tableau.',
            'teachers.*.id.required' => 'Le formateur est obligatoire.',
            'teachers.*.id.exists' => 'Le formateur n\'existe pas.',
            'teachers.*.teacher.id.required' => 'Le formateur est obligatoire.',
            'teachers.*.teacher.id.exists' => 'Le formateur n\'existe pas.',
        ];
    }
}
