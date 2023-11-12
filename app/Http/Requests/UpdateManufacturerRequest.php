<?php

namespace App\Http\Requests;

use App\Models\Manufacturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateManufacturerRequest extends FormRequest
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
            'name' => Rule::unique(Manufacturer::class)->ignore($itemID),
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => trans('validation.unique-manufacturer'),
        ];
    }
}
