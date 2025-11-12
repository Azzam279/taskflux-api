<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes','string','max:150'],
            'description' => ['sometimes','nullable','string','max:2000'],
            'status' => ['sometimes','in:todo,doing,done'],
            'priority' => ['sometimes','in:low,medium,high'],
            'dueDate' => ['sometimes','nullable','date'],
        ];
    }
}
