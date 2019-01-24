<?php

namespace App\Http\Controllers\Crontabs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderModel;

class IndexController extends Controller
{
    //

    /**
     * 计划任务删除过期订单
     */
    public function deleteOrders()
    {
        //过期未支付订单条件  is_pay=0 &&  time() - add_time > 300s
        $oid = 9;           //上次处理之后的 最后一个订单号

        $list = OrderModel::where('oid','>',$oid)->get()->toArray();

        echo date('Y-m-d H:i:s') . "执行 deleteOrders\n\n";die;

        foreach($list as $k=>$v){

            if($v['is_pay']==0){
                if(time() - $v['add_time'] > 300){
                    //删除订单
                    OrderModel::where(['oid'=>$v['oid']])->update(['is_delete'=>1]);
                }
            }
        }

        echo date('Y-m-d H:i:s') . "执行 deleteOrders\n\n";


    }
}
