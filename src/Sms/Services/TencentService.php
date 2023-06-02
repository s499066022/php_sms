<?php

namespace Scy\Phpsms\Sms\Services;

// 导入对应产品模块的client
use Scy\Phpsms\Sms\Common\BaseSms;
use Scy\Phpsms\Sms\Interfaces\SmsInterface;
use TencentCloud\Sms\V20210111\SmsClient;

// 导入要请求接口对应的Request类
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Credential;

// 导入可选配置类
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;

/**
 *  TencentService 腾讯短信发送类
 */
class TencentService extends BaseSms implements SmsInterface
{
    /**
     *  腾讯云发送成功状态码
     */
    const TENCENT_OK = 'ok';

    /**
     *  腾讯云发送成功状态码
     */
    public static $TencentCode = 0;

    public static $Message = "";

    public function send(array $config)
    {
        try {
            $cred = new Credential($config['secretId'], $config['secretKey']);
            // 实例化一个http选项，可选的，没有特殊需求可以跳过
            $httpProfile = new HttpProfile();
            // 配置代理
            // $httpProfile->setProxy("https://ip:port");
            $httpProfile->setReqMethod("GET");  // post请求(默认为post请求)
            $httpProfile->setReqTimeout(30);    // 请求超时时间，单位为秒(默认60秒)
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");  // 指定接入地域域名(默认就近接入)

            // 实例化一个client选项，可选的，没有特殊需求可以跳过
            $clientProfile = new ClientProfile();
            $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
            $clientProfile->setHttpProfile($httpProfile);

            // 实例化要请求产品(以sms为例)的client对象,clientProfile是可选的
            // 第二个参数是地域信息，可以直接填写字符串 ap-guangzhou，或者引用预设的常量
            $client = new SmsClient($cred,  $config["city"], $clientProfile);
            // 实例化一个 sms 发送短信请求对象,每个接口都会对应一个request对象。
            $req = new SendSmsRequest();
            $params = array(
                "PhoneNumberSet" => array("+86" . $config['phoneNumber']),
                "PhpsmsAppId" =>  $config['PhpsmsAppId'],
                "SignName" => $config['signName'],
                "TemplateId" => $config['templateId'],
                "TemplateParamSet" => sort($config['TemplateParamSet']) 
            );
            $req->fromJsonString(json_encode($params));
            $resp = $client->SendSms($req);
            // 输出json格式的字符串回包
            $respJson = $resp->toJsonString();
            $respData = json_decode($respJson, true);

            if ($respData['SendStatusSet'][0]['Code'] == self::TENCENT_OK) {
                self::$TencentCode = 200;
            }else{
                self::$Message = $respData['SendStatusSet'][0]['Message'] ;
            }

            return $this->toJsonData(self::$TencentCode,  self::$Message );
        } catch (TencentCloudSDKException $e) {
            return $e;
        }
    }
}