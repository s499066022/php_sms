<?php

namespace Scy\Phpsms\Sms;


use Scy\Phpsms\Sms\Services\SmsBaoService;
use Scy\Phpsms\Sms\Services\TencentService;
use Scy\Phpsms\Sms\Services\AliyunService;

/**
 * SmsFactory 实现短信的简单工厂封装（腾讯、短信宝）
 */
class SmsFactory
{
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

    //私有属性
    private $smsType;

    public  $config = [
        //锁定部分
        /* 填写平台对应的CAM密匙secretId，短信宝填写平台账号*/
        'secretId' => '',
        /* 填写平台对应的CAM密匙secretKey，短信宝填写平台密码*/
        'secretKey' => '',
        /* 短信应用ID: 短信SdkAppId在 [短信控制台] 添加应用后生成的实际SdkAppId，示例如1400006666 ,短信宝默认为空*/
        'PhpsmsAppId' => '',
        /**服务器城市参数 ap-nanjing */
        'city' => 'ap-nanjing ',
        //变化部分
        /* 填写腾讯、阿里平台对应的签名内容,短信宝则默认为空 */
        'signName' => '',
        /* 发送的手机号,示例如17899873465 */
        'phoneNumber' => '',
        /* 模板 ID: 必须填写已审核通过的模板 ID。模板ID可登录 [短信控制台] 查看 */
        'templateId' => "",
        /**模版参数 */
        'templateParamSet' => [],
        /* 模板发送的短信内容，短信宝则需要填写 如："【短信宝】您的验证码是"5390",3分钟有效。", 腾讯默认为空 */
        'content' => '', //【短信宝】您的验证码是'.$code.',3分钟有效。
    ];

    public function __construct($type)
    {
        $this->smsType = $type;
    }

    public function getSmsService()
    {
        switch ($this->smsType) {
            case self::SMS_BAO:
                //短信宝
                return new SmsBaoService();
                break;
            case self::SMS_TENCENT:
                //腾讯云
                return new TencentService();
                break;
            case self::SMS_ALIYUN:
                //阿里云
                return new AliyunService();
                break;
            default:
                return null;
        }
    }
}