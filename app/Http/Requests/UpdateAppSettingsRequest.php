<?php

namespace App\Http\Requests;

use App\Traits\WrapsApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAppSettingsRequest extends FormRequest
{
    use WrapsApiResponse;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */ 
    public function rules(): array
    {
        return [
            'discount' => 'numeric|min:0',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = $this->respondValidationError($validator);
        throw new HttpResponseException($response);
    }
}
