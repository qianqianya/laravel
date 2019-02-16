<?php

namespace App\Http\Controllers\weChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class weChatController extends Controller
{
    public function weChat(){
        echo $_GET['echo str'];
    }
}