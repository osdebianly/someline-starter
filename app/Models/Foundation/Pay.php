<?php

namespace Someline\Models\Foundation;

use Someline\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pay extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'state', 'number', 'note', 'user_id', 'verify_code', 'client_id'
    ];


}
