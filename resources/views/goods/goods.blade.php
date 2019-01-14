{{-- 购物车页面--}}
@extends('layout.goods')
@section('title') {{$title}}    @endsection
@section('content')
    <table class="table table-hover">
        <h2>商品页面</h2>
        <tr class="success">
            <td>ID</td>
            <td>名称</td>
            <td>数量</td>
            <td>价格</td>
            <td>时间</td>
            <td>操作</td>
        </tr>
        @foreach($data as $v)
        <tr class="info">
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td>{{$v->goods_store}}</td>
            <td>{{$v->goods_price / 100}}</td>
            <td>{{date("Y-m-d H:i:s",$v->goods_ctime)}}</td>
            <td><li class="btn"><a href="/goodsDetails/{{$v['goods_id']}}">加入购物车</a></li></td>
        </tr>
        @endforeach
    </table>
@endsection