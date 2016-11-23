<?php

namespace Someline\Models\Foundation;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['pid', 'name', 'icon', 'slug', 'url', 'active', 'description', 'sort'];

    public function setSortAttribute($value)
    {
        if ($value && is_numeric($value)) {
            $this->attributes['sort'] = intval($value);
        } else {
            $this->attributes['sort'] = 0;
        }
    }
}
