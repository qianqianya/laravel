<?php

namespace App\Http\Controllers\Movie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class MovieController extends Controller
{
    public function movie(){
        $key='test_bit';
        $seat_status=[];
        for($i=0;$i<=30;$i++){
            $status=Redis::getbit($key,$i);
            var_dump($status);exit;
            $seat_status[$i]=$status;
        }
        $data=[
            'seat'=>$seat_status
        ];
        return view('movie.movie',$data);

    }
    public function buy($pos,$status){
        $key='test_bit';
        Redis::setbit($key,$pos,$status);
    }
}