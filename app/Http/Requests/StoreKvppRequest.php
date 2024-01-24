<?php

namespace App\Http\Requests;

use App\Models\Kvpp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKvppRequest extends FormRequest
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
                Rule::unique(Kvpp::class)->where(function ($query) {
                    $query->where('mnn_id', $this->mnn_id)
                        ->where('form_id', $this->form_id)
                        ->where('country_code_id', $this->country_code_id)
                        ->where('promo_company_id', $this->promo_company_id)
                        ->where('dose', $this->dose)
                        ->where('pack', $this->pack);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'dose.unique' => trans('validation.unique-kvpp'),
        ];
    }
}
