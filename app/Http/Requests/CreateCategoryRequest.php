<?php

namespace App\Http\Requests;

use App\Enums\ChildTypes;
use App\Rules\DontHaveMixedChilds;
use App\Rules\MaxLevelSubCategory;
use App\Traits\WrapsApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|string',
            'discount' => 'numeric|min:0|max:100|nullable',
            'parent_id' => [
                'exists:categories,id',
                new MaxLevelSubCategory(config('app.subcategoryMaxLevel')),
                new DontHaveMixedChilds(ChildTypes::Item)
            ],
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
