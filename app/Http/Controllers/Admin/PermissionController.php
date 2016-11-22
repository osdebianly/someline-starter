<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Someline\Http\Requests;
use Someline\Http\Controllers\BaseController;
use Someline\Models\Foundation\Permission;


class PermissionController extends BaseController
{

    function __construct()
    {

    }

    /**
     * 角色列表
     */
    public function index()
    {
        return view('admin.rbac.permission');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        $permissions = Permission::all();
        return $permissions;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list(Permission $permission)
    {
        $permissions = Permission::all()->toArray();
        return array_column($permissions, 'name');
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function store(Request $request)
    {
        //todo 权限判断
//        $admin = current_admin() ;
//        if( is_null($admin) || $admin->email != config('admin.admin_email','admin@admin.com')){
//            return response_message('仅限超级管理员操作') ;
//        }
        $data = $request->only('name', 'slug', 'description', 'level');

        $permission = Permission::create($data);

        return response_message();

    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        //todo 权限判断
//        $admin = current_admin() ;
//        if( is_null($admin) || $admin->email != config('admin.admin_email','admin@admin.com')){
//            return response_message('仅限超级管理员操作') ;
//        }
        $data = $request->only('name', 'slug', 'description', 'level');
        try {
            $permission = Permission::findOrFail($id);
            $permission->update($data);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }

        return response_message();

    }

    /**
     * 删除菜单
     * @param Request $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        try {
            Permission::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        return response_message();
    }


}
