<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use App\Model\GoodsModel;

class GoodsController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('商品管理')
            ->description('商品列表')
            ->body($this->grid());
    }

    protected function grid()
    {
        $grid = new Grid(new GoodsModel());

        $grid->model()->orderBy('goods_id','desc');     //倒序排序

        $grid->goods_id('商品ID');
        $grid->goods_name('商品名称');
        $grid->goods_store('库存');
        $grid->goods_price('价格');
        $grid->goods_ctime('添加时间')->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });

        return $grid;
    }

    //修
    public function edit($id, Content $content)
    {

       //echo __METHOD__;die;
        return $content
            ->header('商品管理')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    //创建
    public function create(Content $content)
    {
        //echo 1;exit;
        return $content
            ->header('商品管理')
            ->description('添加')
            ->body($this->form());
    }
    //修改
    public function update($id)
    {
        $where=[
            'goods_id'=>$id
        ];
            $data = [
                'goods_name' => $_POST['goods_name'],
                'goods_store' => $_POST['goods_store'],
                'goods_price' => $_POST['goods_price'],
            ];
            GoodsModel::where($where)->update($data);
    }
    //添加
    public function store()
    {
        if(request()->isMethod('post')) {
            $goods_name = request()->input('goods_name');
            $goods_store = request()->input('goods_store');
            $goods_price = request()->input('goods_price');
            $data = [
                'goods_name' => $goods_name,
                'goods_store' => $goods_store,
                'goods_price' => $goods_price,
                'goods_ctime' => time()
            ];
            GoodsModel::insertGetId($data);
        }
    }


    //查
    public function show($id)
    {
        $where=[
            'goods_id'=>$id
        ];
        GoodsModel::where($where)->select();
        echo __METHOD__;echo '</br>';
    }

    //删除
    public function destroy($id)
    {
        $where=[
            'goods_id'=>$id
        ];
        GoodsModel::where($where)->delete();
        $response = [
            'status' => true,
            'message'   => 'ok'
        ];
        return $response;
    }

    protected function form()
    {
        $form = new Form(new GoodsModel());
        $form->display('goods_id', '商品ID');
        $form->text('goods_name', '商品名称');
        $form->number('goods_store', '库存');
        $form->currency('goods_price', '价格')->symbol('¥');
        $form->ckeditor('content');

        return $form;
    }
}
