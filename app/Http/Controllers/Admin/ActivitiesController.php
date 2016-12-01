<?php
namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Someline\Http\Controllers\BaseController;
use Someline\Models\Activity;
use Someline\Models\Foundation\Menu;
use Someline\Models\Foundation\Permission;

class ActivitiesController extends BaseController
{


    public function __construct()
    {

    }

    /**
     * 菜单列表
     */
    public function goodReputation()
    {

        return view('admin.activity.good_reputation');
    }

    /**
     * 待审核好评
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function goodReputationWait()
    {
        return $this->getGoodReputation('wait');
    }

    /**
     * 审核通过
     * @return array
     */
    public function goodReputationSuccess()
    {
        return $this->getGoodReputation('success');
    }

    /**
     * 审核不通过
     * @return array
     */
    public function goodReputationFail()
    {
        return $this->getGoodReputation('fail');
    }

    /**
     * 获取审核列表
     * @param $type string
     * @return array
     */
    private function getGoodReputation($type = 'wait')
    {
        $data = [];

        $activities = \DB::table('activities')
            ->select('id', 'user_id', 'good_reputation')
            ->where('good_reputation->state', $type)
            ->limit(100)
            ->get();

        foreach ($activities as $activity) {
            $data[] = array_merge(json_decode($activity->good_reputation, true), ['id' => $activity->id, 'user_id' => $activity->user_id,]);
        }
        return $data;
    }

    /**
     * 所有评价
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function goodReputationAll()
    {
        $goodReputations = Activity::all('id', 'user_id', 'good_reputation')->toArray();
        return array_map(function ($row) {
            return array_merge($row['good_reputation'], ['id' => $row['id'], 'user_id' => $row['user_id']]);
        }, $goodReputations);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateGoodReputation(Request $request, $id)
    {
        //todo 权限判断
//        $admin = current_admin() ;
//        if( is_null($admin) || $admin->email != config('admin.admin_email','admin@admin.com')){
//            return response_message('仅限超级管理员操作') ;
//        }
        $data = $request->only('state', 'note');

        \DB::table('activities')
            ->where('id', $id)
            ->update(['good_reputation->state' => (string)$data['state'], 'good_reputation->note' => (string)$data['note']]);
        //$activity = Activity::findOrFail($id);
        //$activity->update(]) ;

        return response_message();
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
        if (!empty($permissionName)) {
            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $menuData['slug'] = $permission->slug;
        }
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
