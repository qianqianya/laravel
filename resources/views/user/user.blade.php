{{-- 用户注册--}}

@extends('layout.layout')
@section('title') {{$title}}    @endsection
@section('content')
    <form class="form-signin" action="/userAdd" method="post">
        {{csrf_field()}}
        <h1 class="form-signin-heading">用户注册</h1>
        <label for="inputNickName">Nickname</label>
        <input type="text" name="u_name" id="inputNickName" class="form-control" placeholder="nickname" required autofocus>
        <label for="inputEmail">Email</label>
        <input type="email" name="u_email" id="inputEmail" class="form-control" placeholder="@" required autofocus>
        <label for="inputPassword" >Password</label>
        <input type="password" name="u_pwd1" id="inputPassword" class="form-control" placeholder="***" required>
        <label for="inputPassword2" >Confirm Password</label>
        <input type="password" name="u_pwd2" id="inputPassword2" class="form-control" placeholder="***" required>
        <label for="inputTel">Phone</label>
        <input type="text" name="u_tel" id="inputTel" class="form-control" placeholder="phone" required>
        <br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="width:25%;float: left">注册</button>
        <button class="btn btn-lg btn-primary btn-block" type="reset" style="width:25%;float: right">重置</button>
    </form>
@endsection