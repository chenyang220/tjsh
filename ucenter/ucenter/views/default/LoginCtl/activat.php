<!DOCTYPE html>
<html class="root61">
<?php
$re_url = '';
$re_url = Yf_Registry::get('re_url');
$from = $_REQUEST['callback'];
$callback = $from ?: $re_url;
$t = '';
$code = '';
extract($_GET);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>老会员首次登录</title>
    <link rel="stylesheet" href="<?= $this->view->css ?>/register.css">
    <link rel="stylesheet" href="<?= $this->view->css ?>/base.css">
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/headfoot.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/old_member.css" />
    <link rel="stylesheet" href="<?= $this->view->css ?>/iconfont/iconfont.css">
    <link rel="stylesheet" href="<?= $this->view->css ?>/new-style.css">
    <script src="<?= $this->view->js ?>/jquery-1.9.1.js"></script>
    <script src="<?=$this->view->js?>/base64.js"></script>
    <script src="<?= $this->view->js ?>/respond.js"></script>
    <script src="<?= $this->view->js ?>/regist.js"></script>

    <style type="text/css">
        .form-item .clear-btn {
            right: 10px;
        }

        /* 取消H5表单上下箭头 */
        /* 谷歌浏览器兼容性 */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0;
        }

        /* 火狐浏览器兼容性 */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<style>
    .timeSelectBox1 {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        bottom:0;
        width: 100vw;
        /*    height: 100%;*/
        background-color: #00000030;
        text-align: center;
        z-index: 999999;
    }
    .TeStSnContent>p {
    margin: 0;
    height: 50px;
    line-height: 50px;
}
        .TeStSon1{
        display: block;
        width: 40%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }
    .TeStSon1>p{
        height: 45px;
        line-height: 45px;
        text-align: left;
        padding-left: 20px;
        font-size: 16px;
        background: #eee;
        margin:0;
        padding-left: 5%;
    }
.field{
    background-color: white;
} 
</style>
<body>
<!-- 遮罩层开启 -->
<div id="mask_box" class="timeSelectBox1" >
    <div class="loading-indicator">
    <div class="TeStSon1" style="    height: auto;">
        <div class="TeStSnContent TeStSnUd">
            <img style="    width: 80px;" src="ucenter\static\default\images\quan.jpg" alt="">
            <p style="color: #007673;">正在注册</p>
        </div>
    </div>
    </div>
