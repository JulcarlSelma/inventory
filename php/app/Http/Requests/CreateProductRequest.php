<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'image_path' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048', // Optional image upload with size limit
            'name' => 'required|string|max:255',
            'description' => 'nullable|string', // Make description optional
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $this->route('product'),
            'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $this->route('product'),
            'serial_number' => 'nullable|string|max:100|unique:products,serial_number,' . $this->route('product'),
            'price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:price', // Must be greater than or equal to the price
            'category_id' => [
                'nullable',        // Allows the field to be null or missing from the request
                'numeric',         // Ensures it's a number (the ID) if present
                Rule::exists('categories', 'id'), // Ensures the ID exists in the 'categories' table
            ],
        ];
    }
}
