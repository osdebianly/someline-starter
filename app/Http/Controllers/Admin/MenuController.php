<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Someline\Http\Controllers\BaseController;
use Someline\Models\Foundation\Menu;
use Someline\Models\Foundation\Permission;

class MenuController extends BaseController
{


    public function __construct()
    {

    }

    /**
     * 菜单列表
     */
    public function index()
    {

        return view('admin.rbac.menu');
    }

    public function all()
    {
        $menus = Menu::all();
        return $menus;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function list()
    {
        $menus = Menu::all()->toArray();
        return array_column($menus, 'name');
    }

    public function permission(Request $request, $id)
    {
        $menu = Menu::find($id);
        $permission = Permission::where('slug', $menu->slug)->firstOrFail();
        return $permission->name;
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
        $permissionName = $request->permissionData;
        $menuData = $request->menuData;

        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $menuData['slug'] = $permission->slug;
        $menu = Menu::create($menuData);
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
        $permissionName = $request->permissionData;
        $menuData = $request->menuData;
        unset($menuData['id']);
        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $menuData['slug'] = $permission->slug;
        $menu = Menu::findOrFail($id);
        $menu->update($menuData);

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
            Menu::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        return response_message();
    }

}
