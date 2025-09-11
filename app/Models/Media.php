<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'path',
        'disk',
        'type',
        'size',
        'meta'
        ];

}
