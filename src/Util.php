<?php

namespace hVenus\LaravelSaasRetailEleMe;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Util
{
    // 签名
    public static function sign($params, $secret)
    {
        $params['secret'] = $secret;
        ksort($params);
        $str = '';
        foreach ($params as $k => $v) {
            $str .= $k . '=' . $v . '&';
        }
        $str = trim($str, '&');
        $sign = md5($str);
        return strtoupper($sign);
    }

    // 数组拼接成url字符串
    public static function arrToStr($arr, $sign)
    {
        $arr['sign'] = $sign;
        ksort($arr);
        $str = '';
        foreach ($arr as $k => $v) {
            $str .= $k . '=' . urlencode($v) . '&';
        }
        $str = trim($str, '&');
        return $str;
    }

    // 生成最终调用的url
    public static function makeUri($params, $sign)
    {
        $str = Util::arrToStr($params, $sign);
        return '/?' . $str;
    }

    // 请求接口
    public static function request($host, $app_key, $app_secret, $cmd, $body)
    {
        ksort($body);
        $body_str = json_encode($body);
        $sign_arr = [
            'cmd' => $cmd,
            'version' => 3,
            'timestamp' => time(),
            'ticket' => strtoupper(uuid_create(1)),
            'source' => $app_key,
            'body' => $body_str,
            "encrypt" => "aes",
        ];
        ksort($sign_arr);
        $sign = Util::sign($sign_arr, $app_secret);
        $uri = Util::makeUri($host, $sign_arr, $sign);
        $client =  new Client(['base_uri' => $host]);
        $response = $client->request('POST', $uri, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        ]);
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return $response->getBody()->getContents();
        }
        return ['errno' => -1, 'error' => $statusCode];
    }
}
