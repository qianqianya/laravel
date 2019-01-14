{{-- 用户登录--}}

@extends('layout.layout')
@section('title') {{$title}}    @endsection
@section('content')
    <form class="form-signin" action="/loginAdd" method="post">
        {{csrf_field()}}
        <h2 class="form-signin-heading">请登录</h2>
        <label for="inputEmail">Email</label>
        <input type="email" name="u_email" id="inputEmail" class="form-control" placeholder="@" required autofocus>
        <label for="inputPassword" >Password</label>
        <input type="password" name="u_pwd" id="inputPassword" class="form-control" placeholder="***" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me">记住密码
            </label>
        </div>
        <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="width:25%;float: left">登录</button>
        <a href="{{url('userAdd')}}" class="btn btn-lg btn-primary btn-block" style="width:25%;float: right">注册</a>
    </form>
@endsection
