<?php

namespace App\Http\Controllers\Goods;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品主页
     * liruixiang
     */
    public function goodsList(){
        $list  = GoodsModel::paginate(2);
        //print_r($res);exit;
        //var_dump($res);exit;
        $data=[
            'title'=>'商品主页',
            'list'=>$list
        ];
        return view('goods.goods',$data);
    }


    /**
     * 商品主页
     * liruixiang
     */
    public function goodsDel($goods_id){
        $where=[
            'goods_id'=>$goods_id
        ];
        $res=GoodsModel::where($where)->delete();

        //print_r($res);exit;
        if($res){
            header('Refresh:2;url=/goodsList');
            echo '删除成功';
        }else{
            header('Refresh:2;url=/goodsList');
            echo '删除失败';
        }
    }

    public function goodsDetails($goods_id){
        $goods = GoodsModel::where(['goods_id'=>$goods_id])->first();

        //商品不存在
        if(!$goods){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }
        $data = [
            'goods' => $goods,
            'title' => '商品详情'
        ];
        return view('goods.goodsdeta',$data);
    }
}
