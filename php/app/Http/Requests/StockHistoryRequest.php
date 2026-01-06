<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockHistoryRequest extends FormRequest
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
            'stock_id' => 'required|integer|exists:stocks,id',
            'count' => 'required|integer|min:0',
            'out_date' => 'required|date',
            'requestor' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
            'details' => 'nullable|string',
        ];
    }
}
