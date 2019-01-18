<?php

namespace App\Http\Controllers\Order;

use App\Model\CartModel;
use App\Model\GoodsModel;
use App\Model\OrderModel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public $u_id;             // 登录UID
    public function __construct()
    {
        $this->middleware('check.login.token');
        $this->middleware(function ($request, $next) {
            $this->u_id = session()->get('u_id');
            return $next($request);
        });
    }

    public function pay(){
        $url='http://chaiq.qianqianya.xyz';
        $client=new Client([
            'base_uri'=>$url,
            'timeout'=>2.0,
        ]);

        $response=$client->request('GET','.order.php');
        echo $response->getBody();
    }

    /**
     * 订单展示
     */
    public function orderList(){
        $list=OrderModel::where(['uid'=>$this->u_id])->get();
        $data=[
            'title'=>'订单展示',
            'list'=>$list
        ];
        return view('order.order',$data);
    }

    /**
     * 提交订单添加
     * liruixaing
     */
    public function orderAdd()
    {
        //查询购物车商品
        $cart_goods = CartModel::where(['uid'=>$this->u_id])->orderBy('c_id','desc')->get()->toArray();
        //var_dump($cart_goods);exit;
        if(empty($cart_goods)){
            die("购物车中无商品");
            header('refresh:2,url=/goodsList');
        }
        $order_amount = 0;
        foreach($cart_goods as $k=>$v){
            $goods_info = GoodsModel::where(['goods_id'=>$v['goods_id']])->first()->toArray();
            $goods_info['c_num'] = $v['c_num'];
            $list[] = $goods_info;

            //计算订单价格 = 商品数量 * 单价
            $order_amount += $goods_info['goods_price'] * $v['c_num'];
        }

        //生成订单号
        $order_name = OrderModel::generateOrderSN();
        $data = [
            'o_name'      => $order_name,
            'uid'           => session()->get('u_id'),
            'o_ctime'      => time(),
            'o_amount'  => $order_amount
        ];

        $oid = OrderModel::insertGetId($data);
        if(!$oid){
            echo '生成订单失败';
        }

        $o_name=OrderModel::where(['o_id'=>$oid])->first();
        echo '下单成功,订单号：'.$o_name['o_name'] .' 跳转订单页面';

        //清空购物车
        CartModel::where(['uid'=>session()->get('u_id')])->delete();
        header('refresh:2,url=/orderList');
    }

    /**
     * 删除订单
     * liruixiang
     */
    public function orderDel($o_id){
        $where=[
            'o_id'=>$o_id,
            'uid'=>$this->u_id
        ];
        $res=OrderModel::where($where)->delete();
        if($res){
            header('refresh:1,url=/orderList');
            echo '删除成功，正在跳转订单页面';
        }else{
            header('refresh:1,url=/orderList');
            echo '删除失败，正在跳转订单页面';
        }
    }

    /**
     * 订单支付
     *liruixiang
     */
    public function orderPay($o_id){
        //查询订单
        $order_info = OrderModel::where(['o_id'=>$o_id])->first();
        //var_dump($order_info);exit;
        if(!$order_info){
            header('refresh:1,url=/orderList');
            die("订单 ".$o_id. "不存在！");
        }
        //检查订单状态 是否已支付 已过期 已删除
        if($order_info->pay_time > 0){
            header('refresh:1,url=/orderList');
            die("此订单已被支付，无法再次支付");
        }

        //调起支付宝支付


        //支付成功 修改支付时间
        OrderModel::where(['o_id'=>$o_id])->update(['pay_ctime'=>time(),'pay_amount'=>rand(1111,9999),'is_pay'=>1,'status'=>2]);

        //增加消费积分 ...

        header('Refresh:2;url=/orderList');
        echo '支付成功，正在跳转';

    }
}
