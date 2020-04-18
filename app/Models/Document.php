<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;

/**
 * Class Document
 * @package App\Models
 * @property string $id
 * @property string $status
 * @property string $payload
 */
class Document extends Model
{
    /** @var int  */
    const PER_PAGE = 20;
    /** @var string */
    const STATUS_PUBLISHED = 'published';
    /** @var string  */
    const STATUS_DRAFT = 'draft';

    /** @var string  */
    protected $keyType = 'string';
    /** @var bool  */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'payload',
    ];

    /**
     * Default values
     *
     * @var array
     */
    protected $attributes = [
        'payload' => '{}',
    ];

    /**
     * Get available statuses in system
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED
        ];
    }

    /**
     * Override to automatically create
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Document $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
            $model->setAttribute('status', self::STATUS_DRAFT);
        });
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getPayloadAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * @param $value
     */
    public function setPayLoadAttribute($value)
    {
        $this->payload = json_encode($value);
    }
}
