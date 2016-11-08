<?php

namespace Toplan\PhpSms;

/**
 * Class
 *
 * @property string $apikey
 */
class SecondOfficeAgent extends Agent
{
    public function sendSms($to, $content, $tempId, array $data)
    {
        $this->sendContentSms($to, $content);
    }

    public function sendContentSms($to, $content)
    {

        $url = 'http://sms.2office.cn:8080/WebService/sms3.aspx';
        $password = md5($this->accountid . $this->apikey);
        $smsid = microtime(true) * 100;
        $data = array(
            'account' => $this->account,
            'password' => $password,
            'mobile' => $to,
            'content' => $content,
            'channel' => $this->channel,
            'smsid' => $smsid,

        );

        $response = $this->curl($url, $data);

        $this->setResult($response);
    }

    public function voiceVerify($to, $code, $tempId, array $data)
    {
        $url = 'http://voice.yunpian.com/v1/voice/send.json';
        $apikey = $this->apikey;
        $postString = "apikey=$apikey&code=$code&mobile=$to";
        $response = $this->sockPost($url, $postString);
        $this->setResult($response);
    }

    protected function setResult($result)
    {
        $this->result(Agent::INFO, $result);

        $this->result(Agent::SUCCESS, $result['request'] == 1);
        $this->result(Agent::CODE, $result['response']);
    }

    public function sendTemplateSms($to, $tempId, array $data)
    {
    }
}
