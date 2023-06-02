# sms-sdk

配置参数，可快速实现不同平台的短信发送(目前只支持腾讯云、短信宝)

## Installation

```php
composer require scy/phpsms
```

## example

```php
  
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
```
