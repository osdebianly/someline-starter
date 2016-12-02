<?php

namespace Someline\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'type', 'number', 'note'
    ];
}
