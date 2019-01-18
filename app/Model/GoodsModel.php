<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsModel extends Model
{
    //
    public $table = 'laravel_goods';
    public $timestamps = false;
    public $primaryKey = 'goods_id';



    //获取某字段时 格式化 该字段的值
    public function getPriceAttribute($price)
    {
        return $price / 100;
    }

    //获取某字段时 格式化 该字段的值
    public function getStoreAttribute($store)
    {
        return  $store ;
    }
}
