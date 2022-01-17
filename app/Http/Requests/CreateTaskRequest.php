<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'max:255',
            ],
            'category' => 'max:255',
            'description' => 'nullable|max:255',
            'deadline_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ];
    }
}
