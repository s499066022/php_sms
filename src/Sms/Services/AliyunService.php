<?php

namespace Scy\Phpsms\Sms\Services;

// 导入对应产品模块的client
use Scy\Phpsms\Sms\Common\BaseSms;
use Scy\Phpsms\Sms\Interfaces\SmsInterface;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

use function AlibabaCloud\Client\json;

/**
 *  AliyunService 腾讯短信发送类
 */
class AliyunService extends BaseSms implements SmsInterface
{
    
    public static $Code = 0;
    public static $Message  = 0;

    public function send(array $config)
    {
        $config = new Config([
            // 必填，您的 AccessKey ID
            "accessKeyId" => $config['secretId'],
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => $config['secretKey'],
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        $client = new Dysmsapi($config);
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $config['phoneNumber'],
            "signName" => $config['signName'],
            "templateCode" => $config['templateId'],
            "templateParam" => json_encode($config['templateParamSet'])
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $client->sendSmsWithOptions($sendSmsRequest, $runtime);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            // 如有需要，请打印 error
            Utils::assertAsString($error->message);
        }
        if($client['Code']!=='OK'){
             self::$message  =  $client['Message'];
        }
        return $this->toJsonData(0,self::$message);
    }
}
