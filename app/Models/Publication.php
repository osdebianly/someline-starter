<?php

namespace Someline\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Publication extends Model
{
//    protected $fillable = [
//        'package_name', 'min_version', 'max_version', 'min_time', 'max_time', 'uuids'
//    ];
    protected $guarded = ['id', 'created_at', 'updated_at', 'created_by', 'created_ip', 'updated_ip'];

    public function setMinTimeAttribute($value)
    {
        $this->attributes['min_time'] = Carbon::parse($value);
    }

    public function setMaxTimeAttribute($value)
    {
        $this->attributes['max_time'] = Carbon::parse($value);
    }

    public function setUuidsAttribute($value)
    {
        $this->attributes['uuids'] = json_encode($value);
    }

    public function getUuidsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setOnlineConfigAttribute($value)
    {
        $this->attributes['online_config'] = json_encode($value);
    }

    public function getOnlineConfigAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setServerListAttribute($value)
    {
        $this->attributes['server_list'] = json_encode($value);
    }

    public function getServerListAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setHotUpgradeAttribute($value)
    {
        $this->attributes['hot_upgrade'] = json_encode($value);
    }

    public function getHotUpgradeAttribute($value)
    {
        return json_decode($value, true);
    }

}
