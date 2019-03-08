<?php

namespace App\Http\Controllers\weixin;

use App\Model\WeixinUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp;
use Illuminate\Support\Facades\Storage;

class weixinController extends Controller
{
    //protected $redis_weixin_access_token='str:weixin_access_token';
    public function getWXAccessToken()
    {
        $token = Redis::get($this->redis_weixin_access_token);
        if (!$token) {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . env('WEIXIN_APPID') . '&secret=' . env('WEIXIN_APPSECRET');
            $data = json_decode(file_get_contents($url), true);

            $token = $data['access_token'];
            Redis::set($this->redis_weixin_access_token, $token);
            Redis::setTimeout($this->redis_weixin_access_token, 3600);
        }
        return $token;

    }

    public function getUserInfo($openid,$id)
    {
        //$openid = 'oo8Oz0skvOcYMVI-qHQb5gX43r0g';
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';

        $data = json_decode(file_get_contents($url), true);
        $res = WeixinUser::where(['id' => $id])->first();

     var_dump($data);
    }

}