</div>
<!-- 遮罩层结束 -->
<!-- PC端页面 -->
<div class="pcRegisterBox">
    <div id="form-header" class="header">
        <div class="logo-con w clearfix">
            <a href="<?=Yf_Registry::get('ucenter_api_url')?>" class="index_logo">
                <img src="<?= $web['site_logo'] ?>" alt="logo" height="60">
            </a>
            <div class="logo-title"><p>激活</p></div>
        </div>

    </div>
    <div class="main ">
        <div class="pcRrStop">
            <div class="Rr progress-step step1">
                <div class="RrL">
                      <p class="RrLNumber RrLFirst">1</p>
                      <p class="RrL_p">上传身份证照片</p>
                </div>

            </div>
            <!-- 2 -->
            <div class="Rr firstStep progress-step step2 active">

                <div class="innerWire">
                    <p>············></p>
                </div>

                <div class="RrL">
                      <p class="RrLNumber">2</p>
                      <p class="RrL_p RrL_pDefault">填写注册基本信息</p>
                </div>

            </div>

             <!--3-->
            <div class="Rr firstStep progress-step step3">

                <div class="innerWire">
                    <p>············></p>
                    <!-- <p>···················<span class="IrSpan">></span></p> -->
                </div>

                <div class="RrL">
                      <p class="RrLNumber">3</p>
                      <p class="RrL_p RrL_pDefault">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp设置密码&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
                </div>

            </div>
            <!--4-->
            <div class="Rr firstStep progress-step step4">

                <div class="innerWire">
                    <p>············></p>
                    <!-- <p>···················<span class="IrSpan">></span></p> -->
                </div>

                <div class="RrL">
                      <p class="RrLNumber">4</p>
                      <p class="RrL_p RrL_pDefault">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp申请成功&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
                </div>

            </div>
        </div>
    
        <!-- PC-2 -->
        <div class="pcStCont pcdatas">
            <div class="reg-form" id="reg-form1">
                <form action="" id="register-form" class="ItRegister" method="post" novalidate="novalidate" onsubmit="return false;" autocomplete="off">
                    <input type="hidden" name="from" class="from" value="<?php echo $from; ?>">
                    <input type="hidden" name="callback" class="callback" value="<?php echo urlencode($callback); ?>">
                    <input type="hidden" name="t" class="token" value="<?php echo $t; ?>">
                    <input type="hidden" name="code" class="code" value="<?php echo $code; ?>">
                    <input type="hidden" name="re_url" class="re_url" value="<?php echo $re_url; ?>">
                    <input style="display:none" name="hack">
                    <input type="password" style="display:none" name="hack1">
                    <div class="form-item" id="form-item-idcard" style="z-index: 12;">
                        <label>身份证号码 </label>
                        
                        <input type="text" id="user_idcard" class="field PCfield re_user_password" autocomplete="off" maxlength="18" placeholder="自动带出" default="<i class=&quot;i-def&quot;></i>请输入您的身份证号" disabled="disabled">
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div class="form-item" id="form-item-mobile" style="z-index: 12;">
                        <label>手机号</label>
                   
                        <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="11" placeholder="请输入您的手机号码" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div class="Mobile_div" style="">
                        <div class="form-item form-item-mobile">
                            <div class="form-item form-item-phonecode">
                            <label>验证码 </label>

                            <input type="text" name="mobileCode" maxlength="6" id="phoneCode" onblur="checkRcode()" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                            <button id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码 </button>
                            <i class="i-status"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-email" class="form-item" style="z-index: 12;">
                        <label>邮箱地址 </label>
                        <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="请输入您的邮箱地址" default="<i class=&quot;i-def&quot;></i>建议使用常用邮箱地址" onblur="checkEmail()" onfocus="showTip(this)">
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div class="agreements">
                        <input id="agree_button" type="checkbox" name="agreen" checked="">
                        <p class="LookThat">已阅读并同意<a class="c-default iblock align-top" href="javascript:;">尚赫</a>优惠顾客规章</p>
                    </div>
                </form>
            </div>

            <button type="submit" class=" btn-PCData" onclick="actitClick()">下一步</button>
        </div>
        <!-- PC-3 -->
        <div class="pcStCont pcSetpPassword">
            <div class="reg-form PCPassword">
                <form action="" id="register-form3" method="post" novalidate="novalidate"  onsubmit="return false;">
                    <div class="pas">
                        <div id="form-item-password" class="form-item" style="z-index: 12;">
                            <label>新 密 码</label>
                            <span class="close-btn js_clear_btn clear-icon"></span>
                            <input type="password" id="re_user_password" class="field re_user_password" maxlength="16" placeholder="6-16位字母数字区分大小写" default="<i class=i-def></i><?= $pwd_str ?>" onfocus="checkPwd()" onblur="pwdCallback()">
                            <span class="clear-btn eye-icon"></span>
                            <i class="i-status"></i>
                        </div>
                        <div class="input-tip">
                            <span></span>
                        </div>

                    </div>

                    <div id="form-item-rpassword" class="form-item pas">
                        <label>确 认 密 码</label>

                        <span class="close-btn js_clear_btn clear-icon"></span>
                        <input type="password" name="form-equalTopwd" id="form-equalTopwd" class="field" placeholder="请再次填写密码" maxlength="16" default="<i class=&quot;i-def&quot;></i>请再次输密码" onblur="checkRpwd()" onfocus="showTip(this)">

                        <span class="clear-btn eye-icon"></span>
                        <i class="i-status"></i>
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div class="register_B">
                       <!--  <button type="submit" class="btn-register" onclick="nextStep(3)">确认</button> -->
                        <button type="submit" class="btn-register" onclick="actitClick1()">确认</button>
                    </div>

                </form>
            </div>
        </div>
        <!--PC-4 -->
        <div class="pcStCont PCsucceed">
            <div class="reg-form">
                <form action="" id="register-form4" method="post" novalidate="novalidate" onsubmit="return false;">
                    <div class="informationBox">
                        <h3><i></i>恭喜您完成资料验证!</h3>
                        <br><br>
                        <div class="inNameBox">
                            <p class="InNume">您的会员编号是：<span id="member_id">4553355<span></span></span></p>
                            <p class="InNume">您的辅导员编号是：<span id="par_member">10239</span></p>
                        </div>
                        <div class="QRCodeIcon">
                            <!-- <img src="ucenter\static\default\images\login_01\twoDimensionCode.png" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png" id="qrurl"> -->
                            <div id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                        </div>
                        <p class="hint">提示：您的二维码可以在我的-我的个人资料中查看</p>


                        <button type="submit" class="btn-PCsucceed" onclick="actitClick2()">进入首页</button>

                    </div>


                </form>
            </div>
        </div>


</div>

</div>
<div class="timeSelectBox TeStSon_bns">
    <div class="TeStSon">
        <div class="posts-content" style="font-family: -apple-system,BlinkMacSystemFont,Helvetica Neue,PingFang SC,Microsoft YaHei,Source Han Sans SC,Noto Sans CJK SC,WenQuanYi Micro Hei,sans-serif;">
            <p><?= $reg_row['reg_protocol']['config_value'] ?></p>

            <div align="right" class="f14"><br>
                <button class="TeStSon_bn" style="width: 100px;height: 20px;line-height: 0px;background-color: #fff;border:1px solid #666;border-radius: 4px;display:block;margin:0 auto;">同意并继续</button>
                <!-- <a rel="nofollow" title="举报不良内容或评论" class="red" onclick="openPopWin('jubaoPop')" href="javascript:void(0)">举报</a> -->

            </div>
        </div>

    </div>
</div>





