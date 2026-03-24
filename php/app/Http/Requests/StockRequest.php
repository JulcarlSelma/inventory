<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        return [
            'history_id' =>  [
                $isUpdate ? 'required' : 'nullable',
                'integer',
                'exists:stock_history,id'
            ],
            'product_id' => 'required|integer|exists:products,id',
            'stocked_count' => 'required|integer|min:0',
            'type' => 'required|string|in:in,out',
            'date' => 'nullable|date',
            'requestor' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
            'details' => 'nullable|string',
        ];
    }
}
