<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>项目-{{$title}}</title>

    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>

<div class="container">
    @yield('content')
</div>

@section('footer')
    {{--<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>--}}
    {{--<script src="{{URL::asset('/bootstrap/js/bootstrap.min.js')}}"></script>--}}
@show
</body>
</html>

