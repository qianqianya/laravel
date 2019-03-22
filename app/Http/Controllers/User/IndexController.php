<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index(Request $request){
        $current_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $data=[
            'login'=>$request->get('is_login'),
            'current_url'=>urlencode($current_url)
        ];
        //var_dump($data);exit;
        return view('user.index',$data);
    }
}