<?php

namespace plugin\aoaostar_com\image_url\nodes\telegraph;

use plugin\aoaostar_com\image_url\ApiException;
use plugin\aoaostar_com\image_url\Plugin;

class main implements Plugin
{

    public function main($filepath): string
    {

        $data = [
            'file' => new \CURLFile($filepath),
        ];

        $headers = array(
            CONTENT_TYPE_MULTIPART_FORM_DATA,
            USERAGENT,
        );
        $res = xiaomei_post('https://telegra.ph/upload', $data, $headers);
        $result = json_decode($res);
        if (empty($result->error) && !empty($result[0]->src)) {
            return 'https://i0.wp.com/telegra.ph' . $result[0]->src;
        }
        if (!empty($result->error)) {
            $msg = $result->error;
        } else {
            $msg = '上传失败';
        }
        throw new ApiException($msg, $res);
    }
}
