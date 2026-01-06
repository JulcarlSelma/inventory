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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:price',
            // Special handling for the 'unique' rule on 'sku'
            'sku' => [
                'required',
                'string',
                'max:100',
                // This rule checks for uniqueness, but ignores the record with the current $productId
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'category_id' => [
                'nullable',        // Allows the field to be null or missing from the request
                'numeric',         // Ensures it's a number (the ID) if present
                Rule::exists('categories', 'id'), // Ensures the ID exists in the 'categories' table
            ],
        ];
    }
}
