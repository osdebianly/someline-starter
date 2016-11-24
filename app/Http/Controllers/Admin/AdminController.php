<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Someline\Http\Requests;
use Someline\Http\Controllers\BaseController;
use Someline\Models\Foundation\Admin;
use Someline\Models\Foundation\Menu;
use Someline\Models\Foundation\Permission;
use Someline\Models\Foundation\Role;


class AdminController extends BaseController
{

    function __construct()
    {

    }

    /**
     * 角色列表
     */
    public function index()
    {
        return view('admin.rbac.admin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        $admins = Admin::all();
        return $admins;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list(Admin $Admin)
    {
        $Admins = Admin::all()->toArray();
        return array_column($Admins, 'name');
    }

    public function roles(Request $request, $id)
    {
        $admin = Admin::find($id);
        $roles = $admin->roles()->get()->toArray();
        return array_column($roles, 'name');
    }

    public function permissions(Request $request, $id)
    {
        $admin = Admin::find($id);
        $permissions = $admin->getPermissions()->toArray();
        return array_column($permissions, 'name');
    }

    public function myMenus(Request $request)
    {
        $admin = current_admin();
        if (is_null($admin)) {
            return [];
        }
        $permissions = $admin->getPermissions()->toArray();
        $menuList = array_column($permissions, 'slug');

        $menus = Menu::all()->toArray();
        $myMenus = [];
        foreach ($menus as $menu) {
            if (in_array($menu['slug'], $menuList)) {
                $tmpMenu = [];
                $tmpMenu['id'] = (string)$menu['id'];
                $tmpMenu['name'] = (string)$menu['name'];
                $tmpMenu['url'] = (string)$menu['url'];
                if ($menu['pid'] == 0) {
                    $tmpMenu['children'] = [];
                    $myMenus[$menu['id']] = $tmpMenu;
                } elseif ($menu['pid'] > 0) {
                    if (!isset($myMenus[$menu['pid']])) {
                        $myMenus[$menu['pid']] = array_first(array_filter(array_map(function ($item) use ($menu) {
                            if ($item['id'] == $menu['pid']) {
                                $tmpMenu['id'] = (string)$item['id'];
                                $tmpMenu['name'] = (string)$item['name'];
                                $tmpMenu['url'] = (string)$item['url'];
                                $tmpMenu['children'] = [];
                                return $tmpMenu;
                            }
                        }, $menus)));
                    }
                    $myMenus[$menu['pid']]['children'][] = $tmpMenu;
                }
            }

        }
        return array_values($myMenus);
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
        $roles = $request->roleData;
        $permissions = $request->permissionData;
        $adminData = $request->adminData;
        $admin = Admin::create($adminData);

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $admin->attachRole($role);
        }

        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $admin->attachPermission($permission);
        }

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
        $roles = $request->roleData;
        $permissions = $request->permissionData;
        $adminData = $request->adminData;
        unset($adminData['id']);
        try {
            $admin = Admin::findOrFail($id);
            $admin->update($adminData);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        $admin->detachAllRoles();
        $admin->detachAllPermissions();

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $admin->attachRole($role);
        }

        foreach ($permissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $admin->attachPermission($permission);
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
            Admin::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        return response_message();
    }


}
