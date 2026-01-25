<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       return [
            'name' => 'required|string|max:255',
            'address_line_one' => 'nullable|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country_id' => 'nullable|exists:countries,id',
            'website' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'members_count' => 'required|integer',
            'business_est' => 'required|integer',
            'profile' => 'nullable|string',
            'fpp' => 'required|in:yes,no',
            'email' => 'required|email',

            'status' => 'nullable|in:pending,approved,suspended,blacklisted',
            'active' => 'nullable|boolean',
            'show_home' => 'nullable|boolean',

            'contactPersons.*.title' => ['nullable'],
            'contactPersons.*.first_name' => ['nullable'],
            'contactPersons.*.last_name' => ['nullable'],
            'contactPersons.*.job_title' => ['nullable'],
            'contactPersons.*.phone_number' => ['nullable'],
            'contactPersons.*.cell_number' => ['nullable'],
            'contactPersons.*.email' => ['nullable'],

        ];
    }
}



