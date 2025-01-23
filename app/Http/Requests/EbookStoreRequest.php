<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EbookStoreRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'file_path' => 'required|file|mimes:pdf|max:2048', // Misalnya, hanya file PDF
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Misalnya, hanya gambar
        ];
    }
}
