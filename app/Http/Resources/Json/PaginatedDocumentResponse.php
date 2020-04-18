<?php

namespace App\Http\Resources\Json;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Request;

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
