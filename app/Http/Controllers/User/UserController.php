<?php

namespace App\Http\Controllers\User;

use App\Model\userModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 主页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * lirunxiang
     */
    public function center(){
        /*
        if($_COOKIE['token'] != request()->session()->get('u_token')){
            die("非法请求");
        }else{
            echo '正常请求';
        }


        echo 'u_token: '.request()->session()->get('u_token'); echo '</br>';
        //echo '<pre>';print_r($request->session()->get('u_token'));echo '</pre>';

        echo '<pre>';print_r($_COOKIE);echo '</pre>';
        die;
        */
        if(empty($_COOKIE['u_id'])){
            header('Refresh:2;url=/loginAdd');
            echo '请先登录';
            exit;
        }else{
            echo 'UID: '.$_COOKIE['u_id'] . ' 欢迎回来';
        }
    }

    /**
     * 注册跳转
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * liruixiang
     */
    public function userAdd()
    {
        if(request()->isMethod('post')) {
            $u_pwd1=request()->input('u_pwd1');
            $u_pwd2=request()->input('u_pwd2');
            $u_name=request()->input('u_name');
            $u_email=request()->input('u_email');
            $where=[
                'u_email'=>$u_email
            ];
            $email=userModel::where($where)->first();

            $where=[
                'u_name'=>$u_name
            ];
            $name=userModel::where($where)->first();
            if($name) {
                header('refresh:2,url=/userAdd');
                echo '用户名重复---返回注册页面';
            }else if($email){
                header('refresh:2,url=/userAdd');
                echo '邮箱重复只能申请一次---返回注册页面';
            }else if(empty($u_pwd1)){
                header('refresh:2,url=/userAdd');
                echo '密码不能为空---返回注册页面';
            }else if(empty($u_pwd2)){
                header('refresh:2,url=/userAdd');
                echo '确认密码不能为空---返回注册页面';
            }else if($u_pwd2!=$u_pwd1){
                header('refresh:2,url=/userAdd');
                echo '密码和确认密码必须一致---返回注册页面';
            }else{
                $u_pwd=password_hash($u_pwd2,PASSWORD_BCRYPT);
                $data = [
                    'u_name' => $u_name,
                    'u_pwd' => $u_pwd,
                    'u_tel' => request()->input('u_tel'),
                    'u_email' => $u_email,
                    'u_ctime' => time(),
                ];

                $uid = userModel::insertGetId($data);
                if ($uid) {
                    $token = substr(md5(time().mt_rand(1,99999)),10,10);
                    setcookie('u_id',$uid,time()+86400,'/','',false,true);
                    setcookie('token',$token,time()+86400,'/center','',false,true);

                    request()->session()->put('u_token',$token);
                    request()->session()->put('u_id',$uid);

                    header('refresh:2,url=/center');
                    echo '注册成功.页面跳转中';
                } else {
                    header('refresh:2,url=/userAdd');
                    echo '注册失败----返回注册页面';
                }
            }
        }else{
            $data=[
                'title'=>'注册页面'
            ];
            return view('user.user',$data);
        }
    }

    /**
     * 登录跳转
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * liruixiang
     */
    public function loginAdd(){
        if(request()->isMethod('post')){
            $email=request()->input('u_email');
            $pwd=request()->input('u_pwd');

            if(empty($email)){
                header('refresh:2,url=/loginAdd');
                echo '邮箱不能为空---跳转登录页面中';
            }else if(empty($pwd)){
                header('refresh:2,url=/loginAdd');
                echo '密码不能为空---跳转登录页面中';
            }else{
                $where=[
                   'u_email'=>$email
                ];
                $u_pwd=userModel::where($where)->first();
                if($u_pwd){
                    if(password_verify($pwd,$u_pwd['u_pwd'])){
                        $token = substr(md5(time().mt_rand(1,99999)),10,10);
                        setcookie('u_id',$u_pwd['u_id'],time()+86400,'/','',false,true);
                        setcookie('token',$token,time()+86400,'/center','',false,true);

                        request()->session()->put('u_token',$token);
                        request()->session()->put('u_id',$u_pwd['u_id']);

                        header('refresh:2,url=/center');
                        echo '登录成功.正在跳转主页面.请耐心等待。亲';
                    }else{
                        header('refresh:2,url=/loginAdd');
                        echo '密码不正确---跳转登录页面中';
                    }
                }else{
                    header('refresh:2,url=/loginAdd');
                    echo '用户名不存在---跳转登录页面中';
                }
            }
        }else{
            $data=[
                'title'=>'登录页面'
            ];
            return view('login.login',$data);
        }
    }

    public function loginQuit(){
        setcookie('u_id',null);
        setcookie('token',null);
        request()->session()->pull('u_token',null);

        header('refresh:2,url=/loginAdd');
    echo '退出成功，正在跳转登录页面';
    }



}
