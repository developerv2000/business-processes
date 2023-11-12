<?php

namespace App\Http\Requests;

use App\Models\Mnn;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMnnRequest extends FormRequest
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
        $itemID = $this->route('item')?->id;

        return [
            'name' => Rule::unique(Mnn::class)->ignore($itemID),
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => trans('validation.unique-mnn'),
        ];
    }
}
