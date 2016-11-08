<?php

namespace Someline\Api\Controllers;


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
            //return ['status_code'=>Status::HTTP_BAD_REQUEST,'message'=>'验证码不正确'];
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
//        $currentUser = auth_user();
//        if (empty($currentUser->phone_number)) {
//            throw new ResourceException('未绑定手机号码');
//            //return ['status_code' => Status::HTTP_BAD_REQUEST, 'message' => '未绑定手机号码'];
//        }
        //丢弃上传的手机号码
        //$request->merge(['mobile' => $currentUser->phone_number]);
        $res = send_sms_code();
        if (!$res['success']) {
            throw new ResourceException($res['message']);
            //return ['status_code' => Status::HTTP_BAD_REQUEST, 'message' => $res['message'], 'errors' => $res['type']];
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
        //验证数据
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'verifyCode' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            throw new ResourceException('参数不全:' . $validator->errors());
            //return ['status_code' => Status::HTTP_BAD_REQUEST, 'message' => '参数不全', 'errors' => $validator->errors()];
        }

        //$currentUser = auth_user();
        $newPassword = $request->password;

        //$request->merge(['mobile' => $currentUser->phone_number]);
        if (!verify_sms_code()) {
            throw new ResourceException('验证码不正确');
            //return ['status_code' => Status::HTTP_BAD_REQUEST, 'message' => '验证码不正确'];
        }

        //更新密码
        $currentUser = User::where('phone_number', $request->mobile)->firstOrfail();
        $currentUser->password = bcrypt($newPassword);
        $currentUser->save();

        return ['status_code' => Status::HTTP_OK, 'message' => '密码修改成功'];
    }


}
