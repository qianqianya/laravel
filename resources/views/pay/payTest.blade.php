<img src="{{$file_name}}">
{{csrf_field()}}

<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>

<script>
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     :   '/payShow',
        type    :   'post',
        dataType:   'json',
        success :   function(msg) {
            if(msg.status==1000){
                window.location.href='支付成功';
            }else{
                window.location.href='/支付失败请重新支付';
            }
        }
    })
</script>