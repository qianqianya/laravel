<?php

namespace App\Http\Controllers\weChat;
use App\Model\WeixinUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp;

class weChatController extends Controller
{
    protected $redis_weixin_access_token = 'str:weixin_access_token';     //微信 access_token

    public function weChat(){
        echo $_GET['echostr'];
    }

    /**
     * 接收事件推送
     */
    public function validToken()
    {
        //$get = json_encode($_GET);
        //$str = '>>>>>' . date('Y-m-d H:i:s') .' '. $get . "<<<<<\n";
        //file_put_contents('logs/weixin.log',$str,FILE_APPEND);
        //echo $_GET['echostr'];
        $data = file_get_contents("php://input");
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_event.log',$log_str,FILE_APPEND);
    }

    /**
     * 接收微信服务器事件推送
     */
    public function weChatToken()
    {
        $data = file_get_contents("php://input");


        //解析XML
        $xml = simplexml_load_string($data);        //将 xml字符串 转换成对象

        $event = $xml->Event;                       //事件类型
        //var_dump($xml);echo '<hr>';

        if ($event == 'subscribe') {
            $openid = $xml->FromUserName;               //用户openid
            $sub_time = $xml->CreateTime;               //扫码关注时间


            echo 'openid: ' . $openid;
            echo '</br>';
            echo '$sub_time: ' . $sub_time;

            //获取用户信息
            $user_info = $this->getUserInfo($openid);
            echo '<pre>';
            print_r($user_info);
            echo '</pre>';

            //保存用户信息
            $u = WeixinUser::where(['openid' => $openid])->first();
            //var_dump($u);die;
            if ($u) {       //用户不存在
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

                $id = WeixinUser::insertGetId($user_data);      //保存用户信息
                var_dump($id);
            }
        }
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents('logs/wx_event.log',$log_str,FILE_APPEND);
    }

    /**
     * 获取微信AccessToken
     */
    public function getWXAccessToken()
    {

        //获取缓存
        $token = Redis::get($this->redis_weixin_access_token);
        if(!$token){        // 无缓存 请求微信接口
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WEIXIN_APPID').'&secret='.env('WEIXIN_APPSECRET');
            $data = json_decode(file_get_contents($url),true);

            //记录缓存
            $token = $data['access_token'];
            Redis::set($this->redis_weixin_access_token,$token);
            Redis::setTimeout($this->redis_weixin_access_token,3600);
        }
        return $token;

    }

    /**
     * 获取用户信息
     * @param $openid
     */
    public function getUserInfo($openid)
    {
        //$openid = 'oo8Oz0skvOcYMVI-qHQb5gX43r0g';
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

        $data = json_decode(file_get_contents($url),true);
        echo '<pre>';print_r($data);echo '</pre>';
        return $data;
    }

    /**
     * 创建服务号菜单
     */
    public function createMenu(){
        //echo __METHOD__;
        // 1 获取access_token 拼接请求接口
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getWXAccessToken();


        //2 请求微信接口
        $client = new GuzzleHttp\Client(['base_url' => $url]);
        //var_dump($client);exit;
        $data = [
            "button"    => [
                [
                    //"type"  => "view",      // view类型 跳转指定 URL
                    "name"  => "网易云音乐",
                    "sub_button"=>[
                        [
                            "type"=>"view",
                            "name"=>"搜索",
                            "url"=>"https://www.soso.com/"
                        ],
                        [
                            "type"=>"view",
                            "name"=>"首页",
                            "url"=>"https://music.163.com/"
                        ]
                    ]
                ],
                [
                    "type"=>"view",
                    "name"=>"百度一下",
                    "key"=>"https://www.baidu.com/"
                ],
                [
                    "type"=>"view",
                    "name"=>"欢乐欢乐",
                    "key"=>"https://www.xiaopi.com/game/27976.html"
                ],

            ]

        ];
        //var_dump($data);exit;
        $r = $client->Request('POST', $url, [
            'body' => json_encode($data,JSON_UNESCAPED_UNICODE)
        ]);
        //var_dump($r);exit;

        // 3 解析微信接口返回信息

        $response_arr = json_decode($r->getBody(),true);
        echo '<pre>';print_r($response_arr);echo '</pre>';

        if($response_arr['errcode'] == 0){
            echo "菜单创建成功";
        }else{
            echo "菜单创建失败，请重试";echo '</br>';
            echo $response_arr['errmsg'];

        }
    }

}