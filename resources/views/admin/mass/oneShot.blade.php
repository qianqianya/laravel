<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>聊天页面</title>
</head>
<body>
<!-- //微聊消息上墙面板 -->
<div class="wc__chatMsg-panel flex1">
    <div class="wc__slimscroll2">
        <div class="chatMsg-cnt">
            <ul class="clearfix" id="J__chatMsgList">
                <p align="center"><a href="">﹀</a></p>
                <p class="time" align="center" ><span>2019年22月31日 晚上22:30</span></p>
                <!-- 别人-->
                <li class="others" style="width:2000px;height: 100px;float:left;">
                    <div><img style="width:50px;height:50px;" src="{{env('IMG_URL')}}form_test/EyKuUaXsKuUfNU0e.jpg" alt=""></div>
                    <div class="content">
                        <p class="author">马云(老子天下第一)</p>
                        <div class="msg" >
                            hello 各位女士、先生，欢迎大家来到达摩派，进群后记得修改备注哈~~ 名字+公司/职业/机构
                        </div>
                    </div>
                </li>
                <!--自己-->
                <li class="me"  style="height: 200px;float: right;">
                    <div><img style="width:50px;height:50px;" src="{{env('IMG_URL')}}form_test/EyKuUaXsKuUfNU0e.jpg" alt=""></div>
                    <div class="content">
                        <p class="author">Nice奶思</p>
                        <div class="msg" >
                            么么哒，马总发个红包呗！
                        </div>
                    </div>
                </li>
                <li class="others" style="width:2000px;height: 100px;float:left;">
                    <div><img style="width:50px;height:50px;" src="{{env('IMG_URL')}}form_test/EyKuUaXsKuUfNU0e.jpg" alt=""></div>
                    <div class="content">
                        <p class="author">马云(老子天下第一)</p>
                        <div class="msg" >
                            hello 各位女士、先生，欢迎大家来到达摩派，进群后记得修改备注哈~~ 名字+公司/职业/机构
                        </div>
                    </div>
                </li>
                <!--自己-->
                <li class="me"  style="height: 200px;float: right;">
                    <div><img style="width:50px;height:50px;" src="{{env('IMG_URL')}}form_test/EyKuUaXsKuUfNU0e.jpg" alt=""></div>
                    <div class="content">
                        <p class="author">Nice奶思</p>
                        <div class="msg" >
                            么么哒，马总发个红包呗！
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- //微聊底部功能面板 -->
<div class="wc__footTool-panel" align="bottom">
    <!-- 输入框模块 -->
    <form class="wc__editor-panel wc__borT flexbox" method="post" action="">
        <div style="float: right;"><button type="submit" style="height:33px;">发送</button></div>
        <div class="wrap-editor flex1" style="border: 1px red solid;width:1000px;float: right;"><div class="editor J__wcEditor" contenteditable="true"></div></div>
        <i class="btn btn-emotion"></i>
        <i class="btn btn-choose"></i>
    </form>

    <!-- 表情、选择模块 -->
    <div class="wc__choose-panel wc__borT" style="display: none;">
        <!-- 表情区域 -->
        <div class="wrap-emotion" style="display: none;">
            <div class="emotion__cells flexbox flex__direction-column">
                <div class="emotion__cells-swiper flex1" id="J__swiperEmotion">
                    <div class="swiper-container">
                        <div class="swiper-wrapper"></div>
                        <div class="pagination-emotion"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<script>
    // ...长按弹出菜单
    $("#J__chatMsgList").on("longTap", "li .msg", function(e){
        var that = $(this), menuTpl, menuNode = $("<div class='wc__chatTapMenu animated anim-fadeIn'></div>");
        that.addClass("taped");
        that.parents("li").siblings().find(".msg").removeClass("taped");
        var isRevoke = that.parents("li").hasClass("me");
        var _revoke = isRevoke ? "<a href='#'><i class='ico i4'></i>撤回</a>" : "";

        if(that.hasClass("picture")){
            console.log("图片长按");
            menuTpl = "<div class='menu menu-picture'><a href='#'><i class='ico i1'></i>复制</a><a href='#'><i class='ico i2'></i>收藏</a><a href='#'><i class='ico i3'></i>另存为</a>"+ _revoke +"<a href='#'><i class='ico i5'></i>删除</a></div>";
        }else if(that.hasClass("video")){
            console.log("视频长按");
            menuTpl = "<div class='menu menu-video'><a href='#'><i class='ico i3'></i>另存为</a>" + _revoke +"<a href='#'><i class='ico i5'></i>删除</a></div>";
        }else{
            console.log("文字长按");
            menuTpl = "<div class='menu menu-text'><a href='#'><i class='ico i1'></i>复制</a><a href='#'><i class='ico i2'></i>收藏</a>" + _revoke +"<a href='#'><i class='ico i5'></i>删除</a></div>";
        }

        if(!$(".wc__chatTapMenu").length){
            $(".wc__chatMsg-panel").append(menuNode.html(menuTpl));
            autoPos();
        }else{
            $(".wc__chatTapMenu").hide().html(menuTpl).fadeIn(250);
            autoPos();
        }

        function autoPos(){
            console.log(that.position().top)
            var _other = that.parents("li").hasClass("others");
            $(".wc__chatTapMenu").css({
                position: "absolute",
                left: that.position().left + parseInt(that.css("marginLeft")) + (_other ? 0 : that.outerWidth() - $(".wc__chatTapMenu").outerWidth()),
                top: that.position().top - $(".wc__chatTapMenu").outerHeight() - 8
            });
        }
    });

    // ...表情、选择区切换
    $(".wc__editor-panel").on("click", ".btn", function(){
        var that = $(this);
        $(".wc__choose-panel").show();
        if (that.hasClass("btn-emotion")) {
            $(".wc__choose-panel .wrap-emotion").show();
            $(".wc__choose-panel .wrap-choose").hide();
            // 初始化swiper表情
            !emotionSwiper && $("#J__emotionFootTab ul li.cur").trigger("click");
        } else if (that.hasClass("btn-choose")) {
            $(".wc__choose-panel .wrap-emotion").hide();
            $(".wc__choose-panel .wrap-choose").show();
        }
        wchat_ToBottom();
    });

    // ...处理编辑器信息
    var $editor = $(".J__wcEditor"), _editor = $editor[0];
    function surrounds(){
        setTimeout(function () { //chrome
            var sel = window.getSelection();
            var anchorNode = sel.anchorNode;
            if (!anchorNode) return;
            if (sel.anchorNode === _editor ||
                    (sel.anchorNode.nodeType === 3 && sel.anchorNode.parentNode === _editor)) {

                var range = sel.getRangeAt(0);
                var p = document.createElement("p");
                range.surroundContents(p);
                range.selectNodeContents(p);
                range.insertNode(document.createElement("br")); //chrome
                sel.collapse(p, 0);

                (function clearBr() {
                    var elems = [].slice.call(_editor.children);
                    for (var i = 0, len = elems.length; i < len; i++) {
                        var el = elems[i];
                        if (el.tagName.toLowerCase() == "br") {
                            _editor.removeChild(el);
                        }
                    }
                    elems.length = 0;
                })();
            }
        }, 10);
    }
    // 格式化编辑器包含标签
    _editor.addEventListener("click", function () {
        //$(".wc__choose-panel").hide();
    }, true);
    _editor.addEventListener("focus", function(){
        surrounds();
    }, true);
    _editor.addEventListener("input", function(){
        surrounds();
    }, false);
    // 点击表情
    $("#J__swiperEmotion").on("click", ".face-list span img", function(){
        var that = $(this), range;

        if(that.hasClass("face")){ //小表情
            var img = that[0].cloneNode(true);
            _editor.focus();
            _editor.blur(); //输入表情时禁止输入法

            setTimeout(function(){
                if(document.selection && document.selection.createRange){
                    document.selection.createRange().pasteHTML(img);
                }else if(window.getSelection && window.getSelection().getRangeAt){
                    range = window.getSelection().getRangeAt(0);
                    range.insertNode(img);
                    range.collapse(false);

                    var sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }, 10);
        }else if(that.hasClass("del")){ //删除
            _editor.focus();
            _editor.blur(); //输入表情时禁止输入法

            setTimeout(function(){
                range = window.getSelection().getRangeAt(0);
                range.collapse(false);

                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
                document.execCommand("delete");
            }, 10);
        } else if(that.hasClass("lg-face")){ //大表情
            var _img = that.parent().html();
            var _tpl = [
                '<li class="me">\
                    <div class="content">\
                        <p class="author">Nice奶思</p>\
                        <div class="msg lgface">'+ _img + '</div>\
                </div>\
                <a class="avatar" href="微聊(好友主页).html"><img src="img/uimg/u__chat-img14.jpg" /></a>\
            </li>'
            ].join("");
            $chatMsgList.append(_tpl);

            wchat_ToBottom();
        }
    });
</script>

