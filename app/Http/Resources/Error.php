<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * Class Error
 * @package App\Http\Resources
 */
class Error extends JsonResource
{
    /** @var Throwable */
    protected $exception;

    /**
     * Error constructor.
     * @param Throwable $exception
     * @param $resource
     */
    public function __construct(Throwable $exception, $resource = null)
    {
        static::withoutWrapping();
        parent::__construct($resource);
        $this->exception = $exception;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => $this->exception->getCode(),
            'message' =>  $this->exception->getMessage(),
        ];
    }
}
