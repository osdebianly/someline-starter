<?php
/**
 * Created by PhpStorm.
 * User: Libern
 * Date: 22/7/16
 * Time: 17:39
 */

namespace Someline\Http\Controllers;


use Someline\Models\Foundation\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    public function index()
    {
        return view('users.user_list');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        $users = User::all();
        return $users;
    }

    public function store(Request $request)
    {
        //todo 权限判断
//        $user = current_user() ;
//        if( is_null($user) || $user->email != config('user.user_email','user@user.com')){
//            return response_message('仅限超级管理员操作') ;
//        }

        $user = User::create($request->all());

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
//        $user = current_user() ;
//        if( is_null($user) || $user->email != config('user.user_email','user@user.com')){
//            return response_message('仅限超级管理员操作') ;
//        }

        $userData = $request->all();
        unset($userData['id']);
        try {
            $user = User::findOrFail($id);
            $user->update($userData);
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
            User::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_message('该配置无效');
        }
        return response_message();
    }

}