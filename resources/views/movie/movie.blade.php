{{-- 订单页面--}}
@extends('layout.goods')
@section('content')
   @foreach($seat as $k=>$v)
       @if($v==1)
           <button class="btn-default btn-danger">座位{{$k}}</button><br>
       @else
           <button class="btn-default btn-info">座位{{$k}}</button><br>
       @endif
   @endforeach
@endsection