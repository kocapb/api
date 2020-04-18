<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 * @package App\Models
 */
class Model extends BaseModel
{
    /**
     * Оverload standard output
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('app.format.datetime'));
    }

    /**
     * Оverload standard output
     *
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('app.format.datetime'));
    }
}
