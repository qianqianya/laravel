<?php

namespace App\Http\Controllers\Goods;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * 商品主页
     */
    public function goodsList(){
        $list  = GoodsModel::paginate(5);
        //print_r($res);exit;
        //var_dump($res);exit;
        $data=[
            'list'=>$list
        ];
        return view('goods.goods',$data);
    }


    /**
     * 商品主页
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
    public function uploadIndex()
    {
        return view('goods.upload');
    }

    public function uploadPDF(Request $request)
    {
        $pdf = $request->file('pdf');
        $ext  = $pdf->extension();
        if($ext != 'pdf'){
            die("请上传PDF格式");
        }
        $res = $pdf->storeAs(date('Ymd'),str_random(5) . '.pdf');
        if($res){
            echo '上传成功';
        }

    }
    public function keyword(Request $request){
        $search = $request->input('s');
        $newslist =GoodsModel::where([['goods_name', 'like', "%$search%"]])->paginate(2);
        return view('goods.keyword', ['list'=> $newslist,'search'=>$search]);
    }

}
