<html class="root61">
<?php
$re_url = '';
$re_url = Yf_Registry::get('re_url');

$from = '';
$callback = $re_url;
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
    <title>上传身份证照片</title>
    <link rel="stylesheet" href="<?=$this->view->css?>/register.css">
    <link rel="stylesheet" href="<?=$this->view->css?>/base.css">
    <link rel="stylesheet" href="<?=$this->view->css?>/tips.css">
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/headfoot.css" />
    <script src="<?=$this->view->js?>/jquery-1.9.1.js"></script>
    <script src="<?=$this->view->js?>/respond.js"></script>
    <script src="<?=$this->view->js?>/regist.js"></script>
</head>

<body>
<div id="form-header" class="header">
    <div class="logo-con w clearfix">
        <a href="<?=$shop_url?>" class="index_logo">
            <img src="<?= $web['site_logo'] ?>" alt="logo" height="60">
        </a>
        <div class="logo-title">上传身份证照片</div>
    </div>

</div>
<div class="container w">
    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>上传身份证照片</div>
    <input type="hidden" name="callback" class="callback" value="<?php echo urlencode($callback); ?>">
    <input type="hidden" name="t" class="token" value="<?php echo $t; ?>">
    <input type="hidden" name="code" class="code" value="<?php echo $code; ?>">
    <input type="hidden" name="re_url" class="re_url" value="<?php echo $re_url; ?>">
    <div class="main clearfix" id="form-main">
        <div class="reg-form fl">
            <form action="" id="register-form" method="post" novalidate="novalidate"  onsubmit="return false;">
              

                <div id="form-item" class="form-item" style="z-index: 12;">
                    <label>上传身份证照片正面</label>
                    <input type="file" id="images" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议至少使用两种字符组合" default="<i class=i-def></i><?=$pwd_str?>" name="images">
                  
                    <i class="i-status"></i>
                    
                </div>
                <div id="form-item" class="form-item" style="z-index: 12;">
                    <label>上传身份证照片负面</label>
                    <input type="file" id="images1" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议至少使用两种字符组合" default="<i class=i-def></i><?=$pwd_str?>" name="images1">
                  
                    <i class="i-status"></i>
                    
                </div>

                <div class="input-tip">
                    <span></span>
                </div>

                <div>
                    <button type="submit" class="btn-register" onclick="imgClick()">下一步</button>
                </div>

            </form>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>新会员注册</div>
    <div class="main clearfix" id="form-main">
        <div class="reg-form fl" id="reg-form1">
            <form action="" id="register-form1" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>辅导员编号：</label>
                    <input type="text" id="par_member" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="辅导员编号" default="<i class=i-def></i><?=$pwd_str?>" onchange="instruClick()">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>辅导员姓名：</label>
                    <input type="text" id="par_name" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="辅导员姓名" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>身份证号码：</label>
                    <input type="texttext" id="user_idcard" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="身份证号码" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员姓名：</label>
                    <input type="text" id="user_name" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="会员姓名" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员性别：</label>
                    <input type="text" id="user_gender" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="会员性别" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>出生年月：</label>
                    <input type="text" id="user_birth" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="出生年月" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
               <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>户籍地址：</label>
                    <input type="text" id="user_address" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="户籍地址" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员手机：</label>
                    <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议使用常用手机" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="Mobile_div" style="">
                    <div class="form-item form-item-mobile" id="form-item-mobile">
                        <div class="form-item form-item-phonecode">
                        <label><em class="must">*</em>手机验证码：</label>
                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                        <button id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码</button>
                        <i class="i-status"></i>
                    </div>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员邮箱：</label>
                    <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="会员邮箱" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>

                <input type="hidden" name="regstep" id="regstep1" class="from" value="1">
                <div>
                    <button type="submit" class="btn-register" onclick="reg1Click()">下一步</button>
                </div>

            </form>
        </div>
    </div>

    <br>
    <br>
    <br>

    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>优惠顾客资料</div>
    <div class="main clearfix" id="form-main2">
        <div class="reg-form fl">
            <form action="" id="register-form2" method="post" novalidate="novalidate"  onsubmit="return false;">
              
                <div id="form-item" class="form-item" style="z-index: 12;">
                    <label>拍照上传银行卡照片</label>
                    <input type="file" id="bankimg" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="bankimg" onchange="bankImg()">
                    <i class="i-status"></i>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行卡号：</label>
                    <input type="text" id="bankaccount" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="银行卡号" default="<i class=i-def></i><?=$pwd_str?>" onfocus="" onblur="">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行类别：</label>
                    <input type="text" id="bankno" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="银行类别" default="<i class=i-def></i><?=$pwd_str?>"onfocus="" onblur="">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行支行名称：</label>
                    <input type="texttext" id="banksubranch" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="银行支行名称" default="<i class=i-def></i><?=$pwd_str?>" onfocus="" onblur="">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行分行：</label>
                    <input type="text" id="bankbranch" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="银行分行" default="<i class=i-def></i><?=$pwd_str?>" onfocus="" onblur="">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>开户行所在省：</label>
                    <input type="text" id="bankprovince" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="开户行所在省" default="<i class=i-def></i><?=$pwd_str?>" onfocus="" onblur="">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>开户行所在市：</label>
                    <input type="text" id="bankcity" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="开户行所在市" default="<i class=i-def></i><?=$pwd_str?>" >
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <input type="hidden" name="regstep" id="regstep2" class="from" value="2">
                <div>
                    <button type="submit" class="btn-register" onclick="reg2Click()">下一步</button>
                </div>

            </form>
        </div>
    </div>


    <br>
    <br>
    <br>

    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>设置密码</div>
    <div class="main clearfix" id="form-main3">
        <div class="reg-form fl">
            <form action="" id="register-form3" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div class="pas">
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label><em class="must">*</em>新 密 码：</label>
                        <span class="close-btn js_clear_btn clear-icon"></span>
                        <input type="password" id="re_user_password" class="field re_user_password" maxlength="20" placeholder="建议至少使用两种字符组合" default="<i class=i-def></i><?= $pwd_str ?>" onfocus="checkPwd()" onblur="pwdCallback()"> 
                        <span class="clear-btn eye-icon"></span>
                        <i class="i-status"></i>
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>

                </div>
                
                <div id="form-item-rpassword" class="form-item">
                    <label>确 认 密 码：</label>
                    <input type="password" name="form-equalTopwd" id="form_equalTopwd" class="field" placeholder="请再次输入密码" maxlength="20" default="<i class=&quot;i-def&quot;></i>请再次输入密码" onblur="checkRpwd()" onfocus="showTip(this)">
                    <span class="clear-btn eye-icon"></span>
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>

                <input type="hidden" name="regstep" id="regstep3" class="from" value="3">
                <div>
                    <button type="submit" class="btn-register" onclick="reg3Click()">确认</button>
                </div>

            </form>
        </div>
    </div>


    <br>
    <br>
    <br>

    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>申请成功</div>
    <div class="main clearfix" id="form-main">
        <div class="reg-form fl">
            <form action="" id="register-form4" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div style="text-align: center">
                    <h3>恭喜您完成资料验证</h3>
                    <br>
                        您的会员编号是：<p id="member_id">xxxxx</p>
                        您的辅导员编号是：<p id="parent_member">xxxxxx</p> 
                    </div>
                <input type="hidden" name="regstep" id="regstep4" class="from" value="4">
                <div>
                    <button type="submit" class="btn-register" onclick="reg4Click()">进入首页</button>
                </div>

            </form>
        </div>
    </div>

    <?php
    include $this->view->getTplPath() . '/' . 'footer.php';
    ?>
