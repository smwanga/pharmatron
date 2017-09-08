<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'batch_no' => 'nullable|alpha_dash',
            'lpo_number' => 'nullable|alpha_dash',
            'ref_number' => 'nullable|alpha_dash',
            'supplier_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'marked_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric',
            'expire_at' => 'required|after:'.Carbon::now(),
            'pack_size' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function messages()
    {
        return [
            'supplier_id.required' => trans('messages.validation.suppliers.required'),
            'expire_at.after' => trans('messages.validation.suppliers.after'),
        ];
    }
}
