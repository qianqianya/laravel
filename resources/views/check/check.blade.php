{{-- 购物车页面--}}
@extends('layout.goods')

@section('content')
    <table class="table table-hover">
        <h2>商品页面</h2>
        <tr class="success">
            <td>ID</td>
            <td>openid</td>
            <td>添加时间</td>
            <td>时间</td>
        </tr>
        @foreach($list as $v)
            <tr class="inf5">
                <td>{{$v->id}}</td>
                <td>{{$v->openid}}</td>
                <td>{{date("Y-m-d H:i:s",$v->add_time)}}</td>
                <td>{{$v->nickname}}</td>
                <td>{{date("Y-m-d H:i:s",$v->subscribetime)}}</td>
            </tr>
        @endforeach
    </table>

    <h5 style="float:right;width: 200px">{{$list->links()}}</h5>
@endsection