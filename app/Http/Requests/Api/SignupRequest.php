<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignupRequest extends FormRequest
{

    private $dataObject;

    public function __construct()
    {
        // Initialize $dataObject as a new stdClass object
        $this->dataObject = new \stdClass();
    }

    public function rules(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:5|max:100',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'type' => 'required',
        ];
        return $rules;
    }
    public function messages()
    {
        return [

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'data' => $this->dataObject,
            'status' => 0,
            'errors' => $validator->errors(),
        ], 400));
    }
}
