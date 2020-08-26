<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @package App\src\Models
 */
class Message extends Model
{

    protected $fillable = [
        'id',
        'author',
        'text',
    ];

}
