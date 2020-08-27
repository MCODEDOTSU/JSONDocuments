<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * Class Message
 * @package App\src\Models
 */
class Document extends Model
{

    protected $fillable = [
        'id',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'object',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $attributes = [
        'payload' => '{}',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($document) {
            $document->{$document->getKeyName()} = (string)Uuid::generate();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

}
