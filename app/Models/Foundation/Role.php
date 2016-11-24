<?php
namespace Someline\Models\Foundation;

use GeniusTS\Roles\Models\Role as Model;
use GeniusTS\Roles\Traits\RoleHasRelations;
class Role extends Model
{
    use RoleHasRelations;
    private $action = 'role';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function setLevelAttribute($value)
    {
        if ($value && is_numeric($value)) {
            $this->attributes['level'] = intval($value);
        } else {
            $this->attributes['level'] = 1;
        }
    }

}
