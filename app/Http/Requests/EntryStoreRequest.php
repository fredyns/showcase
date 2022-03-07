<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryStoreRequest extends FormRequest
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
            'label' => ['required', 'max:255', 'string'],
            'date' => ['nullable', 'date'],
            'text' => ['nullable', 'string'],
            'uuid' => ['required', 'max:255'],
            'file' => ['nullable', 'file'],
            'image' => ['nullable', 'image', 'max:1024'],
            'datetime' => ['nullable', 'date'],
            'bool' => ['nullable', 'boolean'],
            'number' => ['nullable', 'numeric'],
            'json' => ['nullable', 'json'],
        ];
    }
}
