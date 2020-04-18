<?php

namespace App\Http\Requests\Document;

use App\Http\Requests\Request;

class ListRequest extends Request
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
            'page' => 'int',
            'perPage' => 'int',
        ];
    }

}
