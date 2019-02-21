<form action="/admin/wxsendmsg" method="post">
    {{csrf_field()}}
    <textarea name="mass" id="" cols="20" rows="3"></textarea>
    <input type="submit" vlaue="提交">
</form>