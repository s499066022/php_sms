<?php

namespace Scy\Phpsms\Sms\Interfaces;

interface SmsInterface
{
    /**
     * 短信发送
     * @param array $config
     * @return mixed
     */
    public function send(array $config);
}