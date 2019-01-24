{{-- 购物车页面--}}
@extends('layout.goods')

@section('content')
    <table class="table table-hover">
        <h2>商品页面</h2>

        <div class="nav navbar-right panel_toolbox col-xs-3">
            <form role="form" method="GET" action="/keyword">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="请输入标题" name="keyword" value="{{$search}}}">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit">搜索</button>
                </span>
                </div>
            </form>
        </div>
        <tr class="success">
            <td>ID</td>
            <td>名称</td>
            <td>数量</td>
            <td>价格</td>
            <td>时间</td>
            <td>操作</td>
        </tr>
        @foreach($list as $v)
            <tr class="inf5">
                <td>{{$v->goods_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_store}}</td>
                <td>{{$v->goods_price / 100}}</td>
                <td>{{date("Y-m-d H:i:s",$v->goods_ctime)}}</td>
                <td><li class="btn"><a href="">加入购物车</a></li></td>
            </tr>
        @endforeach
    </table>

    <h5 style="float:right;width: 200px">{{$list->links()}}</h5>
@endsection