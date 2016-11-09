<?php namespace lyfing\pay;
    /**
     * 苹果支付扩展
     * User: lyfing
     * Date: 2016/11/9
     * Time: 下午5:25
     */

/**
 * 21000 App Store不能读取你提供的JSON对象
 * 21002 receipt-data域的数据有问题
 * 21003 receipt无法通过验证
 * 21004 提供的shared secret不匹配你账号中的shared secret
 * 21005 receipt服务器当前不可用
 * 21006 receipt合法，但是订阅已过期。服务器接收到这个状态码时，receipt数据仍然会解码并一起发送
 * 21007 receipt是Sandbox receipt，但却发送至生产系统的验证服务
 * 21008 receipt是生产receipt，但却发送至Sandbox环境的验证服务
 *
 * $receipt_data 苹果返回的支付凭证
 * $sandbox  为1时$url为测试地址，为0时为正试地址
 */
use \GuzzleHttp\Client;

class ApplePay
{
    const SANDBOX_URL = 'https://sandbox.itunes.apple.com/verifyReceipt';
    const PRODUCTION_URL = 'https://buy.itunes.apple.com/verifyReceipt';

    private $receipt;
    private $url;

    function __construct($receipt, $sandbox = 0)
    {

        $this->url = $sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL;

        if (strpos($receipt, '{') !== false) {
            $this->receipt = base64_encode($receipt);
        } else {
            $this->receipt = $receipt;
        }

    }

    function verify()
    {
        //小票信息
        $postData = json_encode(["receipt-data" => $this->receipt]);

        $client = new Client(['headers' => ['Content-Type' => 'application/json']]);
        $response = $client->post($this->url, ['body' => $postData]);
        $resultJSON = $response->getBody();
        $data = json_decode($resultJSON, true);
        return $data;
    }
}