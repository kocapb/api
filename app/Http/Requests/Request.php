<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * @return bool
     */
    abstract public function authorize(): bool;

    /**
     * @return array
     */
    abstract public function rules(): array;
}
