<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="{{url('/form/test')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="file" name="media">
        <input type="suvmit" value="提交">
    </form>
</body>
</html>