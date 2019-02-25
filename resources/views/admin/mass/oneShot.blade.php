<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>聊天页面</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body>
<!-- //微聊消息上墙面板 -->
<div class="wc__chatMsg-panel flex1" >
    <div class="wc__slimscroll2">
        <div class="chatMsg-cnt">
            <ul class="clearfix" id="J__chatMsgList">
                <p align="center"><a href="">﹀</a></p>


            </ul>
        </div>
    </div>
</div><br>

<!-- //微聊底部功能面板 -->
<div class="wc__footTool-panel" align="bottom">
    {{csrf_field()}}
    <input type="hidden" value="1" id="msg_pos">
    <!-- 输入框模块 -->
    <form action="" class="form-inline">
        <input type="hidden" value="{{$openid}}" id="openid">
        <input type="hidden" value="1" id="msg_pos">
        <textarea name="" id="send_msg" cols="50" rows="5" style="margin-left:1000px;"></textarea><br>
        <button class="btn btn-info" id="send_msg_btn" style="margin-left:1280px;">发送</button>
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
<script src="{{URL::asset('/js/weixin/chat.js')}}"></script>
<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
