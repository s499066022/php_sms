<?php

namespace Scy\Phpsms\Sms\Common;

class BaseSms
{
    /**
     *  短信成功状态码
     */
    const MESSAGE_OK = 200;

    /**
     *  短信失败状态码
     */
    const MESSAGE_ERROR = 50001;

    /**/
    public static $message = [
        '200' => '发送成功',
        '50001' => '发送失败',
    ];

    /**
     * 返回json
     * @param $code
     * @param string $message
     * @param array $data
     * @return false|string
     */
    public function toJsonData($code, $msg="",$data = [])
    {
       
        $result = [
            'code' => $code,
            'message' => $msg==="" ? "发送成功":$msg,
            'data' => !empty($data) ? $data : [],
        ];

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}