<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:2000'],
            'status' => ['required','in:todo,doing,done'],
            'priority' => ['required','in:low,medium,high'],
            'dueDate' => ['nullable','date'],
        ];
    }
}
