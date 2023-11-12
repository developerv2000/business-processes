<?php

namespace App\Http\Requests;

use App\Models\Generic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGenericRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dose' => [
                Rule::unique(Generic::class)->where(function ($query) {
                    $query->where('manufacturer_id', $this->manufacturer_id)
                        ->where('mnn_id', $this->mnn_id)
                        ->where('form_id', $this->form_id)
                        ->where('dose', $this->dose)
                        ->where('pack', $this->pack);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'dose.unique' => trans('validation.unique-generic'),
        ];
    }
}