</div>

<script>
    
    //一步插入数据库
    var param = new Array();

    //身份证图片上传
    function imgClick(){
        var images  = $('#images').val();
        var images1 = $('#images1').val();

        if (!images) {
            return Public.tips.alert('请上传身份证正面图片');
        }
        if (!images1) {
            return Public.tips.alert('请上传身份证反面图片');
        }
     
        var form = new FormData($("#register-form")[0]);
        $.ajax({ 
              url:'./index.php?ctl=Login&met=regidapi&typ=json',  
              type:'POST',
              contentType:false,
              processData:false, 
              data:form,  
              success:function (res){
                if(res.status == 250)
                {
                    Public.tips.alert('该身份证已注册会员！',afterreset);
                }else if(res.status == 200){
                    alert("成功");
                    //setCookie("cardinfo",JSON.stringify(res.data),1);  //序列化 反序列化JSON.parse()

                    //把回传的身份证信息显示出来
                    $("#user_idcard").attr("value",res.data[3]);
                    $("#user_name").attr("value",res.data[2]);
                    $("#user_gender").attr("value",res.data[4]);
                    $("#user_birth").attr("value",res.data[1]);
                    $("#user_address").attr("value",res.data[0]);

                    $("#form-main").css("display","none");      
                }else{ 
                    Public.tips.error("<?=_('验证失败！')?>");
                }  
              },  
              error:function (res){  
                console.log(res);  
              }  
        });
    }
    
    function afterreset(){
        window.location.href = '<?=sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>';
    }

    //自动带出身份证信息
    // var cardinfo = JSON.parse(getCookie("cardinfo"));

    // if (cardinfo) {
    //     $("#user_idcard").attr("value",cardinfo[3]);
    //     $("#user_name").attr("value",cardinfo[2]);
    //     $("#user_gender").attr("value",cardinfo[4]);
    //     $("#user_birth").attr("value",cardinfo[1]);
    //     $("#user_address").attr("value",cardinfo[0]);
    // }
    //用辅导员编号，进行上线会员资格检查
    function instruClick(){
        //如果是手动输入
        var par_member = $("#par_member").val();  //直销会员编号
        //var par_member = '9191919';
        //var idno = cardinfo[3]; //调用上线会员资格检查接口的会员的身份证号
        var idno = $("#user_idcard").val();
        var ajaxurl = './index.php?ctl=Login&met=CheckParent&typ=json';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data:{"IDNo": idno,"ParentMemberID": par_member},
            dataType: "json",
            async: false,
            success: function (respone) {
                if (respone.status == 200) {
              
                    setCookie("BelongSalon",respone.data['BelongSalon'],1); //归属沙龙编号
                    setCookie("ParentMemberName",respone.data['ParentMemberName'],1);  //辅导员姓名

                    $("#par_name").attr("value",respone.data['ParentMemberName']); 
                   
                } else {
                    Public.tips.alert(respone.msg);
                    return false;
                }
            }
        });
    }

    //验证手机
    function checkMobile() {

        var form_mobile = $("#user_mobile");
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
                        if (respone.status == 250) {
                            var errormsg = icons.error + '该手机号已被注册';
                            onKeyupHandler($("#user_mobile"), errormsg);
                            mobile_check = false;
                        } else {
                            $("#form-item-mobile").addClass("form-item-valid");
                            $("#form-item-mobile").next().find("span").html("");
                            mobile_check = true;
                        }
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
    //获取注册验证码
    function get_randcode_phone() {

        var mobile_check = false;
        var form_mobile = $("#user_mobile");
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

        var ajaxurl = './index.php?ctl=Login&met=reg1Code&typ=json';
        
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            async: false,
            data: "mobile=" + mobile,
            success: function (respone) {
                if (respone.status == 250) {
                    var errormsg = icons.error + respone.msg;
                    onKeyupHandler(form_mobile, errormsg);
                } else if (respone.status == 230) {
                    var errormsg = icons.error + respone.msg;
                    onKeyupHandler(form_mobile, errormsg);
                } else {
                    window.countDown();
                    setCookie("phone_code",respone.data['user_code'],1);
                    alert(respone.data['user_code']);
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

    //新会员注册
    function reg1Click(){

        param['par_member']  = $('#par_member').val();
        param['par_name']    = $('#par_name').val();
        param['user_idcard'] = $('#user_idcard').val();
        param['user_name']   = $('#user_name').val();
        param['user_gender'] = $('#user_gender').val();
        param['user_birth']  = $('#user_birth').val();
        param['user_address']= $('#user_address').val();
        param['user_mobile'] = $('#user_mobile').val();
        param['user_code']   = $('#phoneCode').val();
        param['user_email']  = $('#user_email').val();
        param['phone_code']  = getCookie("phone_code"); //获取验证码

        param['BelongSalon'] = getCookie("BelongSalon"); //归属沙龙


        if (!param['par_member']) {
            return Public.tips.alert('请输入辅导员编号');
        }
        if (!param['par_name']) {
            return Public.tips.alert('请输入辅导员姓名');
        }
        if (!param['user_idcard']) {
            return Public.tips.alert('请输入身份证号码');
        }
        if (!param['user_name']) {
            return Public.tips.alert('请输入会员姓名');
        }
        if (!param['user_gender']) {
            return Public.tips.alert('请输入会员性别');
        }
        if (!param['user_birth']) {
            return Public.tips.alert('请输入出生年月');
        }
        if (!param['user_address']) {
            return Public.tips.alert('请输入户籍地址');
        }
        if (!param['user_mobile']) {
            return Public.tips.alert('请输入手机号');
        }
        if (!param['user_code']) {
            return Public.tips.alert('请输入短信验证码');
        }else if(param['user_code']!=param['phone_code']){
            return Public.tips.alert('您输入的短信验证码不正确');
        }
        if (!param['user_email']) {
            return Public.tips.alert('请输入会员邮箱');
        }

        if (param['user_gender'] == "男") {
            param['user_gender'] = 1;
        }else if(param['user_gender'] == "女"){
            param['user_gender'] = 0;
        }else{
            param['user_gender'] = 2;
        } 

        $("#reg-form1").css("display","none");
    }


    //优惠顾客资料-上传银行卡图片
    function bankImg(){

        var bankimg  = $('#bankimg').val();

        if (!bankimg) {
            return Public.tips.alert('请上传银行卡正面图片');
        }

        var form = new FormData($("#register-form2")[0]);  
        $.ajax({ 
              url:'./index.php?ctl=Login&met=bankcardapi&typ=json',  
              type:'POST',
              contentType:false,
              processData:false, 
              data:form,  
              success:function (res){
                 if(res.status == 200){
                    alert("成功");
                    //setCookie("bankinfo",JSON.stringify(res.data),1);  //序列化 反序列化JSON.parse()
 
                    $("#bankaccount").attr("value",res.data['bank_card_number']);
                }else{ 
                    Public.tips.error("<?=_('验证失败！')?>");
                }  
              },  
              error:function (res){  
                console.log(res);  
              }  
        });
    }

    //自动带出银行卡信息
   
    // var bankinfo = JSON.parse(getCookie("bankinfo"));

    // if (bankinfo) {

    //     $("#bankaccount").attr("value",bankinfo['bank_card_number']);
    //     $("#bankno").attr("value",bankinfo['BIN_CARDNAME']);
    //     $("#banksubranch").attr("value",bankinfo[4]);
    //     $("#bankbranch").attr("value",bankinfo[1]);
    // }

    //优惠顾客资料-银行卡资料提交
    function reg2Click(){
    
        param['bankaccount']  = $('#bankaccount').val();
        param['bankno']       = $('#bankno').val();
        param['banksubranch'] = $('#banksubranch').val();
        param['bankbranch']   = $('#bankbranch').val();
        param['bankprovince'] = $('#bankprovince').val();
        param['bankcity']     = $('#bankcity').val();

        if (!param['bankaccount']) {
            return Public.tips.alert('请输入银行卡号');
        }
        if (!param['bankno']) {
            return Public.tips.alert('请输入银行类别');
        }
        if (!param['banksubranch']) {
            return Public.tips.alert('请输入银行支行名称');
        }
        if (!param['bankbranch']) {
            return Public.tips.alert('请输入银行分行');
        }
        if (!param['bankprovince']) {
            return Public.tips.alert('请输入开户行所在省');
        }
        if (!param['bankcity']) {
            return Public.tips.alert('请输入开户行所在市');
        }

         //判断是否选中我已阅读用户手册
        // if (!$('#agree_button').is(':checked')) {
        //     Public.tips.alert('请确认是否同意尚赫优惠顾客规章');
        //     return;
        // }

        $("#form-main2").css("display","none");

    }


    //设置密码
    function reg3Click(){
        
        param['re_user_password'] = $('#re_user_password').val();//新密码
        param['user_password']    = $('#form_equalTopwd').val();//新密码
        var token = $(".token").val();
        console.log(param);

        var params = {
            "par_member": param['par_member'],  //辅导直销员编号
            "par_name": param['par_name'],  //辅导员姓名
            "user_idcard": param['user_idcard'],  
            "user_name": param['user_name'],  
            "user_gender": param['user_gender'],  
            "user_birth": param['user_birth'],  
            "user_address": param['user_address'],
            "user_mobile": param['user_mobile'], 
            "user_code": param['user_code'],  
            "user_email": param['user_email'],  
            "bankaccount": param['bankaccount'],  //银行账号
            "bankno": param['bankno'],  //银行类别
            "banksubranch": param['banksubranch'],  //银行支行名称
            "bankbranch": param['bankbranch'],  //银行分行名称
            "bankprovince": param['bankprovince'],  //主键
            "bankcity": param['bankcity'],  //主键
            "user_password": param['user_password'],    //传输确认密码
            "BelongSalon":param['BelongSalon'],
            "t": token
        };

        var ajaxurl = './index.php?ctl=Login&met=register1&typ=json';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            async: false,
            data:params,
            success: function (respone)
            {
                if(respone.status == 200){
                    alert("成功");

                    console.log(respone);

                    setCookie("member_id",respone.data['MemberID'],1);
                    setCookie("par_member",respone.data['par_member'],1);

                    $("#member_id").text(respone.data['MemberID']);
                    $("#parent_member").text(respone.data['par_member']);

                    $("#form-main3").css("display","none");
                }else{
                    Public.tips.alert('注册失败，'+respone.msg);
                    //三秒后跳转首页
                    return;
                }
            }
        });
    }

    function reg4Click(){
        window.location.href = "./index.php?ctl=User&met=getUserInfo";
    }

    var icons = {
        def: '<i class="i-def"></i>',
        error: '<i class="i-error"></i>',
        weak: '<i class="i-pwd-weak"></i>',
        medium: '<i class="i-pwd-medium"></i>',
        strong: '<i class="i-pwd-strong"></i>'
    };
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
            item.addClass('form-item-error')
        }
        item.removeClass('form-item-valid');
        item.next().find('span').addClass('error').html(msg).show();
    }
    //检测密码
    function checkPwd() {

        var form_pwd = $("#re_user_password");
        var msg = form_pwd.attr('default');


        var s = form_pwd.parent().next().find("span").html();
        if(!s)
        {   
            form_pwd.parent().next().find("span").html(msg);
        }

        form_pwd.on('keyup', function (e) {
            var value = $(this).val();
            pwdStrengthRule(form_pwd, value);
        })
    }
    function pwdCallback()
    {   var form_pwd = $("#re_user_password");
        var user_pwd = $("#re_user_password").val();
        hideError(form_pwd);
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
    function checkRpwd()
    {   
        var form_rpwd = $("#form_equalTopwd");
        var rpwd = $("#form_equalTopwd").val();  //确认密码
        var pwd = $("#re_user_password").val();

        hideError(form_rpwd);

        if(rpwd)
        {
            if(rpwd == pwd)
            {
                $("#form-item-rpassword").addClass("form-item-valid");
                $("#form-item-rpassword").next().find("span").html("");
            }
            else
            {
                $("#form-item-rpassword").removeClass("form-item-valid");
                var errormsg = icons.error + '两次密码输入不一致';
                onKeyupHandler(form_rpwd, errormsg);
            }
        }
        else
        {
            $("#form-item-rpassword").next().find("span").html("");
        }

    }
    function pwdStrengthRule(element, value) {
        var pwdLength = '<?=$reg_row['reg_pwdlength']['config_value']?>';
        var level = 0;
        var typeCount=0;
        var flag = true;
        var valueLength=getStringLength(value);
        if (valueLength < pwdLength) {
                element.parent().removeClass('form-item-valid').removeClass('form-item-error');
                element.parent().next().find('span').removeClass('error').html($(element).attr('default'));
                return;
            }

        for (key in pwdStrength) {
            if (pwdStrength[key].reg.test(value)) {
                typeCount++;
            }
        }
        if(typeCount==1){
            if(valueLength>10){
                level=2;
            }else{
                level=1;
            }
        }else if(typeCount==2){
            if(valueLength<11&&valueLength>5){
                level=2;
            }
            if(valueLength>10){
                level=3;
            }
        }else if(typeCount==3){
            if(valueLength>6){
                level=3;
            }
        }

        if ($.inArray(value, weakPwds) !== -1) {
            flag = false;
            level=1;
        }

        if (flag && level > 0) {
            element.parent().removeClass('form-item-error').addClass(
                'form-item-valid');
        } else {
            element.parent().addClass('form-item-error').removeClass(
                'form-item-valid');
        }
        if (pwdStrength[level] !== undefined) {
            pwdStrength[level]>3?pwdStrength[level]=3:pwdStrength[level];
            element.parent().next().html('<span>' + pwdStrength[level].msg +
                '</span>')
        }
        return flag;
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

    //显示提示语
    function showTip(e)
    {
        var msg = $(e).attr('default');

        if(!$(e).parent().next().find("span").html())
        {
            $(e).parent().next().find("span").html(msg);
        }
    }
    




</script>
</body>

</html>