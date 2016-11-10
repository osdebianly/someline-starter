<?php

namespace Someline\Api\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Someline\Http\Requests\UserUpdateRequest;
use Someline\Models\Foundation\User;
use Illuminate\Support\Facades\Input;
use SmsManager;
use PhpSms;
use Validator;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Status;
use Dingo\Api\Exception\ResourceException;

class SMSController extends BaseController
{


    /**
     * SMSController constructor.
     */
    public function __construct()
    {

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    {
        $res = send_sms_code();

        if (!$res['success']) {
            throw new ResourceException($res['message']);
            //return ['status_code'=>Status::HTTP_BAD_REQUEST,'message'=>$res['message'],'errors'=>$res['type']] ;
        }

        return ['status_code' => Status::HTTP_OK, 'message' => $res['message']];
    }

    /**
     * verify sms code
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        //验证数据
        if (!verify_sms_code()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            //SmsManager::forgetState();
            throw new ResourceException('验证码不正确');
        }
        return ['status_code' => Status::HTTP_OK, 'message' => '验证成功'];

    }

    /**
     * Password rest by phone
     * @param Request $request
     * @return json
     */
    public function resetPassword(Request $request)
    {
        /**
         * 首先检查手机号码
         */
        try {
            User::where('phone_number', $request->mobile)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ResourceException('该手机号码未绑定');
        }

        $res = send_sms_code();
        if (!$res['success']) {
            throw new ResourceException($res['message']);
        }

        return ['status_code' => Status::HTTP_OK, 'message' => $res['message']];
        
    }

    /**
     *  Verify reset password code
     * @param Request $request
     * @return array
     */
    public function verifyRestPassword(Request $request)
    {
        /**
         * 验证数据
         */
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'verifyCode' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            throw new ResourceException('参数不全:' . $validator->errors());
        }

        $newPassword = $request->password;

        if (!verify_sms_code()) {
            throw new ResourceException('验证码不正确');
        }

        /**
         * 更新密码
         */
        $currentUser = User::where('phone_number', $request->mobile)->firstOrFail();
        $currentUser->password = bcrypt($newPassword);
        $currentUser->save();

        return ['status_code' => Status::HTTP_OK, 'message' => '密码修改成功'];
    }


}
