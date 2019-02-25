<?php

namespace App\Admin\Controllers;

use App\Model\WeixinUser;
use App\Model\WeixinUserinfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class WeixinController extends Controller
{
    protected $redis_weixin_access_token = 'str:weixin_access_token';     //微信 access_token
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WeixinUser);

        $grid->id('Id');
        $grid->uid('Uid');
        $grid->openid('Openid')->display(function($openid){
            return '<a href="/admin/information?openid='.$openid.'">'.$openid.'</a>';
        });
        $grid->add_time('Add time')->display(function($time){
            return date('Y-m-d H:s:i',$time);
        });;
        $grid->nickname('Nickname');
        $grid->sex('Sex');
        $grid->headimgurl('Headimgurl')->display(function($img_url){
            return '<img src="'.$img_url.'">';
        });
        $grid->subscribe_time('Subscribe time')->display(function($time){
            return date('Y-m-d H:s:i',$time);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WeixinUser::findOrFail($id));

        $show->id('Id');
        $show->uid('Uid');
        $show->openid('Openid');
        $show->add_time('Add time');
        $show->nickname('Nickname');
        $show->sex('Sex');
        $show->headimgurl('Headimgurl');
        $show->subscribe_time('Subscribe time');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WeixinUser);

        $form->number('uid', 'Uid');
        $form->text('openid', 'Openid');
        $form->number('add_time', 'Add time');
        $form->text('nickname', 'Nickname');
        $form->switch('sex', 'Sex');
        $form->text('headimgurl', 'Headimgurl');
        $form->number('subscribe_time', 'Subscribe time');

        return $form;
    }
    /**
     * 获取微信AccessToken
     */
    public function getWXAccessToken()
    {

        //获取缓存
        $token = Redis::get($this->redis_weixin_access_token);
        if (!$token) {        // 无缓存 请求微信接口
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . env('WEIXIN_APPID') . '&secret=' . env('WEIXIN_APPSECRET');
            $data = json_decode(file_get_contents($url), true);

            //记录缓存
            $token = $data['access_token'];
            Redis::set($this->redis_weixin_access_token, $token);
            Redis::setTimeout($this->redis_weixin_access_token, 3600);
        }
        return $token;

    }


    /**
     * 消息群发
     */
    public function sendMsgView(Content $content)
    {
        //return view('admin.weixin.send_msg');

        return $content
            ->header('微信')
            ->description('群发消息')
            ->body(view('admin.mass.mass'));
    }


    /**
     *
     */
    public function sendMsg(Request $request)
    {
        $mass=$request->input('mass');
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$access_token;
        //var_dump($url);exit;
        $client = new GuzzleHttp\Client(['base_url' => $url]);
        $param = [
            "filter"=>[
                "is_to_all"=>true
            ],
            "text"=>[
                "content"=>$mass
            ],
            "msgtype"=>"text"
        ];
        ///var_dump($param);exit;
        $r = $client->Request('POST', $url, [
            'body' => json_encode($param, JSON_UNESCAPED_UNICODE)
        ]);
        //var_dump($r);exit;
        $response_arr = json_decode($r->getBody(), true);
        //echo '<pre>';
        //print_r($response_arr);
        // echo '</pre>';
        if ($response_arr['errcode'] == 0) {
            echo "发送成功";
        } else {
            echo "发送失败";
            echo '</br>';
            echo $response_arr['errmsg'];
        }
        //获取用户openid
        $list = WeixinUser::all()->pluck('openid')->take(10)->toArray();


        //群发消息

        echo '<pre>';print_r($list);echo '</pre>';
        echo '<pre>';print_r($_POST);echo '</pre>';
    }

    /**
     * 私聊
     */
    public function information(Content $content)
    {
        $openid = $_GET['openid'];
        //echo $openid;exit;
        //$msg=WeixinUser::where(['id'=>$id])->first();
        $data=[
            //'msg'=>$msg
            'openid'=>$openid
        ];
        return $content
            ->header('微信')
            ->description('私聊')
            ->body(view('admin.mass.oneShot',$data));
    }

    /**
     * 微信客服聊天
     */
    public function getChatMsg()
    {
        $openid = $_GET['openid'];  //用户openid
        $pos = $_GET['pos'];//上次聊天位置
        var_dump($openid);exit;
        var_dump($pos);exit;
        $msg = WeixinUserinfo::where(['openid'=>$openid])->where('id','>',$pos)->first();
        $res = WeixinUser::where(['openid'=>$openid])->first();
        $msg['ctime']=date('Y-m-d H:i:s');
        if($msg){
            $response = [
                'errno' => 0,
                'data'  =>$msg->toArray(),
                'res'=>$res->toArray()
            ];

        }else{
            $response = [
                'errno' => 50001,
                'msg'   => '服务器异常，请联系管理员'
            ];
        }

        die( json_encode($response));

    }

    public function textMsg(){
        $openid = $_GET['openid'];
        $text = $_GET['text'];
        $access_token = $this->getWXAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
        //var_dump($url);exit;
        $client = new GuzzleHttp\Client(['base_url' => $url]);
        $param = [
            "touser"=>$openid,
            "msgtype"=>"text",
            "text"=>
                [
                    "content"=>$text
                ]
        ];
        ///var_dump($param);exit;
        $r = $client->Request('POST', $url, [
            'body' => json_encode($param, JSON_UNESCAPED_UNICODE)
        ]);
        //var_dump($r);exit;
        $response_arr = json_decode($r->getBody(), true);
        //echo '<pre>';
        //print_r($response_arr);
        // echo '</pre>';

        if ($response_arr['errcode'] == 0) {
            $response = [
                'errno' => 0
            ];
        } else {
            $response = [
                'errno' => 50001,
                'msg'   => '服务器异常，请联系管理员'
            ];

        }
    }

}
