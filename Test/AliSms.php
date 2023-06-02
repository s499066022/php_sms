<?php
/**
 * 短信宝
 */
const SMS_BAO = 'bao';

/**
 * 腾讯云
 */
const SMS_TENCENT = 'tencent';

/**
 * 阿里云
 */
const SMS_ALIYUN = 'aliyun';

class AliSms
{
    private $id = '';
    private $key = '';
    private $config = [];
    public function __construct()
    {
        $this->config["secretId"] = $this->id;
        $this->config["secretKey"] = $this->key;
    }
    public function send($signName, $phoneNumber, $templateId, $templateParamSet)
    {
        // include "/Users/shenchunye/docker/www/pack/php_sms/src/Sms/SmsFactory";
        // include "./src/Sms/SmsFactory";
        $smsObj = (new Scy\Phpsms\Sms\SmsFactory(Scy\Phpsms\Sms\SmsFactory::SMS_ALIYUN))->getSmsService();
        $this->config['signName'] = $signName;
        $this->config['phoneNumber'] = $phoneNumber;
        $this->config['templateId'] = $templateId;
        $this->config['templateParamSet'] = $templateParamSet;
        
        return $smsObj->send($this->config);
    }
    
}

$out =(new aliSms())->send('alan','18758893229','SMS_279546917',['code'=>'123']);