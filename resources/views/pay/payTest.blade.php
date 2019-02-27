<img src="{{$file_name}}">
{{csrf_field()}}

<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>

<script>
    function check(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/payShow',
            type    :   'get',
            dataType:   'json',
            success :   function(msg) {
                if(msg.status==1000){
                    window.location.href='/paysuccess';
                }else{
                    console.log(1);
                }
            }
        })
    }
    var ids=setInterval('check()',1000);



</script>