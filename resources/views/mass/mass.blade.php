{{-- 群发页面--}}
@extends('layout.goods')

@section('content')
    <form class="form-inline" method="post" action="/all">
        <div class="form-group">
            <label class="sr-only" for="goods_num">群发</label>
            <div class="input-group">
                群发内容<input type="text" class="form-control" name="content" placeholder="请输入您要发布的内容" >
            </div>
        </div>
        <input type="submit" value="提交">
    </form>
@endsection