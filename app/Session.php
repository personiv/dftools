<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $primaryKey = 'session_id';

    protected $casts = [
        'session_data' => 'array'
    ];
}
