<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgetPasswordRequest extends FormRequest
{
    private $dataObject;

    public function __construct() {
        // Initialize $dataObject as a new stdClass object
        $this->dataObject = new \stdClass();
    }

    public function rules()
    {
       
        return [
            'email' => 'required|email'
        ];
    }
    public function messages()
    {
        return [

        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'data' =>$this->dataObject,
            'status' => 0,
            'errors' => $validator->errors(),
        ], 400));
    }
    
}
