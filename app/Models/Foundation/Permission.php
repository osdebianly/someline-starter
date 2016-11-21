<?php
namespace Someline\Models\Foundation;

use GeniusTS\Roles\Models\Permission as Model;

class Permission extends Model
{
    private $action = 'permission';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
