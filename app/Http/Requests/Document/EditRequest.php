<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditRequest
 * @package App\Http\Requests\Document
 */
class EditRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'document' => 'array|required',
            'document.payload' => 'array|required'
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        return $this->json()->all();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator) : void
    {
        throw (new HttpResponseException(response()->json([], Response::HTTP_BAD_REQUEST)));
    }
}
