<?php

namespace Someline\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Publication extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'package_name', 'min_version', 'max_version', 'min_time', 'max_time', 'uuids'
    ];

}
