<?php
/**
 * Created by PhpStorm.
 * User: Libern
 * Date: 22/7/16
 * Time: 17:39
 */

namespace Someline\Http\Controllers\Admin;


use Dingo\Api\Exception\ResourceException;
use GuzzleHttp\Exception\BadResponseException;
use Someline\Models\Foundation\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Someline\Http\Controllers\BaseController;
use Someline\Models\Publication;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PublicationController extends BaseController
{

    /**列表
     * @return mixed
     */
    public function index()
    {
        return view('publications.publication_list');
    }


    /**新增页面
     * @return mixed
     */
    public function add()
    {
        return view('publications.publication_add');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        $publications = Publication::all();
        return $publications;
    }

    public function store(Request $request)
    {
        //todo 权限判断
//        $user = current_user() ;
//        if( is_null($user) || $user->email != config('user.user_email','user@user.com')){
//            return response_message('仅限超级管理员操作') ;
//        }
        $data = $request->all();
        $user = Publication::create($data);

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
            $user = Publication::findOrFail($id);
            $user->update($userData);
        } catch (ModelNotFoundException $e) {
            return response_exection('该配置无效');
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
            Publication::destroy($id);
        } catch (ModelNotFoundException $e) {
            return response_exection('该配置无效');
        }
        return response_message();
    }

    public function gitCheckOut(Request $request)
    {
        $gitUrl = $request->git_url;
        $gitBranch = $request->git_branch;
        $packageName = $request->package_name;


        $basePath = public_path('upgrade/');
        $gitDir = $packageName . date('ymdHis');
        $donwloadUrl = url('upgrade/' . $gitDir);
        if (!file_exists($basePath)) {
            mkdir($basePath, 777, true);
        }
        chdir($basePath);
        /**
         * git clone
         */
        try {
            $process = new Process('git clone ' . $gitUrl . ' ' . $gitDir);
            $process->mustRun();
        } catch (ProcessFailedException $e) {
            return response_exection('克隆出错', $e->getMessage());
        }

        return response_message('克隆成功', ['download_url' => $donwloadUrl]);
    }

}