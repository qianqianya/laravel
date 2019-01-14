<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>项目-{{$title}}</title>

    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>

<div class="container">
    <!-- Static navbar -->
        <div class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">首页</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {{--class="active"--}}
                    <li><a href="/goodsList">商品页面</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">个人中心 <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                            <li><a href="/orderList">订单页面</a></li>
                            <li><a href="/cartList">购物车</a></li>
                        </ul>
                    </li>
                    <?php if(empty($_COOKIE['u_id'])){ ?>
                        <li><a href="/loginAdd">登录</a></li>
                        <li><a href="/userAdd">注册</a></li>
                    <?php }else{ ?>
                        <li ><a href="javascript:;"><?php echo 'UID: '.$_COOKIE['u_id'] . ' 欢迎回来';?></a></li>
                        <li><a href="/loginQuit">退出</a></li>
                    <?php }?>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    @yield('content')
</div>

@section('footer')
    <script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>
@show
</body>
</html>