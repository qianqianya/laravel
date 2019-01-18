<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use App\Model\UserModel;

class UserController extends Controller
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
        $grid = new Grid(new UserModel());

        $grid->u_id('UID');
        $grid->u_name('昵称');
        $grid->u_email('邮箱');
        $grid->u_tel('手机号');
        $grid->u_ctime('注册时间')->display(function($time){
            return date('Y-m-d H:i:s',$time);
        });

        return $grid;
    }


    public function edit($id)
    {
        echo __METHOD__;
    }



    //创建
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }



    public function show($id)
    {
        echo __METHOD__;echo '</br>';
    }

    //删除
    public function destroy($id)
    {

        $response = [
            'status' => true,
            'message'   => 'ok'
        ];
        return $response;
    }



    protected function form()
    {
        $form = new Form(new UserModel());

        $form->text('u_name', '昵称');
        $form->email('u_email', 'Email');

        return $form;
    }
}
