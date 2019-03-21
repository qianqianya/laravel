<?php

namespace App\Http\Controllers\zhenji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\userModel;
class ZhenjiController extends Controller
{
    public function zhenji()
    {
        return json_encode(111);
    }

    public function login(Request $request)
    {
        $u_email = $request->input('u_email');
        $u_pwd = $request->input('u_pwd');

        $res = userModel::where(['u_email' => $u_email, 'u_pwd' => $u_pwd])->first();
        if ($res) {
            return json_encode(
                [
                    'status' => 1000,
                    'msg' => '登录成功'
                ]
            );
        } else {
            return json_encode(
                [
                    'status' => 1,
                    'msg' => '账号或密码错误'
                ]
            );
        }

    }
    public function reg(Request $request)
    {
        $u_name = $request->input('u_name');
        $u_email = $request->input('u_email');
        $u_pwd = $request->input('u_pwd');
        $u_tel = $request->input('u_tel');


        $res = userModel::insert(['u_email' => $u_email, 'u_pwd' => $u_pwd,'u_tel'=>$u_tel,'u_name'=>$u_name]);
        if ($res) {
            return json_encode(
                [
                    'status' => 1000,
                    'msg' => '注册成功'
                ]
            );
        } else {
            return json_encode(
                [
                    'status' => 1,
                    'msg' => '注册失败'
                ]
            );

        }
    }
}
