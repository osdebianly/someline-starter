<?php

if (!function_exists('auth_user')) {

    /**
     * @return \Someline\Model\Foundation\User|\Someline\Models\Foundation\User
     */
    function auth_user()
    {
        return current_auth_user();
    }

}

if (!function_exists('rest_client')) {

    /**
     * @param null $service_name
     * @param null $debug_mode
     * @return \Someline\Rest\RestClient
     */
    function rest_client($service_name = null, $debug_mode = null)
    {
        return new \Someline\Rest\RestClient($service_name, $debug_mode);
    }

}

if (!function_exists('auth_token')) {

    /**
     * @param null $service_name
     * @param null $debug_mode
     * @return \Someline\Rest\RestClient
     */
    function auth_token()
    {
        return auth_user()->token() ;
    }

}

if (!function_exists('auth_client_id')) {

    /**
     * @param null $service_name
     * @param null $debug_mode
     * @return \Someline\Rest\RestClient
     */
    function auth_client_id()
    {
        $token = auth_token() ;
        if(isset($token->client_id)){
            return (int)$token->client_id ;
        }
        return 0 ;
    }

}


if (!function_exists('send_sms_code')) {

    /**
     * @return boolean
     */
    function send_sms_code()
    {

        //启用队列
        PhpSms::queue(true);

        $res = SmsManager::validateSendable();
        if (!$res['success']) {
            return $res;
        }

        $res = SmsManager::validateFields();
        if (!$res['success']) {
            return $res;
        }

        return SmsManager::requestVerifySms();
    }

}

if (!function_exists('verify_sms_code')) {

    /**
     * @return boolean
     */
    function verify_sms_code()
    {
        //验证数据
        $request = request();
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            return false;
        }
        return true;
    }

}