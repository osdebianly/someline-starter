<?php

namespace Someline\Models;

use Illuminate\Database\Eloquent\Model;
//use Someline\Models\BaseModel;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Activity extends BaseModel implements Transformable
{
    use TransformableTrait;

    protected $primaryKey = 'id';

    protected $fillable = ['good_reputation'];

    // Fields to be converted to Carbon object automatically
    //protected $dates = [];

    public function getGoodReputationAttribute($value)
    {
        return json_decode($value, true);
    }

}