<!-- wap 2-->
<div class="app-module">
    <!-- 老会员登录 -->
    <div class="container w appRegister userLogin">
        <div class="steps step-login">
            <div id="header">
                <a href="javascript:history.go(-1)" class="back-pre"></a>
                老会员首次登录
            </div>
            <div class="main clearfix" id="form-main">
                 <div class="portraitIcon tc mb-2">
                    <img src="<?= $web['site_logo'] ?>" alt="logo">
                </div>
                <div class="reg-form fl">
                    <form action="" class="wap-wrap" id="register-form-user" method="post" novalidate="novalidate" onsubmit="return false;" autocomplete="off">
                        <input type="hidden" name="from" class="from" value="<?php echo $from; ?>">
                        <input type="hidden" name="callback" class="callback" value="<?php echo urlencode($callback); ?>">
                        <input type="hidden" name="t" class="token" value="<?php echo $t; ?>">
                        <input type="hidden" name="code" class="code" value="<?php echo $code; ?>">
                        <input type="hidden" name="re_url" class="re_url" value="<?php echo $re_url; ?>">
                        <input style="display:none" name="hack">
                        <input type="password" style="display:none" name="hack1">
                       
                        <div class="mobile">
                            <div id="Mobile">
                                <div class="item-phone-wrap">
                                    <div class="form-item form-item-mobile" id="form-item-idcard">
                                        <i class="IdCardNum"></i>
                                        <!-- <label class="select-country" id="select-country"><em class="must">*</em>身份证号：</label> -->
                                        <span class="clear-btn js_clear_btn clear-icon"></span>
                                        <input type="text" oninput="" id="user_idcard" class="field re_user_mobile" placeholder="身份证号码自动带出" default="<i class=&quot;i-def&quot;></i>请输入您的身份证号" disabled="disabled">
                                        <i class="i-status"></i>
                                    </div>
                                    <div class="input-tip">
                                        <span></span>
                                    </div>
                                </div>
                                <div class="item-phone-wrap">
                                    <div class="form-item form-item-mobile" id="form-item-mobile">
                                       <!--  <label class="select-country" id="select-country"><em class="must">*</em>手机号码：</label> -->
                                       <i class="icons-phone"></i>
                                        <span class="clear-btn js_clear_btn clear-icon"></span>
                                        <input type="text" oninput="" id="user_mobile" class="field re_user_mobile" maxlength="11" placeholder="请您输入您的手机号码" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                                        <i class="i-status"></i>
                                    </div>
                                    <div class="input-tip">
                                        <span></span>
                                    </div>
                                </div>
                                <div class="item-phone-wrap">
                                    <div class="form-item form-item-phonecode">
                                       <!--  <label><em class="must">*</em>手机验证码：</label> -->
                                       <i class="icons-code"></i>
                                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" onblur="checkRcode()" class="field phonecode  re_mobile" placeholder="请输入验证码">
                                        <button id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码</button>
                                        <i class="i-status"></i>
                                    </div>
                                     <div class="input-tip">
                                        <span></span>
                                    </div>
                                </div>
                                
                                <div class="item-phone-wrap">
                                    <div class="form-item form-item-mobile" id="form-item-email">
                                        <!-- <label class="select-country" id="select-country"><em class="must">*</em>邮箱地址：</label> -->
                                        <i class="icons-email"></i>
                                        <span class="clear-btn js_clear_btn clear-icon"></span>
                                        <input type="text" id="user_email" class="field re_user_mobile" placeholder="请输入您的邮箱地址" maxlength="30" default="<i class=&quot;i-def&quot;></i>建议使用常用邮箱地址" onblur="checkEmail()" onfocus="showTip(this)">
                                        <i class="i-status"></i>
                                    </div>
                                    <div class="input-tip">
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-agreen">
                            <div>
                                <input id="agree_button" type="checkbox" name="agreen" checked="">
                                <p class="LookThat">已阅读并同意<a class="c-default iblock align-top" href="javascript:;">尚赫</a>优惠顾客规章</p>
                            </div>
                            <div class="input-tip"><span></span></div>
                        </div>
                        <div>
                            <button type="submit" class="btn-register" onclick="actitClick()">下一步</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 设置密码 3-->
        <div class="steps step-setPassword">
            <div id="header">
                <a href="javascript:history.go(-1)" class="back-pre"></a>
                设置密码
            </div>
       
            <div class="main clearfix wp90" id="form-main1">
               
                <div class="reg-form fl">
                    <form action="" id="register-form1" method="post" novalidate="novalidate" onsubmit="return false;" autocomplete="off">
                        <div id="form-item-password" class="form-item" style="z-index: 12;">
                            <label>新密码：</label>
                            <span class="close-btn js_clear_btn clear-icon"></span>
                            <input type="password" id="re_user_password" class="field re_user_password" autocomplete="off" maxlength="16" placeholder="6-16位字母数字区分大小写" default="<i class=i-def></i><?=$pwd_str?>" onfocus="checkPwd()" onblur="pwdCallback()">
                            <span class="clear-btn eye-icon"></span>
                            <i class="i-status"></i>
                        </div>
                        <div class="input-tip">
                            <span></span>
                        </div>
                        <div id="form-item-rpassword" class="form-item">
                            <label>确认密码：</label>
                            <span class="close-btn js_clear_btn clear-icon"></span>
                            <input type="password" name="form-equalTopwd" id="form-equalTopwd" class="field" placeholder="请再次填写密码" maxlength="16" default="<i class=&quot;i-def&quot;></i>请再次输入密码" onblur="checkRpwd()" onfocus="showTip(this)">
                            <span class="clear-btn eye-icon"></span>
                            <i class="i-status"></i>
                        </div>
                        <div class="input-tip">
                            <span></span>
                        </div>
                        <div>
                            <button type="submit" class="btn-register" onclick="actitClick1()">确认</button>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
        <!-- 申请成功 4-->
        <div class="steps step-apply-success">
            <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>申请成功</div>
            <div class="main clearfix" id="form-main">
                <div class="reg-form fl">
                    <form action="" id="register-form2" method="post" novalidate="novalidate"  onsubmit="return false;">
                        <div class="informationBox">
                            <h3><i></i>恭喜完成资料验证!</h3>
                            <br><br>
                            <div class="inNameBox">
                                <p class="InNume">您的会员编号是：<span id="member_id">1234567<span></p>
                                <p class="InNume">您的辅导员编号是：<span id="par_member">7654321</span></p>
                            </div>
                            <div class="QRCodeIcon">
                               <!--  <img src="ucenter\static\default\images\login\twoDimensionCode.png" id="qrurl"> -->
                                <div id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                            </div>
                            <p class="hint">提示：您的二维码可以在我的-我的个人资料中查看</p>
                            <div>
                                <button type="submit" class="btn-register" onclick="actitClick2()">进入首页</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <!-- 规章弹窗 -->

        <?php
        include $this->view->getTplPath() . '/' . 'footer.php';
        ?>
    </div>
    <script type="text/javascript" src="<?= $this->view->js ?>/jquery.qrcode.js"></script>
    <script type="text/javascript" src="<?= $this->view->js ?>/utf.js"></script>
    <script>
        // 规章弹窗
        $(document).ready(function(){
            $(".LookThat").click(function(){
                $(".TeStSon_bns").show();
                $(document.body).css({
                    "overflow-x":"hidden",
                    "overflow-y":"hidden"
                });
                event.stopPropagation();
            })
            $(".TeStSon_bn").click(function(){
                $(".timeSelectBox").css("display","none");
                $(document.body).css({
                    "overflow-x":"auto",
                    "overflow-y":"auto"
                });
                event.stopPropagation();
            })
        })



        var wp;
        var w = $(window).width();
        if( w > 765){
            $(".appRegister").remove();
            $(".pcRegisterBox").css("display","block")
             wp = 1; //PC模式
        }else{
            wp = 2; //手机模式
            $(".pcRegisterBox").remove();
            $(".appRegister").css("display","block")
        }

        function changeDiv(firstDiv, secondDiv) {
            var temp;
            temp = firstDiv.html();
            firstDiv.html(secondDiv.html());
            secondDiv.html(temp);
        }

        if ($(window).width() < 690) {
            changeDiv($(".pas"), $(".mobile"));
        }
      

        function nextStep(a){
            // registerProcess(a);
            $(".pcStCont").css("display","none");
            if(a ==1){
                $(".pcdatas").css("display","block")
                $('.step2').addClass('active');
            }else if(a ==2){
                $(".pcSetpPassword").css("display","block")
                $('.step3').addClass('active');
            }else if(a ==3){
                $(".PCsucceed").css("display","block");
                $('.step4').addClass('active');
            };

        }
        function AppNextStep(a){
            console.log(a);
            $(".appStCont").css("display","none");
            if(a ==1){
                $(".container_b").css("display","block")
            }else if(a ==2){
                $(".userLogin").css("display","block")
            };

        }
        
    

        var param = new Array();

        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return r[2];
            return '';
        }

  
        var idcard      = getQueryString('idcard');
        var memberid    = getQueryString('memberid');
        var name        = getQueryString('name');
        var img         = getQueryString('img'); //身份证正面
        var img2        = getQueryString('img2');

        var b           = new Base64();  
        var idcard      = b.decode(idcard);
        console.log(idcard);
        param['user_name']   = b.decode(name);
        param['memberid']    = b.decode(memberid);
        param['images']      = b.decode(img);
        param['images2']     = b.decode(img2);

        $("#user_idcard").attr("value",idcard);
        function actitClick(){
            param['user_idcard'] = $('#user_idcard').val();
            param['user_mobile'] = $('#user_mobile').val();
            param['user_email']  = $('#user_email').val();
            param['user_code']   = $('#phoneCode').val();
            param['phone_code']  = param['phoneCode2']; //获取验证码
            if (!param['user_idcard']) {
                return Public.tips.alert('请输入身份证号码');
            }
            if (!param['user_mobile']) {
                return Public.tips.alert('请输入您的手机号码');
            }
            if (!param['phone_code']) {
                return Public.tips.alert('请点击获取短信验证码');
            }
            
            if (!param['user_code']) {
                return Public.tips.alert('请输入短信验证码');
            }else if(param['user_code']!=param['phone_code']){
                return Public.tips.alert('您输入的短信验证码不正确');
            }

            if (!param['user_email']) {
                return Public.tips.alert('请输入您的邮箱地址');
            }
            //判断是否选中我已阅读用户手册
            if (!$('#agree_button').is(':checked')) {
                Public.tips.alert('请确认是否同意用户注册协议');
                return;
            }
            var form_email = $("#user_email");
            hideError(form_email);
            var email = $("#user_email").val();
            if (email) {
                var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/;
                //先匹配是否为邮箱
                if (!reg.test(email)) {
                    var errormsg = icons.error + '请输入正确的邮箱';
                    onKeyupHandler(form_email, errormsg);
                    email_check = false;
                    return email_check;
                }
            }
            //判断输入值是否和获取的一样
            if ($('#user_idcard').val() != idcard) {
                 return Public.tips.alert('您输入的身份证号和上传的身份证图片上不一致');
            }
            if ($('#user_mobile').val() != param['user_mobile2']) {
                 return Public.tips.alert('请不要修改已输入的手机号');
            }

            $("#form-main").css("display","none");  //申请成功内容
            $(".steps").hide();                     //wap全部页面
            $(".step-setPassword").show();          //设置密码
            $(".pcStCont").css("display","none");   //pc全部页面

            $(".pcSetpPassword").css("display","block");    //pc密码
            $('.step3').addClass('active');                 //设置密码进度
        }

        function actitClick1(){
            
            param['re_user_password'] = $('#re_user_password').val();//新密码
            param['user_password']    = $('#form-equalTopwd').val();//新密码
          
            var token = $(".token").val();

            if (!param['re_user_password']) {
                return Public.tips.alert('请输入新密码');
            }
            if (!param['user_password']) {
                return Public.tips.alert('请输入确认密码');
            }
            if (param['re_user_password'] != param['user_password']) {
                return Public.tips.alert('两次密码输入不一致');
            }
            // var params = {
            //     "user_name": '测试',
            //     "user_mobile": '15214338712',
            //     "user_email": '123456@qq.com',
            //     "user_idcard": '612127196804303041',
            //     "memberid": '9191919',
            //     "images": '1111.png',
            //     "images": '2222.png',
            //     "user_password": '123456',
            //     "t": token
            // };
            $("#mask_box").show();
            var params = {
                "user_name": param['user_name'],
                "user_mobile": param['user_mobile'],  //辅导员姓名
                "user_email": param['user_email'],
                "user_idcard": param['user_idcard'],
                "memberid": param['memberid'],
                "images": param['images'],
                "images2": param['images2'],
                "user_password": param['user_password'],
                "t": token
            };
            console.log(params);
            var ajaxurl = './index.php?ctl=Login&met=register2&typ=json';
            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data:params,
                async: false,
                success: function (respone)
                {
                    $("#mask_box").hide();
                    if(respone.status == 200){

                        console.log(respone);

                        setCookie("member_id",respone.data['MemberID'],1);
                        setCookie("par_member",respone.data['par_member'],1);

                        $("#member_id").text(respone.data['MemberID']);
                        $("#par_member").text(respone.data['par_member']);
                        $("#qrurl").attr('src', respone.data['qrurl']);

                        if (wp == 1) {
                            $(".pcSetpPassword").css("display","none");
                            $(".PCsucceed").css("display","block");
                            $('.step4 ').addClass('active');                 //申请成功进度样式
                        } else {
                            $(".step-setPassword").hide();
                            $(".step-apply-success").show();
                        }
                        
                        //生成二维码
                        $("#qrcodeCanvas").qrcode({
                            render : "canvas",    //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
                            text : respone.data['qrurl'],    //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接
                            width : "100",               //二维码的宽度
                            height : "100",              //二维码的高度
                            background : "#ffffff",       //二维码的后景色
                            foreground : "#000000",        //二维码的前景色
                            src: 'ucenter/static/default/images/20180730135300.jpg'             //二维码中间的图片
                         });
                        return;
                    }else{
                        Public.tips.alert('注册失败，'+respone.msg);
                        
                        return;
                    }
                }
            });
            
        }

        function actitClick2(){
            //window.location.href = "./index.php?ctl=User&met=getUserInfo";
            window.location.href = '<?=sprintf('%s?ctl=User&met=getUserInfo1&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>';
        }

        var check_type = <?=$reg_row['reg_checkcode']['config_value']?>;
        if (check_type == 3) {
            check_type = 1;
        }

        var pwdLength = '<?=$reg_row['reg_pwdlength']['config_value']?>';
        //var form_account = $("#re_user_account");
        var form_pwd = $("#re_user_password");
        var form_rpwd = $("#form-equalTopwd");
        var form_mobile = $("#user_mobile");
        var form_email = $("#user_email");
        var form_authcode = $("#form-authcode");
        var user_check = false;
        var option_check = true;
        var mobile_check = false;
        var email_check = false;
        var code_check = false;
        var pwd_check = false;
        var both_pwd_check = false;
        suggestsList = {};

        function get_randfunc(obj) {
            var sj = new Date();
            url = obj.src;
            obj.src = url + '?' + sj;
        }

        var icons = {
            def: '<i class="i-def"></i>',
            error: '<i class="i-error"></i>',
            weak: '<i class="i-pwd-weak"></i>',
            medium: '<i class="i-pwd-medium"></i>',
            strong: '<i class="i-pwd-strong"></i>'
        };

        var pwdStrength = {
            1: {
                reg: /^.*([\W_])+.*$/i,
                msg: icons.weak + '有被盗风险,建议使用字母、数字和符号两种及以上组合'
            },
            2: {
                reg: /^.*([a-zA-Z])+.*$/i,
                msg: icons.medium + '安全强度适中，可以使用三种以上的组合来提高安全强度'
            },
            3: {
                reg: /^.*([0-9])+.*$/i,
                msg: icons.strong + '你的密码很安全'
            }
        };

        var weakPwds = [];

        function filterKey(e) {
            var excludedKeys = [13, 9, 16, 17, 18, 20, 35, 36, 37, 38, 39, 40, 45, 144, 225];
            return $.inArray(e.keyCode, excludedKeys) !== -1;
        }

        function hideError(input, msg) {
            var item = input.parent();
            var msg = msg || input.attr('default');
            item.removeClass('form-item-error form-item-valid');
            item.next().find('span').removeClass('error').html(msg).show();
            item.next().removeClass('phone-bind-tip');
            item.removeClass('phone-binded');
            item.next().removeClass('email-bind-tip');
            item.removeClass('email-binded');
        }

        /**输入过程中处理标签的状态**/
        function onKeyupHandler(input, msg) {
            var item = input.parent();
            if (!item.hasClass('form-item-error')) {
                item.addClass('form-item-error');
            }
            item.removeClass('form-item-valid');
            item.next().find('span').addClass('error').html(msg).show();
        }

        //显示提示语
        function showTip(e) {
            var msg = $(e).attr('default');
            if (!$(e).parent().next().find("span").html()) {
                $(e).parent().next().find("span").html(msg);
            }
        }

        function getStringLength(str) {
            if (!str) {
                return;
            }
            var bytesCount = 0;
            for (var i = 0; i < str.length; i++) {
                var c = str.charAt(i);
                if (/^[\u0000-\u00ff]$/.test(c)) {
                    bytesCount += 1;
                } else {
                    bytesCount += 2;
                }
            }
            return bytesCount;
        }


        

        //检测密码
        function checkPwd() {
            var msg = form_pwd.attr('default');
            var s = form_pwd.parent().next().find("span").html();
            if (!s) {
                form_pwd.parent().next().find("span").html(msg);
            }
           
            form_pwd.on('keyup', function (e) {
                var value = $(this).val();
                // 检查输入的密码长度
                pwdStrengthRule(form_pwd, value);
                pwd_check = pwdStrengthRule(form_pwd, value);
            });

        }

        /*检测密码长度*/
        function pwdStrengthRule(element, value) {
            var level = 0;
            var typeCount = 0;
            var flag = true;
            var valueLength = getStringLength(value);

            if (valueLength < pwdLength) {
                pwd_check = false;
                element.parent().removeClass('form-item-valid').removeClass('form-item-error');
                element.parent().next().find('span').removeClass('error').html($(element).attr('default'));
                return;
            }

            for (key in pwdStrength) {
                if (pwdStrength[key].reg.test(value)) {
                    typeCount++;
                }
            }

            if (typeCount == 1) {
                if (valueLength > 10) {
                    level = 2;
                } else {
                    level = 1;
                }
            } else if (typeCount == 2) {
                if (valueLength < 11 && valueLength > 5) {
                    level = 2;
                }
                if (valueLength > 10) {
                    level = 3;
                }
            } else if (typeCount == 3) {
                if (valueLength > 6) {
                    level = 3;
                }
            }

            if ($.inArray(value, weakPwds) !== -1) {
                flag = false;
                level = 1;
            }

            if (flag && level > 0) {
                element.parent().removeClass('form-item-error').addClass('form-item-valid');
            } else {
                element.parent().addClass('form-item-error').removeClass('form-item-valid');
            }

            if (pwdStrength[level] !== undefined) {
                pwdStrength[level] > 3 ? pwdStrength[level] = 3 : pwdStrength[level];
                element.parent().next().html('<span>' + pwdStrength[level].msg + '</span>')
            }

            return flag;
        }

        /*检测密码*/
        function pwdCallback() {
            var user_pwd = $("#re_user_password").val();
            hideError(form_pwd);

            if (/[~'!@#￥$%^&*()-+_=:\.。—·【】\[\]"、》《<>?？/\|`]+/.test(user_pwd)) {
                var errormsg = icons.error + "密码不能包含特殊字符";
                onKeyupHandler(form_pwd,errormsg);
                return;
            }

            if (user_pwd) {
                var flag = true;
                var reg_number = <?=$reg_row['reg_number']['config_value'] ? $reg_row['reg_number']['config_value'] : 0 ?>;
                var reg_lowercase = <?=$reg_row['reg_lowercase']['config_value'] ? $reg_row['reg_lowercase']['config_value'] : 0 ?>;
                var reg_uppercase = <?=$reg_row['reg_uppercase']['config_value'] ? $reg_row['reg_uppercase']['config_value'] : 0 ?>;
                var reg_symbols = <?=$reg_row['reg_symbols']['config_value'] ? $reg_row['reg_symbols']['config_value'] : 0 ?>;
                var reg_pwdlength = <?=$reg_row['reg_pwdlength']['config_value'] ? $reg_row['reg_pwdlength']['config_value'] : 0 ?>;
                var reg = '';
                reg_number > 0 && (reg += '0-9');
                reg_lowercase > 0 && (reg += 'a-z');
                reg_uppercase > 0 && (reg += 'A-Z');
                reg_symbols > 0 && (reg += "~'!@#￥$%^&*()-/+_=:.。】、—,，【;；：“”’？?）（`·{}《》<>！[…");
                if (reg !== '') {
                    reg = new RegExp('^[' + reg + ']+$');
                    !reg.test(user_pwd) && (flag = false);
                }

                //必须包含数字
                if (reg_number > 0) {
                    if (/[0-9]+/.test(user_pwd)) {
                        flag = flag && true;
                    } else {
                        flag = flag && false;
                    }
                }

                //必须小写字母
                if (reg_lowercase > 0) {
                    if (/[a-z]+/.test(user_pwd)) {
                        flag = flag && true;
                    } else {
                        flag = flag && false;
                    }
                }

                //必须大写字母
                if (reg_uppercase > 0) {
                    if (/[A-Z]+/.test(user_pwd)) {
                        flag = flag && true;
                    } else {
                        flag = flag && false;
                    }
                }

                //必须字符
                if (reg_symbols > 0) {
                    if (/[~'!@#￥$%^&*()-+_=:\.。—·【】\[\]"、》《<>?？/\|`]+/.test(user_pwd)) {
                        flag = flag && true;
                    } else {
                        flag = flag && false;
                    }
                }

                 
                if (reg_pwdlength > 0) {
                    if (user_pwd.length >= <?=$reg_row['reg_pwdlength']['config_value']?>) {
                        flag = flag && true;
                    } else {
                        flag = flag && false;
                    }
                }

                if (flag) {
                    pwd_check = true;
                    $("#form-item-password").addClass("form-item-valid");
                    $("#form-item-password").next().find("span").html("");
                    $("#form-item-password").removeClass("pending");
                } else {
                    pwd_check = false;
                    $("#form-item-password").removeClass("pending");
                    var errormsg = icons.error + "<?= $pwd_str ?>";
                    onKeyupHandler(form_pwd, errormsg);
                }
            } else {
                pwd_check = false;
                $("#form-item-password").removeClass("pending");
                $("#form-item-password").next().find("span").html("");
            }
        }

        /*检测重复密码*/
        function checkRpwd() {
            var rpwd = $("#form-equalTopwd").val();
            var pwd = $("#re_user_password").val();
            hideError(form_rpwd);
            if (rpwd) {
                if (rpwd == pwd) {
                    both_pwd_check = true;
                    $("#form-item-rpassword").addClass("form-item-valid");
                    $("#form-item-rpassword").next().find("span").html("");
                } else {
                    both_pwd_check = false;
                    $("#form-item-rpassword").removeClass("form-item-valid");
                    var errormsg = icons.error + '两次密码输入不一致';
                    onKeyupHandler(form_rpwd, errormsg);
                }
            } else {
                both_pwd_check = false;
                $("#form-item-rpassword").next().find("span").html("");
            }
        }

        //验证手机
        function checkMobile() {
            hideError(form_mobile);
            var mobile = $("#user_mobile").val();
            if (mobile) {
                //先匹配是否为手机号
                if (/^1[34578]\d{9}$/.test(mobile)) {
                    //验证该手机号是否被注册过
                    var ajaxurl = './index.php?ctl=Login&met=checkMobile&typ=json&mobile=' + mobile;
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        dataType: "json",
                        async: false,
                        success: function (respone) {
                            // if (respone.status == 250) {
                            //     var errormsg = icons.error + '该手机号已被注册';
                            //     //onKeyupHandler(form_mobile, errormsg);
                            //     onKeyupHandler($("#user_mobile"), errormsg);
                            //     mobile_check = false;
                            // } else {
                            //     $("#form-item-mobile").addClass("form-item-valid");
                            //     $("#form-item-mobile").next().find("span").html("");
                            //     mobile_check = true;
                            // }
                        }
                    });
                } else {
                    var errormsg = icons.error + '请输入正确的手机号';
                    onKeyupHandler(form_mobile, errormsg);
                    mobile_check = false;
                }
            } else {
                $("#form-item-mobile").next().find("span").html("");
            }
        }
        //验证邮箱
        function checkEmail() {
            var form_email = $("#user_email");
            hideError(form_email);
            var email = $("#user_email").val();
            if (email) {
                var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/;
                //先匹配是否为邮箱
                if (!reg.test(email)) {
                    var errormsg = icons.error + '请输入正确的邮箱';
                    onKeyupHandler(form_email, errormsg);
                    email_check = false;
                    return email_check;
                }
            } else {
                $("#form-item-email").next().find("span").html("");
                return false;
            }
        }
       
        function checkCode() {
            hideError(form_authcode);
            $("#form-item-authcode").next().find("span").html("");
        }

        function checkFormatter(obj) {
            var checkObj = $(obj);
            hideError(checkObj);
            var datatype = parseInt(checkObj.data('datatype'));
            if (datatype) {
                var val = checkObj.val();
                if (val) {
                    //规则可以封装。
                    if (1 == datatype) {
                        // 截取输入的长度，控制在11位以内：
                        val.substring(0, 11);
                        //var reg = new RegExp("^\\d{11}$");
                        var reg = /^1(3|4|5|7|8)\d{9}$/;
                        //先匹配是否为手机号
                        if (reg.test(val)) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '请输入正确的手机号码';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    } else if (2 == datatype) {
                        var reg = new RegExp("^\\d{15}|\\d{}18$");

                        //身份证
                        if (reg.test(val)) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '请输入合法的身份证号码';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    } else if (3 == datatype) {
                        var reg = /^[0-9]*$/;
                        //数字
                        if (reg.test(val)) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '请输入纯数字';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    } else if (4 == datatype) {
                        //字母
                        if (true) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '请输入字符串';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    } else if (5 == datatype) {
                        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;

                        //email
                        if (reg.test(val)) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '请输入正确的邮箱地址';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    } else if (6 == datatype) {
                        var reg = /^([\u4E00-\u9FA5]|\w)*$/;//特殊符号
                        //先匹配是否有特殊符号
                        if (reg.test(val) && val.length <= 20) {
                            checkObj.parent().next().find("span").html("");
                            option_check = true;
                        } else {
                            var msg = checkObj.attr('default');
                            var errormsg = icons.error + '真实姓名格式有误';
                            onKeyupHandler(checkObj, errormsg);
                            option_check = false;
                        }
                    }
                } else {
                    checkObj.parent().next().find("span").html("");
                }
            }

        }
      

        //获取注册验证码
        function get_randcode_phone() {
            //手机号码
            var mobile = $("#user_mobile").val();

            if (!mobile) {
                var errormsg = icons.error + '请填写手机号';
                onKeyupHandler(form_mobile, errormsg);
                return;
            }

            if (!window.randStatus) {
                return;
            }
            //先匹配是否为手机号
            if(!isNaN(mobile) && mobile.length == 11)
            {
                $("#form-item-mobile").next().find("span").html("");
                result = true;
            }else{
                var errormsg = icons.error + '请输入正确的手机号';
                onKeyupHandler(form_mobile, errormsg);
                result = false;
            }

            var ajaxurl = './index.php?ctl=Login&met=reg2Code&typ=json';
     
            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                async: false,
                data:"&mobile=" + mobile,
                success: function (respone) {
                    if (respone.status == 250) {
                        $(".img-code").click();
                        var errormsg = icons.error + respone.msg;
                        onKeyupHandler(form_mobile, errormsg);
                    } else if (respone.status == 230) {
                        $(".img-code").click();
                        var errormsg = icons.error + respone.msg;
                        onKeyupHandler(form_authcode, errormsg);
                    } else {
                        window.countDown();
                        //alert(respone.data['user_code']);
                        setCookie("phone_code",respone.data['user_code'],1);
                        setCookie("user_mobile",mobile,1);

                        param['user_mobile2'] = mobile;
                        param['phoneCode2']   = respone.data['user_code'];

                        Public.tips.alert('请查看手机短信获取验证码!');
                        return false;
                    }
                }
            });
        }

        msg = "<?=_('获取验证码')?>";
        var delayTime = 60;
        window.randStatus = true;
        window.countDown = function () {
            window.randStatus = false;
            delayTime--;
            $('.btn-phonecode').html(delayTime + "<?=_(' 秒后重新获取')?>");
            if (delayTime == 0) {
                delayTime = 60;
                $('.btn-phonecode').html(msg);
                clearTimeout(t);
                window.randStatus = true;
            } else {
                t = setTimeout(countDown, 1000);
            }
        };

        $("#register-form").keydown(function (e) {
            var e = e || event, keycode = e.which || e.keyCode;
            if (keycode == 13) {
                //registclick();
            }
        });

        var from = $(".from").val();
        var callback = $(".callback").val();
        var token = $(".token").val();
        var re_url = $(".re_url").val();

        $.fn.serializeObject = function () {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };

    //检验手机和短信验证码
    function checkRcode(){
        
        if (!$("#user_mobile").val()) {
            Public.tips.alert('请输入手机号!');
            return false;
        }else{

            if (!param['phoneCode2']) {
              
                // Public.tips.alert('请点击获取验证码!');
                return false;
            }
        }

        if (!$("#phoneCode").val()) {
        
            // Public.tips.alert('请输入短信验证码!');
            return false;
        }

        var reg = /^[0-9]{6}$/;
        if (!reg.test($("#phoneCode").val())) {
            Public.tips.alert('请输入正确的短信验证码');
            return false;
        }

        var user_code   = $("#phoneCode").val();//getCookie("phone_code");
        var user_mobile = $("#user_mobile").val();//getCookie("user_mobile");

        var ajaxurl = './index.php?ctl=Login&met=phoneCode&typ=json';

        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            async: false,
            data: {'user_code':user_code,'user_mobile':user_mobile},
            success: function (respone) {
                if (respone.status == 250) {
                    Public.tips.alert('请输入的正确的手机号和验证码!'); //超过60秒会验证失败
                    return false;
                }else{
                
                    // verify_code = 1;
                }
            }
        });

    }
    </script> 
</div>
<script>
    function getCookie(name) {
        var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
        if (arr != null) {
            return unescape(arr[2]);
            return null;
        }
    }
</script>
</body>
</html>
