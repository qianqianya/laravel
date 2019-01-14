<?php

namespace App\Http\Controllers\Cart;

use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public $u_id;                    // 登录UID
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->u_id = session()->get('u_id');
            return $next($request);
        });
    }

    /**
     * 购物车主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * liruixiang
     */
    public function cartList(){
        /*
            var_dump($this->u_id);exit;
            var_dump($cart_goods);exit;
            if(empty($cart_goods)){
                header('refresh:2,url=/goodsList');
                die("购物车是空的");
            }
        */
        $cart_goods = CartModel::where(['uid'=>$this->u_id])->get()->toArray();
        if($cart_goods){
            //获取商品最新信息
            foreach($cart_goods as $k=>$v){
                    $goods_info = GoodsModel::where(['goods_id' => $v['goods_id']])->first();
                    //计算订单价格 = 商品数量 * 单价
                    $order_amount = $goods_info['goods_price'] * $v['c_num'];
                    $goods_info['c_id'] = $v['c_id'];
                    $goods_info['c_num'] = $v['c_num'];
                    $goods_info['c_ctime'] = $v['c_ctime'];
                    $goods_info['goods_price'] = $order_amount;
                    $data[] = $goods_info;
            }
        }

        if(empty($data)){
            $data=[];
        }

        //var_dump($data);exit;
        $list=[
            'title'=>'购物车页面',
            'data'=>$data
        ];
        //var_dump($list);exit;
        return view('cart.cartList',$list);
    }

    /**
     *购物车添加1
     *liruixiang
     */
    public function cartAdd($goods_id){
        //取存的cart_goods判断有无在数据库当中
        $cart_goods = session()->get('cart_goods');
        //print_r($cart_goods);exit;
        //是否已在购物车中   如果不是空的判断
        if(!empty($cart_goods)){
            if(in_array($goods_id,$cart_goods)){
                echo '已存在购物车中';
                exit;
            }
        }

        //存session 之后判断存在数据库当中
        session()->push('cart_goods',$goods_id);

        //减库存
        $where = ['goods_id'=>$goods_id];
        $goods_store = GoodsModel::where($where)->value('goods_store');
        //print_r($goods_store);exit;
        if($goods_store<=0){
            echo '库存不足';
            exit;
        }
        $rs = GoodsModel::where(['goods_id'=>$goods_id])->decrement('goods_store');

        if($rs){
            $where=[
                'goods_id'=> $goods_id
            ];
            $goods_name=GoodsModel::where($where)->first();
            echo '成功添加'."<p style='color:red'>".$goods_name['goods_name']."</p>".'一件，谢谢您的光临';
        }else{
            echo '添加失败';
        }
    }

    /**
     * 购物车删除1
     * liruixiang
     */
    public function cartDel($goods_id){
        //判断 商品是否在 购物车中
        $goods = session()->get('cart_goods');
        //var_dump($goods);exit;
        //echo '<pre>';print_r($goods);echo '</pre>';die;
        $where=[
             'goods_id'=> $goods_id
        ];


        if(in_array($goods_id,$goods)){
            //执行删除
            foreach($goods as $k=>$v){
                if($goods_id == $v){
                    session()->pull('cart_goods.'.$k);
                    $goods_name=GoodsModel::where($where)->first();
                    echo '删除购物车成功----  成功减少 '."<p style='color:red'>".$goods_name['goods_name']."</p>".'一件';
                }
            }
        }else{
            //不在购物车中
            die("商品不在购物车中");
        }
    }

    /**
     * 购物车添加2
     * @return array
     * liruixiang
     */
    public function cartAdd2(){
        $goods_id = request()->input('goods_id');
        $num = request()->input('c_num');
        //var_dump($goods_id);
        //var_dump($num);
        //检查库存
        $store_num = GoodsModel::where(['goods_id'=>$goods_id])->value('goods_store');
        if($store_num<=$num){
            $response = [
                'errno' => 5001,
                'msg'   => '库存不足'
            ];
            return $response;
        }

        //写入购物车表
        $data = [
            'goods_id'  => $goods_id,
            'c_num'       => $num,
            'c_ctime'  => time(),
            'uid'       => session()->get('u_id'),
            'session_token' => session()->get('u_token')
        ];

        $cid = CartModel::insertGetId($data);
        if(!$cid){
            $response = [
                'errno' => 5002,
                'msg'   => '添加购物车失败，请重试'
            ];
            return $response;
        }


        $response = [
            'error' => 0,
            'msg'   => '添加成功'
        ];
        return $response;
    }

    /**
     * 购物车删除2
     * @param $c_id
     * liruixiang
     */
    public function cartDel2($c_id){
        $where=[
            'c_id'=>$c_id
        ];
        $res=CartModel::where($where)->delete();
        if($res){
            header('Refresh:2;url=/cartList');
            echo '删除成功--跳转页面中，请稍后';
        }else{
            header('Refresh:2;url=/cartList');
            echo '删除失败';
        }
    }


}
