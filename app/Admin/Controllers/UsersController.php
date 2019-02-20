<?php

namespace App\Admin\Controllers;

use App\Model\UserModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
{
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
        $grid = new Grid(new UserModel);

        $grid->u_id('用户id');
        $grid->u_name('用户名称');
        $grid->u_pwd('用户密码');
        $grid->u_tel('用户电话');
        $grid->u_email('用户邮箱');
        $grid->u_ctime('添加时间');
        $grid->u_utime('修改时间');

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
        $show = new Show(UserModel::findOrFail($id));

        $show->u_id('用户id');
        $show->u_name('用户名称');
        $show->u_pwd('用户密码');
        $show->u_tel('用户电话');
        $show->u_email('用户邮箱');
        $show->u_ctime('添加时间');
        $show->u_utime('修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserModel);

        $form->number('u_id', '用户id');
        $form->text('u_name', '用户名称');
        $form->text('u_pwd', '用户密码');
        $form->text('u_tel', '用户电话');
        $form->text('u_email', '用户邮箱');
        $form->number('u_ctime', '添加时间');
        $form->number('u_utime', '修改时间');

        return $form;
    }
}
