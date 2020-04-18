<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * Class Error
 * @package App\Http\Resources
 */
class Error extends JsonResource
{
    /**
     * Error constructor.
     * @param $resource
     */
    public function __construct($resource = null)
    {
        static::withoutWrapping();
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];
    }
}
