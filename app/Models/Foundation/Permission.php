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

    /**
     * 获取所有的权限并按照功能分组
     * @author 晚黎
     * @date   2016-11-03T13:20:18+0800
     * @return [type]                   [description]
     */
    public function groupPermissionList()
    {
        $permissions = Permission::all();
        $array = [];
        if ($permissions) {
            foreach ($permissions as $v) {
                array_set($array, $v->slug, ['id' => $v->id, 'name' => $v->name]);
            }
        }
        return $array;
    }

}
