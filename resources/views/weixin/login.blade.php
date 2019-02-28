@extends('layout.goods')

@section('content')
    <div class="container">
        <h2>微信登录</h2>
        <h3>
            <a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxe24f70961302b5a5&amp;redirect_uri=http%3a%2f%2fmall.77sc.com.cn%2fweixin.php%3fr1%3dhttp%3a%2f%2fshop.comcto.com%2fweixin%2fgetcode&amp;response_type=code&amp;scope=snsapi_login&amp;state=STATE#wechat_redirect">Login</a>
        </h3>
    </div>
@endsection
@section('footer')
    @parent
    <script src="{{URL::asset('/js/weixin/chat.js')}}"></script>
@endsection