<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\PaginatedDocumentResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/**
 * Class DocumentCollection
 * @package App\Http\Resources
 */
class DocumentCollection extends ResourceCollection
{
    /**
     * DocumentCollection constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        static::wrap('document');
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            static::$wrap => $this->collection,
            'pagination' => [
                'page' => $this->currentPage(),
                'perPage' => $this->perPage(),
                'total' => $this->total(),
            ],
        ];
    }

    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedDocumentResponse($this))->toResponse($request);
    }
}
