{{-- 群发页面--}}
@extends('layout.goods')

@section('content')
    <form class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="goods_num">群发</label>
            <div class="input-group">
                群发内容<input type="text" class="form-control" placeholder="请输入您要发布的内容" >
            </div>
        </div>

    </form>

    <button type="submit" class="btn btn-primary" id="add_cart_btn"><a href="/all">开始发布</a></button>
@endsection