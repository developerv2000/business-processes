<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
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
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'year' => 'unique:meetings,year,null,null,manufacturer_id,' . $this->manufacturer_id,  // table name, unique column name, primary key, primary key, additional conditions for the uniqueness check
        ];
    }

    public function messages(): array
    {
        return [
            'year.unique' => trans('validation.unique-meeting'),
        ];
    }
}
