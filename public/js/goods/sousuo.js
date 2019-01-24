$('#button').click(function() {
    var button = $('#button').val();
    var keyword=$('#keyword').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/keyword',
        data: {button: button,keyword:keyword},
        type: 'post',
        dataType:'json',
        success:function(msg){
            console.log(msg);
        }

    });
})