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
    public function weChat(){
        echo $_GET['echostr'];
    }

    public function validToken()
    {
        //$get = json_encode($_GET);
        //$str = '>>>>>' . date('Y-m-d H:i:s') .' '. $get . "<<<<<\n";
        //file_put_contents('logs/weixin.log',$str,FILE_APPEND);
        //echo $_GET['echostr'];
        $data = file_get_contents("php://input");
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_event.log', $log_str, FILE_APPEND);
    }

    public function weChatToken()
    {
        $data = file_get_contents("php://input");

        $xml = simplexml_load_string($data);
        $event = $xml->Event;
        //var_dump($xml);echo '<hr>';

        $openid = $xml->FromUserName;
        $sub_time = $xml->CreateTime;

        echo 'openid: ' . $openid;
        echo '</br>';
        echo 'sub_time: ' . $sub_time;

        //获取用户信息
        $user_info = $this->getUserInfo($openid);
        echo '<pre>';
        print_r($user_info);
        echo '</pre>';
        //保存用户信息
        $u = WeixinUser::where(['openid' => $openid])->first();
        //var_dump($u);die;
        if ($u) {
            echo '用户已存在';
        } else {
            $user_data = [
                'openid' => $openid,
                'add_time' => time(),
                'nickname' => $user_info['nickname'],
                'sex' => $user_info['sex'],
                'headimgurl' => $user_info['headimgurl'],
                'subscribe_time' => $sub_time,
            ];

            $id = WeixinUser::insertGetId($user_data);
            var_dump($id);
        }


    }

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

    public function getUserInfo($openid)
    {
        //$openid = 'oo8Oz0skvOcYMVI-qHQb5gX43r0g';
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';

        $data = json_decode(file_get_contents($url), true);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        return $data;
    }

}