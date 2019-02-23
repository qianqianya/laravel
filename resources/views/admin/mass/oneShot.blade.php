<!--//微聊底部功能面板 -->
<div class="wc__footTool-panel">
    <!--输入框模块 -->
    <div class="wc__editor-panel wc__borT flexbox">
        <div class="wrap-editor flex1">
            <div class="editor J__wcEditor" contenteditable="true"></div>
        </div>
        <i class="btn btn-emotion"></i>
        <i class="btn btn-choose"></i>
        <button class="btn-submit J__wchatSubmit">发送</button>
    </div>
    <!--表情、选择模块 -->
    <div class="wc__choose-panel wc__borT" style="display: none;">
        <!--表情区域 -->
        <div class="wrap-emotion" style="display: none;">
            <div class="emotion__cells flexbox flex__direction-column">
                <div class="emotion__cells-swiper flex1" id="J__swiperEmotion">
                    <div class="swiper-container">
                        <div class="swiper-wrapper"></div>
                        <div class="pagination-emotion"></div>
                    </div>
                </div>
                <div class="emotion__cells-footer" id="J__emotionFootTab">
                    <ul class="clearfix">
                        <li class="swiperTmpl cur" tmpl="swiper__tmpl-emotion01"><img
                                    src="img/emotion/face01/face-lbl.png" alt=""></li>
                        <li class="swiperTmpl" tmpl="swiper__tmpl-emotion02"><img src="img/emotion/face02/face-lbl.gif"
                                                                                  alt=""></li>
                        <li class="swiperTmpl" tmpl="swiper__tmpl-emotion03"><img src="img/emotion/face03/face-lbl.gif"
                                                                                  alt=""></li>
                        <li class="swiperTmpl" tmpl="swiper__tmpl-emotion04"><img src="img/emotion/face04/face-lbl.gif"
                                                                                  alt=""></li>
                        <li class="swiperTmpl" tmpl="swiper__tmpl-emotion05"><img src="img/emotion/face05/face-lbl.gif"
                                                                                  alt=""></li>
                        <li class="swiperTmpl" tmpl="swiper__tmpl-emotion06"><img src="img/emotion/face06/face-lbl.gif"
                                                                                  alt=""></li>
                        <li class="swiperTmplSet"><img src="img/wchat/icon__emotion-set.png" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>ij
        <!--选择区域 -->
        <div class="wrap-choose" style="display: none;">
            <div class="choose__cells">
                <ul class="clearfix">
                    <li>
                        <a class="J__wchatZp" href="javascript:;">
                            <span class="img"><img src="img/wchat/icon__choose-zp.png"/><input type="file"
                                                                                               accept="image/*"/></span>
                            <em>照片</em>
                        </a>
                    </li>
                    <li>
                        <a class="J__wchatSp" href="javascript:;">
                            <span class="img"><img src="img/wchat/icon__choose-sp.png"/><input type="file"
                                                                                               accept="video/*"/></span>
                            <em>视频</em>
                        </a>
                    </li>
                    <li>
                        <a class="J__wchatHb" href="javascript:;">
                            <span class="img"><img src="img/wchat/icon__choose-hb.png"/></span>
                            <em>红包</em>
                        </a>
                    </li>
                    <li>
                        <a class="J__wchatSc" href="javascript:;">
                            <span class="img"><img src="img/wchat/icon__choose-sc.png"/></span>
                            <em>我的收藏</em>
                        </a>
                    </li>
                    <li>
                        <a class="J__wchatWj" href="javascript:;">
                            <span class="img"><img src="img/wchat/icon__choose-wj.png"/></span>
                            <em>文件</em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<IMG src="file:///C:\Users\a1683\AppData\Roaming\feiq\RichOle\3961510489.bmp">
<IMG src="file:///C:\Users\a1683\AppData\Roaming\feiq\RichOle\3366624983.bmp">
<div class="wc__choosePanel-tmpl">
    <!--//红包模板.begin -->
    <div id="J__popupTmpl-Hongbao" style="display:none;">
        <div class="wc__popupTmpl tmpl-hongbao">
            <i class="wc-xclose"></i>
            <ul class="clearfix">
                <li class="item flexbox">
                    <label class="txt">总金额</label>
                    <input class="ipt-txt flex1" type="tel" name="hbAmount" placeholder="0.00"/>
                    <em class="unit">元</em>
                </li>
                <li class="item flexbox">
                    <label class="txt">红包个数</label>
                    <input class="ipt-txt flex1" type="tel" name="hbNum" placeholder="填写个数"/>
                    <em class="unit">个</em>
                </li>
                <li class="tips">
                    在线人数共<em class="memNum">186</em>人
                </li>
                <li class="item item-area">
                    <textarea class="describe" name="content" placeholder="恭喜发财，大吉大利"></textarea>
                </li>
                <li class="amountTotal">
                    ￥<em class="num">0.00</em>
                </li>
            </ul>
        </div>
    </div>
    <!--//红包模板.end -->
</div>
<IMG src="file:///C:\Users\a1683\AppData\Roaming\feiq\RichOle\2919792381.bmp">Js代码片段：
<IMG src="file:///C:\Users\a1683\AppData\Roaming\feiq\RichOle\418329596.bmp">//...长按弹出菜单$("#J__chatMsgList").on("longTap", "li .msg", function(e){
varthat = $(this), menuTpl, menuNode = $("
<div class='wc__chatTapMenu animated anim-fadeIn'></div>");
that.addClass("taped");
that.parents("li").siblings().find(".msg").removeClass("taped");
varisRevoke = that.parents("li").hasClass("me");
var_revoke = isRevoke ? "<a href='#'><i class='ico i4'></i>撤回</a>" : "";

if(that.hasClass("picture")){
console.log("图片长按");
menuTpl = "
<div class='menu menu-picture'><a href='#'><i class='ico i1'></i>复制</a><a href='#'><i class='ico i2'></i>收藏</a><a
            href='#'><i class='ico i3'></i>另存为</a>"+ _revoke +"<a href='#'><i class='ico i5'></i>删除</a></div>";
}elseif(that.hasClass("video")){
console.log("视频长按");
menuTpl = "
<div class='menu menu-video'><a href='#'><i class='ico i3'></i>另存为</a>" + _revoke +"<a href='#'><i class='ico i5'></i>删除</a>
</div>";
}else{
console.log("文字长按");
menuTpl = "
<div class='menu menu-text'><a href='#'><i class='ico i1'></i>复制</a><a href='#'><i class='ico i2'></i>收藏</a>" + _revoke
    +"<a href='#'><i class='ico i5'></i>删除</a></div>";
}

if(!$(".wc__chatTapMenu").length){
$(".wc__chatMsg-panel").append(menuNode.html(menuTpl));
autoPos();
}else{
$(".wc__chatTapMenu").hide().html(menuTpl).fadeIn(250);
autoPos();
}

functionautoPos(){
console.log(that.position().top)
var_other = that.parents("li").hasClass("others");
$(".wc__chatTapMenu").css({
position: "absolute",
left: that.position().left + parseInt(that.css("marginLeft")) + (_other ? 0 : that.outerWidth() - $(".wc__chatTapMenu").outerWidth()),
top: that.position().top - $(".wc__chatTapMenu").outerHeight() - 8});
}
});
