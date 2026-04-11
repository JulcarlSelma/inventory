<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product'); 
        return [
            'image_path' => 'nullable|mimes:jpg,jpeg,png,gif|max:2048', // Optional image upload with size limit
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0|gte:price',
            // Special handling for the 'unique' rule on 'sku'
            'sku' => [
                'nullable',
                'string',
                'max:100',
                // This rule checks for uniqueness, but ignores the record with the current $productId
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:50',
                // This rule checks for uniqueness, but ignores the record with the current $productId
                Rule::unique('products', 'barcode')->ignore($productId),
            ],
            'serial_number' => [
                'nullable',
                'string',
                'max:100',
                // This rule checks for uniqueness, but ignores the record with the current $productId
                Rule::unique('products', 'serial_number')->ignore($productId),
            ],
            'category_id' => [
                'nullable',        // Allows the field to be null or missing from the request
                'numeric',         // Ensures it's a number (the ID) if present
                Rule::exists('categories', 'id'), // Ensures the ID exists in the 'categories' table
            ],
        ];
    }
}
