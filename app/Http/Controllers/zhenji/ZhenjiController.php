<?php

namespace App\Http\Controllers\zhenji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ZhenjiController extends Controller
{
    public function zhenji(){
        $data=[
            'title'=>'登录页面'
        ];
        return view('login.login',$data);
    }
}
