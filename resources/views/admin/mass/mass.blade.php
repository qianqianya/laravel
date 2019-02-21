<form action="/admin/wxsendmsg" method="post">
    {{csrf_field()}}
    <textarea name="mass" id="" cols="30" rows="10"></textarea>
    <input type="file">
    <input type="submit" vlaue="提交">
</form>