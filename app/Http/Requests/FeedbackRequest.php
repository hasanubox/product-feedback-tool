<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
        return  [
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:1024'
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'category_id.required' => 'Category is required',
            'description.required' => 'Description is required',
        ];
    }
}
