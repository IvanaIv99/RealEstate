<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UnitsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_type' => 'required|integer|exists:unit_types,id',
            'size' => 'required|integer',
            'bedrooms' => 'required|integer',
            'address' => 'required|string',
            'price' => 'required|digits_between:1,99999999',
            'latitude' => ['required','regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
            'longitude' => ['required','regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/']
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'code' => 403,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'id_type.exists' => 'Unit type doesnt exists.',
            'size.integer' => 'Size must be a number',
            'bedrooms.integer' => 'Number of bedrooms must be a number',
            'latitude.regex' => 'The latitude must be in range between -90 and 90.',
            'longitude.regex' => 'The longitude mus be in range between -180 and 180.',
        ];

    }
}
