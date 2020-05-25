<?php

namespace App\Http\Resources\Json;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class PaginatedDocumentResponse extends PaginatedResourceResponse
{
    /**
     * @param Request $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        return [];
    }
}
