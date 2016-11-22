<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Someline\Http\Requests;
use Someline\Http\Controllers\BaseController;
use GeniusTS\Roles\Models\Role;


class RoleController extends BaseController
{

    function __construct()
    {

    }

    /**
     * 角色列表
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {

        $roles = Role::all();
        return $roles;
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

        $role = Role::create($data);

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
            $role = Role::findOrFail($id);
            $role->update($data);
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
            Role::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        return response_message();
    }


}
