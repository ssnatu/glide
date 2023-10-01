<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class MacAddressMultipleRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'address_data' => 'array',
            'address_data.*.mac_address' => ['required', 
                function (string $attribute, mixed $value, Closure $fail) {

                    $mac_address = str_ireplace(array( '-', ':', '.'), '', $value); // remove all dashes, dots and colons

                    // length of mac_address must be 12 characters long
                    if (strlen($mac_address) !== 12) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ]
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages['address_data.array'] = 'Invalid input';
        $messages['address_data.*.mac_address.required'] = 'MAC address is missing';

        return $messages;
    }
}
