<?php

namespace App\Http\Controllers\zhenji;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ZhenjiController extends Controller
{
    public function zhenji(){
        return json_encode(111);
    }
}
